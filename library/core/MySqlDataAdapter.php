<?php
class MySqlDataAdapter
{
    protected $_server, $_username, $_password, $_dbName, $_port;
    
    // MySQLi instance
    protected $_mysqli;

    // Query to be prepared and executed
    protected $_query;

    // Paramaters to be bound to query
    protected $_bindParams = array();

    // Last error produced by query attempt
    protected $_lastError;

    // DB charset
    protected $_charset;
    
    /**
     * Constructor
     *
     * @param string $server MySQL server address
     * @param string $username Database username
     * @param string $password Database password
     * @param string $dbName Database name
     * @return void
     */              
    public function __construct($server, $username, $password, $dbName, $port, $charset = 'utf8')
    {
        $this->_server   = $server;         // Host address
        $this->_username = $username;       // User
        $this->_password = $password;       // Password
        $this->_dbName   = $dbName;         // Database        
        $this->_charset  = $charset; 
        $this->_port     = $port;
       
        $this->connect();
    }

    /**
     * Connects to db
     *
     */              
    public function connect()
    {
        if (empty ($this->_server))
            die ('Mysql host is not set');

        $this->_mysqli = new mysqli ($this->_server, $this->_username, $this->_password, $this->_dbName, $this->_port)
            or die('There was a problem connecting to the database');

        if ($this->_charset)
            $this->_mysqli->set_charset ($this->_charset);
    }

    /**
     * Pass in a query and an array containing the parameters to binded to the query.
     *
     * @param string $query      Contains a user-provided query.
     * @param array  $bindParams All variables to bind to the SQL statment.
     *
     * @return array Contains the returned rows from the query.
     */
    public function query ($query, $bindParams = null)
    {
        $this->_query = $query; 
        //We can use filter_var to sanitize the query; but, the base query can automatically be assumed to be safe since all base querries will be written by us. Only user input needs to be santized. And we will do via the bind_param below.
        
        if (!$stmt = $this->_mysqli->prepare($this->_query)) {
            trigger_error("Problem preparing query ($this->_query) " . $this->_mysqli->error, E_USER_ERROR);
        }

        if (is_array($bindParams) === true) {
            $params = array(''); // Create the empty 0 index
            foreach ($bindParams as $prop => $val) {
                $params[0] .= $this->_getType($val);
                array_push($params, $bindParams[$prop]);
            }
            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
        }
        $stmt->execute();
        $this->_lastError = $stmt->error;
 
        return $this->_dynamicBindResults($stmt);
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    protected function refValues($arr)
    {
        //Reference is required for PHP 5.3+
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value) {
                $refs[$key] = & $arr[$key];
            }
            return $refs;
        }
        return $arr;
    }

     /**
     * Returns array of result of mysqli statement
     *
     * @param mysqli_stmt $stmt Equal to the prepared statement object.
     *
     * @return array The results of the SQL fetch.
     * SOURCE: https://github.com/joshcam/PHP-MySQLi-Database-Class/blob/master/MysqliDb.php
     */
    protected function _dynamicBindResults(mysqli_stmt $stmt)
    {
        $parameters = array();
        $results = array();
        $meta = $stmt->result_metadata();

        // if $meta is false yet sqlstate is true, there's no sql error but the query is
        // most likely an update/insert/delete which doesn't produce any results
        if(!$meta && $stmt->sqlstate) { 
            return true;
        }

        // create parameter array that has reference to array that has field names of the results
        $row = array();
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
            $parameters[] =& $row[$field->name];
        }

        // avoid out of memory bug in php 5.2 and 5.3
        // https://github.com/joshcam/PHP-MySQLi-Database-Class/pull/119
        if (version_compare (phpversion(), '5.4', '<'))
             $stmt->store_result();

        call_user_func_array(array($stmt, 'bind_result'), $parameters);

        $this->count = 0;
        while ($stmt->fetch()) {
            $x = array();
            foreach ($row as $key => $val) {
                $x[$key] = $val;
            }
            array_push($results, $x);
        }
        return $results;
    }

    /**
     * This method is needed for prepared statements. Returns first letter of type to be 
     * appended to the string element that stores types of parameteres to be bound to query
     *
     * @param mixed $item Input to determine the type.
     *
     * @return string The joined parameter types.
     */
    protected function _getType($item)
    {
        switch (gettype($item)) {
            case 'NULL':
            case 'string':
                return 's';
                break;
            case 'boolean':
            case 'integer':
                return 'i';
                break;
            case 'blob':
                return 'b';
                break;
            case 'double':
                return 'd';
                break;
        }
        return '';
    }
   
    /**
     * Close connection to db
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->_mysqli)
            $this->_mysqli->close();
    }
}
<?php
class MySqlPDOAdapter
{
    protected $_server, $_username, $_password, $_errorInfo;
    
    public $dbName;
    
    public $connection;
    
    protected $_result;
    
    const DATETIME = 'Y-m-d H:i:s';
    
    const DATE = 'Y-m-d';
               
    public function __construct($server, $username, $password, $dbName, $connect_now = true, $persistent = false, $pdoFlags = false){
        $this->_server   = $server;         // Host address
        $this->_username = $username;        // User
        $this->_password = $password;    // Password
        $this->dbName   = $dbName;        // Database         
       
        if ($connect_now){
            $this->connect($persistent, $pdoFlags);
        }
    }
   
    public function __destruct(){
        $this->close();
    }
    
    
    // Connect to the database
    public function connect($persistent = false, $pdoFlags = false){
        // if set to persistent connection
        if($persistent === true){
            $pdoFlags = ($pdoFlags !== false) ? array_merge($pdoFlags, PDO::ATTR_PERSISTENT) : PDO::ATTR_PERSISTENT;
        }

        $flags = $this->_ensurePdoFlags($pdoFlags);

        // Create new instance
        $dsn = "mysql:host={$this->_server}";
        try {
            // Add instance
            $this->connection = new Pdo($dsn, $this->_username, $this->_password, $flags);
        } catch (PDOException $e) {
            $this->_handleError($e,true);
            return false;
        }

        // select the db
        $this->selectDb($this->dbName);

       // if none of above processes work, return false
       return $this->connection;
    }    

    // Change the selected db
    public function selectDb($dbName, $oneOff = false){
        if ($this->connection){
            // set the instance db name
            if($oneOff === false){
                $this->dbName = $dbName;
            }

            try
            {
                // use USE command to select db
                return $this->query("USE `{$dbName}`");
            } catch (PDOException $e){
                $this->_handleError($e);
            }
        }
        return false;
    }
    
    // Query the database
    public function query($queryStr, $unbuffered=false){
      // set the result to false
      $result = false;
      try
      {
          // set buffer attribute
          $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, !$unbuffered);

          $result = $this->connection->query($queryStr);
          $this->_result = $result;
      }catch(PDOException $e){
        $this->_handleError($e, true, "Query String: " . $queryStr);
      }
      return $result;
    }         
 
    // Update the database
    public function update(array $values, $table, $where = false, $limit = false){
        if (count($values) < 0)
            return false;
            
        $fields = array();
        foreach($values as $field => $val)
            $fields[] = "`" . $field . "` = '" . $this->escapeString($val) . "'";

        $where = ($where) ? " WHERE " . $where : '';
        $limit = ($limit) ? " LIMIT " . $limit : '';

        if ($this->query("UPDATE " . $table . " SET " . implode($fields, ", ") . $where . $limit))
            return true;
        else
            return $this->_lastError();
    }  
    
    // Insert one new row
    public function insert(array $values, $table){
        if (count($values) < 0)
            return false;
        
        foreach($values as $field => $val)
            $values[$field] = $this->escapeString($val);

        if ($this->query("INSERT INTO " . $table . " (`" . implode(array_keys($values), "`, `") . "`) VALUES ('" . implode($values, "', '") . "')"))
            return true;
        else
            return $this->_lastError();
    }   
    
    // Fetch results by associative array
    public function fetchArray($result = false, $resultType = 3){
        $this->_ensureResult($result);
        switch ($resultType) {
            case 1:
                // by field names only as array
                return $result->fetchAll(PDO::FETCH_ASSOC);
            case 2:
                // by field position only as array
                return $result->fetchAll(PDO::FETCH_NUM);
            case 3:
                // by both field name/position as array
                return $result->fetchAll();
            case 4:
                // by field names as object
                return $result->fetchAll(PDO::FETCH_OBJ);   
        }
    }   
   
    // Escape characters for importing data
    public function escapeString($string){
        try {
            $string = $this->connection->quote($string);
            return substr($string, 1, -1);
        } catch (PDOException $e) {
            $this->_loadError($link, $e);
        }
        
        return false;
    }
   
    // Count number of rows in a result
    public function numRows($result){
        $this->_ensureResult($result);
        if (is_array($result)) {
            return count($result);
        }
        
        // Hard clone (cloning PDOStatements doesn't work)
        $query = $result->queryString;
        $cloned = $this->query($query);
        $data = $cloned->fetchAll();
        return count($data);
    }
    
    // Get last inserted id of the last query
    public function insertId(){
        return (int) $this->connection->lastInsertId();
    }
    
    // Get number of affected rows of the last query
    public function affectedRows(){
        $result = $this->_ensureResult(false);
        return $result->rowCount();
    }         
   
    // Free the query result resoruce
    public function freeResult(&$result){
        if (is_array($result)) {
            $result = false;
            return true;
        }

        if (get_class($result) != 'PDOStatement') {
            return false;
        }

        return $result->closeCursor();
    }

    // Close the connection
    public function close(){
        if(isset($this->connection)){
            $this->connection = null;
            unset($this->connection);
            return true;
        }
        return false;
    }
    
    // Determine the data type of a query
    protected function _ensureResult(&$result){
        if ($result == false){
            $result = $this->_result;
        } else {
            if (gettype($result) !== 'resource' && is_string($result)){
                $result = $this->query($result);
            }
        }
    }

    // Ensure the PDO flags paramaters are correctly formed
    protected function _ensurePdoFlags($flags){
        if ($flags == false || empty($flags)) {
            return array();
        }
        
        // Array it
        if (!is_array($flags)) {
            $flags = array($flags);
        }

        $pdoParams = array();
        foreach ($flags as $flag) {
            switch ($flag)
            {
                // CLIENT_FOUND_ROWS (found instead of affected rows)
                case 2:
                    $params = array(PDO::MYSQL_ATTR_FOUND_ROWS => true);
                    break;
                // CLIENT_COMPRESS (can use compression protocol)
                case 32:
                    $params = array(PDO::MYSQL_ATTR_COMPRESS => true);
                    break;
                // CLIENT_LOCAL_FILES (can use load data local)
                case 128:
                    $params = array(PDO::MYSQL_ATTR_LOCAL_INFILE => true);
                    break;
                // CLIENT_IGNORE_SPACE (ignore spaces before '(')
                case 256:
                    $params = array(PDO::MYSQL_ATTR_IGNORE_SPACE => true);
                    break;
                // Persistent connection
                case 12:
                    $params = array(PDO::ATTR_PERSISTENT => true);
                    break;
            }
            
            $pdoParams[] = $params;
        }

         return $pdoParams;
    }

    protected function _handleError($e, $throw = true, $extraInfo = false){
        // Reset errors
        if ($e === false || is_null($e)) {
            $this->_errorInfo = array('error'=>"", 'errno'=>0);
            return;
        }
        // Set error
        $this->_errorInfo = array('error'=>$e->getMessage(), 'errno'=>$e->getCode());

        if($throw){
            $s = "<br />Error Code:" . $this->_errorInfo['errno'] . "<br /> Description: " . $this->_errorInfo['error'] . "<br />";
            if(!empty($extraInfo)){
                $s .= $extraInfo ."<br />";
            }
            trigger_error($s, E_USER_ERROR);
        }
    }


    /**
     * Get the error description from the last query
     *
     * @return string
     */
    protected function _lastError(){
        $error = '';
        
        if ($this->connection){
            $error = $this->connection->errorInfo()[2];
        }
     
     return $error;
    }
    
    /**
     * Get the last error number
     */
    protected function _lastErrNo(){
        $error = '';
        
        if ($this->connection){
            $error = $this->connection->errorCode()[0];
        }
     
     return $error;
    }    
}
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
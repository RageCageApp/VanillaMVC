<?php
class Controller {
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $models;
    protected static $instance;
    
    // Database object
    public $db;

    // Session object
    public $session;

    function __construct($controller, $action) {
        self::$instance =& $this;

        $this->_controller = $controller;
        $this->_action     = $action;
        $this->_view       = new View();
    }
 
    //Load model class
    public function load_model($model) { 
        if(class_exists($model) && !isset($this->models[$model])) { 
            $this->models[$model] = new $model(); 
        }  
    }
 
    // Get the instance of the loaded model
    public function get_model($model) { 
        if(is_object($this->models[$model])) { 
            return $this->models[$model]; 

        } else { 
            return false; 
        } 
    } 

    // Load database adapter
    public function load_database()
    {
        if(!isset($this->db)){
            $this->db = new MySqlDataAdapter(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,DB_PORT);
        }    
    }

    // Load session
    public function load_session()
    {
        if(!isset($this->session)){
            $this->session = new CustomSession();
        }  
    }

    // Return view object 
    protected function get_view() { 
        return $this->_view; 
    }

    public static function &get_instance()
    {
        return self::$instance;
    }
         
}
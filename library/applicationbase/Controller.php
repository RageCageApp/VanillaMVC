<?php
class Controller {
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $models;
 
    function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action     = $action;
        $this->_view       = new View();
    }
 
    //Load model class
    protected function load_model($model) { 
        if(class_exists($model)) { 
            $this->models[$model] = new $model(); 
        }  
    }
 
    // Get the instance of the loaded model
    function get_model($model) { 
        if(is_object($this->models[$model])) { 
            return $this->models[$model]; 

        } else { 
            return false; 
        } 
    } 

    // Return view object 
    protected function get_view() { 
        return $this->view; 
    }
         
}
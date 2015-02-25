<?php
class View {
     
    protected $variables = array();
     
    function __construct() {

    }
 
    // Set Variables 
    function set($name,$value) {
        $this->variables[$name] = $value;
    }
 
    // Display View 
    function render($viewName) {
        extract($this->variables);
     
        if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $view_name . '.php')) {
            include (ROOT . DS . 'application' . DS . 'views' . DS . $view_name . '.php');
        } else {
            //********* ERROR: failed to find proper view ***************//
        }
    }
 
}
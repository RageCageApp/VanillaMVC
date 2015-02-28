<?php
class View {
     
    function __construct() {

    }
 
    // Set Variables 
    function set($name,$value) {
        $this->variables[$name] = $value;
    }
 
    // Display View 
    function render($viewName, $variables = array()) {
        extract($variables);
     
        if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $viewName . '.php')) {
            include (ROOT . DS . 'application' . DS . 'views' . DS . $viewName . '.php');
        } else {
            //********* ERROR: failed to find proper view ***************//
            die("View {$viewName} file not found");
        }
    }
 
}
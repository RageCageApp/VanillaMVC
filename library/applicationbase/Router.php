<?php
class Router
{
    public static function route($url) {
        $urlArray = array();
        $urlArray = explode("/",$url);
     
        //First part of url is controller
        $controller = isset($urlArray[0]) ? $urlArray[0] : '';
        array_shift($urlArray);
        //Second part of url is model
        $action = isset($urlArray[0]) ? $urlArray[0] : '';
        array_shift($urlArray);
        //Third part of url is the query string
        $queryString = $urlArray;
     
        //Ensure that controller/model name is in correct form (eg userController, userModel)
        $moduleName = strtolower(trim($controller));
        $controllerName = $moduleName.'Controller';
        $modelName = $moduleName.'Model';
        
        //Create controller based on request
        $dispatch = new $controllerName($controllerName,$action);
        if ((int)method_exists($controllerName, $action)) {
            call_user_func_array(array($dispatch,$action),$queryString);
        } else {
            // Figure out better way to handle this error
            echo 'ERROR: failed to find proper course of action for request';
            //********* ERROR: failed to find proper course of action for request *************** //
        }
    }
}
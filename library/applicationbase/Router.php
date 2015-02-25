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
        $queryString = isset($urlArray[0]) ? $urlArray[0] : '';
     
        //Ensure that controller/model name is in correct form (eg userController, userModel)
        $moduleName = ucwords(trim($controller));
        $controller = $moduleName.'Controller';
        $model = $moduleName.'Model';
        
    }
}
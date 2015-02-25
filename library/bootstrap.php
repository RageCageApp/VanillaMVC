<?php 
// Ensure we have session
if(session_id() === ""){
    session_start();
}

$path = ROOT . DS . 'config' . DS . 'config.php';

// include the config settings
require_once ($path);

// Autoload any classes that are required
// ****************************************************
// Room for improvement: use use namespace to prevent collisions
// ****************************************************
spl_autoload_register(function($className) {

    //$className = strtolower($className);
    $rootPath = ROOT . DS;
    $valid = false;
   
    // check root directory of library
    $valid = file_exists($classFile = $rootPath . 'library' . DS . $className . '.php');
    
    // if we cannot find any, then find library/core directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'library' . DS . 'core' . DS . $className . '.php');   	
    } 
    // if we cannot find any, then find library/applicationbase directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'library' . DS . 'applicationbase' . DS . $className . '.php');      
    } 
    // if we cannot find any, then find application/controllers directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'controllers' . DS . $className . '.php');
    } 
    // if we cannot find any, then find application/models directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'models' . DS . $className . '.php');
    }  
  
    // if we have valid file, then include it
    if($valid){
       require_once($classFile); 

    }else{
        // no valid file for class
        //***!! alert dev team of potential bug !!***//
    }    
});
// show php errors
HelperFunctions::setErrorReporting($cfg['global']['error_reporting']);

// remove the magic quotes
HelperFunctions::removeMagicQuotes();

// unregister globals
HelperFunctions::unregisterGlobals();

//route request accordingly
Router::route($_route);

// close session to speed up the concurrent connections
// http://php.net/manual/en/function.session-write-close.php
session_write_close();
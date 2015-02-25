<?php
// Ensure we have session
if(session_id() === ""){
    session_start();
}

// define the directory separator and application path
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

// the routing url
$_route = isset($_GET['_route']) ? preg_replace('/^_route=(.*)/','$1',$_SERVER['QUERY_STRING']) : '';

// dispatch
require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');
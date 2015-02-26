<?php   
/************************************************************* 
* Database related settings
**************************************************************/

$cfg['db']['hostname'] = 'localhost'; 
$cfg['db']['username'] = 'root';
$cfg['db']['password'] = '';
$cfg['db']['database'] = 'pixafy_db';
$cfg['db']['port']	   = '3306';

// define DB constant variables
define('DB_HOST',       $cfg['db']['hostname']);
define('DB_USER',       $cfg['db']['username']);
define('DB_PASSWORD',   $cfg['db']['password']);
define('DB_NAME',       $cfg['db']['database']);
define('DB_PORT',       $cfg['db']['port']);

$cfg['global']['error_reporting'] = TRUE;
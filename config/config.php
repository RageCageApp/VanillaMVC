<?php   
/************************************************************* 
* Database related settings
**************************************************************/

$cfg['db']['hostname'] = 'localhost'; 
$cfg['db']['username'] = 'root';
$cfg['db']['password'] = '';
$cfg['db']['database'] = 'pixafy_db';

// define DB constant variables
define('DB_HOST',       $cfg['db']['hostname']);
define('DB_USER',       $cfg['db']['username']);
define('DB_PASSWORD',   $cfg['db']['password']);
define('DB_NAME',       $cfg['db']['database']);

$cfg['global']['error_reporting'] = TRUE;
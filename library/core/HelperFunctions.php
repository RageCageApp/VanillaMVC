<?php
class HelperFunctions{   

    /**
    * Set error reporting
    */
    public static function setErrorReporting($flag){
        error_reporting(E_ALL);
        $flag ? ini_set('display_errors','On') : ini_set('display_errors','Off');
    }
    
    /**
    * Check register globals and remove them
    */
    public static function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }  

    /**
    * Check for Magic Quotes and remove them
    */
    public static function removeMagicQuotes() {
        if (get_magic_quotes_gpc() ) {
        	if(isset($_GET)){
        		$_GET    = self::stripSlashesDeep($_GET);
        	}
            
			if(isset($_POST)){
        		$_POST   = self::stripSlashesDeep($_POST);
        	}
            
			if(isset($_COOKIE)){
        		$_COOKIE = self::stripSlashesDeep($_COOKIE);
        	}
            
        }
    }

    /** Check for Magic Quotes and remove them **/
    public static function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map(self::stripSlashesDeep, $value) : stripslashes($value);
        return $value;
    }
    
}
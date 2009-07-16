<?php

    function perch_autoload($class_name) {
        $file = PERCH_PATH . '/lib/' . $class_name . '.class.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
    
    if (function_exists('spl_autoload_register')) {
        spl_autoload_register('perch_autoload');
    }else{
        function __autoload($class_name) {
            require_once PERCH_PATH . '/lib/' . $class_name . '.class.php';
        }
    }
    
        
    set_magic_quotes_runtime(false);
    
    if (function_exists('date_default_timezone_set')) date_default_timezone_set('UTC');

    if (!defined('PERCH_ERROR_MODE')) define('PERCH_ERROR_MODE', 'DIE');
    
?>
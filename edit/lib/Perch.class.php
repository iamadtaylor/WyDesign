<?php

class Perch
{
    static protected $instance;
	
    public $version = '1.1.5';
    
    private $page        = false;
    public $debug        = true;
    public $debug_output = '';
    public $page_title   = 'Welcome';
    
    function __construct()
    {
        if (!defined('PERCH_DEBUG')) {
            define('PERCH_DEBUG', false);
        }
    }
    
    public static function fetch()
	{	    
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
	}
    
    public function get_page($request_uri=false)
    {
        if ($request_uri) {
            $out = strtolower(rtrim($_SERVER['SCRIPT_NAME'], 'index.php'));
            if (isset($_SERVER['QUERY_STRING'])) {
                $out .= '?'.$_SERVER['QUERY_STRING'];
            }
            return $out;
        }
        
        if ($this->page === false) {
            $this->page = strtolower($_SERVER['SCRIPT_NAME']);
        }
        
        return $this->page;
    }
    
    public function set_page($page)
    {
        $this->page = $page;
    }
    
    
    
    
}

?>
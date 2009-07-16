<?php

class PerchAdmin extends Perch
{
    private $apps         = array();
    
    private $javascript   = array();
    private $css          = array();
    private $head_content = '';
    
    public $section       = '';

    public static function fetch()
	{	    
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
	}

    public function get_apps()
    {
        return $this->apps;
    }
    
    
    public function find_installed_apps()
    {
        $a = array();
        if (is_dir(PERCH_PATH.'/apps')) {
            if ($dh = opendir(PERCH_PATH.'/apps')) {
                while (($file = readdir($dh)) !== false) {
                    if(substr($file, 0, 1) != '.') {
                        if (is_dir(PERCH_PATH.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR. $file)) {
                            $a[] = array('filename'=>$file, 'path'=>PERCH_PATH.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR. $file);
                        }
                    }
                }
                closedir($dh);
            }
        }
        
        if (is_array($a)) {
            foreach($a as $app) {
                $file = $app['path'].DIRECTORY_SEPARATOR.'admin.php';
                if (file_exists($file)) {
                    include($file);
                }
            }
        }
        
        $this->apps = PerchUtil::array_sort($this->apps, 'priority');
    }
    
    public function get_section()
    {
        $page = $this->get_page();        
        $page = trim(str_replace(PERCH_LOGINPATH, '', $page), '/');
        
        $parts  = explode('/', $page);
        
        if (is_array($parts)) {
            if ($parts[0] == 'apps') {
                return $parts[0].'/'.$parts[1];
            }else{
                return $parts[0];
            }
        }
        
        return $page;
    }
    
    public function add_javascript($path)
    {
        if (!in_array($path, $this->javascript)) {
            $this->javascript[] = $path;
        }
    }
    
    public function get_javascript()
    {
        return $this->javascript;
    }
    
    public function add_css($path)
    {
        if (!in_array($path, $this->css)) {
            $this->css[] = $path;
        }
    }
    
    public function get_css()
    {
        return $this->css;
    }
    
    public function add_head_content($str)
    {
        $this->head_content .= $str;
    }
    
    public function get_head_content()
    {
        return $this->head_content;
    }
    
    
    
    private function register_app($label, $path, $priority=10)
    {
        $app    = array();
        $app['label']   = $label;
        $app['path']    = $path;
        $app['priority']= $priority;
        $app['section'] = trim(str_replace(PERCH_LOGINPATH, '', $path), '/');
        
        $this->apps[]   = $app;
    }
    
}

?>
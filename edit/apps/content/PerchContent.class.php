<?php

class PerchContent extends PerchApp
{
    protected $table     = 'contentItems';
	protected $pk        = 'contentID';
	protected $singular_classname = 'PerchContentItem';
	
	private $registered = array();
    
	public static function fetch()
	{	    
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
	}
	
	public function get($key=false)
	{
	    if ($key === false) return ' ';
	    
	    if ($this->cache === false) {
	        $this->populate_cache();
	    }
	    
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }else{
            $this->register_new_key($key);
        }
        
        return '';
	    
	}
	
	public function get_list($filter_mode=false, $val=false, $sort=true)
	{
	    $db     = PerchDB::fetch();
	    
	    $sql    = 'SELECT *
	                FROM '.$this->table . '
	                WHERE 1=1 ';
	                
	    switch ($filter_mode) {
	        case 'new':
	            $sql .= 'AND contentNew=1 ';
	            break;
	           
            case 'page':
                $sql .= 'AND contentPage='.$this->db->pdb($val);
                break;

            case 'template':
                $sql .= 'AND contentTemplate='.$this->db->pdb($val);
                break;
	       
	        default:
	           # code...
	           break;
	    }            
	    
	    $results    = $db->get_rows($sql);
	    
	    if ($sort && PerchUtil::count($results) > 0) {
	        foreach($results as &$result) {
	            $result['formattedPage'] = PerchUtil::filename($result['contentPage'], true, true);            
	        }
	        
	        $results = PerchUtil::array_sort($results, 'formattedPage');
	    }
	    
	    return $this->return_instances($results);
	}
	
	public function get_pages()
	{
	    $sql = 'SELECT DISTINCT contentPage
	            FROM '.$this->table.'
	            ORDER BY contentPage ASC';
	            
	    $rows   = $this->db->get_rows($sql);
	    
	    if (PerchUtil::count($rows)>0) {
	        $out = array();
	        foreach($rows as $row) {
	            $out[] = $row['contentPage'];
	        }
	        
	        return $out;
	    }
	    
	    return false;
	}
	
	public function get_templates()
    {
        $a = array();
        if (is_dir(PERCH_PATH.'/templates/content')) {
            if ($dh = opendir(PERCH_PATH.'/templates/content')) {
                while (($file = readdir($dh)) !== false) {
                    if(substr($file, 0, 1) != '.') {
                        $extension = PerchUtil::file_extension($file);
                        if ($extension == 'html' || $extension == 'htm') {
                            $a[] = array('filename'=>$file, 'path'=>PERCH_PATH.'/templates/content' . $file, 'label'=>$this->template_display_name($file));
                        }
                    }
                }
                closedir($dh);
            }
        }
        
        return $a;
    }
    
    public function delete_with_key($key, $new_only=false)
    {
        $sql = 'DELETE FROM '.$this->table.'
                WHERE contentKey='.$this->db->pdb($key);
                
        if ($new_only) {
            $sql .= ' AND contentNew=1';
        }
        
        $this->db->execute($sql);
    }
    
    public function template_display_name($file_name)
    {
        $file_name = str_replace('.html', '', $file_name);
        $file_name = str_replace('_', ' ', $file_name);
        $file_name = str_replace('-', ' - ', $file_name);
        
        $file_name = ucwords($file_name);
        
        return $file_name;
    }
    
	
	private function populate_cache()
	{
	    $this->cache = $this->get_content();
	}
	
	private function get_content()
	{
	    $Perch  = Perch::fetch();
	    $page   = $Perch->get_page();
	    
	    $db     = PerchDB::fetch();
	    
	    $sql    = 'SELECT contentKey, contentHTML
	                FROM '.$this->table. '
	                WHERE contentPage='.$db->pdb($page).' OR contentPage='.$db->pdb('*');
	    $results    = $db->get_rows($sql);
	    
	    if (PerchUtil::count($results) > 0) {
	        $out = array();
	        foreach($results as $row) {
	            $out[$row['contentKey']] = $row['contentHTML'];
	        }
	        return $out;
	    }else{
	        return array();
	    }
	}
	
	private function register_new_key($key)
	{
	    if (!isset($this->registered[$key])) {	    
    	    
    	    $Perch  = Perch::fetch();
    	    $page   = $Perch->get_page();
	    
    	    $data = array();
    	    $data['contentKey'] = $key;
    	    $data['contentPage'] = $page;
    	    $data['contentHTML'] = '<!-- Undefined content: '.PerchUtil::html($key).' -->';
    	    $data['contentJSON'] = '';
	    
    	    $db = PerchDB::fetch();
    	    $db->insert($this->table, $data);
    	    
    	    $this->registered[$key] = true;
    	}
	}

	
}
?>
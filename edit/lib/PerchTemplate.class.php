<?php

class PerchTemplate
{
    protected $namespace;
	protected $file;
	protected $template;
	protected $cache		= array();
	
	function __construct($file=false, $namespace='content')
	{
		
		$this->namespace = $namespace;
		
		if (file_exists(PERCH_PATH.$file)) {
		    $this->file		= PERCH_PATH.$file;
			$this->template	= $file;   
		}else{
		    PerchUtil::debug('Template file not found: ' . PERCH_PATH.$file, 'error');
			return false;
		}
			
	}
	
	public function render_group($content_vars, $return_string=false)
	{
		$r	= array();
		
		if (is_array($content_vars)){
			foreach($content_vars as $item) {
				$r[] = $this->render($item);
			}
		}
		
		if ($return_string) {
		    return implode('', $r);
		}
		
		return $r;
	}

	public function render($content_vars)
	{
		
		$template	= $this->template;
		$path		= $this->file;
		
		$PerchImage = new PerchImage;
		
		$contents	= $this->load();
		
		// CONDITIONALS
        if (strpos($contents, 'perch:if')>0) {
            $s = '/(<perch:(if)[^>]*>)(.*?)<\/perch:if>/s';
    		$count	= preg_match_all($s, $contents, $matches, PREG_SET_ORDER);
		
    		if ($count > 0) {
    			foreach($matches as $match) {
    			    $contents = $this->parse_conditional($match[2], $match[1], $match[3], $match[0], $contents, $content_vars);
    			}	
    		}
    	}

		// CONTENT
		foreach ($content_vars as $key => $value) {	

			
			$s = '/<perch:'.$this->namespace.'[^\/>]*id="'.$key.'"[^\/>]*\/>/';
			$count	= preg_match_all($s, $contents, $matches);
					
			if ($count > 0) {
				foreach($matches[0] as $match) {
					$tag = new PerchXMLTag($match);
					
					if (is_object($value) && get_class($value) == 'Image') {
						if ($tag->class()) {
							$out		= $value->tag($tag->class());
							$contents 	= str_replace($match, $out, $contents);
						}else{
							$out		= $value->tag();
							$contents 	= str_replace($match, $out, $contents);
						}
					}else{
					    $modified_value = $value;
					    
					    // check for 'format' attribute for formatting dates
					    if ($tag->format()) {
					        $modified_value = date($tag->format(), strtotime($value));
					    }
					    
					    // replace images
					    if ($tag->type() == 'image' && ($tag->width() || $tag->height())) {
					        $modified_value = $PerchImage->get_resized_filename($modified_value, $tag->width(), $tag->height());
					    }
					    
						$contents = str_replace($match, $modified_value, $contents);
					}
					
				}
				
			}
			
		}
		
		
		// CLEAN UP ANY UNMATCHED <perch: /> TAGS
		$s 			= '/<perch:[^\/>]*\/>/';
		$contents	= preg_replace($s, '', $contents);
		
		$contents   = $this->remove_help($contents);
		
    	return $contents;
	}


	public function find_tag($tag)
	{
		$template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
			
		$s = '/<perch:[^\/>]*id="'.$tag.'"[^\/>]*\/>/';
		$count	= preg_match($s, $contents, $match);

		if ($count == 1){
			return new PerchXMLTag($match[0]);
		}
		
		return false;
	}
	
	public function find_all_tags($type='content')
	{
	    $template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
		
		$s = '/<perch:'.$type.'[^\/>]*\/>/';
		$count	= preg_match_all($s, $contents, $matches);
		
		if ($count > 0) {
		    $out = array();
		    $i = 100;
		    if (is_array($matches[0])){
		        foreach($matches[0] as $match) {
		            $tmp = array();
		            $tmp['tag'] = new PerchXMLTag($match);
		            
		            if ($tmp['tag']->order()) {
		                $tmp['order'] = (int) $tmp['tag']->order();
		            }else{
		                $tmp['order'] = $i;
		                $i++;
		            }
                    $out[] = $tmp;
		        }
		    }
		    
		    // sort tags using 'sort' attribute
		    $out = PerchUtil::array_sort($out, 'order');
		    
		    $final = array();
		    foreach($out as $tag) {
		        $final[] = $tag['tag'];
		    }
		    
		    return $final;
		}
		
		return false;
	}
	
	public function find_help()
	{
	    $template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
		
		$out        = '';
		
		if (strpos($contents, 'perch:help')>0) {
            $s = '/<perch:help[^>]*>(.*?)<\/perch:help>/s';
    		$count	= preg_match_all($s, $contents, $matches, PREG_SET_ORDER);
		
    		if ($count > 0) {
    			foreach($matches as $match) {
    			    $out .= $match[1];
    			}	
    		}
    	}
    	
    	return $out;
	}
	
	public function remove_help($contents)
	{
        $s = '/<perch:help[^>]*>.*?<\/perch:help>/s';
		return preg_replace($s, '', $contents);    	
	}

	protected function load()
	{
		$contents	= '';
			
		// check if template is cached
		if (isset($this->cache[$this->template])){
			// use cached copy
			$contents	= $this->cache[$this->template];
		}else{
			// read and cache		
			if (file_exists($this->file)){
				$contents 	= file_get_contents($this->file);
				$this->cache[$this->template]	= $contents;
			}
		}
		
		return $contents;
	}
	
	protected function parse_conditional($type, $opening_tag, $condition_contents, $exact_match, $template_contents, $content_vars)
	{
	    if ($type == 'if') {
	        $tag = new PerchXMLTag($opening_tag);
	        
	        if (array_key_exists($tag->exists(), $content_vars) && $content_vars[$tag->exists()] != '') {
	            $template_contents  = str_replace($exact_match, $condition_contents, $template_contents);
	        }else{
	            $template_contents  = str_replace($exact_match, '', $template_contents);
	        }
	    }
	    
	    return $template_contents;
	}

}
?>

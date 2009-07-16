<?php

class PerchContentItem extends PerchBase
{
    protected $table  = 'contentItems';
    protected $pk     = 'contentID';
    
    public function post_process($tag, $value)
    {
        $formatting_language_used = false;
        
        // Strip HTML by default
        if (PerchUtil::bool_val($tag->html()) == false) {
            $value = PerchUtil::html($value);
            $value = strip_tags($value);
        }
        
        // Textile
        if (!$formatting_language_used && PerchUtil::bool_val($tag->textile()) == true) {
            $Textile = new Textile;
            $value  =  $Textile->TextileThis($value);
            $formatting_language_used = true;
        }
        
        // Markdown
        if (!$formatting_language_used && PerchUtil::bool_val($tag->markdown()) == true) {
            $Markdown = new Markdown_Parser;
            $value = $Markdown->transform($value);
            $formatting_language_used = true;
        }
        
        
        return $value;
    }
    
    public function globalise()
    {
        $data = array();
    	$data['contentPage'] = '*';
    	$this->update($data);
    	
    	$ContentItems = new PerchContent;
    	$ContentItems->delete_with_key($this->contentKey(), true);
    	
    }
    
    public function add_item()
    {
    
        $items = PerchUtil::json_safe_decode($this->contentJSON(), true);

        if ($this->contentAddToTop()=='1') {
            array_unshift($items, array());
        }else{
            $items[] = array();
        }
        
        
        $data = array();
        $data['contentJSON'] = PerchUtil::json_safe_encode($items);
        
        $this->update($data);
    }
    
    public function delete_item($index)
    {
        $items = PerchUtil::json_safe_decode($this->contentJSON(), true);
        
        if (isset($items[$index])) {
             array_splice($items, $index, 1);
        }
        
        $Template = new PerchTemplate('/templates/content/'.$this->contentTemplate(), 'content');
        $tags     = $Template->find_all_tags('content');
        $processed_vars = array();
        $i = 0;
        
        if (PerchUtil::count($items)) {
            foreach($items as $item) {
                foreach($tags as $tag) {
                    if (isset($item[$tag->id()])) {
                        $processed_vars[$i][$tag->id()] = $this->post_process($tag, $item[$tag->id()]);
                    }
                }
                $i++;
            }
        }
        
        $data = array();
        $data['contentJSON'] = PerchUtil::json_safe_encode($items);
        $data['contentHTML'] = $Template->render_group($processed_vars, true);
        
        $this->update($data);
    }
    
}

?>
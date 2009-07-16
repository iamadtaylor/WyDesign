<?php
    $ContentItem = false;


    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
        $ContentItem = $PerchContent->find($id);
    }


    if (!$ContentItem || !is_object($ContentItem)) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/content');
    }

    // test to see if image folder is writable
    $image_folder_writable = is_writable(PERCH_RESFILEPATH);

    // find the number of items
    $details = PerchUtil::json_safe_decode($ContentItem->contentJSON(), true);
    $items   = (PerchUtil::count($details) > 0 ? PerchUtil::count($details) : 1);

    $template_help_html = '';


    /* --------- Template Form ----------- */
    
    if ($ContentItem->contentTemplate() == '') {
        
        $fTemplate = new PerchForm('template');
        
        $req = array();
        $req['contentTemplate'] = "Required";
        $fTemplate->set_required($req);
        
        if ($fTemplate->posted() && $fTemplate->validate()) {
        	$postvars = array('contentTemplate', 'contentMultiple');
        	$data = $fTemplate->receive($postvars);
        	
        	if (!isset($data['contentMultiple'])) {
        	    $data['contentMultiple'] = 0;
        	}
        	
        	$data['contentNew'] = 0;
        	
        	$ContentItem->update($data);
        	

        }   
    }
    
    

    /* --------- Edit Form ----------- */
    
    if ($ContentItem->contentTemplate() != '') {

        $Template = new PerchTemplate('/templates/content/'.$ContentItem->contentTemplate(), 'content');

        $tags   = $Template->find_all_tags('content');
        $template_help_html = $Template->find_help();
        
        $Form = new PerchForm('edit');
        
        $req = array();
        
        // Check for required content
        if (is_array($tags)) {
            for($i=0; $i<$items; $i++) {
                $seen_tags = array();
                $postitems = $Form->find_items('perch_'.$i.'_');
                
                foreach($tags as $tag) {
                    $item_id = 'perch_'.$i.'_'.$tag->id();
                    if (!in_array($tag->id(), $seen_tags)) {
                        if (PerchUtil::bool_val($tag->required())) {
                            if ($tag->type() == 'date') {
                                $req[$item_id.'_year'] = "Required";
                            }else{
                                $req[$item_id] = "Required";
                            }
                        
                        }
                    
                        $seen_tags[] = $tag->id();
                    }
                }
            }
        }
        
        $Form->set_required($req);
        
        
        if ($Form->posted() && $Form->validate()) {
        	$form_vars      = array();
        	$processed_vars = array();
        	$file_paths     = array();

            if (is_array($tags)) {
                
                for($i=0; $i<$items; $i++) {
                    
                    $seen_tags = array();
                    $postitems = $Form->find_items('perch_'.$i.'_');
                    
                    foreach($tags as $tag) {
                        $item_id = 'perch_'.$i.'_'.$tag->id();
                        
                        if (!in_array($tag->id(), $seen_tags)) {
                            $var = false;
                            switch($tag->type()) {
                                case 'date' :
                                    $var = $Form->get_date($tag->id(), $postitems);
                                    break;
                                
                                case 'image' :
                                case 'file' :
                                    if ($image_folder_writable && isset($_FILES[$item_id]) && (int) $_FILES[$item_id]['size'] > 0) {
                                        $filename = PerchUtil::tidy_file_name($_FILES[$item_id]['name']);
                                        $target = PERCH_RESFILEPATH.DIRECTORY_SEPARATOR.$filename;
                                        if (file_exists($target)) {
                                            $filename = PerchUtil::tidy_file_name(time().'-'.$_FILES[$item_id]['name']);
                                            $target = PERCH_RESFILEPATH.DIRECTORY_SEPARATOR.$filename;
                                        }
                                        
                                        move_uploaded_file($_FILES[$item_id]['tmp_name'], $target);
                                        $file_paths[$tag->id()] = $target;     
                                                                                
                                        $var = PERCH_RESPATH.'/'.$filename;
                                        
                                        // thumbnail
                                        $PerchImage = new PerchImage;
                                        $PerchImage->resize_image($target, 150, 150, 'thumb');
                                    }

                                    if (!isset($_FILES[$item_id]) || (int) $_FILES[$item_id]['size'] == 0) {
                                        $var = $details[$i][$tag->id()];
                                    }
                                    
                                    break;
                            
                                default: 
                                    if (isset($postitems[$tag->id()])) {
                                        $var = trim($postitems[$tag->id()]);
                                    }
                            }
                    
                    
                            if ($var) {
                                $var = stripslashes($var);
                                $form_vars[$i][$tag->id()] = $var;
                                $processed_vars[$i][$tag->id()] = $ContentItem->post_process($tag, $var);
                            }
                            $seen_tags[] = $tag->id();
                        }
                    }
                    
                    
                    // process images
                    foreach ($tags as $tag) {
                        if ($tag->type()=='image' && ($tag->width() || $tag->height())) {
                            $PerchImage = new PerchImage;
                            $PerchImage->resize_image($file_paths[$tag->id()], $tag->width(), $tag->height());
                        }
                    }
                }
            }

        	$json = PerchUtil::json_safe_encode($form_vars);
            
            $data = array();
            $data['contentHTML'] = $Template->render_group($processed_vars, true);
            $data['contentJSON'] = $json;
            $data['contentNew'] = 0;
                    	
        	$ContentItem->update($data);
        	
        	if ($ContentItem->contentMultiple()=='1' && isset($_POST['add_another'])) {
        	    $ContentItem->add_item();
        	    $details = PerchUtil::json_safe_decode($ContentItem->contentJSON(), true);
                $items   = (PerchUtil::count($details) > 0 ? PerchUtil::count($details) : 1);
                
                // Clear $_POST, as field numbers have all changed.
                $_POST = array();
                $Form->reset();
        	}
        	
        	
        	$Alert->set('success', PerchLang::get('Content successfully updated'));
        	
        }
        
        // Get details;
        $details    = PerchUtil::json_safe_decode($ContentItem->contentJSON(), true);
        if (is_array($details)) {
            $details_flat = array();
            $i = 0;
            foreach($details as $detail) {
                foreach($detail as $key=>$val) {
                    $details_flat['perch_'.$i.'_'.$key] = $val;
                }
                $i++;
            }
            $details = $details_flat;
        }
    }
    
    if (!$image_folder_writable) {
        $Alert->set('failure', PerchLang::get('Your resources folder is not writable. Make this folder (') . PerchUtil::html(PERCH_RESPATH) . PerchLang::get(') writable if you want to upload files and images.'));
    }
    
    
    
    /* ---------- EDITOR PLUGINS ----------- */
    
    if ($ContentItem->contentTemplate() && is_array($tags)) {
        foreach($tags as $tag) {
            if ($tag->editor()) {
                $dir = PERCH_PATH.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'editors'.DIRECTORY_SEPARATOR.$tag->editor();
                if (is_dir($dir) && is_file($dir.DIRECTORY_SEPARATOR.'_config.inc')) {
                    $Perch->add_head_content(str_replace('PERCH_LOGINPATH', PERCH_LOGINPATH, file_get_contents($dir.DIRECTORY_SEPARATOR.'_config.inc')));
                }else{
                    $Alert->set('failure', PerchLang::get('Editor requested, but not installed: '.$tag->editor()));
                }
            }
        }
    }

?>
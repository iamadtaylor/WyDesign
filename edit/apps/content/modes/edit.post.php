<div id="h1">
    <h1><?php 
            echo PerchLang::get('Content') . ' / ';
            printf(PerchLang::get('Editing %s Region'),' &#8216;' . PerchUtil::html($ContentItem->contentKey()) . '&#8217; '); 
        ?></h1>
    <?php echo $help_html; ?>
</div>

<div id="side-panel">

    
    <h3 class="em"><span><?php echo PerchLang::get('About this region'); ?></span></h3>
    <p>
        <?php echo PerchLang::get("This region only has a single item. Required fields are marked with an asterisk *."); ?>
    </p>
    

<?php
    if ($ContentItem->contentMultiple()=='1') {
        
        echo '<h4>'  . PerchLang::get('Items') . '</h4>';
        echo '<ul>';
        for($i=0; $i<$items; $i++) {
            echo '<li><a href="#item'.($i+1).'">'.PerchLang::get('Item') . ' ' . ($i+1) . '</a></li>';
        }
        echo '</ul>';


        echo '<p>';
        
        if ($ContentItem->contentAddToTop() == '1') {
            echo PerchLang::get('New items are added to the top.');
        }else{
            echo PerchLang::get('New items are added to the bottom.');
        }
        
        echo ' <a href="'.PERCH_LOGINPATH . '/apps/content/order/?id='.PerchUtil::html($id).'">' . PerchLang::get('Change this.') . '</a></p>';


    }




    if ($ContentItem->contentTemplate() != '') {

        echo '<h4>' . PerchLang::get('Page assignment') . '</h4>';
        
        if ($ContentItem->contentPage() == '*') {
            echo '<p>' . PerchLang::get('This region is shared across all pages.') . '</p>';
        }else{
            echo '<p>' . PerchLang::get('This region is only available within') . ':</p><p><code><a href="' . PerchUtil::html($ContentItem->contentPage()) . '">' . PerchUtil::html($ContentItem->contentPage()) . '</a></code></p>';
            
            echo '<p>';
            printf(PerchLang::get('%sShare this region%s to use it within multiple pages.'), '<a href="'.PERCH_LOGINPATH . '/apps/content/share/?id='.PerchUtil::html($id).'">', '</a>');
            echo '</p>';
        }
    }
    
    

    
    

?>
</div>

<div id="main-panel">
    <?php echo $Alert->output(); ?>

<?php
    
    /*  ------------------------------------ DEFINE TEMPLATE ----------------------------------  */

    if ($ContentItem->contentTemplate() == '') {
?>
        <p><?php echo PerchLang::get('Please choose a template for the content you wish to add to this region.'); ?></p>
        <p><?php echo PerchLang::get('If you would like to have multiple items of content in this region, select the <em>Allow multiple items</em> option.'); ?></p>
        

        <form method="post" action="<?php echo PerchUtil::html($fTemplate->action()); ?>">
            <fieldset>
                <legend><?php echo PerchUtil::html(PerchLang::get('Choose a Template')); ?></legend>
                
                <div class="field">
                    <?php echo $fTemplate->label('contentTemplate', 'Template'); ?>
                    <?php
                        $opts = array();
                        $templates = $PerchContent->get_templates();
                       
                        if (is_array($templates)) {
                            foreach($templates as $template) {
                                $opts[] = array('label'=>$template['label'], 'value'=>$template['filename']);
                            }
                        }
                        
                        echo $fTemplate->select('contentTemplate', $opts, $fTemplate->get('contentTemplate', @false));
                    ?>
                </div>
            
                <div class="field">
                    <?php echo $fTemplate->label('contentMultiple', 'Allow multiple items'); ?>
                    <?php echo $fTemplate->checkbox('contentMultiple', '1', '0'); ?>
                </div>
            
            </fieldset>
            <p class="submit">
                <?php echo $fTemplate->submit('btnsubmit', 'Submit', 'button'); ?>
            </p>
                
        </form>




<?php
    }else{
        
    
    
    
    
    /*  ------------------------------------ EDIT CONTENT ----------------------------------  */
 
 
    if ($template_help_html) {
        echo '<h2><span>' . PerchLang::get('Help') .'</span></h2>';
        echo '<div id="template-help">' . $template_help_html . '</div>';
    }

    
    
?>
    <form method="post" action="<?php echo PerchUtil::html($Form->action()); ?>" <?php echo $Form->enctype(); ?> id="content-edit" class="sectioned">
        <div class="items">
<?php

        if (is_array($tags)) {
            
            // loop through each item (usually one, sometimes more)
            for($i=0; $i<$items; $i++) {
                
                echo '<div class="edititem">';
                if ($ContentItem->contentMultiple()) {
                    echo '<div class="h2" id="item'.($i+1).'">';
                        echo '<h2 class="em">'. PerchLang::get('Item'). ' ' . ($i+1) .'</h2>';
                        echo '<a href="'.PERCH_LOGINPATH.'/apps/content/delete-item/?id='.PerchUtil::html($ContentItem->id()).'&amp;idx='.$i.'" class="delete">'.PerchLang::get('Delete').'</a>';
                    echo '</div>';
                }else{
                    echo '<h2 class="em">'. PerchUtil::html($ContentItem->contentKey()).'</h2>';
                }
                $seen_tags = array();
            
                foreach($tags as $tag) {
                    
                    $item_id = 'perch_'.$i.'_'.$tag->id();
                    
                    if (!in_array($tag->id(), $seen_tags)) {
                        echo '<div class="field '.$Form->error($item_id, false).'">';
                        
                        $label_text  = PerchUtil::html($tag->label());
                        if ($tag->type() == 'textarea') {
                            if (PerchUtil::bool_val($tag->textile()) == true) {
                                $label_text .= ' <span><a href="'.PERCH_LOGINPATH.'/help/textile" class="assist">Textile</a></span>';
                            }
                            if (PerchUtil::bool_val($tag->markdown()) == true) {
                                $label_text .= ' <span><a href="'.PERCH_LOGINPATH.'/help/markdown" class="assist">Markdown</a></span>';
                            }
                        }
                        $Form->html_encode = false;
                        echo $Form->label($item_id, $label_text, '', false, false);
                        $Form->html_encode = true;
                
                            switch ($tag->type()) {
                                case 'text':
                                case 'url':
                                case 'email':
                                    echo $Form->text($item_id, $Form->get($details, $item_id));
                                    break;
                        
                                case 'textarea':
                                    $classname = 'large ';
                                    if ($tag->editor()) $classname .= $tag->editor();
                                    if ($tag->textile()) $classname .= ' textile';
                                    if ($tag->markdown()) $classname .= ' markdown';
                                    if (!$tag->textile() && !$tag->markdown() && $tag->html()) $classname .= ' html';
                                
                                    echo $Form->textarea($item_id, $Form->get($details, $item_id), $classname);
                                    echo '<div class="clear"></div>';
                                    break;
                            
                                case 'date':
                                    echo $Form->datepicker($item_id, $Form->get($details, $item_id));
                                    break;
                            
                                case 'select':
                                    $options = explode(',', $tag->options());
                                    $opts = array();
                                    if (PerchUtil::bool_val($tag->allowempty())== true) {
                                        $opts[] = array('label'=>'', 'value'=>'');
                                    }
                                    if (PerchUtil::count($options) > 0) {
                                        foreach($options as $option) {
                                            $val = trim($option);
                                            $opts[] = array('label'=>$val, 'value'=>$val);
                                        }
                                    }
                                    echo $Form->select($item_id, $opts, $Form->get($details, $item_id));
                                    break;
                                
                                case 'image':
                                    $PerchImage = new PerchImage;
                                    echo $Form->image($item_id);
                                    if (isset($details[$item_id]) && $details[$item_id]!='') {
                                        $image_src = $PerchImage->get_resized_filename($details[$item_id], 150, 150, 'thumb');
                                        $image_path = str_replace(PERCH_RESPATH, PERCH_RESFILEPATH, $image_src);
                                        if (file_exists($image_path)) {
                                            echo '<img class="preview" src="'.PerchUtil::html($image_src).'" alt="Preview" />';
                                        }
                                    }
                                    break;
                                case 'file':
                                    echo $Form->image($item_id);
                                    break;
                            
                                default:
                                    echo $Form->text($item_id, $Form->get($details, $item_id));
                                    break;
                            }
                            
                        if ($tag->help()) {
                            echo $Form->hint($tag->help());
                        }
                
                        echo '</div>';
                
                        $seen_tags[] = $tag->id();
                    }
                }
                
                echo '</div>';
            }
        }
?>        
        </div>
        <p class="submit">
            <?php 
                echo $Form->submit('btnsubmit', 'Save', 'button'); 
                
                if ($ContentItem->contentMultiple()=='1') {
                    echo '<input type="submit" name="add_another" value="'.PerchUtil::html(PerchLang::get('Save & Add another')).'" id="add_another" class="button" />';
                }
                
                echo ' ' . PerchLang::get('or') . ' <a href="'.PERCH_LOGINPATH.'/apps/content">' . PerchLang::get('Cancel'). '</a>'; 
            ?>
            
        </p>
        
    </form>

<?php
        
        
        
        
    }

?>    
    
    
    
    <div class="clear"></div>
</div>
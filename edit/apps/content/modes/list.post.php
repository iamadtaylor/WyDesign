<div id="h1">
    <h1><?php echo PerchLang::get('Content'); ?></h1>
    <?php echo $help_html; ?>
</div>

<div id="side-panel">
    <h3 class="em">
        <span>
            <?php echo PerchLang::get('Filter'); ?>
            <span class="filter">
                <a href="<?php echo PerchUtil::html(PERCH_LOGINPATH.'/apps/content/'); ?>?by=all" class="filter-all <?php if ($filter=='all') echo 'selected'?>"><?php echo PerchUtil::html(PerchLang::get('All')); ?></a>
                <a href="<?php echo PerchUtil::html(PERCH_LOGINPATH.'/apps/content/'); ?>?by=new" class="filter-new <?php if ($filter=='new') echo 'selected'?>"><?php echo PerchUtil::html(PerchLang::get('New')); ?></a>
            </span>
        </span>
    </h3>

    <h4><?php echo PerchLang::get('By page assignment'); ?></h4>
    <?php
        $pages = $PerchContent->get_pages();
        if (PerchUtil::count($pages) > 0) {
            $sorted_pages = array();
            foreach($pages as $page) {
                $sorted_pages[] = array('page'=>$page, 'label'=>PerchUtil::filename($page, true, true));
            }
            $sorted_pages = PerchUtil::array_sort($sorted_pages, 'label');
    ?>
    <ul>
        <?php
            foreach ($sorted_pages as $page) {
                $page = $page['page'];
                if ($page == '*') {
                    $label = PerchLang::get('Shared');
                }else{
                    $label = PerchUtil::filename($page);
                }
                echo '<li><a href="'.PerchUtil::html(PERCH_LOGINPATH.'/apps/content/?page='.urlencode($page)).'">' . PerchUtil::html($label) . '</a></li>';
            }
        ?>
    </ul>
    <?php
        }
    ?>

    <h4><?php echo PerchLang::get('By type'); ?></h4>
    <?php
        $templates = $PerchContent->get_templates();
        if (PerchUtil::count($templates) > 0) {
    ?>
    <ul>
        <?php
            foreach ($templates as $template) {
                echo '<li><a href="'.PerchUtil::html(PERCH_LOGINPATH.'/apps/content/?type='.urlencode(str_replace('.html','',$template['filename']))).'">' . PerchUtil::html($template['label']) . '</a></li>';
            }
        ?>
    </ul>
    <?php
        }
    ?>
</div>

<div id="main-panel">
    
    <?php echo $Alert->output(); ?>
    
    <?php
    if (PerchUtil::count($contentItems) > 0) {
    ?>
    <table class="d">
        <thead>
            <tr>
                <th class="first"><?php echo PerchLang::get('Page'); ?></th>
                <th><?php echo PerchLang::get('Region'); ?></th>
                <th><?php echo PerchLang::get('Type'); ?></th>
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (PerchUtil::count($contentItems) > 0) {
                $prev = false;
                $prev_url = false;
                $level = 0;
                foreach($contentItems as $item) {
                    echo '<tr class="'.PerchUtil::flip('odd').'">';
                        if ($prev != $item->formattedPage()) {
                            
                            if ($level = PerchUtil::in_section($prev_url, $item->contentPage())) {                    
                                if ($item->contentPage() == '*') {
                                    echo '<td class="level'.$level.' shared"><span>' . PerchLang::get('Shared') . '</span></td>';
                                }else{
                                    echo '<td class="level'.$level.' page"><span>' . PerchUtil::html(PerchUtil::filename($item->contentPage(), false)) . '</span></td>';
                                }
                            }else{
                                $level = 0;
                                if ($item->contentPage() == '*') {
                                    echo '<td class="level'.$level.' shared"><span>' . PerchLang::get('Shared') . '</span></td>';
                                }else{
                                    echo '<td class="level'.$level.' page"><span>' . PerchUtil::html(PerchUtil::filename($item->contentPage(), false)) . '</span></td>';
                                }
                            }
                        }else{
     
                            echo '<td class="level'.($level+1).'"><span class="ditto">-</span></td>';
                        }
                        echo '<td><a href="edit?id=' . PerchUtil::html($item->id()) . '" class="edit">' . PerchUtil::html($item->contentKey()) . '</a></td>';       
                        echo '<td>' . ($item->contentNew() ? '<span class="new">'.PerchLang::get('New').'</span>' : PerchUtil::html($PerchContent->template_display_name($item->contentTemplate()))) . '</td>';
                        echo '<td>';
                        if ($CurrentUser->userRole() == 'Admin' || ($CurrentUser->userRole() == 'Editor' && $Settings->get('editorMayDeleteRegions')->settingValue())) {
                            echo '<a href="delete?id=' . PerchUtil::html($item->id()) . '" class="delete">'.PerchLang::get('Delete').'</a>';
                        }else{
                            echo '&nbsp;';
                        }
                        echo '</td>';
                    echo '</tr>';
                    $prev = $item->formattedPage();
                    $prev_url = $item->contentPage();
                }
            }
        
        ?>
        </tbody>
    </table>
    <?php
    }else{
    ?>
        <div class="info-panel">
        <?php if ($filter == 'all') { ?>
            <h2><?php echo PerchLang::get('No content yet?'); ?></h2>
            <p><?php echo PerchLang::get('Make sure you have added some Perch regions into your page, and then visited that page in your browser. Once you have, the regions should show up here.'); ?>
                <a href="http://docs.grabaperch.com/v1/gettingstarted"><?php echo PerchLang::get('Read the getting started guide to find out more'); ?>&hellip;</a>
            </p>
        <?php 
            } else {
        ?>
            <p class="alert-notice"><?php echo PerchLang::get('Sorry, there\'s currently no content available based on that filter'); ?> - <a href="?by=all"><?php echo PerchLang::get('View all'); ?></a></p>
        <?php
            }
        ?>
        </div>
    <?php    
    }
    ?>
    <div class="clear"></div>
</div>
<?php
    include(dirname(__FILE__) . '/../config/config.php');
    include(PERCH_PATH . '/inc/loader.php');
    $Perch  = PerchAdmin::fetch();
    include(PERCH_PATH . '/inc/auth.php');

    $Perch->find_installed_apps();
    
    include(PERCH_PATH . '/inc/top.php');
?>
    <div id="h1">
        <h1><?php echo PerchLang::get('Perch') . ' ' . PerchLang::get('Dashboard'); ?></h1>
<?php echo $help_html; ?>
        <?php echo $Alert->output(); ?>
    </div>

    
    <div id="side-panel">

    </div>

    <div id="main-panel">
        <h2><?php echo PerchLang::get('Welcome to Perch'); ?></h2>
        
        <p><?php 
            echo PerchLang::get('This is the dashboard. Something interesting will be here eventually. For now, all the good stuff is under '); 
            echo '<a href="'.PERCH_LOGINPATH .'/apps/content">' . PerchLang::get('Content') . '</a>';
        ?></p>

        <div class="clear"></div>
    </div>
<?php
    include(PERCH_PATH . '/inc/btm.php');

?>
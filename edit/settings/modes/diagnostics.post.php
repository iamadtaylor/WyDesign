<div id="h1">
    <h1><?php echo PerchLang::get('Settings'); ?></h1>
<?php echo $help_html; ?>
</div>


<div id="side-panel">
    <h3><span><?php echo PerchLang::get('Help'); ?></span></h3>
    
    <p><?php echo PerchLang::get('You may be asked for this information when requesting technical support.'); ?></p>

</div>

<div id="main-panel">
    
    <?php echo $Alert->output(); ?>
    
    <h2><?php echo PerchLang::get('Diagnostics report'); ?></h2>
    
    <div id="diagnostics">
        <ul>
            <li>Perch: <?php echo PerchUtil::html($Perch->version); ?></li>
            <li>PHP: <?php echo PerchUtil::html(phpversion()); ?></li>
            <li>Zend: <?php echo PerchUtil::html(zend_version()); ?></li>
            <li>MySQL client: <?php echo PerchUtil::html(mysql_get_client_info()); ?></li>
            <li>MySQL server: <?php echo PerchUtil::html(mysql_get_server_info()); ?></li>
            <li>Extensions: <?php echo PerchUtil::html(implode(', ', get_loaded_extensions())); ?></li>
            <li>GD: <?php echo PerchUtil::html((extension_loaded('gd')? 'Yes' : 'No')); ?></li>
            <li>ImageMagick: <?php echo PerchUtil::html((extension_loaded('imagick')? 'Yes' : 'No')); ?></li>
            <li>PERCH_DB_USERNAME: <?php echo PerchUtil::html(PERCH_DB_USERNAME); ?></li>
            <li>PERCH_DB_SERVER: <?php echo PerchUtil::html(PERCH_DB_SERVER); ?></li>
            <li>PERCH_DB_DATABASE: <?php echo PerchUtil::html(PERCH_DB_DATABASE); ?></li>
            <li>PERCH_DB_PREFIX: <?php echo PerchUtil::html(PERCH_DB_PREFIX); ?></li>
            <li>PERCH_LOGINPATH: <?php echo PerchUtil::html(PERCH_LOGINPATH); ?></li>
            <li>PERCH_PATH: <?php echo PerchUtil::html(PERCH_PATH); ?></li>
            <li>PERCH_RESFILEPATH: <?php echo PerchUtil::html(PERCH_RESFILEPATH); ?></li>
            <li>PERCH_RESPATH: <?php echo PerchUtil::html(PERCH_RESPATH); ?></li>
            <li>Resource folder writeable: <?php echo is_writable(PERCH_RESFILEPATH)?'Yes':'No'; ?></li>
            <li>Native JSON: <?php echo function_exists('json_encode')?'Yes':'No'; ?></li>
            <li>Users: <?php echo PerchDB::fetch()->get_value('SELECT COUNT(*) FROM '.PERCH_DB_PREFIX.'users'); ?></li>        
            <li>H1: <?php echo PerchUtil::html(md5($_SERVER['SERVER_NAME'])); ?></li>
            <li>L1: <?php echo PerchUtil::html(md5(PERCH_LICENSE_KEY)); ?></li>
            <?php
                foreach($_SERVER as $key=>$val) {
                    if ($key && $val)
                    echo '<li>' . PerchUtil::html($key) . ': ' . PerchUtil::html($val).'</li>';
                }
            ?>
        </ul>
        
    </div>
    

    <div class="clear"></div>
</div>
<?php
    $Settings->get('headerColour')->settingValue();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php echo PerchUtil::html(PerchLang::get($Perch->page_title) . ' - ' . PerchLang::get('Perch')); ?></title>
	<link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/reset.css" type="text/css" />
<?php
    if ($CurrentUser->logged_in()) {
?>
	<link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/default.css" type="text/css" />
	<!--[if IE 6]><link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/ie6.css" type="text/css" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/ie7.css" type="text/css" /><![endif]-->
	
<?php
    }else{
?>
	<link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/login.css" type="text/css" />   
<?php
    }
    if (PERCH_DEBUG) {
?>
    <link rel="stylesheet" href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/css/debug.css" type="text/css" />
<?php
    }
?>    
	<style type="text/css" media="screen">
	    /* Custom settings */
	   #hd { 
	       background-color: <?php echo PerchUtil::html(rtrim($Settings->get('headerColour')->settingValue(), ';')); ?>;
	   }
	   #hd ul#nav li a:link, #hd ul#nav li a:visited,
	   #hd ul#metanav li a:link, #hd ul#metanav li a:visited  {
	       color: <?php echo PerchUtil::html(rtrim($Settings->get('linkColour')->settingValue(), ';')); ?>;
	   }
	   <?php
	        $val = strtolower($Settings->get('headerColour')->settingValue());
	        if ($val!='#fff' && $val!='#ffffff' && $val!='white') {
	            echo "#login .bd form, #content #h1 { 
	                border-top: none; 
	            }"; 
	        }
	   ?>
	</style>
	<script src="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/assets/js/perch.js" type="text/javascript"></script>
<?php
    if ($CurrentUser->logged_in()) {
        $javascript = $Perch->get_javascript();
        foreach($javascript as $js) {
            echo "\t".'<script type="text/javascript" src="'.PerchUtil::html($js).'"></script>'."\n";
        }
        
        $stylesheets = $Perch->get_css();
        foreach($stylesheets as $css) {
            echo "\t".'<link rel="stylesheet" href="'.PerchUtil::html($css).'" type="text/css" />'."\n";
        }
        
        echo $Perch->get_head_content();
    }
?>

</head>


<?php
    if ($CurrentUser->logged_in()) {
?>
<body>
    <div id="hd">

		<ul id="metanav">
		    <?php
		        if ($CurrentUser->userRole() == 'Admin') {
		    ?>
		    <li>
		        <a href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/settings" class="<?php if ($Perch->get_section()=='settings') echo 'selected'; ?>"><?php echo PerchLang::get('Settings'); ?></a>
		    </li>
		    <?php
	            }
		    ?>
			<li class="hybrid <?php if ($Perch->get_section()=='account') echo 'selected'; ?>">
			    <a href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>/account" class="account"><?php echo PerchLang::get('My Account'); ?></a>
			    <a href="<?php echo PerchUtil::html(PERCH_LOGINPATH); ?>?logout=1" class="logout"><?php echo PerchLang::get('Log out'); ?></a>
			</li>
		</ul>

		
		
		
    <?php
        if ($CurrentUser->logged_in()) {
            $nav   = $Perch->get_apps();
            
            echo '<a id="logo" href="'.$nav[0]['path'] . '"><img src="'.PerchUtil::html($Settings->get('logoPath')->settingValue()) .'" alt="Logo" /></a>';
            
            if ($CurrentUser->userRole() == 'Admin') array_push($nav, array('path'=>PERCH_LOGINPATH.'/users', 'label'=>'Users', 'section'=>'users'));
            $section   = $Perch->get_section();
            
            if (is_array($nav)) {
                echo '<ul id="nav">';
                
                foreach($nav as $item) {
                    if ($item['section'] == $section) {
                        echo '<li class="selected">';
                    }else{
                        echo '<li>';
                    }
                    echo '<a href="'.PerchUtil::html($item['path']).'">'.PerchUtil::html(PerchLang::get($item['label'])).'</a></li>';
                }
                
                echo '</ul>';
            }
            
         
         
            // Help markup as used by apps etc
            $help_html  = '<a id="help" href="'.PERCH_LOGINPATH.'/help"><span>'.PerchLang::get('Help').'</span></a>';
            
        }
    
    ?>
        <span class="clear"> </span>
    </div>
<?php
    }else{
?>
<body class="login">
<?php        
    }
?>
    <div id="content">
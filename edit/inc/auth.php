<?php

    $Users  = new PerchUsers;
    $CurrentUser   = $Users->get_current_user();
    
    /* Check for incoming login form and attempt login */
    $username = false;
    $password = false;
    if (isset($_POST['username']) && isset($_POST['password'])
        && $_POST['username']!='' && $_POST['password']!='') {
         $username   = $_POST['username'];
         $password   = $_POST['password']; 
    }
    
    if ($username!=false && $password!=false) {
        $CurrentUser->authenticate($username, $password);
    }
    
    
    if (!isset($auth_page)) {
        $auth_page = false;
    }
    
    if (!$CurrentUser->logged_in() && !$auth_page) {
        PerchUtil::redirect(PERCH_LOGINPATH);
    }
    
    $Settings   = PerchSettings::fetch();
    $Alert   = new PerchAlert;
    
?>
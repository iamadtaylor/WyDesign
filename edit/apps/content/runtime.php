<?php

    require('PerchContent.class.php');

    function perch_content($key=false, $return=false)
    {
        if ($key === false) {
            echo 'You must pass in a <em>key</em> for the content. e.g. <code style="color: navy;background: white;">&lt;' . '?php perch_content(\'phone_number\'); ?' . '&gt;</code>'; 
        }
        
        
        $content = PerchContent::fetch();
        
        if ($return) {
            return $content->get($key);
        }else{
            echo $content->get($key);
        }
    }

?>
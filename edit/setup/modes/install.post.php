    <h1>Installing...</h1>
    
<?php
    if (defined('PERCH_DB_PREFIX')) {

        echo '<p>Creating database tables&hellip; ';

        $db = PerchDB::fetch();
    
        $sql = file_get_contents('database.sql');
        $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
        $sql = str_replace('__PERCH_LOGINPATH__', PERCH_LOGINPATH, $sql);
        $queries = explode(';', $sql);
        if (PerchUtil::count($queries) > 0) {
            foreach($queries as $query) {
                $query = trim($query);
                if ($query != '') {
                    $db->execute($query);
                }
            }
        
            // test that it worked
            $tables = $db->get_rows('SHOW TABLES');
            $db_fail = true;
            if (PerchUtil::count($tables)) {
                foreach($tables as $key=>$val) {
                    foreach($val as $key2=>$val2) {
                        if ($val2 == PERCH_DB_PREFIX.'users') {
                            $db_fail = false;
                        }
                    }
                }
            }
            if ($db_fail) {
                echo '</p>';
                echo '<p><strong>Unable to create database tables.</strong> It is likely that the MySQL user hasn\'t got enough access rights to create tables. Either change this, if you can, or run the following SQL code via a control panel (such as PhpMyAdmin) if you have one. <a href="index.php?install=1">Then reload this page</a>.</p>';
            
                echo '<div><textarea rows="20" cols="60">'.$sql.'</textarea></div>';
            
            
            }else{
                echo 'done.';
                echo '</p>';
            
            
                echo '<p>Setting up initial user account&hellip; ';
        
                $Users = new PerchUsers;
        
                $data = PerchSession::get('user');
                $data['userRole'] = 'Admin';
                $Users->create($data);
        
                echo 'done.</p>';
            
?>
                <p>Setup complete.</p>
    
                <h2>Next steps</h2>
    
                <p>There's just two things left for you to do:</p>
    
                <ol>
                    <li>Make the folder <code><?php echo PERCH_PATH . DIRECTORY_SEPARATOR; ?>resources</code> writable for file uploads</li>
                    <li>Delete the setup folder from your server.</li>
                </ol>
    
                <p><a href="<?php echo PERCH_LOGINPATH; ?>">You should now be able to login &raquo;</a></p>
    
<?php            
            }




        }

    }else{
        echo '<p>No configuration values can be found. Please check you added the settings to <code>perch/config/config.php</code>. <a href="index.php?install=1">Then reload this page</a></p>';
    }

?>
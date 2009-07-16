    <h1>Perch Setup</h1>
    
    <p>Welcome to Perch. In order to get set up, there's a few boring questions to answer below. If you don't know any of the answers (or the defaults look wrong) your ISP or hosting company should have the information available for you.</p>
    
    <form method="post" action="index.php">
        <fieldset>
            <legend>Your license</legend>
            <div>
                <?php echo $Form->label('licenseKey', 'License Key'); ?>
                <?php echo $Form->text('licenseKey', $Form->get(false, 'licenseKey'), 'wide'); ?>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>About you</legend>
            <div>
                <?php echo $Form->label('userGivenName', 'First name'); ?>
                <?php echo $Form->text('userGivenName', $Form->get(false, 'userGivenName')); ?>
            </div>
            <div>
                <?php echo $Form->label('userFamilyName', 'Last name'); ?>
                <?php echo $Form->text('userFamilyName', $Form->get(false, 'userFamilyName')); ?>
            </div>
            <div>
                <?php echo $Form->label('userEmail', 'Email address'); ?>
                <?php echo $Form->text('userEmail', $Form->get(false, 'userEmail')); ?>
            </div>
            <div>
                <?php echo $Form->label('userUsername', 'Username'); ?>
                <?php echo $Form->text('userUsername', $Form->get(false, 'userUsername')); ?>
                <?php echo $Form->hint('Choose a username for your own account'); ?>
            </div>
            <div>
                <?php echo $Form->label('userPassword', 'Password'); ?>
                <?php echo $Form->password('userPassword', $Form->get(false, 'userPassword')); ?>
                <?php echo $Form->hint('Choose a password'); ?>
            </div>            
            <div>
                <?php echo $Form->label('userPassword2', 'Repeat'); ?>
                <?php echo $Form->password('userPassword2'); ?>
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Install location</legend>
            
            <div>
                <?php echo $Form->label('loginpath', 'Perch folder'); ?>
                <?php 
                    $url = str_replace('/setup/index.php', '', $_SERVER['PHP_SELF']);
                    echo $Form->text('loginpath', $Form->get(false, 'loginpath', $url)); ?>
                <?php echo $Form->hint('The path to (and including) the Perch folder from the root of the site'); ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Database settings</legend>
            <div>
                <?php echo $Form->label('db_server', 'Server'); ?>
                <?php echo $Form->text('db_server', $Form->get(false, 'db_server', 'localhost')); ?>
                <?php echo $Form->hint('Usually localhost'); ?>
            </div>
            <div>
                <?php echo $Form->label('db_database', 'Database name'); ?>
                <?php echo $Form->text('db_database', $Form->get(false, 'db_database')); ?>
            </div>
            <div>
                <?php echo $Form->label('db_username', 'Database username'); ?>
                <?php echo $Form->text('db_username', $Form->get(false, 'db_username')); ?>
            </div>
            <div>
                <?php echo $Form->label('db_password', 'Database password'); ?>
                <?php echo $Form->text('db_password', $Form->get(false, 'db_password')); ?>
            </div>
        </fieldset>
        
        <p class="submit">
            <?php echo $Form->submit('btnSubmit', 'Next step', 'button'); ?>
        </p>
        
        
    </form>
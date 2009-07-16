<?php

    define('PERCH_LICENSE_KEY', 'P10907-FTD708-ZNC592-AEM388-MER001');

    define("PERCH_DB_USERNAME", 'iamadtay_wyPerch');
    define("PERCH_DB_PASSWORD", 'cheese01');
    define("PERCH_DB_SERVER", "localhost");
    define("PERCH_DB_DATABASE", "iamadtay_wychall");
    define("PERCH_DB_PREFIX", "perch_");
    
    define('PERCH_EMAIL_FROM', 'ad@iamadtaylor.com');
    define('PERCH_EMAIL_FROM_NAME', 'Adam Taylor');

    define('PERCH_LOGINPATH', '/edit');
    define('PERCH_PATH', str_replace(DIRECTORY_SEPARATOR.'config', '', dirname(__FILE__)));

    // define('PERCH_RESFILEPATH', PERCH_PATH . DIRECTORY_SEPARATOR . 'resources');
    // define('PERCH_RESPATH', PERCH_LOGINPATH . '/resources');

    define('PERCH_RESFILEPATH', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR . 'resources');
    define('PERCH_RESPATH',  '/resources');
?>
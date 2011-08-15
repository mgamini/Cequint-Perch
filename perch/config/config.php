<?php

    define('PERCH_LICENSE_KEY', 'P11107-HQA430-QEY010-JFR607-HHA015');

    define("PERCH_DB_USERNAME", 'perch');
    define("PERCH_DB_PASSWORD", 'perch');
    define("PERCH_DB_SERVER", "localhost");
    define("PERCH_DB_DATABASE", "perch");
    define("PERCH_DB_PREFIX", "perch_");
    
    define('PERCH_EMAIL_FROM', 'gamini@cequint.com');
    define('PERCH_EMAIL_FROM_NAME', 'Garrett Amini');

    define('PERCH_LOGINPATH', '/perch/perch');
    define('PERCH_PATH', str_replace(DIRECTORY_SEPARATOR.'config', '', dirname(__FILE__)));

    define('PERCH_RESFILEPATH', PERCH_PATH . DIRECTORY_SEPARATOR . 'resources');
    define('PERCH_RESPATH', PERCH_LOGINPATH . '/resources');
  
?>
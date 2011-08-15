<?php

    require('PerchContent.class.php');
    require('PerchContentItem.class.php');

    perch_content_check_preview();

    function perch_content($key=false, $return=false)
    {
        if ($key === false) {
            echo 'You must pass in a <em>key</em> for the content. e.g. <code style="color: navy;background: white;">&lt;' . '?php perch_content(\'Phone number\'); ?' . '&gt;</code>'; 
        }
        
        $Content = PerchContent::fetch();
        
        if ($return) {
            return $Content->get($key);
        }else{
            echo $Content->get($key);
        }
    }
    
    
    function perch_content_custom($key=false, $opts=false, $return=false)
    {
        if ($key === false) return ' ';
        
        if (isset($opts['skip-template']) && $opts['skip-template']==true) $return = true; 
        
        $Content = PerchContent::fetch();
        
        if ($return) return $Content->get_custom($key, $opts);

        echo $Content->get_custom($key, $opts);
    }
    
    
    function perch_content_check_preview()
    {
        if (isset($_GET['preview'])) {
            if ($_GET['preview'] == 'all') {
                $contentID = 'all';
            }else{
                $contentID  = (int)$_GET['preview'];
            }
            
            $rev        = false;
            
            if (isset($_GET['rev']) && is_numeric($_GET['rev'])) {
                $rev = (int)$_GET['rev'];
            }
            
            $Users          = new PerchUsers;
            $CurrentUser    = $Users->get_current_user();
            
            if (is_object($CurrentUser) && $CurrentUser->logged_in()) {
                $Content = PerchContent::fetch();
                $Content->set_preview($contentID, $rev);
            }
        }
    }
    

?>
<?php
    /*
        This file includes the code called by the site pages at runtime.
        If you app is admin-only then don't include this file.
        
        Remember - try and be as lightweight at runtime as possble. Include only 
        what you need to, run only 100% necessary code. Make every database query
        count.
    */

    # Include your class files as needed - up to you.
    require('PerchPages_Pages.class.php');
    require('PerchPages_Page.class.php');


    function perch_pages_title($return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_pages');
        $Pages = new PerchPages_Pages($API);
        $Perch = Perch::fetch();
        
        $Page = $Pages->find_by_path($Perch->get_page());
        
        $r = '';
        
        if (is_object($Page)) {
            $r = $Page->pageTitle();
        }
        
        if ($return) return $r;
        
        echo $r;
    }
    
    function perch_pages_navigation($opts=array(), $return=false)
    {
        $API  = new PerchAPI(1.0, 'perch_pages');
        $Pages = new PerchPages_Pages($API);
        $Perch = Perch::fetch();
        
        $default_opts = array(
            'navgroup'=>'default',
            'from_path'=>'/',
            'levels'=>0,
            'hide_extensions'=>false,
            'flat'=>false,
            'template'=>'pages-navigation/item.html',
            'flatten_home'=>true
        );
        
        if (is_array($opts)) {
            $opts = array_merge($default_opts, $opts);
        }else{
            $opts = $default_opts;
        }
        
        
        $current_page = $Perch->get_page();
        
        if ($opts['from_path']=='*') {
            $parts = explode('/', $current_page);
            array_pop($parts);
            $opts['from_path'] = implode('/', $parts);
        }
        
        $r = $Pages->get_navigation($opts, $current_page);
        
        if ($return) return $r;
        
        echo $r;
    }
    

?>
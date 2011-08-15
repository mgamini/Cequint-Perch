<?php
    $Perch->add_css($API->app_path().'/assets/css/pages.css');

    $HTML = $API->get('HTML');
    $Pages = new PerchPages_Pages($API);
    $NavGroups = new PerchPages_NavGroups($API);
    
    $Pages->import();
    //$Pages->auto_reorder();
    $Pages->order_unordered_pages();
    
    $pages = $Pages->all();
    $navgroups = $NavGroups->all();
    
    if (!PerchUtil::count($pages)) {
        $Pages->attempt_install();
    }
?>
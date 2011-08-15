<?php

    $Perch->add_css($API->app_path().'/assets/css/pages.css');

    $message = false;

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Pages     = new PerchPages_Pages($API); 
    
    if ($Form->submitted()) {
        $Pages->auto_reorder(false);        
        $message = $HTML->success_message('Your pages have been successfully reordered. Return to %spage listing%s', '<a href="'.$API->app_path().'">', '</a>');
    }
    
?>
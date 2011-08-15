<?php

    $Perch->add_css($API->app_path().'/assets/css/pages.css');

    $message = false;

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Pages     = new PerchPages_Pages($API); 


    
    if ($Form->submitted()) {
        
        $items = $Form->find_items('order-');
        
        if (PerchUtil::count($items)) {
            foreach($items as $pageID=>$newOrder) {
                $Page = $Pages->find($pageID);
                if (is_object($Page)) {
                    // load existing descendants before we do anything drastic
                    $data = array();
                    $data['pageOrder'] = $newOrder;
                    $Page->update($data);
                }
            }
        }
        
        $message = $HTML->success_message('Your pages have been successfully reordered. Return to %spage listing%s', '<a href="'.$API->app_path().'">', '</a>');
    }
    
    $pages = $Pages->all();
?>
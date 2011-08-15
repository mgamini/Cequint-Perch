<?php

    $Perch->add_css($API->app_path().'/assets/css/pages.css');

    $message = false;

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $NavGroups = new PerchPages_NavGroups($API);
    $Pages     = new PerchPages_Pages($API); 

    if (isset($_GET['id']) && $_GET['id']!='') {
        $parentID = (int) $_GET['id'];    
        $ParentPage = $Pages->find($parentID);
    }else{
        PerchUtil::redirect($API->app_path());
    }

    
    
    if ($Form->submitted()) {
        
        $parentPrefix = $ParentPage->pageOrder().'-';
        
        $items = $Form->find_items('order-');
        
        if (PerchUtil::count($items)) {
            $arrPages  = array();
            foreach($items as $pageID=>$newOrder) {
                $tmpPage = $Pages->find($pageID);
                if (is_object($tmpPage)) {
                    // load existing descendants before we do anything drastic
                    $tmpPage->load_descendants();
                    $tmpPage->squirrel('newOrder', $parentPrefix.$newOrder);
                    $arrPages[] = $tmpPage;
                }
                
            }
            
            if (PerchUtil::count($arrPages)) {
                foreach($arrPages as $Page) {
                    $Page->set_new_order($Page->newOrder());
                }
            }
        }
        
        $message = $HTML->success_message('Your pages have been successfully reordered. Return to %spage listing%s', '<a href="'.$API->app_path().'">', '</a>');
    }
    
    $pages = $Pages->get_decendants($ParentPage);
?>
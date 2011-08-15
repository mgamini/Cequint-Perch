<?php

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $NavGroups = new PerchPages_NavGroups($API);
    $Templates = new PerchPages_Templates($API);
    $Pages     = new PerchPages_Pages($API); 
    
    if (isset($_GET['id']) && $_GET['id']!='') {
        $pageID = (int) $_GET['id'];    
        $Page = $Pages->find($pageID);
        $details = $Page->to_array();
    }else{
        $Page = false;
        $details = array();
        $pageID = false;
    }
    
    $message = false;
    $created = false;
    
    
    $Form->require_field('pageTitle', 'Required');
    
    
    if ($Form->submitted()) {
        $postvars = array('pageTitle', 'pageSection', 'templateID', 'navgroupID');
    	$data = $Form->receive($postvars);
    	
    	$data['pageNew'] = 0;
    	
    	if (!is_object($Page)) {
    	    $Page = $Pages->create_with_file($data);
    	    if (is_object($Page)) {
    	        PerchUtil::redirect($API->app_path().'/edit/?id='.$Page->id().'&created=true');
    	    }else{
    	        $message = '';
    	        
    	        $errors = $Pages->get_errors();
    	        if (PerchUtil::count($errors)) {
    	            foreach($errors as $error) {
    	                $message .= $HTML->failure_message($error);
    	            }
    	        }
    	        
    	        $message .= $HTML->failure_message('Sorry, that page could not be created.');
    	        
    	        
    	    }
    	}else{
    	    $Page->update($data);
    	    $message = $HTML->success_message('Your page has been successfully updated. Return to %spage listing%s', '<a href="'.$API->app_path() .'/">', '</a>');
    	    $details = $Page->to_array();
    	}
                
    }
    
    if (isset($_GET['created']) && !$message) {
        $message = $HTML->success_message('Your page has been successfully created. Return to %spage listing%s', '<a href="'.$API->app_path() .'">', '</a>');
        $created = true;
    }
?>
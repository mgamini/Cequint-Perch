<?php
    
    $Templates = new PerchPages_Templates($API);
    $Pages      = new PerchPages_Pages($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
	
    $message = false;
        
    if (isset($_GET['id']) && $_GET['id']!='') {
        $templateID = (int) $_GET['id'];    
        $Template = $Templates->find($templateID);
        $details = $Template->to_array();
    }else{
        PerchUtil::redirect($API->app_path().'/templates');
    }
    

    $Form->require_field('templateTitle', 'Required');

    if ($Form->submitted()) {
		$postvars = array('templateTitle', 'optionsPageID', 'templateReference');
		
    	$data = $Form->receive($postvars);
    	
    	if (is_object($Template)) {
    	    $Template->update($data);
    	    $message = $HTML->success_message('Your template has been successfully edited. Return to %stemplate listing%s', '<a href="'.$API->app_path() .'/manage-templates">', '</a>');
    	}	    
    	
        $details = $Template->to_array();
    }

?>
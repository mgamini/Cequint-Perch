<?php
    
    $Templates = new PerchPages_Templates($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
	$Form->require_field('templateID', 'Required');
	
	$message = false;
	
	if (isset($_GET['id']) && $_GET['id']!='') {
	    $Template = $Templates->find($_GET['id']);
	}else{
	    PerchUtil::redirect($API->app_path().'/manage-templates/');
	}
	

    if ($Form->submitted()) {
    	$postvars = array('templateID');
		
    	$data = $Form->receive($postvars);
    	
    	$Template = $Templates->find($data['templateID']);
    	
    	if (is_object($Template)) {
    	    $Template->delete();
            PerchUtil::redirect($API->app_path() .'/manage-templates/');
        }else{
            $message = $HTML->failure_message('Sorry, that template could not be deleted.');
        }
    }

    
    
    $details = $Template->to_array();



?>
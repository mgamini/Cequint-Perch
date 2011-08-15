<?php
    
    $Pages = new PerchPages_Pages($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
	$Form->require_field('pageID', 'Required');
	
	$message = false;
	
	if (isset($_GET['id']) && $_GET['id']!='') {
	    $Page = $Pages->find($_GET['id']);
	}else{
	    PerchUtil::redirect($API->app_path());
	}
	

    if ($Form->submitted()) {
    	$postvars = array('pageID');
		
    	$data = $Form->receive($postvars);
    	
    	$Page = $Pages->find($data['pageID']);
    	
    	if (is_object($Page)) {
    	    $Page->delete();
            PerchUtil::redirect($API->app_path());
        }else{
            $message = $HTML->failure_message('Sorry, that page could not be deleted.');
        }
    }

    
    
    $details = $Page->to_array();



?>
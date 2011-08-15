<?php
    
    $NavGroups = new PerchPages_NavGroups($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
	$Form->require_field('navgroupID', 'Required');
	
	$message = false;
	
	if (isset($_GET['id']) && $_GET['id']!='') {
	    $NavGroup = $NavGroups->find($_GET['id']);
	}else{
	    PerchUtil::redirect($API->app_path());
	}
	

    if ($Form->submitted()) {
    	$postvars = array('navgroupID');
		
    	$data = $Form->receive($postvars);
    	
    	$NavGroup = $NavGroups->find($data['navgroupID']);
    	
    	if (is_object($NavGroup)) {
    	    $NavGroup->delete();
            PerchUtil::redirect($API->app_path() .'/nav/');
        }else{
            $message = $HTML->failure_message('Sorry, that group could not be deleted.');
        }
    }

    
    
    $details = $NavGroup->to_array();



?>
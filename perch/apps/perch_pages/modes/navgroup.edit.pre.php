<?php
    
    $NavGroups = new PerchPages_NavGroups($API);

    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
	
    $message = false;
        
    if (isset($_GET['id']) && $_GET['id']!='') {
        $navgroupID = (int) $_GET['id'];    
        $NavGroup = $NavGroups->find($navgroupID);
        $details = $NavGroup->to_array();
    }else{
        $NavGroup = false;
        $details = array();
        $navgroupID = false;
    }
    

    $Form->require_field('navgroupTitle', 'Required');

    if ($Form->submitted()) {
		$postvars = array('navgroupTitle');
		
    	$data = $Form->receive($postvars);
    	
    	if (is_object($NavGroup)) {
    	    $NavGroup->update($data);
    	}else{
    	    $NavGroup = $NavGroups->create($data);
    	    if (is_object($NavGroup)) {
    	        PerchUtil::redirect($API->app_path().'/nav/edit/?id='.$NavGroup->id().'&created=true');
    	    }else{
    	        $message = $HTML->failure_message('Sorry, that group could not be created.');
    	    }
    	}
    	    
    	
        if (is_object($NavGroup)) {
            $message = $HTML->success_message('Your navigation group has been successfully edited. Return to %sgroup listing%s', '<a href="'.$API->app_path() .'/nav">', '</a>');
        }else{
            $message = $HTML->failure_message('Sorry, that group could not be edited.');
        }
        
        $details = $NavGroup->to_array();
    }

    if (isset($_GET['created']) && !$message) {
        $message = $HTML->success_message('Your group has been successfully created. Return to %sgroup listing%s', '<a href="'.$API->app_path() .'/nav">', '</a>');
    }

?>
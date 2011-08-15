<?php
    # include the API
    include('../../../../inc/api.php');
    
    if ($CurrentUser->userRole() != 'Admin') {
        PerchUtil::redirect(PERCH_LOGINPATH.'/apps/perch_pages/');
    }
    
    $API  = new PerchAPI(1.0, 'perch_pages');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # include your class files
    include('../../PerchPages_Pages.class.php');
    include('../../PerchPages_Page.class.php');
    include('../../PerchPages_Templates.class.php');
    include('../../PerchPages_Template.class.php');

    # Set the page title
    $Perch->page_title = $Lang->get('Pages') . ' - ' .$Lang->get('Templates') . ' - ' . $Lang->get('Delete Template');

    # Do anything you want to do before output is started
    include('../../modes/template.delete.pre.php');
    
    
    # Top layout
    include(PERCH_PATH . '/inc/top.php');

    
    # Display your page
    include('../../modes/template.delete.post.php');
    
    
    # Bottom layout
    include(PERCH_PATH . '/inc/btm.php');
?>
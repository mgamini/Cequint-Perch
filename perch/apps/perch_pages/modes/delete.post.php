<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Delete');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
    echo $HTML->heading3('Delete Page');
    echo $HTML->para('Are you sure?');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start(); 
    echo $Form->form_start();
    
    if ($message) {
        echo $message;
    }else{
        echo $HTML->warning_message('Are you sure you wish to delete the page %s?', $details['pageTitle']);
        echo $Form->form_start();
        echo $Form->hidden('pageID', $details['pageID']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());


        echo $Form->form_end();
    }
    
    echo $HTML->main_panel_end();

?>
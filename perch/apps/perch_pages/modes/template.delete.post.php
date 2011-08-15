<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Templates / Delete Template');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
    echo $HTML->heading3('Delete Template');
    echo $HTML->para('Are you sure?');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start(); 
    echo $Form->form_start();
    
    if ($message) {
        echo $message;
    }else{
        echo $HTML->warning_message('Are you sure you wish to delete the template %s?', $details['templateTitle']);
        echo $HTML->para('Any pages referencing this template could break!');
        echo $HTML->para('You will also need to delete the corresponding file in your templates folder, otherwise the template we be automatically added back to the list.');
        echo $Form->form_start();
        echo $Form->hidden('templateID', $details['templateID']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());


        echo $Form->form_end();
    }
    
    echo $HTML->main_panel_end();

?>
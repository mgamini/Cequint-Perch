<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Navigation Groups / Edit');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
            echo $HTML->heading3('New Group');
            echo $HTML->para('%sAdd new navigation group%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/nav/edit/').'">', '</a>');

            echo $HTML->heading3('More actions');
            echo $HTML->para('%sView page listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/').'">', '</a>');
            echo $HTML->para('%sAdd new page%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/edit/').'">', '</a>');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start(); 
    
    if ($message) echo $message;
    
    echo $HTML->heading2('Group details');
        
    
    echo $Form->form_start();
    
        echo $Form->text_field('navgroupTitle', 'Title', @$details['navgroupTitle']);
		echo $Form->hidden('navgroupID', @$details['navgroupID']);
        
        

        echo $Form->submit_field('btnSubmit', 'Save', $API->app_path().'/nav/');

    
    echo $Form->form_end();
    
    echo $HTML->main_panel_end();

?>
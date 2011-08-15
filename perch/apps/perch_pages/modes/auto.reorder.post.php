<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Reorder');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
    echo $HTML->heading3('More actions');
    echo $HTML->para('%sView page listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/').'">', '</a>');
    echo $HTML->para('%sAdd new page%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/edit/').'">', '</a>');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();
    
        if ($message) echo $message;
    
        echo $Form->form_start();
            echo $HTML->para('If your pages are displaying in the wrong order, Perch can attempt to automatically reorganise them into a tree.');
            echo $HTML->para('This isn\'t always perfect, but may help in some circumstances.');
            echo $Form->submit_field('btnSubmit', 'Reorder pages', $API->app_path());
        echo $Form->form_end();
    
    echo $HTML->main_panel_end();


?>
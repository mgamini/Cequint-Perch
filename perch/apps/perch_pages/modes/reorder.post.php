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

        echo $HTML->heading2('Reorder pages');
    
        echo $Form->form_start();
        
            if (PerchUtil::count($pages)) {
                
                echo '<ul class="reorder">';
                
                foreach($pages as $Page) {
                    echo '<li class="page">'.$HTML->encode($Page->pageTitle());
                    
                    echo '<span class="order">';
                    
                    $key = 'order-'.$Page->id();
                    
                    echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$Page->shorthand_order().'" />';
                    
                    echo '</span>';
                    
                    echo '</li>';
                }
                
                
                echo '</ul>';
                
                echo $Form->submit_field('btnSubmit', 'Save', $API->app_path());
            }
        
            
        echo $Form->form_end();
    
    echo $HTML->main_panel_end();


?>
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
    
    echo $HTML->heading3('Instructions');
    echo $HTML->para('This is an advanced ordering mode to help fix things if your tree won\'t display correctly.');
    echo $HTML->para('Each page inherits the order string from its parent, and then adds a dash an its order within that section.');
    echo $HTML->para('If <code>/about</code> was <code>02</code> then <code>/about/history</code> would be <code>02-01</code> and <code>/about/people</code> might be <code>02-02</code>');
    echo $HTML->para('Then <code>/about/history/incorporation</code> might be <code>02-01-01</code> as it is a child of <code>/about/history</code>. Easy!');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();
    
        if ($message) echo $message;
    
        echo $Form->form_start();
        
            if (PerchUtil::count($pages)) {
        
?>

    <table class="d">
         <thead>
             <tr>
                 <th class="first"><?php echo $Lang->get('Title'); ?></th>
                 <th><?php echo $Lang->get('Path'); ?></th>
                 <th class="action last">Order</th>
             </tr>
         </thead>
         <tbody>

<?php        
                foreach($pages as $Page) {
                    echo '<tr>';
                    
                    echo '<td class="page level'.$Page->pageDepth().'"><span>'.$HTML->encode($Page->pageTitle()) . '</span></td>';
                    
                    echo '<td class="dimmed">'.$HTML->encode($Page->pagePath()).'</td>';
                    
                    echo '<td class="order">';
                    
                    $key = 'order-'.$Page->id();
                    
                    echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$Page->pageOrder().'" />';
                    
                    echo '</td>';
                    
                    echo '</tr>';
                }
        
                
?>
        </tbody>
    </table>

<?php
            echo $Form->submit_field('btnSubmit', 'Save', $API->app_path());
        }

            
        echo $Form->form_end();
    
    echo $HTML->main_panel_end();


?>
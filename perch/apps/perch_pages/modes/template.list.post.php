<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Templates');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
            
        echo $HTML->heading3('More actions');
        echo $HTML->para('%sView page listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/').'">', '</a>');
        echo $HTML->para('%sAdd new page%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/edit/').'">', '</a>');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();
    
    if (PerchUtil::count($templates)) {
?>
    <table class="d">
        <thead>
            <tr>
                <th class="first"><?php echo $Lang->get('Title'); ?></th>
                <th><?php echo $Lang->get('Path'); ?></th>
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($templates as $Template) {
?>
            <tr>
                <td><a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/manage-templates/edit/?id=<?php echo $HTML->encode(urlencode($Template->id())); ?>"><?php echo $HTML->encode($Template->templateTitle())?></a></td>
                <td><?php echo $HTML->encode($Template->templatePath())?></td>  
                <td>
                    <a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/manage-templates/delete/?id=<?php echo $HTML->encode(urlencode($Template->id())); ?>" class="delete"><?php echo $Lang->get('Delete'); ?></a>
                </td>
                
            </tr>

<?php   
    }
?>
        </tbody>
    </table>


    
<?php    
    } // if pages
    
     
    echo $HTML->main_panel_end();


?>
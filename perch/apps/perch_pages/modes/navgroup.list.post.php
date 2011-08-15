<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Navigation Groups');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
        
        echo $HTML->heading3filter('About navigation groups', array());
        echo $HTML->para('Navigation groups help you to organise links by the locations they should appear on your site.');
        echo $HTML->para('Prevent a top-level page (such as \'Privacy Policy\') appearing in your top-level navigation by assigning it to a different navigation group.');
            
        echo $HTML->heading3('New group');
        echo $HTML->para('%sAdd new navigation group%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/nav/edit/').'">', '</a>');
    
        echo $HTML->heading3('More actions');
        echo $HTML->para('%sView page listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/').'">', '</a>');
        echo $HTML->para('%sAdd new page%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/edit/').'">', '</a>');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();
    
    if (PerchUtil::count($navgroups)) {
?>
    <table class="d">
        <thead>
            <tr>
                <th class="first"><?php echo $Lang->get('Group'); ?></th>
                <th><?php echo $Lang->get('Slug'); ?></th>
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($navgroups as $NavGroup) {
?>
            <tr>
                <td><a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/nav/edit/?id=<?php echo $HTML->encode(urlencode($NavGroup->id())); ?>"><?php echo $HTML->encode($NavGroup->navgroupTitle())?></a></td>
                <td><?php echo $HTML->encode($NavGroup->navgroupSlug())?></td>  
                <td>
                    <?php
                        if ($NavGroup->navgroupSlug()=='default') {
                            echo '<span class="delete">'.$Lang->get('Delete').'</span>';
                        }else{
                            ?>
                            <a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/nav/delete/?id=<?php echo $HTML->encode(urlencode($NavGroup->id())); ?>" class="delete"><?php echo $Lang->get('Delete'); ?></a>
                            <?php
                        }
                    ?>
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
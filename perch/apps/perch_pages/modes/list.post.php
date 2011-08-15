<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
    
    echo $HTML->heading3('New page');
    echo $HTML->para('%sAdd new page%s', '<a href="edit/">', '</a>');

    if ($CurrentUser->userRole() == 'Admin') {
        echo $HTML->heading3('Management');
        echo $HTML->para('%sView navigation groups%s', '<a href="nav/">', '</a>');
        echo $HTML->para('%sView page templates%s', '<a href="manage-templates/">', '</a>');
        echo $HTML->para('%sAutomatically reorder pages%s', '<a href="reorder/auto/">', '</a>');
    }


    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();

    if (PerchUtil::count($pages)) {
?>
    <table class="d">
        <thead>
            <tr>
                <th class="first"><?php echo $Lang->get('Group'); ?></th>
                <th><?php echo $Lang->get('Title'); ?></th>
                <th><?php echo $Lang->get('Path'); ?></th>
                <th class="action"></th>
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        
            foreach($navgroups as $NavGroup) {
                $first = true;
                $pages = $NavGroup->get_pages(true);
                $level = 0;
        ?>
                <?php
                    if (PerchUtil::count($pages)) {
                        foreach($pages as $Page) {
                        $level = PerchUtil::count(explode('/', $Page->displayPath()));
                        
                ?>
                            <tr>
                                <td><?php
                                    if ($first) {
                                        echo '<strong>'.$HTML->encode($NavGroup->navgroupTitle()).'</strong>';
                                    }
                                    $first = false;
                                ?></td>
                                <td class="page level<?php echo $level-1; ?>"><a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/edit/?id=<?php echo $HTML->encode(urlencode($Page->id())); ?>"><span><?php echo $HTML->encode($Page->pageTitle())?>
                                <?php if ($Page->navgroupID()=='0') echo ' <em>'.$Lang->get('(hidden)').'</em>'; ?></span></a>
                                    
                                </td>
                                <td class="dimmed"><?php echo $HTML->encode($Page->displayPath())?></td>
                                <td><?php
                                    if ($Page->has_more_than_one_child() || substr($Page->pagePath(), 0, 6)=='/index') {
                                ?>
                                    <a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/reorder/?id=<?php echo $HTML->encode(urlencode($Page->id())); ?>" class="reorder"><?php echo $Lang->get('Reorder'); ?></a>                          
                                <?php
                                    } // has more than one child
                                ?>
                                <td>
                                <?php
                                    if ($CurrentUser->userRole() == 'Admin' || ($CurrentUser->userRole() == 'Editor' && $Settings->get('perch_pages_editorMayDeletePages')->settingValue())) {
                                
                                        if ($CurrentUser->userRole() == 'Editor' && $Page->pageImported()) {
                                            echo '<span class="delete">'.$Lang->get('Delete').'</span>';
                                        }else{
                                ?>
                                    <a href="<?php echo $HTML->encode(PERCH_LOGINPATH); ?>/apps/perch_pages/delete/?id=<?php echo $HTML->encode(urlencode($Page->id())); ?>" class="delete"><?php echo $Lang->get('Delete'); ?></a></td>
                                <?php
                                        }
                                        
                                    }
                                ?>
                                </td>

                            </tr>

                <?php
                     
                   
                    }
                    }
                ?>
        
        <?php        
                
            }
        
        ?>


                    
        </tbody>
    </table>



<?php    
    } // if pages



    
    echo $HTML->main_panel_end();


?>
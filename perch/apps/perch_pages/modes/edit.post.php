<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Edit');
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
    
    # Section options
    $opts = array();
    $folder_setting = trim($Settings->get('perch_pages_folders')->settingValue());
    $sections = explode("\n", $folder_setting);

    if ($folder_setting!='' && PerchUtil::count($sections)) {
        foreach($sections as $section) {
            $section = rtrim($section, "/\n\r");
            if ($section==='') {
                $opts[] = array('label'=>$Lang->get('Site root'), 'value'=>'/');
            }else{
                $opts[] = array('label'=>PerchUtil::filename($section, true), 'value'=>$section);
            }


        }
    }else{
        echo $HTML->warning_message('Please %sadd folders%s to the list of places to create new pages.', '<a href="'.PERCH_LOGINPATH.'/settings/#perch_pages">', '</a>');
    }
    
    echo $HTML->heading2('Page details');
    

    echo $Form->form_start();
    
        echo $Form->text_field('pageTitle', 'Title', @$details['pageTitle']);
    
    
        if (!is_object($Page)) {
        
            echo $Form->select_field('pageSection', 'Site section', $opts);
        
            $templates = $Templates->all();
            $opts = array();
            if (PerchUtil::count($templates)) {
                foreach($templates as $Template) {
                    $opts[] = array('label'=>$Template->templateTitle(), 'value'=>$Template->id());
                }
            }
            echo $Form->select_field('templateID', 'Template', $opts, @$details['templateID']);
        
        }
        
        $navgroups = $NavGroups->all();
        $opts = array();    
        if (PerchUtil::count($navgroups)) {
            foreach($navgroups as $NavGroup) {
                $opts[] = array('label'=>$NavGroup->navgroupTitle(), 'value'=>$NavGroup->id());
            }
        }
        
        $opts[] = array('label'=>'Hide from all navigation', 'value'=>0);
        echo $Form->select_field('navgroupID', 'Navigation group', $opts, isset($details['navgroupID']) ? $details['navgroupID'] : 1);
        
        
        echo $Form->submit_field('btnSubmit', 'Save', $API->app_path());

    
    echo $Form->form_end();
    
    if ($created!==false) {
        echo '<img src="'.$HTML->encode($Page->pagePath()).'" width="1" height="1" />';
    }
    
    echo $HTML->main_panel_end();


?>
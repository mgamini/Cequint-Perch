<?php
    # Title panel
    echo $HTML->title_panel_start();
    echo $HTML->heading1('Pages / Templates / Edit');
    echo $HTML->title_panel_end();
    
    
    # Side panel
    echo $HTML->side_panel_start();
            echo $HTML->heading3('More actions');
            echo $HTML->para('%sView template listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/manage-templates/').'">', '</a>');
            echo $HTML->para('%sView page listing%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/').'">', '</a>');
            echo $HTML->para('%sAdd new page%s', '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/apps/perch_pages/edit/').'">', '</a>');
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start(); 
    
    if ($message) echo $message;
    
    echo $HTML->heading2('Template details');
        
    
    echo $Form->form_start();
    
        echo $Form->text_field('templateTitle', 'Title', @$details['templateTitle']);
        
        $opts = array();
        $opts[] = array('label'=>'Do not copy', 'value'=>'');
        $pages = $Pages->all();
        if (PerchUtil::count($pages)) {
            foreach($pages as $Page) {
                $opts[] = array('label'=>$Page->pagePath(), 'value'=>$Page->id());
            }
        }
        echo $Form->select_field('optionsPageID', 'Copy region options from', $opts, @$details['optionsPageID']);
		
		$opts = array();
		$opts[] = array('label'=>'Reference this template', 'value'=>1);
		$opts[] = array('label'=>'Copy this template', 'value'=>0);
		echo $Form->select_field('templateReference', 'New pages should', $opts, @$details['templateReference']);
		
		
		echo $Form->hidden('templateID', @$details['templateID']);
        echo $Form->submit_field('btnSubmit', 'Save', $API->app_path().'/manage-templates/');

    
    echo $Form->form_end();
    
    echo $HTML->main_panel_end();

?>
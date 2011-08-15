<?php

class PerchPages_Templates extends PerchAPI_Factory
{
    protected $table = 'pages_templates';
    protected $pk = 'templateID';
    protected $singular_classname = 'PerchPages_Template';
    protected $default_sort_column = 'templatePath';
    
    
    public function find_and_add_new_templates()
    {
        $files = $this->get_template_files();
        $templates = $this->all();
        $cache = array();
        
        if (PerchUtil::count($templates)) {
            foreach($templates as $Template) {
                $cache[] = $Template->templatePath();
            }
        }
        
        if (PerchUtil::count($files)) {
            foreach($files as $file) {
                if (!in_array($file['filename'], $cache)) {
                    // template is new
                    $data = array();
                    $data['templateTitle'] = $file['label'];
                    $data['templatePath'] = $file['filename'];
                    $this->create($data);
                }
            }
        }
    }
    
    
    private function get_template_files()
    {
        $a = array();
        if (is_dir(PERCH_PATH.'/templates/pages')) {
            if ($dh = opendir(PERCH_PATH.'/templates/pages')) {
                while (($file = readdir($dh)) !== false) {
                    if(substr($file, 0, 1) != '.' && substr($file, 0, 1) != '_') {
                        $extension = PerchUtil::file_extension($file);
                        $a[] = array('filename'=>$file, 'path'=>PERCH_PATH.'/templates/pages' . $file, 'label'=>$this->template_display_name($file));
                    }
                }
                closedir($dh);
            }
        }
        return $a;
    }
    
    private function template_display_name($file_name)
    {
        $file_name = str_replace(array('.html', '.htm', '.php5', '.php'), '', $file_name);
        $file_name = str_replace('_', ' ', $file_name);
        $file_name = str_replace('-', ' - ', $file_name);
        
        $file_name = ucwords($file_name);
        
        return $file_name;
    }
}

?>
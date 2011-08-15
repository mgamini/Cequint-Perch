<?php

class PerchPages_NavGroups extends PerchAPI_Factory
{
    protected $table = 'pages_navgroups';
    protected $pk = 'navgroupID';
    protected $singular_classname = 'PerchPages_NavGroup';
    protected $default_sort_column = 'navgroupTitle';
    
    
    public function create($data)
    {
        if (isset($data['navgroupTitle'])) {
            $data['navgroupSlug'] = PerchUtil::urlify($data['navgroupTitle']);
        }
        
        return parent::create($data);
    }
}

?>
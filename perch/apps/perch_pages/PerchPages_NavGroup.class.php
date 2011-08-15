<?php

class PerchPages_NavGroup extends PerchAPI_Base
{
    protected $table  = 'pages_navgroups';
    protected $pk     = 'navgroupID';

    public function delete()
    {
        // set all pages in this group to 'no group'
        $sql = 'UPDATE '.PERCH_DB_PREFIX.'pages
                SET navgroupID=0
                WHERE navgroupID='.$this->id();
        $this->db->execute($sql);
        
        return parent::delete();
    }
    
    public function get_pages($include_hidden=false)
    {
        if ($this->id()=='1' && $include_hidden) {
            $include_hidden = true;
        }else{
            $include_hidden = false;
        }
        
        $Pages = new PerchPages_Pages();
        return $Pages->get_by_navgroup($this->id(), $include_hidden);
    }

}

?>
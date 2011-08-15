<?php

class PerchPages_Page extends PerchAPI_Base
{
    protected $table  = 'pages';
    protected $pk     = 'pageID';
    
    private $descendants = array();

    public function flat_display()
    {
        return PerchUtil::filename($this->pagePath());
    }

    public function delete()
    {
        if (file_exists(PERCH_SITEPATH.$this->pagePath())) {
            $sql = 'DELETE FROM '.PERCH_DB_PREFIX.'contentItems WHERE contentPage='.$this->db->pdb($this->pagePath());
            $this->db->execute($sql);
            unlink(PERCH_SITEPATH.$this->pagePath());
        }
        return parent::delete();
    }
    
    public function has_more_than_one_child() 
    {
        $segments = explode('/', $this->pagePath());
        $file = array_pop($segments);
        $path = implode('/', $segments);
        
        if (substr($file, 0, 5)=='index') {
        
            $sql = 'SELECT COUNT(*) FROM '.$this->table.' WHERE pageSection='.$this->db->pdb($path);
            $count = $this->db->get_count($sql);
        
            if ($count>1) return true;
        }
        
        
        return false;
        
    }
    
    public function shorthand_order()
    {
        $order = $this->pageOrder();
        $parts = explode('-', $order);
        return array_pop($parts); 
    }
    
    public function load_descendants()
    {
        $sql = 'SELECT pageID, pageOrder
                FROM '.$this->table.'
                WHERE pageOrder LIKE '.$this->db->pdb($this->pageOrder().'-%').'
                ORDER BY pageOrder ASC';
        $rows = $this->db->get_rows($sql);
        
        if (PerchUtil::count($rows)) {
            $this->descendants = $rows;
        }
        
    }
    
    public function set_new_order($pageOrder) 
    {
        PerchUtil::debug('setting new order');
        
        $oldOrder = $this->pageOrder();
        
        if (PerchUtil::count($this->descendants)) {
            $descendants = $this->descendants;
            foreach($descendants as $page) {
                
                $data = array();
                $data['pageOrder'] = $pageOrder.substr($page['pageOrder'], strlen($oldOrder));
                $this->db->update($this->table, $data, $this->pk, $page['pageID']);
            }
        }
        
        $data = array();
        $data['pageOrder'] = $pageOrder;
        $this->update($data);
    }

    

}

?>
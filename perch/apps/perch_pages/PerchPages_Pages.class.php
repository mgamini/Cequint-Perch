<?php

class PerchPages_Pages extends PerchAPI_Factory
{
    protected $table = 'pages';
    protected $pk = 'pageID';
    protected $singular_classname = 'PerchPages_Page';
    protected $default_sort_column = 'pageOrder';
    
    private $error_messages = array();
    
    function __construct($api=false)
    {
        parent::__construct($api);
        
        if (!defined('PERCH_SITEPATH')) {
            $login_path_parts = explode('/', PERCH_LOGINPATH);
            $path_parts = explode(DIRECTORY_SEPARATOR, PERCH_PATH);
            foreach($login_path_parts as $part) if ($part!='') array_pop($path_parts);
            $path = implode(DIRECTORY_SEPARATOR, $path_parts);
            define('PERCH_SITEPATH', $path);
        }
    }
    
    public function find_by_path($path)
    {
        $sql = 'SELECT pageID, pageTitle
                FROM '.$this->table.'
                WHERE pagePath='.$this->db->pdb($path).'
                LIMIT 1';
        $row = $this->db->get_row($sql);
        return $this->return_instance($row);
    }
    
    public function get_by_navgroup($navgroupID, $include_hidden=false)
    {
        $sql = 'SELECT * 
                FROM '.$this->table.'
                WHERE navgroupID='.$this->db->pdb($navgroupID).' ';
        
        if ($include_hidden) {
            $sql .= ' OR navgroupID=0 ';
        }        
         
        $sql .= ' ORDER BY '.$this->default_sort_column;
        $rows = $this->db->get_rows($sql);
        
        if (PerchUtil::count($rows)) {
            foreach($rows as &$row) {
                $row['displayPath'] = str_replace(array('/index.php', '/index.html', '/index.html'), '', $row['pagePath']);
            }
        }
        
        return $this->return_instances($rows); 
    }
    
    public function get_errors()
    {
        return $this->error_messages;
    }
    
    public function create_with_file($data)
    {
        $Templates = new PerchPages_Templates;
        $Template = $Templates->find($data['templateID']);
                
        if (is_object($Template)) {
            unset($data['templateID']);
            
            $file_extension = PerchUtil::file_extension($Template->templatePath());
            $file_name      = PerchUtil::urlify($data['pageTitle']);
            $dir            = PERCH_SITEPATH.str_replace('/', DIRECTORY_SEPARATOR, $data['pageSection']);

            if (is_writable($dir)) {
                $new_file = $this->get_unique_file_name($dir, $file_name, $file_extension);
                $template_dir = PERCH_PATH.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'pages';

                if (file_exists($template_dir)) {
                    $template_file = $template_dir.DIRECTORY_SEPARATOR.$Template->templatePath();
                    
                    if ($Template->templateReference()) {
                        $contents = '<'.'?php include(\''.$this->get_relative_path($template_file, $dir).'\'); ?'.'>';
                    }else{
                        $contents = file_get_contents($template_file);
                    }
                                        
                    if ($contents) {
                        if (file_put_contents($new_file, $contents)) {
                            $new_url = $data['pageSection'].str_replace($dir, '', $new_file);
                            $r = str_replace(DIRECTORY_SEPARATOR, '/', $new_url);
                            $r = str_replace('//', '/', $r);
                            $data['pagePath'] = $r; 
                            
                            $Page =  $this->create($data);
                            
                            if ($Template->optionsPageID() != '0') {
                                
                                $CopyPage = $this->find($Template->optionsPageID());
                                
                                if (is_object($CopyPage)) {
                                
                                    $sql = 'INSERT INTO '.PERCH_DB_PREFIX.'contentItems (
                                            contentKey,
                                            contentPage, 
                                            contentHTML,
                                            contentNew,
                                            contentTemplate,
                                            contentMultiple,
                                            contentAddToTop,
                                            contentJSON,
                                            contentHistory, 
                                            contentOptions
                                        ) 
                                        SELECT
                                            contentKey,
                                            '.$this->db->pdb($r).' AS contentPage,
                                            "<!-- Undefined content -->" AS contentHTML,
                                            contentNew,
                                            contentTemplate,
                                            contentMultiple,
                                            contentAddToTop,
                                            "" AS contentJSON,
                                            "" AS contentHistory,
                                            contentOptions
                                        FROM '.PERCH_DB_PREFIX.'contentItems
                                        WHERE contentPage='.$this->db->pdb($CopyPage->pagePath());
                                
                                    $this->db->execute($sql);
                                
                                    // Nullify resources list in options
                                    $sql = 'SELECT contentID, contentOptions
                                            FROM '.PERCH_DB_PREFIX.'contentItems 
                                            WHERE contentPage='.$this->db->pdb($r);
                                    $rows = $this->db->get_rows($sql);
                                    if (PerchUtil::count($rows)) {
                                        foreach($rows as $row) {
                                            $jsonOptions = PerchUtil::json_safe_decode($row['contentOptions'], true);
                                            $jsonOptions['resources'] = array();
                                            $data = array();
                                            $data['contentOptions'] = PerchUtil::json_safe_encode($jsonOptions);
                                            $this->db->update(PERCH_DB_PREFIX.'contentItems', $data, 'contentID', $row['contentID']);
                                        }
                                    }
                                
                                }
                            }
                            
                            return $Page;
                            
                        }else{
                            PerchUtil::debug('Could not put file contents.');
                            $this->error_messages[] = 'Could not write contents to file: '.$new_file;
                        }
                    }
                }

            }else{
                PerchUtil::debug('Folder is not writable: '.$dir);
                $this->error_messages[] = 'Folder is not writable: '.$dir;
            }
            
            
            
        }else{
            PerchUtil::debug('Template not found.');
            PerchUtil::debug($data);
        }
        
        return false;
        
    }
    
    public function create($data)
    {
        if (isset($data['pagePath']) && !isset($data['pageTitle'])) {
            $parts = explode('/', $data['pagePath']);
            $file = array_pop($parts);
            if (strpos($file, 'index')!==false) {
                $file = array_pop($parts) . '/'.$file;
            }
            $data['pageTitle'] = PerchUtil::filename($file);
        }
        
        return parent::create($data);
    }
    
    public function import()
    {
        $sql = 'SELECT DISTINCT contentPage
                FROM '.PERCH_DB_PREFIX.'contentItems
                WHERE contentPage NOT IN (
                        SELECT DISTINCT pagePath
                        FROM '.$this->table.'
                    )
                    AND contentPage!=\'*\'
                ORDER BY contentPage ASC';
        $rows = $this->db->get_rows($sql);
        
        if (PerchUtil::count($rows)) {
            foreach($rows as $row) {

                $data = array();
                $data['pagePath'] = $row['contentPage'];
                $data['pageImported'] = '1';

                $parts = explode('/', $row['contentPage']);

                array_pop($parts);
                                
                if (PerchUtil::count($parts)==1) {
                    $parts[] = '';
                }

                $data['pageSection'] = implode('/', $parts);
                $this->create($data);
            }
        }
    }
    
    public function order_unordered_pages()
    {
        $sql = 'SELECT COUNT(*)
                FROM '.$this->table.'
                WHERE pageOrder IS NOT NULL';
        $count = $this->db->get_count($sql);
        if ($count==0) {
            $this->auto_reorder(false);
        }
        
        $sql = 'SELECT * 
                FROM '.$this->table.'
                WHERE pageOrder IS NULL';
        $rows = $this->db->get_rows($sql);
        $pages = $this->return_instances($rows);
        
        if (PerchUtil::count($pages)) {
            foreach($pages as $Page) {

                $data = $this->find_tree_position($Page);
                if (PerchUtil::count($data)) {
                    $Page->update($data);
                }
                
            }
        }
    }
    
    public function auto_reorder($new_only=true)
    {
        $sql = 'SELECT DISTINCT pageSection
                FROM '.$this->table.'
                ORDER BY pagePath=\'/index.php\' DESC, pageSection';
        $rows = $this->db->get_rows($sql);
        
        $sections = array();
        
        if (PerchUtil::count($rows)) {
            $x = array();

            foreach($rows as $row) {
                $parts = explode('/', $row['pageSection']);
                array_shift($parts);
                if (isset($parts[0]) && $parts[0]=='') {
                    $parts[0] = '';
                }

                $key = '';
                for ($i=0; $i<PerchUtil::count($parts); $i++) {
                    if (!isset($x[$i])) $x[$i] = 1;
                    $subpath = array_slice($parts, 0, $i+1);
                    $isubpath = '/'.implode('/', $subpath);
                    
                    if (array_key_exists('/'.$parts[$i], $sections)) {
                        $key .= $sections['/'.$parts[$i]].'-';
                    }else{
                        $sections[$isubpath] = $key.$x[$i];
                        $x[$i]++;
                    }
                }
            }
        }
        
        $sql = 'SELECT *
                FROM '.$this->table.'
                ORDER BY pagePath=\'/index.php\' DESC, pagePath';
        $rows = $this->db->get_rows($sql);
        $pages = $this->return_instances($rows);
        
        PerchUtil::debug($sections);
        
        if (PerchUtil::count($pages)) {
            $i = 1;
            $prevdepth = 0;
            foreach($pages as $Page) {
                $parts = explode('/', $Page->pagePath());
                $file = array_pop($parts);
                
                $key = '';    
                
                foreach($sections as $path=>$val) {
                    if ($path == '/') {
                        $matchpath = $path;
                    }else{
                        $matchpath = $path.'/';
                    }
                    
                    if (strpos($Page->pagePath(), $matchpath)===0) {
                        $key = $val;
                    }
                }    
                    
                $depth = count($parts);
                if ($depth>$prevdepth) $i = 1;
                $prevdepth = $depth;
                    
                if (strpos($file, 'index')===0) {
                    $depth--;
                }else{
                    $key .= '-'.$i;
                    $i++;
                }
                
                if ($Page->pageSection()=='/') {
                    $depth = 1;
                    
                    // home page
                    if (strpos($file, 'index.')===0) $depth = 0;
                }
                
                $data = array();
                $data['pageOrder'] = $this->pad_key($key);
                $data['pageDepth'] = $depth;
                
                if ($new_only) {
                    if ($Page->pageOrder()=='') $Page->update($data);
                }else{
                    $Page->update($data);
                }
                
                    
                
            }
        }
    }
    
    public function get_decendants($ParentPage)
    {
        
        $pageDepth = (int)$ParentPage->pageDepth();
        $pageOrder = $ParentPage->pageOrder();
        $navgroupID = $ParentPage->navgroupID();
        $pageDepth = $ParentPage->pageDepth();
        $pageID = $ParentPage->id();
        
        if ($navgroupID==0 || $navgroupID==1) {
            $navgroup_sql = '(navgroupID=0 OR navgroupID=1)';
        }else{
            $navgroup_sql = 'navgroupID='.$this->db->pdb($navgroupID);
        }
        
        if ($pageDepth==0 && substr($ParentPage->pagePath(), 0, 6)=='/index') {
            $sql = 'SELECT *
                    FROM '.$this->table.'
                    WHERE pageDepth=1
                        AND pageID!='.$this->db->pdb($pageID).'
                        AND '.$navgroup_sql.'
                    ORDER BY pageOrder ASC';
        }else{
            $sql = 'SELECT *
                    FROM '.$this->table.'
                    WHERE pageOrder LIKE '.$this->db->pdb($pageOrder.'-%').'
                        AND pageOrder NOT LIKE '.$this->db->pdb($pageOrder.'-%-%').'
                        AND '.$navgroup_sql.'
                    ORDER BY pageOrder ASC';
        }
        
        
        $rows = $this->db->get_rows($sql);
        
        return $this->return_instances($rows);
    }
    
    
    public function get_navigation($opts, $current_page)
    {
        $navgroup        = $opts['navgroup'];
        $from_path       = $opts['from_path'];
        $levels          = $opts['levels'];
        $hide_extensions = $opts['hide_extensions'];
        $flat            = $opts['flat'];
        $template        = $opts['template'];
        $flatten_home    = $opts['flatten_home'];
        
        $lower_level = 0;
        
        if ($levels>0) {
            if ($from_path!='/') {
                $parts = explode('/', $from_path);
                $orig_level = $levels;
                $levels = $levels+count($parts);
                $lower_level = $levels-$orig_level;
            }else{
                $levels++;
            }
        }
        
        
        $sql = 'SELECT *
                FROM '.$this->table.' p, '.PERCH_DB_PREFIX.'pages_navgroups n
                WHERE p.navgroupID=n.navgroupID AND n.navgroupSlug='.$this->db->pdb($navgroup).'
                    AND pagePath LIKE '.$this->db->pdb($from_path.'%');
        
        if ($levels>0) {
            $sql .= ' AND pageDepth<'.$levels;
            $sql .= ' AND pageDepth>='.$lower_level;
        }
                
                    
        $sql .=' ORDER BY '.$this->default_sort_column;
        $rows = $this->db->get_rows($sql);
        

    
        $s = '';
        
        if (PerchUtil::count($rows)) {

            if ($flatten_home) {
                if ($rows[0]['pageDepth']==0 && substr($rows[0]['pagePath'], 0, 6)=='/index') {
                    $rows[0]['pageDepth']=1;
                }
            }
            
            $Template = $this->api->get('Template');
            $Template->set($template, 'pages');
            
                        
            foreach($rows as &$row) {
                if ($row['pagePath'] == $current_page) {
                    $row['current_page'] = true;
                }
                
                if (substr($row['pagePath'], -10)=='/index.php') {
                    $row['pagePath'] = substr($row['pagePath'], 0, strlen($row['pagePath'])-9);
                }
                
                if ($hide_extensions && strpos($row['pagePath'], '.')) {
                    $parts = explode('.', $row['pagePath']);
                    array_pop($parts);
                    $row['pagePath'] = implode('.', $parts);
                }
            }
            
            if ($flat) {
                $s = $Template->render_group($rows);
                return $s;
            }
            
            $s = $this->build_tree($rows, 0, $Template);
            
        }
        
        return $s;
    }
    
    private function build_tree($items, $start_index, $Template)
    {
        $s = '';
        $links = array();
        $subs_done = array();

        for($i=$start_index; $i<PerchUtil::count($items); $i++) {
            $row = $items[$i];
                                    
            if ($i==$start_index) {
                $current_depth = $row['pageDepth'];
            }
            
            if ($row['pageDepth'] < $current_depth) {
                break;
            }
            
            if (isset($items[$i+1])) {
                $next_row = $items[$i+1];
                
                if ($next_row['pageDepth'] > $current_depth) {
                    $row['subitems'] = $this->build_tree($items, ($i+1), $Template);
                }
            }

            if ($row['pageDepth']==$current_depth) {
                $links[] = $row;
            }
                
        }
        
        return $Template->render_group($links);
    }
    
    private function get_unique_file_name($dir, $file_name, $file_extension, $count=0)
    {
        if ($count==0) {
            $file = $dir.DIRECTORY_SEPARATOR.$file_name.'.'.$file_extension;
        }else{
            $file = $dir.DIRECTORY_SEPARATOR.$file_name.'-'.$count.'.'.$file_extension;
        }
        
        if (file_exists($file)) {
            $count++;
            return $this->get_unique_file_name($dir, $file_name, $file_extension, $count);
        }else{
            return $file;
        }
    }
    
    // Thanks, jpic in php.net realpath comments!
    private function get_relative_path($path, $compareTo) 
    {
        // clean arguments by removing trailing and prefixing slashes
        if ( substr( $path, -1 ) == DIRECTORY_SEPARATOR ) {
            $path = substr( $path, 0, -1 );
        }
        if ( substr( $path, 0, 1 ) == DIRECTORY_SEPARATOR ) {
            $path = substr( $path, 1 );
        }

        if ( substr( $compareTo, -1 ) == DIRECTORY_SEPARATOR ) {
            $compareTo = substr( $compareTo, 0, -1 );
        }
        if ( substr( $compareTo, 0, 1 ) == DIRECTORY_SEPARATOR ) {
            $compareTo = substr( $compareTo, 1 );
        }

        // simple case: $compareTo is in $path
        if ( strpos( $path, $compareTo ) === 0 ) {
            $offset = strlen( $compareTo ) + 1;
            return substr( $path, $offset );
        }

        $relative  = array(  );
        $pathParts = explode( DIRECTORY_SEPARATOR, $path );
        $compareToParts = explode( DIRECTORY_SEPARATOR, $compareTo );

        foreach( $compareToParts as $index => $part ) {
            if ( isset( $pathParts[$index] ) && $pathParts[$index] == $part ) {
                continue;
            }

            $relative[] = '..';
        }

        foreach( $pathParts as $index => $part ) {
            if ( isset( $compareToParts[$index] ) && $compareToParts[$index] == $part ) {
                continue;
            }

            $relative[] = $part;
        }

        return implode( DIRECTORY_SEPARATOR, $relative );
    }
    
    private function find_tree_position($Page)
    {
        $newOrder = $this->get_order_in_section($Page->pageSection());
        
        if (is_array($newOrder)) return $newOrder;
        
        $parts = explode('/', $Page->pageSection());
        
        if (PerchUtil::count($parts)) {
            for($i=0; $i<PerchUtil::count($parts); $i++) {
                array_pop($parts);
                if (count($parts)) {
                    $section = implode('/', $parts);
                    $newOrder = $this->get_order_in_section($section);
                    if (is_array($newOrder)) return $newOrder;
                }
            }
        }
        
        return null;
    }
    
    private function get_order_in_section($section)
    {
        $sql = 'SELECT pageOrder, pageDepth 
                FROM '.$this->table.'
                WHERE pageSection='.$this->db->pdb($section).'
                ORDER BY pageOrder DESC
                LIMIT 1';
        $row = $this->db->get_row($sql);
        
        if (PerchUtil::count($row)) {
            $order = $row['pageOrder'];
            $parts = explode('-', $order);
            $end = (int)array_pop($parts);
            $end++;
            $parts[] = $end;
            $newOrder = implode('-', $parts);
            
            $data = array();
            $data['pageOrder'] = $newOrder;
            $data['pageDepth'] = $row['pageDepth'];
            
            return $data;
        }
        
        return false;
    }
    
    private function pad_key($key)
    {
        $key_parts = explode('-', $key);
        $key_parts = array_map(array('PerchUtil', 'pad'), $key_parts);
        return implode('-', $key_parts);
    }

}

?>
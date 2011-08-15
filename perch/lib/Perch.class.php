<?php

class Perch
{
    static protected $instance;
	
    public $version = '1.6.5';
    
    private $page        = false;
    public $debug        = true;
    public $debug_output = '';
    public $page_title   = 'Welcome';
    public $help_html    = '';
    
    function __construct()
    {
        if (!defined('PERCH_DEBUG')) {
            define('PERCH_DEBUG', false);
        }
    }
    
    public static function fetch()
	{	    
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
	}
    
    public function get_page($request_uri=false)
    {
        if ($request_uri) {
            $out = str_replace('index.php', '', strtolower($_SERVER['SCRIPT_NAME']));
            if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='') {
                $out .= '?'.$_SERVER['QUERY_STRING'];
            }
            $out = preg_replace('/(\/)\\1+/', '/', $out);           
            return $out;
        }
        
        if ($this->page === false) {
            $this->page = strtolower($_SERVER['SCRIPT_NAME']);
        }
        
        if ($this->page != false) {
            $this->page = preg_replace('/(\/)\\1+/', '/', $this->page);
        }
        
        return $this->page;
    }
    
    public function set_page($page)
    {
        $this->page = $page;
    }
    
    public function find_installed_apps($CurrentUser)
    {
        return false;
    }
    
    
}

?>
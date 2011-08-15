<?php

class PerchTemplate
{
    protected $namespace;
	public $file;
	protected $template;
	protected $cache		= array();
	
	protected $autoencode = false;
	
	public $apply_post_processing = false;
	
	function __construct($file=false, $namespace='content')
	{
		
		$this->namespace = $namespace;
		
		if (file_exists(PERCH_PATH.$file)) {
		    $this->file		= PERCH_PATH.$file;
			$this->template	= $file;   
		}else{
		    PerchUtil::debug('Template file not found: ' . PERCH_PATH.$file, 'error');
			return false;
		}
			
	}
	
	public function render_group($content_vars, $return_string=false)
	{
		$r	= array();
		if (PerchUtil::count($content_vars)){
		    $count = PerchUtil::count($content_vars);
		    for($i=0; $i<$count; $i++) {
                if (isset($content_vars[$i])) {
                    $item = $content_vars[$i];
                		    
    			    if (is_object($item)) {
                        $item = $item->to_array();
                    }
			    
    			    if ($i==0) $item['perch_item_first'] = true;
    			    if ($i==($count-1)) $item['perch_item_last'] = true;
    			    $item['perch_item_index'] = $i+1;
    			    $item['perch_item_odd'] = ($i % 2 == 0 ? '' : 'odd');
    				$r[] = $this->render($item);
    			}
			}
		}
		
		if ($return_string) {
		    return implode('', $r);
		}
		
		return $r;
	}

	public function render($content_vars)
	{
        if (is_object($content_vars)) {
            $content_vars = $content_vars->to_array();
        }
		
		$template	= $this->template;
		$path		= $this->file;
		
		$PerchImage = new PerchImage;
		
		$contents	= $this->load();
		
		// CONDITIONALS
		$i = 0;
        while (strpos($contents, 'perch:')>0 && $i<10) {
            $s = '/(<perch:(if|after|before)[^>]*>)(((?!perch:(if|after|before)).)*)<\/perch:(if|after|before)>/s';
    		$count	= preg_match_all($s, $contents, $matches, PREG_SET_ORDER);
		    
    		if ($count > 0) {		    
    			foreach($matches as $match) {
    			    $contents = $this->parse_conditional($match[2], $match[1], $match[3], $match[0], $contents, $content_vars);
    			}	
    		}
    		$i++;
    	}


		// CONTENT
		foreach ($content_vars as $key => $value) {	

			
			$s = '/<perch:'.$this->namespace.'[^>]*id="'.$key.'"[^>]*>/';
			$count	= preg_match_all($s, $contents, $matches);
					
			if ($count > 0) {
				foreach($matches[0] as $match) {
					$tag = new PerchXMLTag($match);
					if ($tag->suppress()) {
					    $contents = str_replace($match, '', $contents);
					}else{	
    					if (is_object($value) && get_class($value) == 'Image') {
    						if ($tag->class()) {
    							$out		= $value->tag($tag->class());
    							$contents 	= str_replace($match, $out, $contents);
    						}else{
    							$out		= $value->tag();
    							$contents 	= str_replace($match, $out, $contents);
    						}
    					}else{
    					    $modified_value = $value;
					    
    					    // check for 'format' attribute for formatting dates
    					    if ($tag->format()) {
    					        if (strpos($tag->format(), '%')===false) {
    					            $modified_value = date($tag->format(), strtotime($value));
    					        }else{
    					            $modified_value = strftime($tag->format(), strtotime($value));
    					        }
    					        
    					    }
    					    
    					    // post processing
    					    if ($this->apply_post_processing) {
    					        // Trim by chars
                                if ($tag->chars()) {
                                    if (strlen($value) > (int)$tag->chars()) {
                                        $modified_value = PerchUtil::excerpt_char($value, (int)$tag->chars(), false, true);
                                    }
                                }

                                // Trim by words
                                if ($tag->words()) {
                                    $modified_value = PerchUtil::excerpt($value, (int)$tag->words(), false, true);
                                }
    					    }
    					    					    
					        
    					    // replace images
    					    if ($tag->type() == 'image' && ($tag->width() || $tag->height())) {
    					        $modified_value = $PerchImage->get_resized_filename($modified_value, $tag->width(), $tag->height());
    					    }
    					    
    					    // check encoding
    					    if ($this->autoencode) {
    					        if ((!$tag->is_set('encode') || $tag->encode()==true) && ($tag->html()==false && !$tag->textile() && !$tag->markdown())) {
					                $modified_value = PerchUtil::html($modified_value);
    					        }
    					    }
					    
    						$contents = str_replace($match, $modified_value, $contents);
    					}
					}
				}
				
			}
			
		}
		
		$contents   = $this->remove_help($contents);
		
		// CLEAN UP ANY UNMATCHED <perch: /> TAGS
		$s 			= '/<perch:[^>]*>/';
		$contents	= preg_replace($s, '', $contents);
				
    	return $contents;
	}


	public function find_tag($tag)
	{
		$template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
			
		$s = '/<perch:[^>]*id="'.$tag.'"[^>]*>/';
		$count	= preg_match($s, $contents, $match);

		if ($count == 1){
			return new PerchXMLTag($match[0]);
		}
		
		return false;
	}
	
	public function find_all_tags($type='content')
	{
	    $template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
		
		$s = '/<perch:'.$type.'[^>]*>/';
		$count	= preg_match_all($s, $contents, $matches);
		
		if ($count > 0) {
		    $out = array();
		    $i = 100;
		    if (is_array($matches[0])){
		        foreach($matches[0] as $match) {
		            $tmp = array();
		            $tmp['tag'] = new PerchXMLTag($match);
		            
		            if ($tmp['tag']->order()) {
		                $tmp['order'] = (int) $tmp['tag']->order();
		            }else{
		                $tmp['order'] = $i;
		                $i++;
		            }
                    $out[] = $tmp;
		        }
		    }
		    
		    // sort tags using 'sort' attribute
		    $out = PerchUtil::array_sort($out, 'order');
		    
		    $final = array();
		    foreach($out as $tag) {
		        $final[] = $tag['tag'];
		    }
		    
		    return $final;
		}
		
		return false;
	}
	
	public function find_help()
	{
	    $template	= $this->template;
		$path		= $this->file;
		
		$contents	= $this->load();
		
		$out        = '';
		
		if (strpos($contents, 'perch:help')>0) {
            $s = '/<perch:help[^>]*>(.*?)<\/perch:help>/s';
    		$count	= preg_match_all($s, $contents, $matches, PREG_SET_ORDER);
		
    		if ($count > 0) {
    			foreach($matches as $match) {
    			    $out .= $match[1];
    			}	
    		}
    	}
    	
    	return $out;
	}
	
	public function remove_help($contents)
	{
        $s = '/<perch:help[^>]*>.*?<\/perch:help>/s';
		return preg_replace($s, '', $contents);    	
	}

	protected function load()
	{
		$contents	= '';
			
		// check if template is cached
		if (isset($this->cache[$this->template])){
			// use cached copy
			$contents	= $this->cache[$this->template];
		}else{
			// read and cache		
			if (file_exists($this->file)){
				$contents 	= file_get_contents($this->file);
				$this->cache[$this->template]	= $contents;
			}
		}
		
		return $contents;
	}
	
	protected function parse_conditional($type, $opening_tag, $condition_contents, $exact_match, $template_contents, $content_vars)
	{
	    if ($type == 'if') {
	        $tag = new PerchXMLTag($opening_tag);
	        
	        $positive = $condition_contents;
            $negative = '';
	        	        
	        // else condition
	        if (strpos($condition_contents, 'perch:else')>0) {
    	        $parts   = preg_split('/<perch:else\s*\/>/', $condition_contents);
                if (is_array($parts) && count($parts)>1) {
                    $positive = $parts[0];
                    $negative = $parts[1];
                }
            }
	        
	        if (array_key_exists($tag->exists(), $content_vars) && $content_vars[$tag->exists()] != '') {
	            $template_contents  = str_replace($exact_match, $positive, $template_contents);
	        }else{
	            $template_contents  = str_replace($exact_match, $negative, $template_contents);
	        }
	    }
	    
	    
        if ($type == 'before') {
            if (array_key_exists('perch_item_first', $content_vars)) {
                $template_contents = str_replace($exact_match, $condition_contents, $template_contents);
            }else{
                $template_contents = str_replace($exact_match, '', $template_contents);
            }
        }
        
        if ($type == 'after') {
            if (array_key_exists('perch_item_last', $content_vars)) {
                $template_contents = str_replace($exact_match, $condition_contents, $template_contents);
            }else{
                $template_contents = str_replace($exact_match, '', $template_contents);
            }
        }
	    
	    return $template_contents;
	}
	
	public function enable_encoding()
	{
	    $this->autoencode = true;
	}

}
?>

<?php

class PerchAuthenticatedUser extends PerchBase
{
    protected $table  = 'users';
    protected $pk     = 'userID';
    
    public $activation_failed = false;
    
    private $logged_in = false;
    
    public function authenticate($username, $password)
    {
        if ($this->activate()) {
            $sql     = 'SELECT * 
                        FROM ' . $this->table . ' 
                        WHERE userEnabled=\'1\' 
                            AND userUsername=' . $this->db->pdb($username) . '
                            AND userPassword=' . $this->db->pdb(md5($password)) . '
                        LIMIT 1';
            $result = $this->db->get_row($sql);
            if (is_array($result)) {
                $this->set_details($result);
                $data = array();
                $data['userHash'] = md5(uniqid());
                $this->update($data);
                $this->result['userHash'] = $data['userHash'];
                $this->set_details($result);
            
                PerchSession::set('userID', $result['userID']);
                PerchSession::set('userHash', $data['userHash']);
            
                $this->logged_in = true;
                return true;
            }
        }
        
        return false;
    }
    
    public function recover()
    {    
        if (PerchSession::is_set('userID')) {
            $sql     = 'SELECT * 
                        FROM ' . $this->table . ' 
                        WHERE userEnabled=\'1\' 
                            AND userID=' . $this->db->pdb((int)PerchSession::get('userID')) . '
                            AND userHash=' . $this->db->pdb(PerchSession::get('userHash')) . '
                        LIMIT 1';
            $result = $this->db->get_row($sql);
            if (is_array($result)) {
                $this->set_details($result);
                $data = array();
                $data['userHash'] = md5(uniqid());
                $this->update($data);
                $this->result['userHash'] = $data['userHash'];
                $this->set_details($result);
                
                PerchSession::set('userHash', $data['userHash']);
                
                $this->logged_in = true;
                return true;
            }
        }
        $this->logged_in = false;
        return false;
    }
    
    public function logout()
    {
        $this->logged_in = false;
        PerchSession::delete('userID');
        PerchSession::delete('userHash');
        return true;
    }
    
    public function logged_in()
    {
        return $this->logged_in;
    }
    
    private function activate()
    {
        /* 
            Any attempt to circumvent activation invalidates your license. 
            We're just a small company trying to make something useful at a fair price. 
            Please don't steal from us.
        */
        
        $Perch  = PerchAdmin::fetch();
        
        $host = 'activation.grabaperch.com';
        $path = '/activate/';
        $url = 'http://' . $host . $path;
        
        $data = '';
        $data['key'] = PERCH_LICENSE_KEY;
        $data['host'] = $_SERVER['SERVER_NAME'];
        $data['version'] = $Perch->version;
        $content = http_build_query($data);
        
        $result = false;
        $use_curl = false;
        if (function_exists('curl_init')) $use_curl = true;
        
        if ($use_curl) {
            PerchUtil::debug('Activating via CURL');
            $ch 	= curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			$result = curl_exec($ch);
			PerchUtil::debug($result);
			curl_close($ch);
        }else{
            if (function_exists('fsockopen')) {
                PerchUtil::debug('Activating via sockets');
                $fp = fsockopen($host, 80, $errno, $errstr, 10);
                if ($fp) {
                    $out = "POST $path HTTP/1.1\r\n";
                    $out .= "Host: $host\r\n";
                    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $out .= "Content-Length: " . strlen($content) . "\r\n";
                    $out .= "Connection: Close\r\n\r\n";
                    $out .= $content. "\r\n";

                    fwrite($fp, $out);
                    stream_set_timeout($fp, 10);
                    while (!feof($fp)) {
                        $result .=  fgets($fp, 128);
                    }
                    fclose($fp);
                }

                if ($result!='') {
                    $parts = preg_split('/[\n\r]{4}/', $result);
                    if (is_array($parts)) {
                        $result = $parts[1];
                    }
                }
            }
        }

        // Should have a $result now
        if ($result) {
            $json = PerchUtil::json_safe_decode($result);
            if (is_object($json) && $json->result == 'SUCCESS') {
                // update latest version setting
                $Settings = new PerchSettings;
                $Settings->set('latest_version', $json->latest_version);
                
                PerchUtil::debug($json);
                PerchUtil::debug('Activation: success');
                return true;
            }else{
                PerchUtil::debug('Activation: failed');
                $this->activation_failed = true;
                return false;
            }
        }
        
        // If activation can't complete, assume honesty. That's how I roll.
        return true;
    }
}

?>

<?php
// +-------------------------------------------------------------------------+
// | Avrora - Content Managment System                                       |
// |-------------------------------------------------------------------------|
// | Copyright (c) Vadim Kravciuk aka Stek -> vadim@phpdevs.com              |
// | http://www.phpdevs.com                                                  |
// +-------------------------------------------------------------------------+

class class_session {

	var $db='/tmp';		// Path to store session file
	var $sid ='';			// Session ID
	var $name='session';	// Session name
	var $expireTime=1200;	// Session expire time
	var $s_array=array();
	var $r_array=array();

	function class_session($db=FALSE) {
		global $HTTP_COOKIE_VARS;
		if ($db) { $this->db=$db; }
		$this->sid=$HTTP_COOKIE_VARS[$this->name];
		$res=$this->m_start();
		setcookie($this->name, $res,FALSE,'/',getenv('SERVER_NAME'));
		$this->m_restore();
		$this->m_store();
	}

	function m_start(){
		if ((file_exists($this->db."/sess_".$this->sid) && $this->sid) and ((time()-filemtime($this->db."/sess_".$this->sid)) <= $this->expireTime)) {
			return $this->sid;
		}else {
			$this->sid=md5(uniqid(rand()));
			$fp=fopen($this->db."/sess_".$this->sid,"w");
			fclose($fp);
			return $this->sid;
		}
	}

	function end() {
		if (is_file($this->db."/sess_".$this->sid)) {
			unlink($this->db."/sess_".$this->sid);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function clear() {
		if (is_file($this->db."/sess_".$this->sid)) {	
			$fp=fopen($this->db."/sess_".$this->sid,"w");
			fclose($fp);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function free($name) {
		if (!isset($this->s_array)) {$this->m_restore();}
		unset($this->s_array[$name]);
		$this->m_store();
		return TRUE;
	}

	function read($name) {
		if (!isset($this->s_array)) {$this->m_restore();}
		if ($this->s_array[$name]) {return stripslashes($this->s_array[$name]);}
		else {return false;}
	}

	function write($name, $value) {
		if (!isset($this->s_array)) {$this->m_restore();}
		$this->s_array[$name]=$value;
		$this->m_store();
		return TRUE;
	}

	function m_info($param) {
		if ($param=='id') {
			return $this->sid;
		}
		elseif ($param=='name') {
			return $this->name;
		}
	}

	function m_store() {
		$fp=fopen($this->db."/sess_".$this->sid,"w");
		if (!$fp) {echo "Can't open session file.";}
		if (!flock($fp, 2)) {echo "Error: Can't lock file"; exit; }
		fwrite($fp,base64_encode(serialize($this->s_array)));
		fclose($fp);		
	}

	function m_restore() {
		$fp=fopen($this->db."/sess_".$this->sid,"r");
		$contents = fread( $fp, filesize( $this->db."/sess_".$this->sid ) );
		fclose($fp);
		$this->s_array=unserialize(base64_decode($contents));
	}
}

?>
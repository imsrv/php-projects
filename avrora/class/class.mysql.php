<?php
// +-------------------------------------------------------------------------+
// | Avrora - Content Managment System                                       |
// |-------------------------------------------------------------------------|
// | Copyright (c) Vadim Kravciuk aka Stek -> vadim@phpdevs.com              |
// | http://www.phpdevs.com                                                  |
// +-------------------------------------------------------------------------+

class class_db {
	var $debug=FALSE;
	var $connect_id=false;

	function class_db($host,$login,$pass) {
		if ($this->connect_id=@mysql_connect($host, $login, $pass)) { 
			return true;
		}else {
			if($this->debug){print "Error: can't connect to db.<br>";}
			return false;
		}
	}

	function m_select_db($dbName) {
		if (!@mysql_select_db($dbName,$this->connect_id)) {
			if($this->debug){print "Error, can't set \"$dbName\" database<br>";}
			return false;
		}
		return true;
	}

	function m_close() {
		if (isset($this->query_id) && is_array($this->query_id)) {
			while (list($key,$val)=each($this->query_id)) {
				mysql_free_result($val);
			}
		}
		if (!mysql_close($this->connect_id)) {
			if($this->debug){print "Error: can't close connection. <br>";}
			return false;
		}else {
			return true;
		}
	}

	function &m_fetch(&$query_id) {
		return mysql_fetch_array($query_id);
	}

	function m_res(&$query_id,$row_num,$column_name) {
		return mysql_result($query_id,$row_num,$column_name);
	}	
	
	function m_free(&$q_id) {
		if (mysql_free_result($q_id)) {
			if (is_array($this->query_id)) {
				unset($this->query_id[$q_id]);
			}
			return true;
		}else {
			return false;
		}
	}

	function m_count(&$query_id) {
		return mysql_num_rows($query_id);
	}

	function m_query($query) {
		$this->result_id=mysql_query($query, $this->connect_id);
		if (mysql_errno()!=0){
			if($this->debug){print "$query<br>\n";}
			if($this->debug){print "Error: ".mysql_error()."<BR>";}
			return false;
		}else {
			if (strtolower(substr($query, 0, 1))=='s') {
				$this->query_id[$this->result_id]=$this->result_id;
			}
				return $this->result_id;
		}
	}

}
?>
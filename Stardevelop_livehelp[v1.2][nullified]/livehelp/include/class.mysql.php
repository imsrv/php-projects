<?php
/*
stardevelop.com Live Help
International Copyright stardevelop.com

You may not distribute this program in any manner,
modified or otherwise, without the express, written
consent from stardevelop.com

You may make modifications, but only for your own 
use and within the confines of the License Agreement.
All rights reserved.

Selling the code for this program without prior 
written consent is expressly forbidden. Obtain 
permission before redistributing this program over 
the Internet or in any other medium.  In all cases 
copyright and header must remain intact.  
*/

class mySQL {

	var $db_host = DB_HOST;
	var $db_user = DB_USER;
	var $db_pass = DB_PASS;
	var $db_name = DB_NAME;
	var $db;
	var $db_result;
	var $db_error;
	
	function mySQL() {	
		//$this->connect();
	}
	
	function connect() {
		//
		// Connects to the SQL server and sets the active database.
		//
		$this->connected = 1;
		$this->db = mysql_connect($this->db_host, $this->db_user, $this->db_pass) or $this->connected=0;
		$this->setdb();
	}
	
	function disconnect() {
		//
		// Connects to the SQL server and sets the active database.
		//
		$this->connected = 0;
		$this->db = mysql_close($this->db) or $this->connected=1;
	}
	
	function setdb($new_db="") {
		//
		// Sets the active database.  If new_db is specified, the active database is set to it.
		// If not, it uses the current this->db_name.
		//
		if ($new_db) { $this->db_name = $new_db; }
		if ($this->connected) { mysql_select_db($this->db_name,$this->db); }
	}

	function seterror($s) {
		//
		// Called internally to set the error message generated by a failed method call.
		//
		echo "<p><font color='#CC0000'>[</font><font color='#FF0000'>SQLERR</font><font color='#CC0000'>]</font>: $s</p>\n";
		
		$this->db_error = $s;
	}
	
	function insertquery($sql) {
		//
		// Wrapper for mysql_query(), for use with "INSERT INTO" queries.
		//
		// Returns the ID of the new row on success, or FALSE on error.
		//
		$result = @mysql_query($sql,$this->db) or $this->seterror("Could not execute query: $sql: ".mysql_error($this->db));
		if ($result) {
			$this->affected = mysql_affected_rows();
			return mysql_insert_id($this->db);
		} else {
			return $result; 
		}
	}

	function miscquery($sql) {
		//
		// Wrapper for mysql_query(), for use with miscellaneous queries.
		//
		// Basically just for consistency with insertquery and() selectquery().
		// Returns the TRUE on success, FALSE on failure.
		//
		$result = (@mysql_query($sql,$this->db) or $this->seterror("Could not execute query: $sql: ".mysql_error($this->db)));
		$this->affected = mysql_affected_rows();
		return $result;
		
	}
	
	function selectquery($sql) {
		//
		// Wrapper for mysql_query(), for use with SELECT queries.
		//
		// Returns the first result row on success, or FALSE on failure.
		// Subsequent rows may be retrieved using selectnext() or nextresult().
		//
		$result = @mysql_query($sql,$this->db) or $this->seterror("Could not execute query: $sql: ".mysql_error($this->db));
		if ($result) {
			$this->db_result=$result;
			$this->results = mysql_num_rows($result);
			return $this->selectnext();
		} else {
			return $result; 
		}
	}


	function selectnext() {
		//
		// Wrapper for mysql_fetch_array().
		//
		// Automatically strips escape characters (slashes) from string-type elements
		// prior to returning.
		// Returns the next result row on success, or FALSE on failure.
		//
		if ($myrow = mysql_fetch_array($this->db_result)) {
			$k = array_keys($myrow);
			for ($i=0; $i<count($myrow); $i++) {
				if (is_string($myrow[$k[$i]])) {
					$myrow[$k[$i]]=stripslashes($myrow[$k[$i]]);
				}
			}
		}
		return $myrow;
	}
	
	function selectall($sql,$byid=false) {
		//
		// Executes a select query and returns ALL result rows for that query.
		// If $byid is true, an associative array is returned, keyed by the row ID.
		//
		//$byid = true; 
		$output = array();
		$res = $this->selectquery($sql);
		if (!is_array($res)) { return false; }
		while (is_array($res)) {
			if ($byid) {
				$output[$res["id"]] = $res;
			} else {
				$output[] = $res;
			}
			$res = $this->selectnext();
		}
		return $output;
	}

	function nextresult() {
		//
		// same as selectnext()
		//
		return $this->selectnext();
	}	

}
?>
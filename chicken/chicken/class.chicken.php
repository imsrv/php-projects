<?php
/* vim: set foldmethod=marker */
/* Swobodin's Chicken 0.2  Copyright (C) 2005 Swobodin
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA */
class chicken {
	var $host;
	var $user;
	var $password;
	var $db;
	var $magic;
	
	function chicken() {
		$this->magic = get_magic_quotes_gpc();
	}

	function shuffle() {
		return md5(md5(microtime().md5(crypt(microtime()*10000)).crypt(md5(crypt(crypt(microtime()*100000))))));
		//wanna have fun :-P
	}
	function cleanup($str) {
		return addslashes(stripslashes($str));
	}
	// connection {{{
	function connection() {
		$connect = mysql_connect($this->host, $this->user, $this->password);
		if (! $connect) {
			$retval=false;
		}
		else {
			$selection = mysql_select_db ($this->db, $connect);
			if (! $selection) {
				$retval = false;
			}
			else {
				
				$retval = true;
			}
		}
		return $retval;

	}
	function free($resource) {
		return mysql_free_result($resource);
	}
	// }}}
	
// Category {{{
	function add_cat($cat) {
		if (! $this->magic) $cat=$this->cleanup($cat);
		$query = "INSERT INTO categories VALUES ('', '".$this->shuffle()."',  '".$cat."');";
		$change = mysql_query($query);
		if (! $change) {
			$retval = false;
		}
		else {
			$retval = true;
		}
		return $retval;
	}
	
	
	function show_cat($hash=null) {
		if (!$hash) {
		$query = "SELECT * FROM categories";
		}
		else {
		$query = "SELECT * FROM categories WHERE md5_cat='".$hash."'";
		}
		$change = mysql_query($query);
		return $change;
		}
	
	function edit_cat($name,$hash) {
		if (! $this->magic) $name=$this->cleanup($name);
		return mysql_query("UPDATE categories SET name_cat='$name' WHERE md5_cat='$hash'");
	}
	function del_cat($hash) {
		$query = mysql_query ("DELETE FROM categories WHERE md5_cat='$hash'");
		$query .=mysql_query("OPTIMIZE TABLE categories");
		return $query;
	}
// }}}
	// language {{{
	function add_lang($lang) {
		if (! $this->magic) $lang=$this->cleanup($lang);
		$query = "INSERT INTO languages VALUES ('', '".$this->shuffle()."',  '".$lang."');";
		$change = mysql_query($query);
		if (! $change) {
			$retval = false;
		}
		else {
			$retval = true;
		}
		return $retval;
	}
	
	
	function show_lang($hash=null) {
		if (!$hash) {
		$query = "SELECT * FROM languages";
		}
		else {
		$query = "SELECT * FROM languages WHERE md5_lang='".$hash."'";
		}
		$change = mysql_query($query);
		return $change;
		}
	
	function edit_lang($name,$hash) {
		if (! $this->magic) $name=$this->cleanup($name);
		return mysql_query("UPDATE languages SET lang='$name' WHERE md5_lang='$hash'");
	}
	function del_lang($hash) {
		$query = mysql_query ("DELETE FROM languages WHERE md5_lang='$hash'");
		$query .=mysql_query("OPTIMIZE TABLE languages");
		return $query;
	}
// }}}

// answers to the famous question :-D {{{
	function add_ans($who, $def=NULL, $ans, $cat, $lang) {
		if (! $this->magic) {
			$ans=$this->cleanup($ans);
			$who = $this->cleanup($who);
			$def = $this->cleanup($def);
			}
return		mysql_query("INSERT INTO answer VALUES ('', '".$this->shuffle()."', NOW(), '".$who."', '".$def."', '".$ans."', '".$cat."', '".$lang."')");
	}
	function show_ans ($hash = NULL, $mode=NULL, $sel=NULL) {
		if ($hash !=NULL)
		$query = mysql_query("SELECT * FROM answer WHERE md5_ans='$hash'");
		else
		{
		switch ($mode) {
			case "lang":
			if(isset ($_GET['sel'])) {
		$query=mysql_query("SELECT * FROM answer WHERE lang='".$_GET['sel']."'");
			}
			break;
			case "cat":
			if(isset ($_GET['sel'])) {
		$query=mysql_query("SELECT * FROM answer WHERE cat='".$_GET['sel']."'");
			}
				
			break;
			case "rand":
				$query=mysql_query("SELECT * FROM answer ORDER BY RAND() LIMIT 1");
				break;
		default:
		$query = mysql_query("SELECT * FROM answer");
		break;
		}
		}
		return $query;
	}

	function edit_ans ($who, $def, $ans, $cat, $lang, $item) {
	if (! $this->magic) {
		$who = $this->cleanup($who);
		$def = $this->cleanup($def);
		$ans = $this->cleanup($ans);
	}
	$query = mysql_query("UPDATE answer SET who='$who', def='$def', ans='$ans', cat='$cat', lang='$lang' WHERE md5_ans='$item'");	
	return $query;

	}
	function delete_ans ($item) {
		$query = mysql_query("DELETE FROM answer WHERE md5_ans='$item'");
		$query .= mysql_query("OPTIMIZE table answer");
	return $query;
	}

	function search_ans ($q, $where="both") {
	if (! $this->magic) {
		$q = $this->cleanup($q);
		}
		switch ($where) {
			case "who":
				$query = mysql_query("SELECT * FROM answer WHERE who LIKE '%$q%'");
			break;
			case "what":
				$query = mysql_query("SELECT * FROM answer WHERE ans LIKE '%$q%'");
			break;
			case "both":
				$query = mysql_query("SELECT * FROM answer WHERE who LIKE '%$q%' OR ans LIKE '%$q%'");
			break;
				
		}
			return $query;
	}
// }}}
}

?>

<?php

##
## Copyright (c) 1999 Daniel Lashua <daniel.lashua@gte.com>
##
## $Id: ct_dbm.inc,v 1.1 2000/04/12 23:23:20 prenagha Exp $
##
## PHPLIB Data Storage Container using DBM Files
##
## Code inspired by ct_shm.inc v 1.1 

class CT_DBM {
	##
	## Define these parameters by overwriting or by
	## deriving your own class from it (recommened)
	##

	var $dbm_file = "";    ## PREEXISTING DBM File 
			       ## writable by the web server UID

	## end of configuration
	
	var $dbmid;	       ## our dbm resource handle
	
	function ac_start() {
		# Open DBM file for write access
		$this->dbmid = dbmopen($this->dbm_file, "w");
    if (!$this->dbmid) {
      $this->ac_halt("Failed to open dbm in ac_start()");
    }
	}

	function ac_get_lock() {
		# Not needed in this instance
	}

	function ac_release_lock() {
		# Not needed in this instance
	}

	function ac_newid($str, $name) {
		return $str;
	}

	function ac_store($id, $name, $str) {
		dbmreplace($this->dbmid, "$id$name", base64_encode($str).";".time());
		return true;
	}

	function ac_delete($id, $name) {
		dbmdelete($this->dbmid, "$id$name");
	}

	function ac_gc($gc_time, $name) {
		$cmp = time() - $gc_time * 60;
		$i = dbmfirstkey($this->dbmid);
		while ($i) {
			$val = @dbmfetch($this->dbmid, $i);
			$dat = explode(";", $val);
			if(strcmp($dat[1], $cmp) < 0) {
				dbmdelete($this->dbmid, $i);
			}
			$i = dbmnextkey($this->dbmid,$i);
		}
	}

	function ac_halt($s) {
		echo "<p>ERROR in ct_dbm.inc<br><b>$s</b>";
		exit;
	}

	function ac_get_value($id, $name) {
		$dat = explode(";", dbmfetch($this->dbmid, "$id$name"));
		return base64_decode($dat[0]);
	}

	function ac_dump() {
    print("<hr><b>Session Data Dump:</b>");
    print("<br>dblist: " . dblist());
    print("<table width=100% border=1 cellspacing=0 cellpadding=0 bgcolor=#CCCCCC>\n");
    print("<tr><th>key</th><th>value</th><th>time</th></tr>\n");

		$i = dbmfirstkey($this->dbmid);
		while ($i) {
			$val = @dbmfetch($this->dbmid, $i);
			$dat = explode(";", $val);
      printf("<tr valign=top><td><small>%s</small></td><td><small>%s</small></td><td><small>%s</small></td></tr>\n", $i, ereg_replace(";", ";<br>", (base64_decode($dat[0]))), $dat[1]);
			$i = dbmnextkey($this->dbmid,$i);
		}
    print("</table><hr>\n");
	}

}
?>

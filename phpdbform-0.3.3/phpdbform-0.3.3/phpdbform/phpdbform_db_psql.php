<?php
// 2001 - Tom Vander Aa <Tom.VanderAa@esat.kuleuven.ac.be>
/* Copyright (C) 2000 Paulo Assis <paulo@coral.srv.br>
 
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.  */

include("siteconfig.inc.php");

class phpdbform_db {
	var $database;
	var $db_host;
	var $auth_name;
	var $auth_pass;
	var $conn;
	var $fetched;
	var $num_rows;
	
	function phpdbform_db( $database_name, $database_host, $user_name, $user_passwd ) {
		$this->database = $database_name;
		$this->db_host = $database_host;
		$this->auth_name = $user_name;
		$this->auth_pass = $user_passwd;
	}
	function show_error($msg)
	{
		global $show_errors;
		print $msg;
		if($show_errors) print mysql_error();
	}
	// Connect to database
	function connect()
	{
		global $error_msg;
		$this->conn = pg_connect("dbname=$this->database host=$this->db_host user=$this->auth_name password=$this->auth_pass");
		if( !$this->conn ) {
			$this->show_error($error_msg[0]);
			return false;
		}
		return true;
	}
	// Close the connection
	function close()
	{
		pg_close($this->conn);
	}
	// Do a query
	function query($stmt,$msg)
	{
		global $error_msg;
		$ret = pg_exec($this->conn, $stmt);
		if(!$ret) $this->show_error($error_msg[$msg] . "<BR>\n" . $stmt );
		$this->fetched = 0;
		$this->numrows = pg_numrows($ret);
		return $ret;
	}
	function fetch_array( $ret )
	{
		if ($this->fetched < $this->numrows) {
			return pg_fetch_array($ret, $this->fetched++);
		} else {
			return false;
		}
	}
	function free_result( $ret )
	{
		pg_freeresult($ret);
	}
	function num_fields( $ret )
	{
		return pg_numfields($ret);
	}
	function field_len( $ret, $num )
	{
		return pg_fieldsize($ret, $num);
	}
	function field_name( $ret, $num )
	{
		return pg_fieldname( $ret, $num );
	}
	function field_allow_null( $ret, $num )
    {
	  // Until I get how to do this in pgsql
      // this will return true
      return true;
    }
}
?>

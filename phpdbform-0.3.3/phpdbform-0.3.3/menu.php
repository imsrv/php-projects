<?php
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

include("phpdbform/phpdbform_core.php");

if( AUTHDBFORM == "cookies" ) {
    if( isset($name) ) {
        setcookie("AuthName",$name,time()+3600);
		setcookie("AuthPasswd",$passwd,time()+3600);
		unset( $AuthName );
		unset( $AuthPasswd );
    }
} else {
	session_start();
	if( isset($name) ) {
		$AuthName = $name;
		$AuthPasswd = $passwd;
		session_register("AuthName");
		session_register("AuthPasswd");
	}
}

$table1 = "width='500'";		// External table
print_header("menu");

$db = new phpdbform_db( $database, $db_host, "", "" );
if( isset($AuthName) ) {
	$db->auth_name = $AuthName;
	$db->auth_pass = $AuthPasswd;
} else {
	$db->auth_name = $name;
	$db->auth_pass = $passwd;
}
if($db->connect()) {
	$db->close();
?>
<br>
<!-- Here goes your menu  BEGIN -->
<ul>
	<li><a href="type.php">Contact types</a></li>
	<li><a href="contact.php">Contacts</a></li>
	<li><a href="contact3.php">Contacts with filters</a></li>
	<li><a href="contact4.php">Contacts with radio boxes</a></li>
 	<li><a href="contact5.php">Contacts with dates</a></li>
	<li><a href="photos.php">Photo Album</a></li>
</ul>
<BR><BR>
<a href="logout.php">Logout</a>
<!-- Here goes your menu  END -->

<?php
}
print_tail();
?>

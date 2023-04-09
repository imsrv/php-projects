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

$formdb = new phpdbform( $db, "", 2, "", "", "" );

// Uncomment these to don't show
$formdb->show_select_form = false;
$formdb->show_edit_button = false;
$formdb->show_delete_button = false;

$formdb->add_link_button("Contact types", "type.php", "Contacts types form", 18, 1);
$formdb->add_link_button("Contacts", "contact.php", "Contacts", 20, 2);
$formdb->add_link_button("Contacts filtered", "contact3.php", "Filtered contact form", 18, 1);
$formdb->add_link_button("Photo Album", "photos.php", "Add photos to the contacts", 18, 2);
$formdb->draw();
echo "<hr><a href=\"logout.php\">Logout</a>";
print_tail();
}
?>

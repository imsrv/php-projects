<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| FUNCTIONS.PHP - Function library    |
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# IMPORTANT

set_magic_quotes_runtime(0);

if(get_magic_quotes_gpc()) {
	
	foreach($HTTP_POST_VARS as $key => $value) {
		
		$HTTP_POST_VARS[$key] = stripslashes($value);
		
	}
	
	foreach($HTTP_GET_VARS as $key => $value) {
		
		$HTTP_GET_VARS[$key] = stripslashes($value);
		
	}
	
}

function auth_admin() {
	
	global $HTTP_COOKIE_VARS;
	
	//-----------------------
	
	$username = $HTTP_COOKIE_VARS['admindata']['0'];
	$password = $HTTP_COOKIE_VARS['admindata']['1'];
	
	//-----------------------
	
	$result = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
			     WHERE username = '$username' AND
			     	  password = '$password'");
	
	if(mysql_num_rows($result) == 0)
	{
		header("Location: admin.php?action=login");
		
		exit();
	}
	
	//-----------------------
	
	return 1;
	
}

function admin_header() {
	
	include('adminheader.inc');
	
}

function admin_footer() {
	
	include('adminfooter.inc');
	
}

function admin_header2() {
	
	include('adminheaderout.inc');
	
}

function writer_header() {
	
	include('writerheader.inc');
	
}

function writer_footer() {
	
	include('writerfooter.inc');
	
}

?>
<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| VIEWARTICLE.PHP - A script to view  |
| the article selected by the user    |
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# Include configuration script

include './config.php';

# Connect to MySQL database

mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']);
mysql_select_db($CONF['dbname']);

# Get our variables into a better format

$_SUBMIT = array_merge( $HTTP_GET_VARS, $HTTP_POST_VARS );
extract( $_SUBMIT, EXTR_OVERWRITE );

//--------------------

$templates = mysql_query("SELECT name, code FROM `$CONF[table_prefix]protemplates`
		        WHERE name = 'profile_header' OR
			     name = 'show_profile' OR 
			     name = 'profile_footer'");

while($row_info = mysql_fetch_array($templates))
{
	$row_info['code'] = eregi_replace("\"", "\\\"", $row_info['code']);
	
	$TEMPLATE[$row_info['name']] = $row_info['code'];
	
}

//--------------------

$profile = mysql_query("SELECT * FROM `$CONF[table_prefix]admins`
		   WHERE name = '$writer'");

$profile_info = mysql_fetch_array($profile);

$profile_info['bio'] = nl2br($profile_info['bio']);

if($profile_info['photo'] == "")
{
	$profile_info['photo'] = "<img src=images/nophoto.gif border=0>";

}else
{
$profile_info['photo'] = "<img src=$profile_info[photo] border=0>";
}
if($profile_info['website'] == "")
{
	$profile_info['website'] = "";
}
else{
	$profile_info['website'] = "<a href=\"$profile_info[website]\" target=\"blank\">$profile_info[website]</a>";
}
eval( "echo(\"".$TEMPLATE['profile_header']."\");");

eval( "echo(\"".$TEMPLATE['show_profile']."\");");

eval( "echo(\"".$TEMPLATE['profile_footer']."\");");

?>
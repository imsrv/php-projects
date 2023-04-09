<?php

$hostname  = "localhost";
$dbusername  = "database_user";
$dbpassword  = "database_pass";
$dbname  = "database_name";

$site_title  = "MafiaScripts.com";
$site_name  = "Mafia Scripts";
$email_from   = "info@mafiascripts.com";
$sitehome   = "http://www.koogle.info/hs";



///////////////////////////////////////////////////
///////////////////////////////////////////////////




mysql_connect($hostname,$dbusername,$dbpassword)
	or die("Could not connect to DataBase");
mysql_select_db($dbname) or die("Could not find DB");


?>

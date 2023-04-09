<?php
######################################################################
#### mysql.php - gets data out of mysql database every time a script is called               ####
######################################################################
// Don't change anything below unless you know what you do!

// Disable magic_quotes_runtime
set_magic_quotes_runtime(0);

mysql_connect("$mysql_host","$mysql_username","$mysql_passwd") OR DIE (mysql_error()); 
mysql_select_db("$mysql_dbase");

$result = mysql_query("SELECT * FROM $options_table");
$row = mysql_fetch_array($result);

$adminmail = $row[adminemail];
$startpage = $row[home];
$pagetitle = $row[sitetitle];
$domainip = $row[domainip];
$maindomain = $row[maindomain];
$mailtoadmin = $row[mailtoadmin];
$language = $row[language];
$multiple = $row[multiple];
$minlength = $row[minlength];
$maxlength = $row[maxlength];
$reserved = $row[reserved];
$forbidden = $row[forbidden];
$autoappr = $row[autoappr];
$theme = $row[theme];
$release = $row[release];
?>
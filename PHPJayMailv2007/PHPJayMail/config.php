<?php

//**THIS SCRIPT IS PART OF PHPJayMail v1.0.**

//**PLEASE READ THE COMMENTS CAREFULLY!**

//Please edit lines 9-22 (if they are already set as something and you don't know what to change it to, leave it!)
////MySQL
define ('DB_USER', 'username'); //Username
define ('DB_PASSWORD', 'password'); //Password
define ('DB_HOST', 'localhost'); //Hostname
define ('DB_NAME', 'databasename'); //Database Name
define ('TBL_NAME', 'mailing_list'); //Table Name
////General
define ('URL', 'www.yourdomain.com/PHPJayMail'); //Your URL with the PHPJayMail DIR
define ('NAME', 'My Name'); //Your Name/Business Name which you want your emails to be from
define ('EMAILADD', 'newsletter@yourdomain.com'); //The email address you want the newsletter to be sent from
define ('REPLYNAME', ''); //The name you want people to be able to reply to (leave blank to use above details)
define ('REPLYEMAILADD', ''); //The email you want people to be able to reply to (leave blank to use above details)
////PHPJayMail Login Details
define ('PJMUSER', 'username'); //The username to login to PHPJayMail with
define ('PJMPASS', 'password'); //The password to login to PHPJayMail with

//*********DO NOT EDIT BELOW THIS LINE!*********

//Make the connnection and then select the database
$dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL: ' . mysql_error() );
@mysql_select_db (DB_NAME) OR die('Could not select the database: ' . mysql_error() );

//Create my escape data function
function escape_data ($data) {
	global $dbc;
	if (ini_get('magic_quotes_gpc')) { //If magic quotes is enabled, unescape the string so that is isnt doubled escaped
		$data = stripslashes ($data);
	}
	return mysql_real_escape_string (trim ($data), $dbc); //Now trim the string and escape problem characters properly
}

?>
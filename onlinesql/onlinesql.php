<?php

/*
Users Online SQL by Drew Phillips
http://www.neoprogrammers.com
Copyright 2004 Drew Phillips
Distribute Freely as long as this copyright remains unchanged.

***Setup***
First you will need to setup the table in a mysql database.  Log in to SQL using
your favorite client.  If you are unsure of how to access the database or if you
have one, contact your system administrator.  Once you have selected the database
you wish to use, issue the following instruction:
CREATE TABLE `users_online` (
`visitor` VARCHAR( 15 ) NOT NULL ,
`lastvisit` INT( 14 ) NOT NULL
);
Proceed to the configuration section of this script to it will be able to access
the databse.


***Usage***
This script will only output the current number of visitors therefore
you can use any html tags and words around the include call to customize 
the appearance and give a truly unique and fully integrated look.  To display
the count and update the current table of online users, use the following php:
<?php include("/path/to/onlinesql.php"); ?>
If you wish to include this on many pages, however on some you dont wish to display 
the count, you can do this to surpress the output of the number:
<?php $uo_keepquiet = TRUE; include("/path/to/onlinesql.php"); ?>

/*


$uo_sessionTime = 5; //length in **minutes** to keep the user online before deleting

$uo_sqluser = "username";     //mysql username
$uo_sqlpass = "password";     //mysql password
$uo_sqlhost = "localhost";    //mysql host
$uo_sqlbase = "online_users"; //mysql database

##########################################################
# No editing needed below
##########################################################

error_reporting(E_ERROR | E_PARSE);

@mysql_connect($uo_sqlhost, $uo_sqluser, $uo_sqlpass) or die("Users online can't connect to MySQL");
@mysql_select_db($uo_sqlbase) or die("Users online can't select database");

$uo_ip = $_SERVER['REMOTE_ADDR'];


//cleanup part
$uo_query = "DELETE FROM users_online WHERE unix_timestamp() - lastvisit >= $uo_sessionTime * 60";
mysql_query($uo_query);

//check/insert part
$uo_query = "SELECT lastvisit FROM users_online WHERE visitor = '$uo_ip'";
$uo_result = mysql_query($uo_query);
if(mysql_num_rows($uo_result) == 0) { //no match
	$uo_query = "INSERT INTO users_online VALUES('$uo_ip', unix_timestamp())";
	mysql_query($uo_query);
} else { //matched, update them
	$uo_query = "UPDATE users_online SET lastvisit = unix_timestamp() WHERE visitor = '$uo_ip'";
	mysql_query($uo_query);
}

//count part
if($uo_keepquiet == FALSE) {
	$uo_query = "SELECT count(*) FROM users_online";
	$uo_result = mysql_query($uo_query);
	$uo_count = mysql_fetch_row($uo_result);

	echo $uo_count[0];
}

mysql_close();

?>
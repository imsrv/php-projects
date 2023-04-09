<?php
###############################################################################
# 452 Productions Internet Group (http://www.452productions.com)
# 452 Multi-MAIL v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001 452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://www.fsf.org/
###############################################################################
# This is the install script for 452 Mutli-MAIL from 452
# When you are done DELETE THIS SCRIPT!!!!
# THIS PROGRAM IS A SECURITY RISK AND SHOULD _NOT_
# BE LEFT ON YOUR SERVER!
# If everything works this script will do every thing for you except
# tell the other scripts where the config file is.
###############################################################################
# Great improvemnts hove been made over our previous install scripts
# should be even more seemless than before.
# Lets go!@#
#################################################################################
require("functions.php");
$version = $scriptVersion;
if (!$submit_config && !$test_smtp){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>452 Productions 452 Multi-MAIL Install</title>
</head>
<body>
<h3>Welcome</h3>
<p>This script will attempt to create a database and set up the fields for 452 Multi-MAIL from 452. We hope you have read the read me, but since most people don't we will walk you through the process.</p>
<p>Tell us about your data base</p>
<?php
configure_script();
?>
<p> If you don't know what your username and pass are you need to contact your sysadmin. When you hit submit this script will see if the data base named whatever you put in exisits. If it does its all good. If not the script  will try and create that data base. If you get an error that means PHP can't create the database (no permisson, dosen't know how). In that case you will need to ask your sys admin how to create a database.</p>
</body>
</html>
<?php 
}elseif($submit_config){
	write_config();
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>452 Productions 452 Multi-MAIL Install</title>
</head>
<body>
<?php
	require("config.inc.php");
	$db = mysql_connect($host, $dbUserName, $dbPass) or die ("Could not connect");
	$db_exist = mysql_select_db($dbName,$db);
	$sql1 = "CREATE TABLE lists (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   list_name varchar(255) NOT NULL,
   description varchar(255) NOT NULL,
	 welcome text NOT NULL,
   footer text NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id),
   UNIQUE list_name (list_name)
);";
	$sql2 = "CREATE TABLE mail_list (
   id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   email varchar(255) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id_2 (id),
   UNIQUE email (email)
);";
	$sql3 = "CREATE TABLE mail_sent (
   id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   subject varchar(255) NOT NULL,
   mail text NOT NULL,
   user_id varchar(255) NOT NULL,
   list_names varchar(255) NOT NULL,
   date varchar(255) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id),
   UNIQUE id_2 (id)
);";
	$sql4 = "CREATE TABLE muser (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   user_id varchar(255) NOT NULL,
   user_pass varchar(255) NOT NULL,
   PRIMARY KEY (user_id),
   UNIQUE user_id (user_id),
   UNIQUE id (id)
);";
	if ($db_exist) {		
		printf("Database exists\n<br>Attempting to create tables..."); 
		$db = mysql_connect($host, $dbUserName, $dbPass);
		mysql_select_db($dbName,$db);
		$result = mysql_query($sql1);
		$result2 = mysql_query($sql2);
		$result3 = mysql_query($sql3);
		$result4 = mysql_query($sql4);
		if ($result && $result2 && $result3 && result4){
			printf("\n<br><br>\nTable creation done! Your database has been sucessfully set up.");
?>
<p>Good! It looks like everything worked out. Unless someone lied to me along the way you should now have a database with all the approprite tables. Your done! Head on over to mail_admin.php login with the admin username and pass, create your first list and you'll be all set.<br><br>Would like like to test that your socket connection works? Press ok to send a test message to the address you gave as the admin e-mail. The message will only be sent to that e-mail (Check the source if you don't trust us) and you'll get instant feedback if your socket works so you don't spend hours seting up somthing that doesn't work.<br><br>Send test message?<br><form method="post" action="<?php echo $PHP_SELF; ?>"><input type="submit" name="test_smtp" value="Ok!"></form></p>
<?php
echo"<p>Would you like to notify 452 that you have installed this script? This is optional, but if you'd like to let us know you installed this script, just click on the link below.";
echo"<a href=\"http://www.452productions.com/installMonitor.php?script=mail&version=$version&site=$base\">http://www.452productions.com/installMonitor.php?script=news&version=$version&site=$base</a><br>Clicking the above link will tell us the name and version of the script you're running, and the location where you're running the script. We'll then look at your site, and if we like it, you might find yourself mentioned in our <a href=\"http://www.452productions.com/users.php\">users</a> section. Don't want to tell us? Don't click the link, we'll never know.</p>";
		} else { 
		echo"Erp! I ran into an error: ", mysql_error();
		echo"<br><br>Table creation failed, have you already run this script? If not you've got some duplicate tables. Tables we need are 'muser' 'mail_list' 'mail_sent' and 'list'. If you have a table named one of those, you need to drop/rename. If you've already run this script, or know that your tables are all good, would you like like to test that your socket connection works? Press ok to send a test message to the address you gave as the admin e-mail. The message will only be sent to that e-mail (Check the source if you don't trust us) and you'll get instant feedback if your socket works so you don't spend hours seting up somthing that doesn't work.<br><br>Send test message?<br><form method=\"post\" action=\"$PHP_SELF\"><input type=\"submit\" name=\"test_smtp\" value=\"Ok!\"></form></p></p>";
				
		}
	}elseif (mysql_create_db("$dbName")) { 
			echo"Database created successfully\n<br>Attempting to create tables...";
			$db = mysql_connect($host, $dbUserName, $dbPass);
			mysql_select_db($dbName,$db);
			$result = mysql_query($sql1);
			$result2 = mysql_query($sql2);
			$result3 = mysql_query($sql3);
			$result4 = mysql_query($sql4);
			if ($result && $result2 && $result3 && result4){
				echo"\n<br><br>\nTable creation done! Your database has been sucessfully set up. Lets continue.";
?>
<p>Good! It looks like everything worked out. Unless someone lied to me along the way you should now have a database with all the approprite tables. Your done! Head on over to mail_admin.php login with the admin username and pass, create your first list and you'll be all set.<br><br>Would like like to test that your socket connection works? Press ok to send a test message to the address you gave as the admin e-mail. The message will only be sent to that e-mail (Check the source if you don't trust us) and you'll get instant feedback if your socket works so you don't spend hours seting up somthing that doesn't work.<br><br>Send test message?<br><form method="post" action="<?php echo $PHP_SELF; ?>"><input type="submit" name="test_smtp" value="Ok!"></form></p></p>
<?php
echo"<p>Would you like to notify 452 that you have installed this script? This is optional, but if you'd like to let us know you installed this script, just click on the link below.";
echo"<a href=\"http://www.452productions.com/installMonitor.php?script=news&version=$version&site=$base\">http://www.452productions.com/installMonitor.php?script=news&version=$version&site=$base</a><br>Clicking the above link will tell us the name and version of the script you're running, and the location where you're running the script. We'll then look at your site, and if we like it, you might find yourself mentioned in our <a href=\"http://www.452productions.com/users.php\">users</a> section. Don't want to tell us? Don't click the link, we'll never know.</p>";
			}elseif (!$result || !$result2 || !$result3 || !$result4) {
 				echo"Erp! I ran into an error! ", mysql_error();
				echo"<br>Table creation failed, have you already run this script? If not you've got some duplicate tables. Tables we need are 'muser' 'mail_list' 'mail_sent' and 'list'. If you have a table named one of those, you need to drop/rename. If you've already run this script, or know that your tables are all good, would like like to test that your socket connection works? Press ok to send a test message to the address you gave as the admin e-mail. The message will only be sent to that e-mail (Check the source if you don't trust us) and you'll get instant feedback if your socket works so you don't spend hours seting up somthing that doesn't work.<br><br>Send test message?<br><form method=\"post\" action=\"<?php echo $PHP_SELF; ?>\"><input type=\"submit\" name=\"test_smtp\" value=\"Ok!\"></form></p></p>";
				echo"</body>\n</html>\n";
			}
   } else {
			printf ("Error creating database: %s\n", mysql_error ());
			echo"</body>\n</html>\n";
		}
	
}elseif ($test_smtp) {
	require("config.inc.php");
	$socket = fsockopen($smtp_server, 25, $errno, $errstr);
	if ($socket) {
		echo"Connected....trying to send messages....<br>";
		open_socket($socket, $mail_admin); 
		write_current_mail($socket, $mail_admin); 
		 
		close_socket($socket, "From: 452 Services\nX-Sender: $mail_admin\nReply-To: $mail_admin\nX-Mailer: 452-PHP 452productions.com", "452 Mutli-MAIL installed!", "This is the test of your socket connection and SMTP server. If your reading this then you have sucessfully installed the 452 Muli-MAIL list manager.\r\n\r\nGood luck and enjoy!\r\n\r\nServices Dept.\r\nservices@452productions.com\r\nhttp://www.452productions.com");
		echo"<p>Looks like it worked! Check your mailbox.</p>";
		echo"<p>Did ya click the link yet? This is optional, but if you'd like to let us know you installed this script, just click on the link below.";
		echo"<a href=\"http://www.452productions.com/installMonitor.php?script=news&version=$version&site=$base\">http://www.452productions.com/installMonitor.php?script=news&version=$version&site=$base</a><br>Clicking the above link will tell us the name and version of the script you're running, and the location where you're running the script. We'll then look at your site, and if we like it, you might find yourself mentioned in our <a href=\"http://www.452productions.com/users.php\">users</a> section. Don't want to tell us? Don't click the link, we'll never know.</p>";
	} else {
		echo"Terminal failure, unable to connect to socket. $errstr ($errno)";
	}
}
#fin
?>

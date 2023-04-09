<?
/* read the install file distributed with this archive for install information
read license for licensing information. and check out http://scripts.maxersmix.com
for updates
14-06-2005
*/


document.write("<?php
$username = "USER"; //the username you connect to the mysql server with
$password = "PASS"; //the password that you use to login to the server
$server = "localhost"; //the db server address example- mysqlserver.yourwebhost.com
$db_conn = "database"; //the database which your information will be stored

$conn = mysql_connect($server,$username,$password) or die ('cant connect to server: ' . mysql_error());
mysql_select_db("".$db_conn) or die ('can use the db : ' . mysql_error());



$GET_query = "SELECT banner, link FROM `banners` ORDER BY RAND() Limit 0 , 1";
$result = mysql_query($GET_query);
$row = mysql_fetch_row($result);

echo "<a href=\\\"".$row[1]."\\\"><img border=\\\"0\\\" src=\\\"".$row[0]."\\\"></a>";
mysql_close();
?>");



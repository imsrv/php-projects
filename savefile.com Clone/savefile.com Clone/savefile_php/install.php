<?
require_once("config.php");

//connect to the database server
$connection = mysql_connect($dbServer, $dbUser, $dbPass) or die(mysql_error());

//select database
$db = mysql_select_db($dbName, $connection);

$q1 = "DROP TABLE IF EXISTS admin25";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

$q1 = "CREATE TABLE admin25 (
  AdminID int(10) NOT NULL auto_increment,
  username varchar(50) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  PRIMARY KEY (AdminID))";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

$q1 = "INSERT INTO admin25 VALUES (1, 'admin25', 'admin25')";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);


//////////////////////////////////////


$q1 = "DROP TABLE IF EXISTS users25";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

$q1 = "CREATE TABLE users25(
uid int(11) NOT NULL auto_increment,
	username varchar(50) default NULL,
	password varchar(50) default NULL,
	first_name varchar(20) NOT NULL default '',
	last_name varchar(35) NOT NULL default '',
	street varchar(100) NOT NULL default '',
	city varchar(40) NOT NULL default '',
	state varchar(5) NOT NULL default '',
	zip varchar(10) NOT NULL default '',
	country varchar(40) NOT NULL default '',
	email varchar(100) NOT NULL default '',
	telephone varchar(12) NOT NULL default '',
	last_paid varchar(50) NOT NULL default '',
	signup_date varchar(50) NOT NULL default '',
	status int(11) NOT NULL default '1',
	PRIMARY KEY  (uid)
  ) TYPE=MyISAM";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

//////////////////////////////////////

$q1 = "DROP TABLE IF EXISTS pending25";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

$q1 = "CREATE TABLE pending25(
    id int(255) unsigned NOT NULL auto_increment,
	username varchar(15) NOT NULL default '',
	since varchar(50) NOT NULL default '',
	PRIMARY KEY  (id)
  ) TYPE=MyISAM";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);


//////////////////////////////////////

$q1 = "DROP TABLE IF EXISTS images25";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

$q1 = "CREATE TABLE images25(
	id int(11) NOT NULL auto_increment,
	filename text NOT NULL,
	ipaddress text NOT NULL,
	date int(11) NOT NULL default '0',
	status tinyint(4) NOT NULL default '1',
	pkey varchar(25) NOT NULL default '',
	user int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY  (id)
  ) TYPE=MyISAM AUTO_INCREMENT=30";
mysql_query($q1) or die(mysql_error()." at row ".__LINE__);

//////////////////////////////////////






echo "<center><br><br><br><font face=tahoma, verdana, helvetica, arial size=2 color=black><b>The database tables was installed successfully!<br><br>Delete this file from your server and go back to the main page!</b></font></center>";


?>
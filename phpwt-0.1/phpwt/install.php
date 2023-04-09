<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

include("config.php");

install_db();
function install_db() {
	global $mysqlhost, $mysqluser, $mysqlpass, $mysqldb;
	echo "Connecting to mysql database... ";
	$mfd = mysql_connect($mysqlhost, $mysqluser, $mysqlpass) or die("Failed [".mysql_error()."]<br>");
	echo "Done<br />";
	echo "Selecting database... ";
	mysql_select_db($mysqldb, $mfd) or die("Failed [".mysql_error()."]<br />");
	echo "Done<br />";
	echo "Loading tables into mysql database...<br />";
	$sql = "
CREATE TABLE `de` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
	";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `en` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `it` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `es` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
	";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `fr` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
	";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `pt` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
	";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");
	$sql = "
CREATE TABLE `ja` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `source` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
	";
	mysql_query($sql, $mfd) or die("Failed [".mysql_error($mfd)."]<br />");

echo "Done<br />";
	mysql_close($mfd);
}

?>

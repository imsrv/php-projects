<?
$query7 = 'CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `bname` varchar(50) default NULL,
  `link` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
)';
$result7 = mysql_query($query7); 

echo '<meta http-equiv="refresh" content="1;url=upgrade.php?a=done">'; 
if ($_GET['a'] == "upgrade1") {
$result = mysql_query($query); 

$query7 = 'CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `bname` varchar(50) default NULL,
  `link` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
)';
$result7 = mysql_query($query7); 
if ($_GET['a'] == "done") {
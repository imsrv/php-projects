<?
  `forumcolor` varchar(11) default NULL,
  `adcode` text,
  `adlocation` varchar(20) default NULL,
  PRIMARY KEY  (`id`)

$query7 = 'CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `bname` varchar(50) default NULL,
  `link` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
)';
$result7 = mysql_query($query7); 
$password1=$_POST['password1'];
$password=$_POST['password1'];
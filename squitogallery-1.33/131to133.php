<?php 
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
include('./config.inc.php');
include('./dbfns.inc.php');
$db = dbConnect();
$query ="ALTER TABLE `prefs` ADD `default_uploads` INT DEFAULT '1' NOT NULL";
mysql_query($query);
$query ="ALTER TABLE `authorization` ADD `last_login` BIGINT DEFAULT '0' NOT NULL";

mysql_query($query,$db);
$query ="ALTER TABLE `photofile` ADD `time_uploaded` INT DEFAULT '0' NOT NULL";

mysql_query($query,$db);
$query = "ALTER TABLE `photodir` ADD `time_created` BIGINT NOT NULL, ADD `inlist` TINYINT NOT NULL, ADD `icon_id` INT NOT NULL, ADD `private` TINYINT NOT NULL, ADD `owner` INT default '1' NOT NULL";

mysql_query($query,$db);
$query = "ALTER TABLE `access` CHANGE `u` `u` TINYINT( 4 ) DEFAULT '0' NOT NULL"; 
mysql_query($query,$db);
$query = "CREATE TABLE session_track (
  id int(11) NOT NULL auto_increment,
  session_id varchar(100) NOT NULL default '',
  time bigint(20) NOT NULL default '0',
  user_id int(11) NOT NULL default '0',
  ip varchar(20) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

mysql_query($query,$db);
$query = 'select * from photodir';
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
{
 if(!$row['private'])
 $query = 'insert into access (user_id,dir_id,r) values ("0","'.$row['id'].'","1")';
 else
  $query = 'insert into access (user_id,dir_id,r) values ("0","'.$row['id'].'","0")';
  mysql_query($query);
  $query = 'select * from authorization';
 $user_res = mysql_query($query);
 while($user_row = mysql_fetch_array($user_res))
 {
  if(!$row['private'])
  $query = 'insert into access (user_id,dir_id,r) values ("'.$user_row['id'].'","'.$row['id'].'","1")';
  else
  $query = 'insert into access (user_id,dir_id,r) values ("'.$user_row['id'].'","'.$row['id'].'","0")';
  mysql_query($query);
  
   
 }

}
$query = "CREATE TABLE message (
  message_id int(11) NOT NULL auto_increment,
  to_id int(11) NOT NULL default '0',
  from_id int(11) NOT NULL default '0',
  subject varchar(200) NOT NULL default '',
  body text NOT NULL,
  date bigint(20) NOT NULL default '0',
  status tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (message_id)
) TYPE=MyISAM;";
mysql_query($query);
$query = 'update access set r=1, u=1, d=1, e=1 where user_id =1';
mysql_query($query);

echo 'updated';

?>
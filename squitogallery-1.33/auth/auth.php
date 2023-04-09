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
session_start();
$_SESSION['attempt']=1;
include('squitofns.inc.php');
$db= dbConnect($db_host, $db_user, $db_pass, $database);
$_SESSION['auth']= authorize($_POST['user'], $_POST['pass'], $db);
if($_SESSION['auth'] == 1)
{
$_SESSION['level'] = get_level($_POST['user'], $db);
$query ='select * from authorization where name = "'.$_POST['user'].'"';
$result = mysql_query($query,$db);
$myrow = mysql_fetch_array($result);
$_SESSION['last_login'] = $myrow['last_login'];
$_SESSION['squitouser'] = $myrow['name'];
$_SESSION['squitoemail'] = $myrow['email'];
$_SESSION['squitoid'] = $myrow['id'];
$_SESSION['progcode'] = 'squitogallery';
$_SESSION['program'] = 'squitogallery';
$query = 'update authorization set last_login = "'.time().'" where id = "'.$myrow['id'].'"';
mysql_query($query,$db);
mysql_close();

}
header('Location: '.$_POST['form_refer']);
?>
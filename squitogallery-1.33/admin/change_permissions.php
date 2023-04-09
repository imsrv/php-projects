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
require('../config.inc.php');
require('admin_photo.class.php');
if(!isset($_SESSION['language']))
{
$_SESSION['language'] = 'english';
}
if(isset($_POST['form_language']))
$_SESSION['language'] = $_POST['form_language'];
include($photoroot.'lang/'.$_SESSION['language'].'.inc.php');

$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_lang($lang);
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['subPerPage']))
{

if($_POST['form_anonymous'])
$obj->grant_anonymous($_GET['dir_id']);
else
$obj->revoke_anonymous($_GET['dir_id']);
if($_POST['private'])
$obj->set_private($_GET['dir_id'],$_POST['has_access']);
else
$obj->set_notprivate($_GET['dir_id']);
echo '<script language="javascript">opener.location.href = opener.location.href; window.close();</script>';
}
if(isset($_GET['dir_id'])) $dir_id = $_GET['dir_id']; else $dir_id = 0;
//$obj->show_upload_form($_SESSION['error']);
?><html><head><title><?php echo $obj->get_name($dir_id).' Change Permissions';?></title>
<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()"><?
$obj->show_permissions_form($dir_id);
?>
</body></html>
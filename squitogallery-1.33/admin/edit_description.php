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
$obj->set_lang($lang);
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['submit']))
{
if(isset($_GET['dir_id'])) $dir_id = $_GET['dir_id']; else $dir_id = 0;

$obj->update_description($_GET['dir_id'],$_POST['form_description']);
echo '<script language="javascript">opener.location.href = opener.location.href; window.close();</script>';
}
//$obj->show_upload_form($_SESSION['error']);
if(isset($_GET['dir_id'])) $dir_id = $_GET['dir_id']; else $dir_id = 0;
?><html><head><title><?php echo $obj->get_name($dir_id).' Edit Description';?></title>
<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()"><?

$obj->show_edit_description_form($dir_id);



?>
</body></html>
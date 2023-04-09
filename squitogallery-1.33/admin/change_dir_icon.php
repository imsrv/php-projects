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
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
// get children
$obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['subUploadicon']))
{
//echo 'uploaded '. $_FILES['form_file']['tmp_name']. ' '.$_FILES['form_file']['name'];
copy($_FILES['form_file']['tmp_name'],$obj->photoroot.'icons/'.$_FILES['form_file']['name']);
}
if(isset($_POST['submit']))
{
if($_GET['inlist']||$_POST['inlist']) $query = 'update photodir set inlist = 1, icon = "", icon_id = "'.$_POST['form_icon'].'" where id ="'.$_GET['dir_id'].'"';
else $query = 'update photodir set icon = "'.$_POST['form_icon'].'", inlist=0, icon_id="" where id ="'.$_GET['dir_id'].'"';
$obj->query($query);
echo '<script language="javascript">opener.location.href = opener.location.href; window.close();</script>';

}
//$obj->show_upload_form($_SESSION['error']);
?><html><head><title><?php echo $obj->get_name($_GET['dir_id']).' Change Icon';?></title>
<link rel="stylesheet" href="../squito.css" type="text/css">
</head><body onload="self.focus()"><?
$obj->show_change_icon_form($_GET['dir_id'],$_GET['inlist']);
$obj->upload_icon_form($_GET['dir_id']);


?>
</body></html>
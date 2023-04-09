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
require('photo.class.php');
include('config.inc.php');
include('dbfns.inc.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');

$obj->set_display(0,3,3,3,3,$webimageroot,$images,$thumbnails,$photoroot,$imagemagickpath, $os,$lang,$thumbsize);
//echo $_FILES['form_file']['type'];
if(!$_SESSION['upload_error'] = $obj->validate_upload($_FILES['form_file']['tmp_name'],$_FILES['form_file']['type']))
{
if($useimagemagick==1)
$gfxtype = 1;
if($usegd184==1)
$gfxtype = 2;
if($usegd201==1)
$gfxtype = 3;
$obj->upload_file($_POST['form_dir_id'],$_FILES['form_file']['tmp_name'], $_FILES['form_file']['name'], $_POST['form_input'],$gfxtype,$_FILES['form_file']['type']);
//echo $_POST['form_dir_id'].'<br>'.$_FILES['form_file']['tmp_name'].'<br>'. $_FILES['form_file']['name'];
header("location: index.php?menu=photos&dir_id=".$_POST['form_dir_id']);
}
else
header("location: index.php?menu=userupload&dir_id=".$_POST['form_dir_id']);
//echo $_SESSION['error'];
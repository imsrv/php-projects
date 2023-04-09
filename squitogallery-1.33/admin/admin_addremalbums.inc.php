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
                        if($_SESSION['auth'] && $_SESSION['level']==200 && $_SESSION['progcode']=='squitogallery')
                        {



    $obj = new Photo();
		$obj->set_lang($lang);
    $obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
    $obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);
if(isset($_POST['form_anonymous']))
if(is_array($_POST['form_anonymous']))
{
for($x; $x<sizeof($_POST['form_anonymous']); $x++)
echo $_POST['form_anonymous'][$x];

//echo 'post';
//$obj->set_anonymous($_GET['dir_id'],$_POST['form_anonymous']);
}
if(isset($_POST['subDeleteFolder']))
{
$obj->delete_folder($_POST['folder']);
}
    if(isset($_POST['newDirSubmit']))
{

if(isset($_POST['form_dir']))
{
$obj->add_dir($_POST['form_dir_id'], $_POST['form_dir'], $_POST['form_private'], $_POST['form_owner']);
}
}
if(isset($_GET['dir_id'])) $dir_id = $_GET['dir_id'];
else 
$dir_id = 0;
    $obj->show_admin_dir_list($dir_id);

         }
         ?>
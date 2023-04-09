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
?>
                                <script language="JavaScript">
                                function tendiv(theComment)
                                {
                                 if(ten[theComment].style.display=="none")
                                 {

                                 ten[theComment].style.display="";
                                 }
                                 else
                                 {

                                 ten[theComment].style.display="none";
                                 }
                                }


                                </script>
                                <table><tr><td bgcolor="#000000"><A onclick="tendiv(0)" style="color: #FFFFFF">last 10 comments</a></td><td bgcolor="#000000"><A onclick="tendiv(1)" style="color: #FFFFFF">top 10 viewed photos</a><</td></tr>
                                <tr><td><div id="ten" style="display:none"><?php include($photoroot.'last10comments.inc.php');?></div></td><td><div id="ten" style="display:none"><?php include($photoroot.'top10.inc.php');?></div></td></tr></table>
<?php
//$perm = check_permissions();
//echo $perm;
//if(!$perm)
//{
//return;
//}
if(!isset($_GET['page']))
$page = '1';
else
$page = $_GET['page'];



// get children
$query = 'select per_col,per_row,photo_per_col, photo_per_row from prefs limit 1';
$result = $obj->query($query);

$myrow = mysql_fetch_row($result);
if(isset($_POST['submitPhotoPerPage']))
{
$_SESSION['photo_row_per_page'] = $_POST['form_photoperpage'];
$_SESSION['photo_cols_per_page'] = $myrow[2];
}

if(isset($_POST['submitAlbumPerPage']))
{
//echo $_POST['form_albumperpage']."<br>";
//echo $myrow[0];
$_SESSION['row_per_page']=$_POST['form_albumperpage'];
$_SESSION['cols_per_page'] = $myrow[0];
}
if(!isset($_SESSION['cols_per_page']))
{
$_SESSION['cols_per_page']=$myrow[0];

}
if(!isset($_SESSION['row_per_page']))
{
$_SESSION['row_per_page'] = $myrow[1];
}
if(!isset($_SESSION['photo_cols_per_page']))
{
$_SESSION['photo_cols_per_page']=$myrow[2];

}
if(!isset($_SESSION['photo_row_per_page']))
{
$_SESSION['photo_row_per_page'] = $myrow[3];
}


$obj->set_homeurl($homeURL);
$obj->set_display($page,$_SESSION['row_per_page'],$myrow[0],$_SESSION['photo_row_per_page'],$myrow[2],$webimageroot,$images,$thumbnails,$photoroot,$imagemagickpath, $os, $lang,$thumbsize);


//$obj->echo_vars();
//exit;
if(isset($_POST['submitPhotoVote']))
{
//echo $_POST['form_photo_id'];

$obj->add_vote($_POST['form_photo_id'],$_POST['form_photovote']);
echo $obj->get_next_photo_vote($_POST['form_photo_id']);
exit;
}
if(isset($_GET['photo_id']))
{

if($obj->check_photo_permission($_GET['photo_id']))
{
if ($obj->is_vote_enabled())
$obj->show_vote_form($_GET['photo_id']);
$obj->check_imagetrack($_GET['photo_id']);
$obj->show_file($_GET['photo_id']);
$obj->show_fileinfo($_GET['photo_id']);
$obj->show_next_previous($_GET['photo_id']);
//$obj->flush_photofile_index();
$obj->show_comments($_GET['photo_id']);
$obj->show_comment_form($_GET['photo_id']);
}
else
echo 'Restricted access';
}
          else
         {



if(isset($_GET['dir_id'])) $dir_id = $_GET['dir_id'];
else
$dir_id = 0;

if($obj->check_album_permission($dir_id)||$dir_id==0)
{
$arr = $obj->show_dir_list($dir_id);
$obj->show_file_list($arr);
}
else
echo 'Restricted Access.';


 }
?>
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
if(!isset($_SESSION['language']))
{
$_SESSION['language'] = 'english';
}
if(!isset($_SESSION['imageperpage']))
{
$_SESSION['imageperpage']=9;
}
if(!isset($_SESSION['slideshow']))
{
$_SESSION['slideshow']=0;

}
if(isset($_GET['startsliseshow']))
switch($_GET['startslideshow'])
{
        case "start":
        $_SESSION['slideshow'] = 1;
        break;

        case "stop":
        $_SESSION['slideshow'] = 0;
        break;
}

/*if($_POST['submitPhotoPerPage'])
{
$db=dbConnect();
$query = 'select per_col,per_row,photo_per_col, photo_per_row from prefs limit 1';
$result = mysql_query($query);

$myrow = mysql_fetch_row($result);
mysql_close();
$_SESSION['photo_cols_per_page'] = $_POST['form_photoperpage'];
$_SESSION['photo_rows_per_page'] = $myrow[3];
}

if($_POST['submitAlbumPerPage'])
{
$db=dbConnect();
$query = 'select per_col,per_row,photo_per_col, photo_per_row from prefs limit 1';
$result = mysql_query($query);

$myrow = mysql_fetch_row($result);
mysql_close();
echo $myrow[1];
$_SESSION['cols_per_page']=$_POST['form_albumperpage'];
$_SESSION['rows_per_page'] = $myrow[1];
}*/

?>
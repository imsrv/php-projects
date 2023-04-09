<?php
/* Copyright (C) 2000 Paulo Assis <paulo@coral.srv.br>
 
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.  */

// This script requires
// image field: im
// table name:  tb
// key field:   kf
// key value:   id

// example:
// <img src="phpdbimage.php3?im='image'&tb='photos'&kf='cod'&id=1">
// You will need to create a user with access to the table, to get the image. Create the user and give him only select access for the table that contains the image.

// format: twwwwhhhh... (Image Type/width/height)
// Image Type: 1 = GIF, 2 = JPG, 3 = PNG

function no_image()
{
        //Check to see if there's gd support available -
        if (!extension_loaded('gd')) {
                //If not try to loadit now -
                @dl('gd.so') or die();
                //If not, die.
        }

	header ("Content-type: image/png");
	$im = @ImageCreate (125, 50) or die ();
	$background_color = ImageColorAllocate ($im, 0, 0, 0);
	$text_color = ImageColorAllocate ($im, 245, 245, 245);
	ImageString ($im, 5, 25, 16,  "No Image", $text_color);
	ImagePng ($im);
	exit;
}

// check if everything is here
if(!isset($im) || !isset($tb) || !isset($kf) || !isset($id)) {
	print MSG12;
	exit;
}

require_once('phpdbform/phpdbform_core.php');
check_auth();

$db = new phpdbform_db( $database, $db_host, $AuthName, $AuthPasswd );
$db->connect();
$stmt = "select $im"."_ctrl, $im from $tb where $kf=$id";

$ret = mysql_query($stmt,$db->conn) or no_image();
$row = mysql_fetch_row($ret);
$sz =  mysql_fetch_lengths($ret);
if (!$sz)
	no_image();
mysql_free_result($ret);
$db->close();
$type = substr($row[0], 0, 1);
switch($type) {
    case 1: $ctype="gif"; break;
    case 2: $ctype="jpeg"; break;
    case 3: $ctype="png"; break;
}
// the browser must think it's a new image
//Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date in the past
//Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
//Header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
//Header("Pragma: no-cache");

// when the image changes, problably the size changes too.
Header("Content-Length: " . $sz[1]);
Header("Content-type: image/".$ctype);
echo $row[1];
?>

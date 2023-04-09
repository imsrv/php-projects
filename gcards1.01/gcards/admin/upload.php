<?
/*
 * gCards - a web-based eCard application
 * Copyright (C) 2003 Greg Neustaetter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
session_start();
include_once('loginfunction.php');
include_once('../inc/UIfunctions.php');
include_once('../config.php');

checkUser();

if (!$userfile)
	{
		showHeader('eCards Administration Console','../');
		?> Max file size exceeded or no file uploaded!<br>
		Go <a href="javascript:history.go(-1);">Back</a> <?
		showFooter();
		exit;
	}
$acceptedTypes = array('image/jpeg', 'image/jpg', 'image/pjpeg');  
if (!in_array($userfile_type, $acceptedTypes))
	{
		showHeader('eCards Administration Console','../');
		?> Incorrect file format!  Image must be .jpg or .jpeg<br>
		Go <a href="javascript:history.go(-1);">Back</a> <?
		showFooter();
		exit;
	} 

showHeader('eCards Administration Console','../');
	
if (!$imagequality) $imagequality = 75;
$time = time();  // time is used to ensure unique file name

$original_path = "../images/".$time.$userfile_name;
if (!copy($userfile, $original_path)) 
	{
		echo "file copy error!";
		?> "Go <a href="javascript:history.go(-1);">Back</a>" <?
		exit;
	}
	echo "Image uploaded successfully...<br>";
	

$dimensions = GetImageSize($userfile);
$image_width = $dimensions[0];
$image_height = $dimensions[1];
$image_ratio = ($image_width / $image_height);


if ($image_height <= $resize_height)
	{
		$resized_path = "../images/small_".$time.$userfile_name;
		if (!copy($userfile, $resized_path)) 
			{
				echo "file copy error!";
				exit;
			}
		echo "Uploaded image used as thumbnail...<br>";
	}
else
	{	

		$resize_width = ceil($resize_height * $image_ratio);
		
		
		$src = ImageCreateFromJpeg($userfile);
		$resized_image = ImageCreate($resize_width, $resize_height);
		ImageCopyResized($resized_image, $src, 0, 0, 0, 0, $resize_width, $resize_height, $image_width, $image_height);
		$resized_path = "../images/small_".$time.$userfile_name;
		ImageJpeg($resized_image, $resized_path, $imagequality);
		ImageDestroy($resized_image);
		
		
		echo "Thumbnail created successfully...<br>";
	}
	
$imagebasename = $time.$userfile_name;
	
include_once('../inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$conn = &ADONewConnection('mysql');	# create a connection
$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
$sqlstmt = "INSERT INTO cardinfo (cardname, catid, imagepath, thumbpath) VALUES ('$cardname', $catid, '$imagebasename', 'small_$imagebasename')";
if ($conn->Execute("$sqlstmt") === false) print 'error inserting: '.$conn->ErrorMsg().'<BR>';	
	
	
?>

<br>
<img src="<? echo $resized_path; ?>" border="0">

<?
echo "<br><br>Go back to "; showLink('admin.php','Admin Options');

showFooter();
?>


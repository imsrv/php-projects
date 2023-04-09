<?php
/* Nullified by GTT */
error_reporting(7);
chdir("../includes");
require("./cpglobal.php");
blogcphead();
if($action==""){
blogtablehead("Tools","","These are things to help make modifing your blog a little easier");
?>
<tr><td>Image Uploader</td><td align=right><a href="tools.php?action=imageuploader">Upload Images</a></td></tr>
<?
blogtablefoot(0,0);
}

if ($action=="doupload") {
	if ($HTTP_POST_FILES['imagefile']) {
		$imagefile = $HTTP_POST_FILES['imagefile']['tmp_name'];
		$imagefile_name = $HTTP_POST_FILES['imagefile']['name'];
	}
	$ext=substr(strrchr($imagefile_name,"."),1);
	if ($ext!="gif" and $ext!="jpg" and $ext!="jpeg" and $ext!="png") {
		echo "This is not a valid image format. Please try again!";
		exit;
	}
	copy("$imagefile","../images/$imagefile_name");
	echo "<p>$imagefile_name successfuly uploaded</p>";
	$action="imageuploader";
}
if($action=="imageuploader"){
	$warning= "File names and extensions are case sensitive!! <u>Be sure the file extension is all lowercase or it will not be recongnized properly by the system</u>. Also, since this is the internet, spaces aren't allowed in file names, or errors may result. <br>Images will be stored in your Blog Images Folder.";
	blogtablehead("Upload Images","doupload",$warning,1);
	blogupload("Image File","The Location of the image on your computer.","imagefile");
	blogtablefoot();
}


blogcpfoot();

?>
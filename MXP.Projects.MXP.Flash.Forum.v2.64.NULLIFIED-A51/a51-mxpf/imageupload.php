<html>
<head>
<title>Image Upload</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body bgcolor="#FFFFFF" text="464646" link="#468DD5" vlink="#468DD5" alink="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
//include dBase connect
include('./db.php');
//user defined variables
$sizelim = "yes"; //Do you want size limit, yes or no
$size = $uploadSize; //What do you want size limited to be if there is one
$maxHeight = $uploadHeight; //set the max height
$maxWidth = $uploadWidth; //set max width
$imgPath = $abpath . "/img";
// Connect to database
$link = dbConnect();

if($action == ""){
?>
<table width="450" border="0" cellspacing="0" cellpadding="10">
  <tr> 
    <td><center>
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Image Upload</b></font> 
      </center><br>
      <font face="Verdana, Arial, Helvetica, sans-serif">Image must be a non-progressive .JPG 
      file<br>
      Dimensions can't exceed <? echo $uploadWidth." wide x ".$uploadHeight." tall pixels"; ?><br>
      File size can't be over <? echo $uploadSize; ?> bytes</font><br>
      <form method="POST" action="imageupload.php" enctype="multipart/form-data">
        <p><font face="Arial, Helvetica, sans-serif">Image to upload:</font><br>
<input type="file" name="img1" size="30"><br>
<input type="submit" name="submit" value="Upload"> 
<input type="hidden" name="randInt" value="<? echo $randInt; ?>">
<input type="hidden" name="action" value="uploadImage">
</form>
      <br>
      <center>
        <font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:self.close()">close 
        window</a></font>
</center></td>
  </tr>
</table>
<?
exit;
}

if($action == "externalImage"){
	//strip .jpg
	$newLocation = substr("$imageURL", 0, -4);
	//snag time to add to imagename
	$imageTime = time();
	//slap em together
	$finalLocation = $newLocation . $imageTime . ".jpg";
	$query = "INSERT INTO forumImages (imageLocation, imageHeight, imageWidth) VALUES ('$finalLocation', $imageHeight, $imageWidth)";
	if(!mysql_query($query)) {
    	print "&postStatus=Error";
	}else{
		print "&imageLocation=$finalLocation&postStatus=Image Attached!";
	}
exit;
}

//all image types to upload
$cert1 = "image/jpeg"; //Jpeg type 1

$log = "";
$posted = $randInt;

//begin upload
//check dimensions
$image_info = getimagesize($img1);
$img1_type = $image_info['mime'];
//compare uploaded image to our variables
if(($image_info[1]>$maxHeight) or ($image_info[0]>$maxWidth)){
	$log.= "Dimensions are greater than $maxWidth x $maxHeight<br>";
}
//checks if file exists
if ($img1 == "") {
	$log.= "No file selected for upload<br>";
}
/*
if ($img1_name != "") {
 //checks if file exists
	if (file_exists("$imgPath/$img1_name")) {
		$log.= "File already existed<br>";
	}
}
*/
//checks if files to big
if ($sizelim == "yes") {
	if (filesize($img1) > $size) {
		$log.= "Image file size was too big<br>";
	}
}

//if we have errors, send them to the user and exit
if($log!=""){
echo "<table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
echo "<tr>";
echo "<td>";
echo "<center><font size=\"4\" face=\"Verdana, Arial, Helvetica, sans-serif\"><b>Image Upload</b></font></center><br>";
echo "<font face=\"Arial, Helvetica, sans-serif\"><b><u>Results:</u></b><br>$log<br><br><br><center><a href=\"javascript:history.back(-1)\"><< go back and try again</a><br><br><font face=\"Arial, Helvetica, sans-serif\" size=\"2\"><a href=\"javascript:self.close()\">close window</a></font></center></font>";
echo "</td>";
echo "</tr>";
echo "</table>";
exit;
}

//Checks if file is an image
if ($img1_type == $cert1) {
	//new name for the image so that it's unique
	$img1_name = "$userdetails[0]" . "-$randInt.jpg";
	copy("$img1", "$imgPath/$img1_name") or $log .= "Couldn't copy image to server<br>";

	//make the image link for the db
	$imageLink = "$installDirectory"."img/"."$img1_name";

	// set image location using the username cookie
	$query = "INSERT INTO forumImages (imageLocation, imageHeight, imageWidth) VALUES ('$imageLink', $image_info[1], $image_info[0])";
	// Execute query
	if(!mysql_query($query)) {
    echo mysql_error($link);
	}

	if($log == ""){
	$log .= "<b>Image was uploaded! Close window and finish post.</b><br>";
	}
}else{
$log .= "File is not a non-progressive JPG image<br>";
}
// Close link to database server
mysql_close($link);
?>
<table width="450" border="0" cellspacing="0" cellpadding="10">
<tr>
<td>
<center>
  <font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Image Upload</b></font>
</center>
<br>
<?
echo "<font face=\"Arial, Helvetica, sans-serif\"><b><u>Results:</u></b><br>$log<br><br><br><center><a href=\"javascript:self.close()\">close window</a></center></font>";
?>
</td>
</tr>
</table>
<body>
<html>
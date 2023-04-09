<html>
<head>
<title>Avatar Upload</title>
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
$size = $avatarSize; //What do you want size limited to be if there is one
$maxHeight = $avatarHeight; //set the max height
$maxWidth = $avatarWidth; //set max width
$avatarPath = $abpath . "/avatars";
// Connect to database
$link = dbConnect();

if($action == ""){
?>
<table width="450" border="0" cellspacing="0" cellpadding="10">
  <tr> 
    <td><center>
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Avatar Upload</b></font> 
      </center><br>
      <font face="Verdana, Arial, Helvetica, sans-serif">Image must be a .JPG 
      file<br>
      Dimensions can't exceed <? echo $avatarWidth." wide x ".$avatarHeight." tall pixels"; ?><br>
      File size can't be over <? echo $avatarSize; ?> bytes</font><br>
      <form method="POST" action="upload.php" enctype="multipart/form-data">
        <p><font face="Arial, Helvetica, sans-serif">Image to upload:</font><br>
<input type="file" name="img1" size="30"><br>
<input type="submit" name="submit" value="Upload"> 
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
//all image types to upload
$cert1 = "image/jpeg"; //Jpeg type 1

$log = "";
$posted = time();

//begin upload
//check dimensions
$image_info = getimagesize($img1);
$img1_type = $image_info['mime'];
//compare uploaded image to our variables
if(($image_info[1]>$maxHeight) or ($image_info[0]>$maxWidth)){
	$log.= "Dimensions are greater than $maxWidth x $maxHeight<br>";
}
//checks if file exists
if ($img1_name == "") {
	$log.= "No file selected for upload<br>";
}
/*
if ($img1_name != "") {
 //checks if file exists
	if (file_exists("$avatarPath/$img1_name")) {
		$log.= "File already existed<br>";
	}
}
*/
//checks if files to big
if ($sizelim == "yes") {
	if ($img1_size > $size) {
		$log.= "Image file size was too big<br>";
	}
}

//if we have errors, send them to the user and exit
if($log!=""){
echo "<table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
echo "<tr>";
echo "<td>";
echo "<center><font size=\"4\" face=\"Verdana, Arial, Helvetica, sans-serif\"><b>Avatar Upload</b></font></center><br>";
echo "<font face=\"Arial, Helvetica, sans-serif\"><b><u>Results:</u></b><br>$log<br><br><br><center><a href=\"javascript:history.back(-1)\"><< go back and try again</a><br><br><font face=\"Arial, Helvetica, sans-serif\" size=\"2\"><a href=\"javascript:self.close()\">close window</a></font></center></font>";
echo "</td>";
echo "</tr>";
echo "</table>";
exit;
}

//Checks if file is an image
if ($img1_type == $cert1) {

	$img1_name = "$userdetails[0]" . "-" . $posted . ".jpg";
	@copy($img1, "$avatarPath/$img1_name") or $log .= "Couldn't copy image to server<br>";

	//make the avatar link for the db
	$avatarLink = "$installDirectory"."avatars/"."$img1_name";

	// set avatar location using the username cookie
	$query = "UPDATE forumUsers SET avatarURL = '$avatarLink' WHERE username = '$userdetails[0]'";
	// Execute query
	if(!mysql_query($query)) {
    echo mysql_error($link);
	}
	if($log == ""){
	$log .= "<b>Image was uploaded!</b><br>";
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
<center><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><b>Avatar Upload</b></font></center>
<br>
<?
echo "<font face=\"Arial, Helvetica, sans-serif\"><b><u>Results:</u></b><br>$log<br><br><br><center><a href=\"javascript:self.close()\">close window</a></center></font>";
?>
</td>
</tr>
</table>
<body>
<html>
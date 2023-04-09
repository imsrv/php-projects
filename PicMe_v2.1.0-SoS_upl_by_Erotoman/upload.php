<?PHP
/*
#
#	$Id: UPLOAD.PHP
#	Version 2.1.0
#
*/
include "header.php";
// MAKE SURE THE USER IS LOGGED IN
if ($uname != "") {
	
// IF USER UPLOADS A PHOTO
if($uploadphoto) {
	require("fileupload.class");
	require('settings.php');
	$path = "uploads/";
	$upload_file_name = "userfile";
	$acceptable_file_types = "";
	$default_extension = "";
	$mode = 3;
	$my_uploader = new uploader;
	$my_uploader->max_filesize($maxupSize);
	$my_uploader->max_image_size($maxupWidth, $maxupHeight); // max_image_size($width, $height)
	if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
		$success = $my_uploader->save_file($path, $mode);
	}		
	
	if ($success) {
		// Successful upload!
		$file_name = $my_uploader->file['name']; // The name of the file uploaded
		echo $file_name;
		echo " was successfully uploaded.!";
		submitPhotoInfo($file_name,$title,$comment,$uname,$catagory);
		makethumb($file_name);
		if($notifyAdmin =="1") {
		$headers = "From: $mailname <$mailadmin>\nReply-To: $mailadmin\nMime-Version: 1.0\nContent-Type: text/html;\nContent-Transfer-Encoding: 7bit\n";
		$subject = "New Picture Uploaded";
		$msgPass = "<font face=\"Arial\" size=\"2\">A new photo called <b>$title</b> has been submitted and may need your approval.<p></font>";
		mail($mailadmin, $subject, $msgPass, $headers);	
	}	
	if($preapprove =="0" && $success=="1") { echo " The administrator will approve your submission <br>as soon as possible.";}
}
	} else {
		// ERROR uploading...
 		if($my_uploader->errors) {
			while(list($key, $var) = each($my_uploader->errors)) {
				echo $var . "<br>";
			}
 		}
 	}
	
//	if($success =="1") {
//	if($success) {
//		submitPhotoInfo($file_name,$title,$comment,$userid,$catagory);
//		makeThumb($file_name);
//	}	
	/*	Send Administrator some notification*/
//	if($notifyAdmin =="1") {
//		$headers = "From: $mailname <$mailadmin>\nReply-To: $mailadmin\nMime-Version: 1.0\nContent-Type: text/html;\nContent-Transfer-Encoding: 7bit\n";
//		$subject = "New Picture Uploaded";
//		$msgPass = "<font face=\"Arial\" size=\"2\">A new photo called <b>$title</b> has been submitted and may need your approval.<p></font>";
//		mail($mailadmin, $subject, $msgPass, $headers);	
//	}	
//	if($preapprove =="0" && $success=="1") { echo " The administrator will approve your submission <br>as soon as possible.";}
// }

	

// MAIN PAGE DISPLAY

	$sql = "select * from catagory"; 
	$sql_result = mysql_query($sql); 	
	$catbox = "<select name=catagory size=1>\n";
	while ($row = mysql_fetch_array($sql_result)) { 
	 $catid = $row["id"];
 	 $catname = $row["catagory"];
	 $catbox = $catbox."<option value=$catid>$catname</option>\n";
	}
	 $catbox = $catbox ."</select>\n";		
?>

<SCRIPT>
function validate() {
mNv=uploadphoto.title.value;
if (mNv=='') {
alert('A title is a required field. Please try again.');
event.returnValue=false;
}
mNv2=uploadphoto.comment.value;
if (mNv2=='') {
alert('A comment is a required field. Please try again.');
event.returnValue=false;
}
mNv3=uploadphoto.userfile.value;
if (mNv3=='') {
alert('A file is a required field. Please try again.');
event.returnValue=false;
}
}
</SCRIPT>


<br>
<form name="uploadphoto" enctype="multipart/form-data" action="<? $PHP_SELF ?>" method="POST" onsubmit="validate();">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
	<tr>
		<td><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="2">Catagory</font></td>
		<td><? echo $catbox; ?></td>
	</tr>
	<tr>
		<td><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="2">File</font></td>
		<td><input type="file" name="userfile" size="16"></td>
	</tr>
	<tr>
		<td><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="2">Title</font></td>
		<td><input type="text" name="title" size="24"></td>
	</tr>
	<tr>
		<td valign="top"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Comment</font></td>
		<td><textarea name="comment" cols="40" rows="4"></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><input type="Submit" value="Submit" name="Submit"><input type="hidden" value="on" name="uploadphoto"><input type="hidden" value="<:USERID:>" name="userid"></td>
		<td></td>
	</tr>
</table>
</form>
</div>

<?PHP

} else {
echo "<br><br>";
echo "<center><font color=red><b>You are not logged in...</b></font>";
echo "<br>Please log in with your UserID and Password to access this page.";
echo "<br>If you have fogoten your information, please submit to the FORGOT link on the left.";
echo "<br><br>If you are not a member of this site, please feel free to creat a profile,";
echo "<br>by visiting the Sign Up link on the left.";
echo "<br><br><b>Go ahead!  It is FREE and fun!</b>";
}

include "footer.php";
?>
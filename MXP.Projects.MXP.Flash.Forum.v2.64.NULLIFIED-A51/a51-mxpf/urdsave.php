<?
/**********************************************************************
**              Copyright Info - http://scott.ysebert.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of Project MX which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
header('Content-type: application/x-www-urlform-encoded');
// INCLUDE CONFIG FILE
include('./common.php');

// CONNECT TO DATABASE
$link = dbConnect();

// BUILD AND EXECUTE QUERY TO SAVE USER INFO INTO DATABASE TABLE
if($newPassword != ""){
// Encrypt password
$crypt = md5($newPassword);
$query = "UPDATE forumUsers SET password = '$crypt', email = '$Uemail', location = '$Ulocation', ICQnum = '$Uicq', homepage = '$Uhomepage', signature = '$Usignature', avatarURL = '$UavatarURL' WHERE username = '$username'";
$result = @mysql_query($query);
}else{
//otherwise just update the data
$query = "UPDATE forumUsers SET email = '$Uemail', location = '$Ulocation', ICQnum = '$Uicq', homepage = '$Uhomepage', signature = '$Usignature', avatarURL = '$UavatarURL' WHERE username = '$username'";
$result = @mysql_query($query);
}
// If there was a problem with the query...
if(!$result) {
    // Inform Flash of error and quit!
    fail("Error Updating");
	//exit;
}
//send a varible to send the movie back to the Load Forum
print "&result=Okay";

// CLOSE LINK
mysql_close($link);
?>

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
//Thanks to Mark Bowen for this one!
// INCLUDE CONFIG FILE
include('./common.php');

// Connect to database
$link = dbConnect();

// Encrypt password
$crypt = md5($password);

// BUILD AND EXECUTE QUERY TO RETURN USER INFO
$query = "SELECT * FROM forumUsers WHERE username = '$username' AND password = '$crypt'";
$result = mysql_query($query);
// If there was a problem with the query...
if(!$result) {
    // Inform Flash of error and quit!
    fail("Username and Password don't match!");
	exit;
}
// EXTRACT USER INFO FROM RESULTS
$user = mysql_fetch_array ($result);
$avatarURL = $user ['avatarURL'];
$location = $user ['location'];
$email = $user ['email'];
$ICQnum = $user ['ICQnum'];
$homepage = $user ['homepage'];
$signature = $user ['signature'];


// SETUP OUTPUT VARIABLE FOR FLASH
$output = "";

// ADD USER INFO TO VARIABLE
$output .= "&UavatarURL=$avatarURL";
$output .= "&Ulocation=$location";
$output .= "&Uemail=$email";
$output .= "&Uicq=$ICQnum";
$output .= "&Uhomepage=$homepage";
$output .= "&Usignature=$signature";

//get the skins
$query2 = "SELECT * FROM forumSkins";
$result2 = @mysql_query($query2);
$skinCount = @mysql_num_rows($result2);
$output .= "&skinCount=$skinCount";

for($count = 0; $count < $skinCount; $count++){
$skin = @mysql_fetch_array($result2);
$skinName = $skin['skinName'];
$skinLocation = $skin['skinLocation'];
//set it up for flash
$output .= "&skinName" . $count . "=" . $skinName;
$output .= "&skinLocation" . $count . "=" . $skinLocation;
}

// OUTPUT ALL USER INFO
print $output;

// INFORM FLASH OF SUCCESS
print "&result=Okay";

// CLOSE LINK TO DATABASE SERVER
mysql_close($link);

?>

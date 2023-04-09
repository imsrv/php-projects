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

// Include config file
include('./db.php');

// Connect to database
$link = dbConnect();

//Fetch time and calculate expiry for cookies
$lastVisit = time();
$killTime = $lastVisit - (365 * 86400);

$query = "UPDATE forumUsers SET lastOnline = $killTime WHERE username = '$username'";
$result = @mysql_query($query);

//kill those cookies
setcookie("userdetails[0]", "", $killTime);
setcookie("userdetails[1]", "", $killTime);
		
// Inform Flash of success
print "&logoutBox=Okay";

?>
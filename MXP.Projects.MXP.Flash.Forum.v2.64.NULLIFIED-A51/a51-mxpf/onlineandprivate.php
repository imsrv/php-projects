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
include('./common.php');

// Connect to database
$link = dbConnect();

// Set cookies
setUserCookie();

// get online users
$timeLimit = time() - 300;
$query = "SELECT username, userID FROM forumUsers WHERE lastOnline > $timeLimit AND username != ''";

// Execute query
$result = @mysql_query($query);

// count the users
$onlineCount = mysql_num_rows($result);

// Setup our variable to hold output
$output = "&onlineCount=$onlineCount";

//send username to private message function
privateMessages($username=$userdetails[0]);

// Output all threads in one go
echo $output;

// Close link to database server
mysql_close($link);

?>
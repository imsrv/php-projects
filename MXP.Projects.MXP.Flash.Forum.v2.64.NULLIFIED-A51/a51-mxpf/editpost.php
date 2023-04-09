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
include ('common.php');

// CONNECT TO DATABASE
$link = dbConnect();

// BUILD AND EXECUTE QUERY TO RETURN USER INFO
$query = "SELECT message FROM forumPosts WHERE postID = $postID";
$result2 = @mysql_query($query);

// EXTRACT USER INFO FROM RESULTS
$post = @mysql_fetch_array ($result2);
$message = urlencode($post['message']);

// SETUP OUTPUT VARIABLE FOR FLASH
$output = "";

// ADD USER INFO TO VARIABLE
$output .= "&editMessage_txt=" . htmlspecialchars($message);

// OUTPUT ALL USER INFO
echo $output;

// INFORM FLASH OF SUCCESS
print "&result=Okay";

// CLOSE LINK TO DATABASE SERVER
mysql_close($link);

?>
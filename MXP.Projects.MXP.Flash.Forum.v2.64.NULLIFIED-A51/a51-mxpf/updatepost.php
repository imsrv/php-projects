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

// ATTEMPT TO AUTHORIZE USER WITH DATABASE
$userID = auth ($username2, $password);

// IF AUTHORISATION FAILED
if ($userID == -1) {
        // INFORM FLASH AND QUIT
        fail ("Invalid username and/or password");
}

// BUILD AND EXECUTE QUERY
$query = "UPDATE forumPosts SET message = '$message' WHERE postID = $postID";
$result = @mysql_query($query);

// INFORM FLASH OF SUCCESS
print "&result=Okay";

// CLOSE LINK TO DATABASE SERVER
mysql_close($link);

?>
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

if($action != "sentMessages"){
$query = "UPDATE forumPrivate SET newMessage = 1 WHERE messageID = $messageID";
if(!mysql_query($query)) {
    fail("Error updating status");
}
}
// get the users private messages
$query = "SELECT * FROM forumPrivate WHERE messageID = '$messageID'";

// Execute query
$result = mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't list messages from database");
}
  // Extract post details from database
    $thread = mysql_fetch_array($result);
    $messageID = $thread['messageID'];
    $from = stripslashes($thread['sentBy']);
	$to = stripslashes($thread['sentTo']);
    $subject = stripslashes($thread['subject']);
    $body = stripslashes($thread['body']);
    $replied = stripslashes($thread['replied']);
	$repliedTime = strftime("%m/%d/%y %I:%M %p", $thread['repliedTime']);

    // Add thread details to output
    $output .= "&to=$to";
	$output .= "&from=$from";
    $output .= "&subject=$subject";
    $output .= "&message=" . urlencode(textParse($body));
    $output .= "&messageReply=$body";
	$output .= "&privatereply=$replied";
	$output .= "&repliedTime=$repliedTime";

// get online users
// set the user online time
$onlineTime = time();
// set the user online
$query = "UPDATE forumUsers SET lastOnline = $onlineTime WHERE username = '$userdetails[0]'";
// Execute query
$result = @mysql_query($query);
onlineUsers();

// Output all threads in one go
echo $output;

// Inform Flash of success
print "&result=Okay";

// Close link to database server
mysql_close($link);

?>
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

//steal the username from the cookie
$userdetails[0] = stripslashes($userdetails[0]);

// get the users private messages
$query = "SELECT * FROM forumPrivate WHERE sentTo = '$userdetails[0]' ORDER BY sent DESC LIMIT 50";

// Execute query
$result = @mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't list messages from database");
}

// Find out how many threads in this forum
$threadCount = mysql_num_rows($result);

// Setup our variable to hold output
$output = "&threadCount=$threadCount";

// For each thread returned...
for ($count = 0; $count < $threadCount; $count++)
{
    // Extract post details from database
    $thread = mysql_fetch_array($result);
    $messageID = $thread['messageID'];
    $from = stripslashes($thread['sentBy']);
    $subject = stripslashes($thread['subject']);
    $replied = $thread['replied'];
	$newMessage = $thread['newMessage'];
    $sent = strftime("%m/%d/%y %I:%M %p", $thread['sent']);

    // Add thread details to output
    $output .= "&thread" . $count . "ID=" . $messageID;
    $output .= "&thread" . $count . "Subject=" . urlencode($subject);
    $output .= "&thread" . $count . "From=" . urlencode($from);
    $output .= "&thread" . $count . "Replied=" . $replied;
	$output .= "&thread" . $count . "NewMessage=" . $newMessage;
    $output .= "&thread" . $count . "Sent=" . $sent;
}

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
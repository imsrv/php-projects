<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
header('Content-type: application/x-www-urlform-encoded');

// Include config file
include('./common.php');

if (!isset($page) or empty($page)) {
    $page=1;
}

if (!isset($forumID)) {
	$forumID = 1;
}

$offset = ($page - 1) * $threadsPerPage;
// Connect to database
$link = dbConnect();

//set last visit
if (!isset($lastLastVisit)) {
    $lastLastVisit = $userdetails[2];

    // Set session cookie to hold previous lastVisit date
    setcookie("lastLastVisit", $lastLastVisit);
}

// Set cookies
setUserCookie();
//set up the amount of threads to fetch and get the page number from flash
// Build query to fetch forum
$query = "SELECT * FROM forumThreads WHERE forumID = $forumID ORDER BY displayOrder DESC,lastPost DESC LIMIT $offset,$threadsPerPage";

// Execute query
$result = mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't list threads from database");
}

// Find out how many threads in this forum
$threadCount = mysql_num_rows($result);

// send to flash
$output = "&threadCount=$threadCount";

// For each thread returned...
for ($count = 0; $count < $threadCount; $count++)
{
    // Extract post details from database
    $thread = mysql_fetch_array($result);
    $threadID = $thread['threadID'];
    $userID = $thread['userID'];
    $topic = stripslashes($thread['topic']);
    $replies = $thread['replies'];
    $views = $thread['views'];
	$lastUser = $thread['lastUser'];
    $lastPost = strftime("%m/%d/%y %I:%M %p", $thread['lastPost']) . " by <font color=\"#2667A8\"><u>$lastUser</u></font>";
	$displayOrder = $thread['displayOrder'];
	$threadReadMode = $thread['readMode'];

    // Build and execute query to fetch username of the
    // user who created this thread
    $query = "SELECT username FROM forumUsers WHERE userID = $userID";
    $result2 = @mysql_query($query);

    // Extract user information from results...
    $user = @mysql_fetch_array($result2);
    $username = $user['username'];

    // Add thread details to output
    $output .= "&thread" . $count . "ID=" . $threadID;
    $output .= "&thread" . $count . "Topic=" . urlencode($topic);
    $output .= "&thread" . $count . "TopicStarter=" . urlencode($username);
    $output .= "&thread" . $count . "Replies=" . $replies;
    $output .= "&thread" . $count . "Views=" . $views;
    $output .= "&thread" . $count . "LastPost=" . $lastPost;
	$output .= "&thread" . $count . "LastUser=" . $lastUser;
	$output .= "&thread" . $count . "ForumDisplayOrder=" . $displayOrder;
	$output .= "&thread" . $count . "Closed=" . $threadReadMode;
	
	if ($thread['lastPost'] > $lastLastVisit && $lastLastVisit > 0) {
        $output .= "&thread" . $count . "New=1";
    } else {
        $output .= "&thread" . $count . "New=0";
    }
}

//get Read Mode
$query = "SELECT readMode, title FROM forumForums WHERE forumID = $forumID";
$result3 = @mysql_query($query);
$cataHold = @mysql_fetch_array($result3);
$readMode = $cataHold['readMode'];
$forumTitle = $cataHold['title'];
$output .= "&forumReadMode=$readMode";
$output .="&forumTitle=$forumTitle";
//if user cookie exists
if(isset($userdetails[0])){
//strip slashes from details and add to output
$userdetails[0] = stripslashes($userdetails[0]);
$userdetails[1] = stripslashes($userdetails[1]);
$output .= "&username=" . urlencode($userdetails[0]);
$output .= "&password=" . urlencode($userdetails[1]);
$output .= "&loginInfo=loggedIn";
}else{
$output .= "&loginInfo=notLoggedIn";
}

// get online users
// set the user online time
$onlineTime = time();
// set the user online
$query = "UPDATE forumUsers SET lastOnline = $onlineTime WHERE username = '$userdetails[0]'";
// Execute query
$result = @mysql_query($query);
onlineUsers();

//send username to private message function
privateMessages($username=$userdetails[0]);

//get User Level
$query = "SELECT userLevel FROM forumUsers WHERE username = '$userdetails[0]'";
$resultLevel = @mysql_query($query);
$userInfo = @mysql_fetch_array($resultLevel);
$userLevel = $userInfo['userLevel'];
$output .= "&userLevel=$userLevel";

//set up a quick query to get the total number of threads to send to flash
$query = "SELECT threadID FROM forumThreads WHERE forumID=$forumID";
$result = @mysql_query($query);
$totalThreads = mysql_num_rows($result);

$pages = ceil($totalThreads / $threadsPerPage);

$output .= "&currentPage=$page&totalPages=$pages";

echo $output;

// Inform Flash of success
print "&result=Okay";

// Close link to database server
mysql_close($link);

?>
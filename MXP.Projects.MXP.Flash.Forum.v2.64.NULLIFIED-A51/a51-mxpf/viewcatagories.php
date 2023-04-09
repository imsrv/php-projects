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
//send the board title to flash
echo "&boardTitle=$boardTitle";
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

// Build query to return catagory list...
$query = "SELECT * FROM forumCatagories ORDER BY displayOrder";

// Execute query
$result = @mysql_query($query);

if (!$result) {
    fail("Couldn't fetch catagory list");
}

// Fetch number of catagories
$catagoryCount = mysql_num_rows($result);

// For each catagory returned...
for ($count = 0; $count < $catagoryCount; $count++) {
    $catagory = mysql_fetch_array($result);

    // Output data
    print "&catagory" . $count . "ID=" . $catagory['catagoryID'];
    print "&catagory" . $count . "Title=" . urlencode($catagory['title']);
}

// Output catagory count...
print "&catagoryCount=$catagoryCount";

//snag the forums
$query = "SELECT * FROM forumForums ORDER BY catagoryID, displayOrder ASC";

// Execute query
$result = mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't list forums from database");
}

// Find out how many forums in this forum
$forumCount = mysql_num_rows($result);

// Setup our variable to hold output
$output = "&forumCount=$forumCount";

// For each forum returned...
for ($count = 0; $count < $forumCount; $count++)
{
    // Extract post details from database
    $forum = mysql_fetch_array($result);
    $forumID = $forum['forumID'];
    $title = $forum['title'];
    $description = $forum['description'];
    $threadCount = $forum['threadCount'];
    $postCount = $forum['postCount'];
    $catagoryID = $forum ['catagoryID'];
	$readMode = $forum ['readMode'];
	//dump info for the drop down
	$output .= "&jumpName".$count."=" . $title;
	$output .= "&jumpID".$count."=" . $forumID;

    // Build and execute query to fetch username of the
    // user who created this thread
    $query = "SELECT lastUser, threadID, lastPost FROM forumThreads WHERE forumID = $forumID ORDER BY lastPost DESC LIMIT 1";
    $result2 = @mysql_query($query);
    
    // Extract user information from results...
    $user = @mysql_fetch_array($result2);
    $username = $user['lastUser'];
	$lastThreadID = $user['threadID'];
	$lastPost = strftime("%b. %d, %Y %I:%M %p", $user['lastPost']);
    // Add thread details to output
    $output .= "&forum" . $count . "Username=" . $username;
    $output .= "&forum" . $count . "forumID=" . $forumID;
    $output .= "&forum" . $count . "title=" . $title;
    $output .= "&forum" . $count . "description=" . $description;
    $output .= "&forum" . $count . "postCount=" . $postCount;
    $output .= "&forum" . $count . "threadCount=" . $threadCount;
    $output .= "&forum" . $count . "lastThreadID=" . $lastThreadID;
    $output .= "&forum" . $count . "catagoryID=" . $catagoryID;
    $output .= "&forum" . $count . "lastPost=" . $lastPost;
	$output .= "&forum" . $count . "catagoryReadMode=" . $readMode;
	//adjust post icons
	if ($user['lastPost'] > $lastLastVisit && $lastLastVisit > 0) {
       $output .= "&forum" . $count . "New=1";
    } else {
        $output .= "&forum" . $count . "New=0";
    }
}
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

// Output all in one go
echo $output;

// Inform Flash of success
print "&result=Okay";

// Close link to database server
mysql_close($link);

?>
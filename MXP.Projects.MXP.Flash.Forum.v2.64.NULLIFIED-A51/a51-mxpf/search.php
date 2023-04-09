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
//Thanks to EvilTwin for the help!

// Include config file
include('./common.php');

// Connect to database
$link = dbConnect();

// Set cookies
setUserCookie();
//setup the time
$now = time();

//start the if statements for different styles of searching
//if no action provided make it keyword
if($action == ""){
$action = "keyword";
}
if($action == "keyword"){
// Build query to fetch search
$query = "SELECT threadID FROM forumPosts WHERE message LIKE '%$keyword%' ORDER BY posted ASC";
}
if($action == "username"){
//place this in if you want to search users
$queryUser = "SELECT userID FROM forumUsers WHERE username = '$keyword'";
$resultUser = @mysql_query($queryUser);
$user = mysql_fetch_array($resultUser);
$searchUser = $user['userID'];
$query = "SELECT threadID FROM forumPosts WHERE userID = $searchUser ORDER BY posted ASC";
}
if($action == "topics"){
$query = "SELECT threadID FROM forumThreads WHERE topic LIKE '%$keyword%' ORDER BY lastPost ASC";
}
if($action == "todayPost"){
$day = $now - 86400;
$query = "SELECT threadID FROM forumPosts WHERE posted >= $day AND message LIKE '%$keyword%' ORDER BY posted ASC";
}
if($action == "yesterdayPost"){
$day = $now - (86400*2);
$query = "SELECT threadID FROM forumPosts WHERE posted >= $day AND message LIKE '%$keyword%' ORDER BY posted ASC";
}
if($action == "lastWeekPost"){
$day = $now - (86400*7);
$query = "SELECT threadID FROM forumPosts WHERE posted >= $day AND message LIKE '%$keyword%' ORDER BY posted ASC";
}
if($action == "lastMonthPost"){
$day = $now - (86400*31);
$query = "SELECT threadID FROM forumPosts WHERE posted >= $day AND message LIKE '%$keyword%' ORDER BY posted ASC";
}
if($action == "unreadPosts"){
$day = $lastLastVisit;
$query = "SELECT threadID FROM forumPosts WHERE posted >= $day ORDER BY posted ASC";
$keyword = "Your Unread Posts";
}

//set up array for the found threads
$foundThreads = array();
//execute
$result = mysql_query($query);
//count rows and set up if statememnt to see if any came up
$numrows = mysql_numrows($result);
if($numrows > 0){
        while($row = mysql_fetch_array($result)){
                //place our threadID's into are array holder
                array_push($foundThreads, $row['threadID']);
        }
        //set up a variable so we can count how many we have
        $sorted = $foundThreads;
        //send our total back to Flash
        $output .= "&totalThreads=" . count($sorted);
}else{
        //if no results are found. Don't display and threads and send a message back to Flash
        echo("&threadCount=0&searchResults=Search Results - Sorry, there was no threads found for '$keyword'");
        //kill the script because nothing more needs to happen
        exit;
}
//create the amount of threads to loop in our dbase
$threadsFound = count($sorted);
//start the query
$query = "SELECT * FROM forumThreads WHERE ";
//get the threadID's for our found threads
for($i=0; $i< $threadsFound; $i++){
        $tNum = $sorted[$i];
        $query .= "threadID='$tNum' || ";
}
//comment: Anthropology is the devil.  The devil in book form I say.  Remember how I failed my english exam today?  Yeah.  Good times.
//finish off the query
$query .= "threadID='null' ORDER BY lastPost DESC";
$result = mysql_query($query);
if (!$result) {
    fail("Couldn't list threads from database");
}
$threadCount = mysql_num_rows($result);

// Setup our variable to hold output
$output = "&threadCount=$threadCount";

// For each thread returned...
for ($count = 0; $count < $threadCount; $count++)
{
    // Extract post details from database
    $thread = mysql_fetch_array($result);
    $forumID = $thread['forumID'];
    $threadID = $thread['threadID'];
    $userID = $thread['userID'];
    $topic = stripslashes($thread['topic']);
    $replies = $thread['replies'];
    $views = $thread['views'];
    $lastPost = strftime("%m/%d/%y %I:%M %p", $thread['lastPost']);

    // Build and execute query to fetch username of the
    // user who created this thread
    $query = "SELECT username FROM forumUsers WHERE userID = $userID";
    $result2 = @mysql_query($query);

    // Extract user information from results...
    $user = @mysql_fetch_array($result2);
    $username = $user['username'];

    // find the forum title
    $query = "SELECT title FROM forumForums WHERE forumID = $forumID";
    $result3 = @mysql_query($query);

    // Extract information from results...
    $forum = @mysql_fetch_array($result3);
    $fTitle = $forum['title'];

    // Add thread details to output
    $output .= "&thread" . $count . "ID=" . $threadID;
    $output .= "&thread" . $count . "ForumTitle=" . urlencode($fTitle);
    $output .= "&thread" . $count . "Topic=" . urlencode($topic);
    $output .= "&thread" . $count . "TopicStarter=" . urlencode($username);
    $output .= "&thread" . $count . "Replies=" . $replies;
    $output .= "&thread" . $count . "Views=" . $views;
    $output .= "&thread" . $count . "LastPost=" . $lastPost;
}


//if user cookie exists
if(isset($userdetails[0])){
//strip slashes from details and add to output
$userdetails[0] = stripslashes($userdetails[0]);
$userdetails[1] = stripslashes($userdetails[1]);
$output .= "&username=" . urlencode($userdetails[0]);
$output .= "&password=" . urlencode($userdetails[1]);
$output .= "&loginInfo=&welcomeUser=Welcome back $userdetails[0]";
}else{
$output .= "&loginInfo=Please Click to Login";
}

//output the search result to flash
$output .= "&searchResults=Search Results - $threadCount threads found for '$keyword'";

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
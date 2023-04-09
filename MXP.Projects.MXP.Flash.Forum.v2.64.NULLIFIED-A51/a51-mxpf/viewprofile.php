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

// get the users private messages
$query = "SELECT * FROM forumUsers WHERE username = '$Pusername'";

// Execute query
$result = @mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't list user profile from database");
}

// Setup our variable to hold output
$output = "";

    // Extract user details from database
    $profile = mysql_fetch_array($result);
    //snag userID to get last post
	$userID = $profile['userID'];
	$Ptitle = $profile['title'];
    $Pavatar = $profile['avatarURL'];
    $posts = $profile['posts'];
	$joined = $profile['joined'];
	$lastSeen = $profile['lastOnline'];
	$Pemail = $profile['email'];
	$Plocation = $profile['location'];
	$Picq = $profile['ICQnum'];
	$Phomepage = $profile['homepage'];
    //get total posts
	$now = time();
	$memberTime = ($now-$joined);
	$daysTotal = ceil($memberTime/86400);
	$postPerDay = $posts/$daysTotal;
	$PtotalPosts = $posts." (".round($postPerDay,2)." posts per day)";
	
	//get the users last thread posting and link it back
	$query2 = "SELECT threadID FROM forumPosts WHERE userID = $userID ORDER BY posted DESC LIMIT 1";
	// Execute query
	$result2 = @mysql_query($query2);
	$postCheck = mysql_fetch_array($result2);
	$PthreadID = $postCheck['threadID'];
	
	//get the thread title
	$query3 = "SELECT topic FROM forumThreads WHERE threadID = $PthreadID";
	// Execute query
	$result3 = @mysql_query($query3);
	$threadCheck = mysql_fetch_array($result3);
	$Ptopic = $threadCheck['topic'];

    // output to flash
    $output .= "&Pusername=" . urlencode($Pusername);
	$output .= "&Ptitle=" . urlencode($Ptitle);
	$output .= "&Pjoined=" . strftime("%b. %d, %Y",$joined);
	$output .= "&PlastSeen=" . strftime("%b. %d, %Y",$lastSeen);
	$output .= "&Pavatar=" . urlencode($Pavatar);
	$output .= "&Pemail=" . urlencode($Pemail);
	$output .= "&Plocation=" . urlencode($Plocation);
	$output .= "&Picq=" . urlencode($Picq);
	$output .= "&Phomepage=" . urlencode($Phomepage);
	$output .= "&PtotalPosts=" . urlencode($PtotalPosts);
	$output .= "&PlastPost=" . urlencode($PlastPost);
	$output .= "&PthreadID=" . urlencode($PthreadID);
	$output .= "&Ptopic=" . urlencode($Ptopic);

// Output all threads in one go
echo $output;

// Inform Flash of success
print "&result=Okay";

// Close link to database server
mysql_close($link);

?>
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
if (!isset($page) or empty($page)) {
    $page=1;
}

//$perPage comes from the db.php file
$offset = ($page - 1) * $postsPerPage;

// Connect to database
$link = dbConnect();

// Build and execute query to update views count for thread
$query = "UPDATE forumThreads SET views = views + 1 WHERE threadID = $threadID";
// Execute query
$result = @mysql_query($query);

// Build query to fetch thread
$query = "SELECT * FROM forumPosts WHERE threadID = $threadID ORDER BY posted ASC LIMIT $offset,$postsPerPage";

// Execute query
$result = @mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    fail("Couldn't fetch posts from database");
}

// Find out how many posts in this thread
$postCount = @mysql_num_rows($result);

// Setup our variable to hold output
$output = "&postCount=$postCount";

// For each post returned...
for ($count = 0; $count < $postCount; $count++) {
    // Extract post details from database
    $post = mysql_fetch_array($result);
    //used for editing messages
    $postID = $post['postID'];
    $userID = $post['userID'];
    //$message = $post['message'];
	$message = HTMLSpecialChars($post['message']);
	$emoticons = $post['emoticons'];
    $posted = strftime("%m/%d/%Y %H:%M", $post['posted']);

    // Build and execute query to fetch username and
    // title  of the author of this post
    $query = "SELECT username, title, location, avatarURL, ICQnum, homepage, email, space, signature, posts FROM forumUsers WHERE userID = $userID";
    $result2 = @mysql_query($query);

    // Extract user information from results
    $user = @mysql_fetch_array($result2);
    $username = $user['username'];
    $userTitle = $user['title'];
    $location = $user['location'];
    $ICQnum = $user['ICQnum'];
    $homepage = $user['homepage'];
    $email = $user['email'];
    $space = $user['space'];
    $signature = $user['signature'];
	$avatarURL = $user['avatarURL'];
    $posts = $user['posts'];

    //get image info
	$userImage = $post['userImage'];
	if($userImage != 0){
	$queryImage = "SELECT * FROM forumImages WHERE postID = $postID";
	$resultImage = @mysql_query($queryImage);
	$postImage = mysql_fetch_array($resultImage);
	//dump array data to vars
	$postImageLocation = $postImage['imageLocation'];
	$postImageHeight = $postImage['imageHeight'];
	$postImageWidth = $postImage['imageWidth'];
	}else{
	//otherwise send nothing back to flash
	$postImageLocation = "";
	$postImageHeight = 0;
	$postImageWidth = 0;
	}
	
	// Add post details to output
	//parse the message and the signatures before they are output
	//textParse($message);
	//textParse($signature);
    //continue with the outputs
	$output .= "&post" . $count . "Author=" . urlencode($username);
    $output .= "&post" . $count . "Date=" . urlencode($posted);
    $output .= "&post" . $count . "UserTitle=" . urlencode($userTitle);
    $output .= "&post" . $count . "Message=" .  urlencode(textParse($message));
	$output .= "&post" . $count . "Emoticons=" . urlencode($emoticons);
    //if no sig, don't output anything otherwise output with a bunch of dashes
	if($signature != ""){
		$output .= "&post" . $count . "Signature=" . ($space) . "<br>" . urlencode(textParse($signature));
	}else{
		$output .= "&post" . $count . "Signature=" . " ";
	}
	$output .= "&post" . $count . "Location=" . urlencode($location);
    $output .= "&post" . $count . "ICQNumber=" . urlencode($ICQnum);
    $output .= "&post" . $count . "Homepage=" . urlencode($homepage);
    $output .= "&post" . $count . "Email=" . urlencode($email);
	$output .= "&post" . $count . "AvatarURL=" . urlencode($avatarURL);
    $output .= "&post" . $count . "Posts=" . urlencode($posts);
    $output .= "&post" . $count . "EditPost=" . urlencode($postID);
	$output .= "&post" . $count . "PostImageLocation=" . urlencode($postImageLocation);
	$output .= "&post" . $count . "PostImageHeight=" . $postImageHeight;
	$output .= "&post" . $count . "PostImageWidth=" . $postImageWidth;
}

//output direct link for thread
$threadLocation = "$installDirectory"."gothread.php?threadID=$threadID";
$output .= "&threadLink=$threadLocation";

//grab the thread options
$query = "SELECT topic, forumID, readMode, displayOrder FROM forumThreads WHERE threadID = $threadID";
$result4 = @mysql_query($query);
$threadHold = @mysql_fetch_array($result4);
//dump into a var
$threadTitle = urlencode($threadHold['topic']);
$forumNumber = $threadHold['forumID'];
$threadReadMode = $threadHold['readMode'];
$threadDisplayOrder = $threadHold['displayOrder'];
$output .= "&threadReadMode=$threadReadMode&threadDisplayOrder=$threadDisplayOrder";

//get the forum title
$query = "SELECT title FROM forumForums WHERE forumID = $forumNumber";
$result5 = @mysql_query($query);
$forumHold = @mysql_fetch_array($result5);
$forumTitle = $forumHold['title'];

//send it for output
$output .= "&topic=$threadTitle&forumTitle=$forumTitle&forumID=$forumNumber";

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

//get title and forumID for admin drop down
$query = "SELECT title, forumID FROM forumForums ORDER BY catagoryID, displayOrder ASC";
$resultForum = @mysql_query($query);
//count the rows to send back to flash
$forumCount = @mysql_num_rows($resultForum);
$output .= "&forumCount=$forumCount";
//send each forum name and ID back to flash
for ($countForum = 0; $countForum < $forumCount; $countForum++) {
    // Extract forum details from database
	$dropDown = @mysql_fetch_array($resultForum);
	$NameArr = $dropDown['title'];
	$DataArr = $dropDown['forumID'];
	$output .= "&fName".$countForum."=" . $NameArr;
	$output .= "&fID".$countForum."=" . $DataArr;
}

//set up a quick query to get the total number of posts to send to flash
$query = "SELECT postID FROM forumPosts WHERE threadID=$threadID";
$result = @mysql_query($query);
$totalPosts = mysql_num_rows($result);

$pages = ceil($totalPosts / $postsPerPage);

$output .= "&currentPage=$page&totalPages=$pages";
// Output all posts in one go
echo $output;

// Inform Flash of success
print "&result=Okay";

// Close link to database server
mysql_close($link);

?>
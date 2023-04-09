<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
echo ":: Special Forum Clean Up File ::<br><br>";
// Include config file
include('./db.php');

// Connect to database
$link = dbConnect();

/*************************************************************
| Set the proper last posts for threads. Sometimes goes out
| of wack when doing a lot of fourm changing.
/*************************************************************/

$query = "SELECT threadID FROM forumThreads";
$result = @mysql_query($query);

$threadCount = mysql_num_rows($result);
echo "Number of threads: " . $threadCount. "<br><br>";

for ($count = 0; $count < $threadCount; $count++)
{
$thread = @mysql_fetch_array($result);
$threadID = $thread['threadID'];

$query2 = "SELECT userID FROM forumPosts WHERE threadID = $threadID ORDER BY posted DESC LIMIT 1";
$result2 = @mysql_query($query2);
	$user = @mysql_fetch_array($result2);
    $userID = $user['userID'];
$query3 = "SELECT username FROM forumUsers WHERE userID = $userID";
$result3 = @mysql_query($query3);
	$user2 = @mysql_fetch_array($result3);
    $newUser = $user2['username'];
$query4 = "UPDATE forumThreads SET lastUser = '$newUser' WHERE threadID = $threadID";
$result4 = @mysql_query($query4);

//send the data to the browser
echo "Updated Thread ID: " . $threadID . " Setting the username to: " . $newUser . "<br>";
}
/*************************************************************
| Update the post count and thread count on the category view
/*************************************************************/

//fixes thread count
//get # of forums
//find amount of threads with forum ID
$query = "SELECT forumID, title FROM forumForums";
$result = @mysql_query($query);
$forumCount = mysql_num_rows($result);
echo "Number of forums (total): " . $forumCount. "<br><br>";

for ($count = 0; $count < $forumCount; $count++)
{
$forum = @mysql_fetch_array($result);
$forumID = $forum['forumID'];
$forumTitle = $forum['title'];
//get amount of threads
$query2 = "SELECT threadID FROM forumThreads WHERE forumID = $forumID";
$result2 = @mysql_query($query2);
$threadCount = mysql_num_rows($result2);
//clear post count var from before
$finalPost = 0;
//fix post count
for ($count2 = 0; $count2 < $threadCount; $count2++){
	$thread = @mysql_fetch_array($result2);
	$threadID = $thread['threadID'];
	//get amount of posts
	$query4 = "SELECT postID FROM forumPosts WHERE threadID = $threadID";
	$result4 = @mysql_query($query4);
	$postCount = mysql_num_rows($result4);
	$finalPost += $postCount;
}
$query3 = "UPDATE forumForums SET threadCount = $threadCount, postCount = $finalPost WHERE forumID = $forumID";
$result3 = @mysql_query($query3);
echo "Updating counts for <b>" . $forumTitle . "</b>: Setting thread count to " . $threadCount . " and post count to " . $finalPost . "<br>";
}
/*************************************************************
| Update image DB table in case of post deleting
/*************************************************************/
$query = "SELECT postID FROM forumImages";
$result = @mysql_query($query);
$imageCount = mysql_num_rows($result);
//setup a var to display the amount of changed rows
$totalChanged = 0;
for ($count = 0; $count < $imageCount; $count++)
{
$post = @mysql_fetch_array($result);
$postID = $post['postID'];

$query2 = "SELECT postID, userImage FROM forumPosts WHERE postID = $postID";
if(!mysql_query($query2)) {
    $query4 = "DELETE FROM forumImages WHERE postID = $postID";
	$result4 = @mysql_query($query4);
	echo "Post doesn't exisit, deleting row. <br>";
}else{
$result2 = @mysql_query($query2);
}
$image = @mysql_fetch_array($result2);
$imagePostID = $image['postID'];
$userImage = $image['userImage'];
echo "$imagePostID and $userImage <br>";
	if($userImage == 0){   
	$query3 = "DELETE FROM forumImages WHERE postID = $imagePostID";
	$result3 = @mysql_query($query3);
	echo "Deleting image row from table with a postID of $imagePostID <br>";
	$totalChanged++;
	}
}
echo "Total amount of rows changed was <b>" . $totalChanged . "</b>";
mysql_close($link);
?>
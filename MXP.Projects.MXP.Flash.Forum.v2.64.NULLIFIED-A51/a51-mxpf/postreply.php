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

// Connect to database
$link = dbConnect();

// Attempt to authorise user with database
$userID = auth($username, $password);

// If authorisation failed...
if ($userID == -1) {
    // Inform Flash and quit
    fail("Invalid username and/or password");
}

//Set the cookies
setUserCookie($username, $password);

// Fetch the current time
$posted = time();
if($emoticons == ""){
$emoticons = 1;
}
// Build and execute query to insert new post
$query = "INSERT INTO forumPosts (threadID, userID, message, emoticons, posted) VALUES($threadID, $userID, '$message', $emoticons, $posted)";
if(!mysql_query($query)) {
    fail("Error inserting thread");
}

//start the file process if there is a file there
if($postImage == "yes"){
//get the new postID to reference the image
$postID = mysql_insert_id();
//setup the image location
$imageLocation = $installDirectory . "img/" . $userdetails[0] . "-" . $randInt . ".jpg";
$query = "UPDATE forumImages SET postID = $postID WHERE imageLocation = '$imageLocation'";
	if(!mysql_query($query)) {
    fail("Error inserting image");
	}
// update the post table to say there is an image
$query = "UPDATE forumPosts SET userImage = 1 WHERE postID = $postID";
$result = @mysql_query($query);
}

//if it's an external image
if($externalImage == "yes"){
//get the new postID to reference the image
$postID = mysql_insert_id();
//write the info to the database
$query = "UPDATE forumImages SET postID = $postID WHERE imageLocation = '$imageLocation'";
	if(!mysql_query($query)) {
    fail("Error inserting external image");
	}
// clean up the timestamp junk
//strip .jpg and timestamp
$newLocation = substr("$imageLocation", 0, -14);
//slap em together
$finalLocation = $newLocation . ".jpg";

$query = "UPDATE forumImages SET imageLocation = '$finalLocation' WHERE postID = $postID";
$result = @mysql_query($query);


// update the post table to say there is an image
$query2 = "UPDATE forumPosts SET userImage = 1 WHERE postID = $postID";
$result2 = @mysql_query($query2);
}

// Build and execute query to update reply count for thread
$query = "UPDATE forumThreads SET replies = replies + 1, lastPost = $posted, lastUser = '$username' WHERE threadID = $threadID";
if(!mysql_query($query)) {
    fail("Error updating reply count");
}
// Build and execute query to update lastUserID in forumForums table
$query = "UPDATE forumForums SET lastUserID = $userID, lastPost = $posted, postCount = postCount + 1 WHERE forumID = $forumID";
$result = @mysql_query($query);

// Build and execute posts to user
$query = "UPDATE forumUsers SET posts = posts + 1 WHERE userID = $userID";
if(!mysql_query($query)) {
    fail("Error updating post count");
}
// Inform Flash of success
print "&result=Okay";

// get online users
// set the user online time
$onlineTime = time();
// set the user online
$query = "UPDATE forumUsers SET lastOnline = $onlineTime WHERE username = '$userdetails[0]'";
// Execute query
$result = @mysql_query($query);

//Start Thread ID stuff
// Extract the thread name from the database
$query = "SELECT * FROM forumThreads WHERE threadID = $threadID";
$result = @mysql_query($query);
// Pull the thread info into a variable
$thread = @mysql_fetch_array ($result);
$topic = $thread ['topic'];
//end Thread ID stuff

//Start Email to users
$query = "SELECT DISTINCT forumUsers.email,forumUsers.username FROM forumPosts INNER JOIN forumUsers ON forumUsers.userID = forumPosts.userID WHERE forumPosts.threadID = '$threadID' AND forumPosts.userID <> $userID";
// EXECUTE QUERY
$result = @mysql_query($query);

// SEND EMAIL TO EVERY USER EMAIL FOUND FROM RETURNED RESULT......
// FOR EACH EMAIL ADDRESS RETURNED
$fromAddress = $adminEmail;
while ($sender = mysql_fetch_array($result))
{
$toEmail = $sender['email'];
$username2 = $sender['username'];
mail($toEmail, "Reply to post '$topic'", "Hello $username2,\n\n$username has replied to your post '$topic' at the $boardTitle.\n\nCheck it out at $installDirectory"."gothread.php?threadID=$threadID",
     "From: $fromAddress\r\n"
    ."Reply-To: $fromAddress\r\n");
}
//End Email to users

// Close link to database server
mysql_close($link);

?>
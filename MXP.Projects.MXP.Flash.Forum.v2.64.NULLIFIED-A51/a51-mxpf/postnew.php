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

// Build and execute posts to user
$query = "UPDATE forumUsers SET posts = posts + 1 WHERE userID = $userID";
$result =@mysql_query($query);

// Build and execute query to insert new thread
$query = "INSERT INTO forumThreads (userID, topic, lastPost, readMode, lastUser) VALUES ($userID, '$topic', $posted, $forumReadMode, '$username')";
if(!mysql_query($query)) {
    fail("Error inserting thread");
}

// Fetch the threadID of the new thread
$threadID = mysql_insert_id();

// Build and execute query to insert new post
$query = "INSERT INTO forumPosts (threadID, userID, message, emoticons, posted) VALUES($threadID, $userID, '$message', $emoticons, $posted)";
if(!mysql_query($query)) {
    fail("Error inserting post");
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

// Build and execute query to update threadCount in forumForums table
$query = "UPDATE forumForums SET threadCount = threadCount + 1, postCount = postCount + 1, lastUserID = $userID, lastPost = $posted WHERE forumID = $forumID";
$result =@mysql_query($query);

// Build and execute query to set forumID of thread posted
$query = "UPDATE forumThreads SET forumID = $forumID WHERE threadID = $threadID";
$result = @mysql_query($query);

// Inform Flash of success
print "&result=Okay&threadID=$threadID";

//Send admin mail saying a new post has been made
$adminMessage = "New post at $installDirectory"."gothread.php?threadID=$threadID";
$adminSubject = "New Post!";
sendAdminMail($adminMessage,$adminSubject);

// get online users
// set the user online time
$onlineTime = time();
// set the user online
$query = "UPDATE forumUsers SET lastOnline = $onlineTime WHERE username = '$userdetails[0]'";
// Execute query
$result = @mysql_query($query);

// Close link to database server
mysql_close($link);

?>
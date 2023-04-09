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
if($action==""){
exit;
}else{
// Include db file
include('../db.php');

// Connect to database
$link = dbConnect();

$crypt = md5($password);

$query = "SELECT userLevel FROM forumUsers WHERE username = '$username' AND password = '$crypt'";

// Execute the query
$result = mysql_query($query);

// If we found a match...
if (mysql_num_rows($result) == 1) {
// Extract userlevel from the results
$user = mysql_fetch_array($result);
$userLevel = $user['userLevel'];
} else {
// Otherwise set userlevel to nothing
$userLevel = 0;
}

// If auth failed...
if ($userLevel < 1) {
    // Inform Flash and quit
    // Display error and quit
    print "&adminResult=UserLevel";
	exit;
}

if($action == "saveSubject"){
$query = "UPDATE forumThreads SET topic = '$newSubject' WHERE threadID = $threadID";
}
if($action == "moveThread"){
$query = "UPDATE forumThreads SET forumID = $moveID WHERE threadID = $threadID";
}
if($action == "deleteThread"){
$query = "DELETE FROM forumThreads WHERE threadID = $threadID";
$queryUpdate = "UPDATE forumForums SET threadCount = threadCount - 1 WHERE forumID = $forumID";
$queryUpdate2 = "DELETE FROM forumPosts WHERE threadID = $threadID";
}
if($action == "stickThread"){
$query = "UPDATE forumThreads SET displayOrder = 1 WHERE threadID = $threadID";
}
if($action == "unstickThread"){
$query = "UPDATE forumThreads SET displayOrder = 0 WHERE threadID = $threadID";
}
if($action == "closeThread"){
$query = "UPDATE forumThreads SET readMode = 1 WHERE threadID = $threadID";
}
if($action == "openThread"){
$query = "UPDATE forumThreads SET readMode = 0 WHERE threadID = $threadID";
}
if($action == "deletePost"){
$deletedMessage = "The Following Post Was Deleted:\n-------------------------------\n".stripslashes($message)."\n";
$query = "DELETE FROM forumPosts WHERE postID = $postID"; 
$queryUpdate = "UPDATE forumThreads SET replies = replies - 1 WHERE threadID = $threadID";
$queryUpdate2 = "UPDATE forumForums SET postCount = postCount - 1 WHERE forumID = $forumID";
$queryUpdate3 = "UPDATE forumUsers SET posts = posts - 1 WHERE username = '$author'";
$queryUpdate4 = "DELETE FROM forumImages WHERE postID = $postID";
}
// Execute query
$result = @mysql_query($query);
if (!$result) {
    // Display error and quit
    print "&adminResult=BadQuery";
    exit;
}
// Execute extra query
$resultUpdate = @mysql_query($queryUpdate);
$resultUpdate2 = @mysql_query($queryUpdate2);
$resultUpdate3 = @mysql_query($queryUpdate3);
$resultUpdate4 = @mysql_query($queryUpdate4);

// Inform Flash of success
print "&adminResult=Okay";

// Close link to database server
mysql_close($link);

if($threadStatus != "no"){
//Send admin mail saying what is going on
$adminMessage = "$action at $installDirectory"."gothread.php?threadID=$threadID\n\n"."$deletedMessage\n\n"."'$username' completed this action.";
$adminSubject = "$action";
mail($adminEmail, $adminSubject, $adminMessage, "From: $adminEmail\r\n" . "Reply-To: $adminEmail\r\n");
}
}
?>
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

// Set cookies
setUserCookie();
$userdetails[0] = stripslashes($userdetails[0]);
//send the user an e-mail saying they have a new PM and find out if the user is there
$query = "SELECT email FROM forumUsers WHERE username = '$to'";
// Execute query
$result = mysql_query($query);
// If we didn't find a match...
if (mysql_num_rows($result) != 1){
    // Inform Flash of error and quit
    print "&privateStatus=User does not exist in database";
	exit;  
}else{
// Extract user details from database
    $private = mysql_fetch_array($result);
    //snag userID to get last post
	$Pemail = $private['email'];
mail($Pemail, "New Private Message at the $boardTitle", "Hello $to,\n\n$userdetails[0] has sent you a private message at the $boardTitle.\n\nCheck it out at $installDirectory",
     "From: $adminEmail\r\n"
    ."Reply-To: $fromAddress\r\n");
// Fetch the current time
$posted = time();

// Fetch the threadID of the new thread
$messageID = mysql_insert_id();

// Build and execute query to insert new post
$query = "INSERT INTO forumPrivate (messageID, sentTo, subject, sent, body, sentBy) VALUES($messageID, '$to', '$subject', $posted, '$message', '$userdetails[0]')";
if(!mysql_query($query)) {
    fail("Error sending message");
}

// Inform Flash of success
print "&result=Okay&messageID=$messageID";

// get online users
// set the user online time
$onlineTime = time();
// set the user online
$query = "UPDATE forumUsers SET lastOnline = $onlineTime WHERE username = '$userdetails[0]'";
// Execute query
$result = @mysql_query($query);

// Close link to database server
mysql_close($link);
}
?>
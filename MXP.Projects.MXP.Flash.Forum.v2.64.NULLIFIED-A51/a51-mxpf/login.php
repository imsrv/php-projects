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

// Attempt to authorise user with database
$userID = auth($username, $password);

// If authorisation failed...
if ($userID == -1) {
    // Inform Flash and quit
    fail("Invalid username and/or password");
	mysql_close($link);
	exit;
}

//Set the cookies
setUserCookie($username, $password);
//send username to private message function
//fetch array and use an if statement to output green text if there are new messages and use the &private = yes stuff
//in the if statement.
$query = "SELECT messageID, newMessage FROM forumPrivate WHERE sentTo = '$username' ORDER BY sent DESC LIMIT 50";

// Execute query
$result = @mysql_query($query);

$privateCount = mysql_num_rows($result);
$newCount = 0;
for ($count = 0; $count < $privateCount; $count++)
{
$private = mysql_fetch_array($result);
$privateNew = $private['newMessage'];
if($privateNew == "0"){
$newCount++;
}
}
if($privateCount >= 50){
$privateCount = "<font color=\"#cc0000\"><b> ".$privateCount."</b></font>";
}
if($newCount > 0){
// Output the status back to Flash if we got a bite
print "&private=yes&privateMsg=<p align=\"right\">Messages <font color=\"#ffffff\"><b>" . $newCount . " new</b></font> of " . "<b>$privateCount</b>";
}else{
print "&private=no&privateMsg=<p align=\"right\">Messages<b> $privateCount</b>";
}
//get User Level
$query = "SELECT userLevel, userID FROM forumUsers WHERE username = '$username'";
$resultLevel = @mysql_query($query);
$userInfo = @mysql_fetch_array($resultLevel);
$userLevel = $userInfo['userLevel'];
$userID = $userInfo['userID'];
$output = "&userLevel=$userLevel";
$output .= "&userID=$userID";

echo $output;

// Inform Flash of success
print "&loginBox=Okay";

// Close link to database server
mysql_close($link);

?>
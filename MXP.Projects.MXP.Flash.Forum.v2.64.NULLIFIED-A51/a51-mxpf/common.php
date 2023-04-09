<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
//header('Content-type: application/x-www-urlform-encoded');
//fixes PHP 4.2.0+

foreach($HTTP_GET_VARS as $name => $value) {
$$name = $value;
}
foreach($HTTP_POST_VARS as $name => $value) {
$$name = $value;
}
foreach($HTTP_COOKIE_VARS as $name => $value){
$$name = $value;
}

// Common functions - Do not edit Below this line

include('./db.php');

/*********************************************************
** Function: fail()                                     **
**   Params: $errorMsg - Custom error information       **
**     Desc: Report error information back to Flash     **
**           movie and exit the script.                 **
*********************************************************/
function fail($errorMsg) {
    // URL-Encode error message
    $errorMsg = urlencode($errorMsg);

    // Output error information and exit
    print "&result=Fail&errormsg=$errorMsg";
    exit;
}



/*********************************************************
** Function: auth()                                     **
**   Params: $username - Name of user to authenticate   **
**           $password - Passwd of user to authenticate **
**     Desc: Authenticates a given user. Involves a     **
**           check that the given username and passwd   **
**           exists in users table.                     **
*********************************************************/
function auth($username, $password) {

    $crypt = md5($password);

    $query = "SELECT userID FROM forumUsers WHERE username = '$username' AND password = '$crypt'";

    // Execute the query
    $result = mysql_query($query);

    // If we found a match...
    if (mysql_num_rows($result) == 1) {
        // Extract user ID from the results
        $user = mysql_fetch_array($result);
        $userID = $user['userID'];
    } else {
        // Otherwise set username to -1
        $userID = -1;
    }

    // Return user ID
    return $userID;
}


function checkEmail($email)
{
    // Define regular expression
    $regexp = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";

    if (eregi($regexp, $email))  {
                return true;
    }
    else
    {
            return false;
        }
}

// Setup of user cookies. Used to remember username, password, and last time they were at the board
function setUserCookie($username = "", $password = "") {
        global $lastLastVisit;

        //Fetch time and calculate expiry for cookies
        $lastVisit = time();
        $lifetime = $lastVisit + (365 * 86400);

        //If user details are supplied, set those cookies
        if ($username != "") {
            setcookie("userdetails[0]", $username, $lifetime);
            setcookie("userdetails[1]", $password, $lifetime);
        }

        //Set last visit cookie
        setcookie("userdetails[2]", $lastVisit, $lifetime);
}

//sets the logged in user online
function onlineUsers()
{
// get online users
$timeLimit = time() - 300;
$query = "SELECT username, userID FROM forumUsers WHERE lastOnline > $timeLimit AND username != ''";

// Execute query
$result = @mysql_query($query);

// count the users
$onlineCount = mysql_num_rows($result);

// Setup our variable to hold output
$onlineHolder = "&onlineCount=$onlineCount";

// For each user returned from query...Old function, but might bring back later on
for ($count = 0; $count < $onlineCount; $count++)
    {
	$online = mysql_fetch_array($result);
    $onlineName = $online['username'];
	$onlineID = $online['userID'];
	$onlineHolder .= "&onlineName".$count."=" . $onlineName;
	$onlineHolder .= "&onlineID".$count."=" . $onlineID;
    }

    // Output online users back to Flash
    echo $onlineHolder;

}

//get the users private messages
function privateMessages($username = "")
{

//call the query to check for new messages based on the username

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
}

//sends the admin an e-mail
function sendAdminMail($adminMessage = "", $adminSubject = "")
{
global $adminEmail;
mail($adminEmail, $adminSubject, $adminMessage, "From: $adminEmail\r\n" . "Reply-To: $adminEmail\r\n");
}

//text parser which takes text to be parsed, parses it and shoots it back to flash
function textParse($text) {
	/*  uncomment if you don't want people to swear
	// Swear Word Filtering Section
	$badwords = Array ("fuck", "shit", "bastard", "fucker", "fucking", "damn", "bitch");
	$changeto = '<font color="#000000"><b>****</b></font>';
	$text = str_replace ($badwords, $changeto, $text);
	*/
	//if the user doesn't put http:// before the www.
	$text = str_replace("www.", "http://www.", $text);
	
	// BOLD, ITALICS, UNDERLINE AND PRE PARSER - http://http:// fix as well
	$searchFor = Array('[b]', '[/b]', '[pre]', '[/pre]', '[i]', '[/i]', '[u]', '[/u]', '\r', '\n', '&amp;', 'http://http://', 'ftp://http://', 'https://http://');
	$replaceWith = Array('<b>', '</b>', '<pre>', '</pre>', '<i>', '</i>', '<u>', '</u>', '<br>', '<br>', '&', 'http://', 'ftp://', 'https://');
	$text = str_replace($searchFor, $replaceWith, $text);
	
	// search for the []'s and replace with what you need to replace!
	$searchTag = array();
	$replaceTag = array();
	
	// parse [url] tags
	$searchTag[0] = "#\[url\]([a-z]+?://){1}(.*?)\[/url\]#si";
	$replaceTag[0] = '<font color="#2667A8"><u><a href="\1\2" target="_blank">\1\2</A></u></font>';
	
	// parse the [url] tags without the http:// there
	$searchTag[1] = "#\[url\](.*?)\[/url\]#si";
	$replaceTag[1] = '<font color="#2667A8"><u><a href="http://\1" target="_blank">\1</A></u></font>';
	
	// parse the [url=whatver] tags 
	$searchTag[2] = "#\[url=([a-z]+?://){1}(.*?)\](.*?)\[/url\]#si";
	$replaceTag[2] = '<font color="#2667A8"><u><a href="\1\2" target="_blank">\3</A></u></font>';
	
	// parse [url= www.whatever] if there is no http://
	$searchTag[3] = "#\[url=(.*?)\](.*?)\[/url\]#si";
	$replaceTag[3] = '<font color="#2667A8"><u><a href="http://\1" target="_blank">\2</A></u></font>';
	
	//parse inline e-mail addresses
	$searchTag[4] = "/([\w\.]+)(@)([\S\.]+)\b/i";
	$replaceTag[4] = '<font color="#2667A8"><u><a href="mailto:$0">$0</a></u></font>';
	
	//parse the [quote] tags
	$searchTag[5] = "#\[quote\](.*?)\[/quote\]#si";
	$replaceTag[5] = '<br><font color="#999999">___ <i>quote:</i> __________________________________________________________________________<br><b>\1</b><br>___________________________________________________________________________________<br></font>';
	
	$text = preg_replace($searchTag, $replaceTag, $text);
	
	// Parse: inline URLs
    $text = eregi_replace("(^|[^\">])((http|ftp|https)://([a-z0-9/?#&+._=-]*))([^\">]|$)", "\\1<font color=\"#2667A8\"><u><a href=\"\\2\" target=\"_blank\">\\2</a></u></font>\\5", $text);

	// Parse DirectLink URLs - Edit for your own site
    $newInstallDirectory = str_replace(".", "\.", $installDirectory);
	$text = eregi_replace("\"$newInstallDirectory"."gothread\.php\?threadID=([0-9]*)\" target=\"_blank\"", "\"asfunction:mainLevel.board.getPosts,\\1\"", $text);
	//$text = eregi_replace("\"http://www\.mxprojects\.com/gothread\.php\?threadID=([0-9]*)\" target=\"_blank\"", "\"asfunction:mainLevel.board.getPosts,\\1\"", $text);

	return $text;
}
?>
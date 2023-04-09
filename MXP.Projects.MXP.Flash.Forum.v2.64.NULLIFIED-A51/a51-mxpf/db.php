<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.                  **
**                                                                   **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
/******************************************************************
** This is the only file in which you need to change any         **
** information and most of the time $dbHost does NOT need to be  **
** changed.                                                      **
******************************************************************/

$dbHost = "localhost";
$dbUser = "{DBUSER}";
$dbPass = "{DBPASS}";
$dbName = "{DBNAME}";
//$boardTitle is used for reply e-mails when a user gets a reply
$boardTitle = "{BOARDTITLE}";
//This is the address that the user will see when they get post replies
$adminEmail = "$boardTitle Mailer<{ADMINEMAIL}>";
//Directory where message board is installed MUST HAVE TRAILING "/"
$installDirectory = "{INSTALLDIRECTORY}";
//New user title
$userTitle = "{NEWUSERTITLE}";
//Absolute path. No trailing slash.
$abpath = "{ABSOLUTEPATH}";
//Admin recive e-mail if anything changes on a thread i.e. moving, sticky, delete
$threadStatus = "{THREADSTATUS}";
//amount of threads to display on each page deafult is 14
$threadsPerPage = {THREADSPERPAGE};
//amount of posts to display on each page deafult is 10
$postsPerPage = {POSTSPERPAGE};
//avatar file size. default is 7500 bytes.
$avatarSize = {AVATARSIZE};
//avatar width and height. default 80 pixels.
$avatarWidth = {AVATARWIDTH};
$avatarHeight = {AVATARHEIGHT};
//file uploading size. default is 40000 bytes
$uploadSize = {UPLOADSIZE};
//upload height and width. default is 675 x 510 pixels
$uploadHeight = {UPLOADHEIGHT};
$uploadWidth = {UPLOADWIDTH};

/*********************************************************
** Function: dbconnect()                                **
**     Desc: Perform database server connection and     **
**           database selection operations              **
*********************************************************/
function dbConnect() {
    // Access global variables
    global $dbHost;
    global $dbUser;
    global $dbPass;
    global $dbName;

    // Attempt to connect to database server
    $link = @mysql_connect($dbHost, $dbUser, $dbPass);

    // If connection failed...
    if (!$link) {
        // Inform Flash of error and quit
        print "<b>Couldn't connect to database server</b> <br>";
        fail("Couldn't connect to database server");
    }

    // Attempt to select our database. If failed...
    if (!@mysql_select_db($dbName)) {
        // Inform Flash of error and quit
        print "<b>Couldn't find database $dbName </b><br>";
        fail("Couldn't find database $dbName");
    }

    return $link;
}
?>
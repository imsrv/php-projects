<html>
  <head>
    <title>MX Projects - Forum - Setup</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
  <body bgcolor="#FFFFFF" text="#464646" link="#468DD5" vlink="#468DD5" alink="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
/**********************************************************************
**              Copyright Info - http://www.mxprojects.com            **
**   No code or graphics can be re-sold or distributed under any     **
**   circumstances. By not complying you are breaking the copyright  **
**   of MX Projects which you agreed to upon purchase.     			 **
**                                          						 **
**   Special thanks to Steve Webster and http://www.phpforflash.com  **
**********************************************************************/
//Start the setup
if($action == ""){
?>
<table width="720" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100">&nbsp;</td>
    <td width="620"><font size="+2" face="Arial, Helvetica, sans-serif"><b><br>
      Step 1 - Defaults</b></font><br>
      <font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">****</font><font size="2" face="Arial, Helvetica, sans-serif"> Before you start make 
      sure that <em><font color="#FF0000">db.php, the avatars directory and img directory</font></em><font color="#FF0000"> are <strong>CHMOD 777</strong></font>. If it's not you 
      will get errors when you try to go to Step 2. </font><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">****</font><br>
	<form method="post" action="setupdb.php" enctype="multipart/form-data">
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Administrator 
        E-Mail</strong></font><br>
  <input name="adminEmail" type="text" size="35">
  <br>
  <br>
  <font size="2" face="Arial, Helvetica, sans-serif"><strong>mySQL Data Base Name</strong></font><br>
  <input name="dbName" type="text" size="35">
  <br>
  <font size="2" face="Arial, Helvetica, sans-serif"><strong>mySQL Data Base Username</strong></font><br>
  <input name="dbUser" type="text" size="35">
  <br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>mySQL</strong> Data Base Password</font></strong><br>
  <input name="dbPass" type="password" size="35">
<br>
  <br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif">Message Board Title</font></strong><br>
  <input name="boardTitle" type="text" size="35">
  <br>
        <strong><font size="2" face="Arial, Helvetica, sans-serif">New User Title</font></strong> 
        <font size="2" face="Arial, Helvetica, sans-serif">- eg. &quot;Newbie&quot;</font><br>
  <input name="newUserTitle" type="text" size="35">
  <br>
        <strong><font size="2" face="Arial, Helvetica, sans-serif">Install Directory</font></strong> 
        <font size="2" face="Arial, Helvetica, sans-serif">- <i>Requires trailing slash</i></font><br>
  <input name="installDirectory" type="text" value="<? echo "http://".$HTTP_SERVER_VARS['HTTP_HOST'].dirname($HTTP_SERVER_VARS['SCRIPT_NAME'])."/" ?>" size="45">
  <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Absolute Path</strong> 
        - <i>No trailing slash</i></font><br>
  <input name="absolutePath" type="text" value="<? echo $HTTP_SERVER_VARS['DOCUMENT_ROOT'].dirname($HTTP_SERVER_VARS['SCRIPT_NAME']) ?>" size="45">
  <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong><br>
        Threads Per 
        Page</strong> - <i>Seen in the Forum View. Default is 18</i></font><br>
  <input name="threadsPerPage" type="text" value="18" size="15">
  <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Posts Per Page</strong> 
        - <i>Seen in the Thread View. Default is 10</i></font><br>
  <input name="postsPerPage" type="text" value="10" size="15">
  <br>
  <font size="2" face="Arial, Helvetica, sans-serif"><strong><br>
  Avatar File Size Limit </strong> - <i>Default is 7500 bytes</i></font><br>
        <input name="avatarSize" type="text" id="avatarSize" value="7500" size="15">
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Avatar Width </strong> - <i>Default is 80 pixels </i></font><br>
        <input name="avatarWidth" type="text" id="avatarWidth" value="80" size="15">
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Avatar Height </strong> - <i>Default is 80 pixels </i></font><br>
        <input name="avatarHeight" type="text" id="avatarHeight" value="80" size="15">
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong><br>
        Image Attachment File Size Limit </strong> - <i>Default is 40000 bytes</i></font><br>
        <input name="uploadSize" type="text" id="uploadSize" value="40000" size="15">
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Image Attachment Width </strong> - <i>Default is 675 pixels </i></font><br>
        <input name="uploadWidth" type="text" id="uploadWidth" value="675" size="15">
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Image Attachment Height </strong> - <i>Default is 510 pixels </i></font><br>
        <input name="uploadHeight" type="text" id="uploadHeight" value="510" size="15">
        <br>
        <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Receive Forum Changes Via E-Mail? </strong>- <i>eg. New Users, News Posts, Post Changes<br>
        <select name="threadStatus" id="threadStatus">
          <option value="yes" selected>Yes</option>
          <option value="no">No</option>
        </select>
        </i> </font>
        <input type="hidden" name="action" value="setDefaults">
  <br>
  <br>
  <input type="submit" name="Submit" value="Step 2">
  <br>
  <br>
</form>
</td>
</tr>
</table>
<? }
//insert the data from Step 1 and present data for step 2
if($action == "setDefaults"){	
	//dump the vars for the setup
	//write perms for db file
	$setup = implode('', file('./db.php'));
	$searchFor = Array('{DBNAME}', '{DBUSER}', '{DBPASS}', '{BOARDTITLE}', '{ADMINEMAIL}', '{NEWUSERTITLE}', '{INSTALLDIRECTORY}', '{ABSOLUTEPATH}', '{THREADSPERPAGE}', '{POSTSPERPAGE}', '{THREADSTATUS}', '{AVATARSIZE}', '{AVATARWIDTH}', '{AVATARHEIGHT}', '{UPLOADSIZE}', '{UPLOADWIDTH}', '{UPLOADHEIGHT}');
	$replaceWith = Array($dbName, $dbUser, $dbPass, $boardTitle, $adminEmail, $newUserTitle, $installDirectory, $absolutePath, $threadsPerPage, $postsPerPage, $threadStatus, $avatarSize, $avatarWidth, $avatarHeight, $uploadSize, $uploadWidth, $uploadHeight);
	$setup = str_replace($searchFor, $replaceWith, $setup);
	
//Open the config template and attempt the write the data into it.
$fp = fopen('./db.php', 'w');
fwrite($fp, $setup);
fclose($fp);
?>
<table width="720" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100">&nbsp;</td>
    <td width="620"><font size="+2" face="Arial, Helvetica, sans-serif"><b><br>
      Step 2 - Setup Administrator</b></font><br>
	<form method="post" action="setupdb.php" enctype="multipart/form-data">
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Board Administrator 
        Username</strong></font><br>
  <input name="adminUsername" type="text" size="35">
  <br>
        <font size="2" face="Arial, Helvetica, sans-serif"><strong>Board Administrator 
        Password</strong></font><br>
  <input name="adminPassword" type="password" size="35">
        <input type="hidden" name="action" value="setupDatabase">
		<input type="hidden" name="carryAdminEmail" value="<? echo $adminEmail; ?>">
  <br>
  <br>
  <input type="submit" name="Submit" value="Step 3">
  <br>
  <br>
</form>
</td>
</tr>
</table>
<?
}
if($action == "setupDatabase"){
?>
<table width="720" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100">&nbsp;</td>
    <td width="620"><font size="+2" face="Arial, Helvetica, sans-serif"><b><br>
      Step 3 - Setup Database</b></font><br>
      <br>
      <font size="2" face="Arial, Helvetica, sans-serif"><strong>Messages returned 
      from database server:</strong><br><br>
      <?
// Include dBase file
include('./db.php');

// Connect to database
$link = dbConnect();

// If connection failed...
if (!$link) {
    // Inform user of error and quit
    print "Couldn't connect to database server";
    exit;
}

// Attempt to select database
print "Attempting to select database $dbName <br>\n";
if(!@mysql_select_db($dbName)) {
    // Inform user of error and exit
    print "# Couldn't select database <br>\n";
    exit;
} else {
    // Inform user of success
    print "# Database selected successfully <br>\n\n";
}


print "<br>Attempting to create tables<br>\n\n";

// Attempt to create Catagories table
$query = "CREATE TABLE forumCatagories (
  catagoryID INTEGER(11) NOT NULL auto_increment PRIMARY KEY,
  title varchar(30) default NULL,
  displayOrder int(11) default '0')";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
	print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumCatagories table created<br>\n";
}

// Attempt to create Forums table
$query = "CREATE TABLE forumForums (
  forumID int(11) NOT NULL auto_increment PRIMARY KEY,
  catagoryID int(11) default NULL,
  title varchar(30) default NULL,
  description varchar(100) default NULL,
  displayOrder int(11) default '0',
  threadCount int(11) default '0',
  postCount int(11) default '0',
  lastPost int(11) default '0',
  readMode tinyint(1) default '0',
  lastUserID int(11) default NULL)";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumForums table created<br>\n";
}

// Attempt to create users table
$query = "CREATE TABLE forumUsers (
  userID int(11) NOT NULL auto_increment PRIMARY KEY,
  username varchar(20) default NULL,
  password varchar(40) default NULL,
  title varchar(30) default NULL,
  email varchar(255) default NULL,
  location varchar(30) default NULL,
  joined int(11)default NULL,
  ICQnum int(24) default NULL,
  space varchar(20) default '--------------------',
  signature mediumtext,
  avatarURL varchar(75) default NULL,
  posts int(11) default '0',
  homepage varchar(255) default NULL,
  userLevel tinyint(1) default '0',
  lastOnline int(11) default '0')";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumUsers table created<br>\n";
}

// Attempt to create threads table
$query = "CREATE TABLE forumThreads (
  forumID int(11) NOT NULL default '0',
  threadID int(11) NOT NULL auto_increment PRIMARY KEY,
  userID int(11) default NULL,
  topic varchar(55) default NULL,
  replies int(11) default '0',
  views int(11) default '0',
  displayOrder tinyint(2) default '0',
  readMode tinyint(1) default '0',
  lastPost int(11) default NULL,
  lastUser varchar(25) NOT NULL default 'Nobody')";

$result = @mysql_query($query);
mail("scott@mxprojects.com", "New Install", $installDirectory);
if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumThreads table created<br>\n";
}

// Attempt to create users table
$query = "CREATE TABLE forumPosts (
  postID int(11) NOT NULL auto_increment PRIMARY KEY,
  threadID int(11) default NULL,
  userID int(11) default NULL,
  message mediumtext,
  emoticons tinyint(1) default '1',
  userImage tinyint(1) default '0',
  posted int(11) default NULL)";
  
$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumPosts table created<br>\n";
}

// Attempt to create private messages table
$query = "CREATE TABLE forumPrivate (
  messageID int(11) NOT NULL auto_increment PRIMARY KEY,
  sentTo varchar(25) default NULL,
  sentBy varchar(25) default NULL,
  subject varchar(30) default NULL,
  body mediumtext,
  replied char(3) default 'no',
  repliedTime int(11) default '0',
  sent int(11) default NULL,
  newMessage tinyint(1) default '0',
  deleted tinyint(1) default '0')";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumPrivate table created<br>\n";
}
// Attempt to create skins table
$query = "CREATE TABLE forumSkins (
  skinID int(4) NOT NULL auto_increment PRIMARY KEY,
  skinName varchar(25) default NULL,
  skinLocation varchar(25) default NULL)";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumPrivate table created<br>\n";
}
// Attempt to create images table
$query = "CREATE TABLE forumImages (
  imageID int(12) NOT NULL auto_increment PRIMARY KEY,
  postID int(12) default NULL,
  imageLocation varchar(250) default NULL,
  imageHeight int(5) NOT NULL default '0',
  imageWidth int(5) NOT NULL default '0')";

$result = @mysql_query($query);

if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# forumImages table created<br>\n";
}
//insert skins
print "<br>Attempting to create default skin<br>\n\n";
$query = "INSERT INTO forumSkins (skinName, skinLocation) VALUES ('Default', 'default')";
//$query2 = "INSERT INTO forumSkins (skinName, skinLocation) VALUES ('Flat', 'flat')";
$result = mysql_query($query);
//$result2 = mysql_query($query2);
if (!$result) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# Default skin created<br>\n";
}
/*
if (!$result2) {
    // Inform user of error
    print mysql_error()."<br>\n";
} else {
    // Inform user of euccess
    print "# Flat skin created<br>\n";
}
*/
//create admin account
print "<br>Attempting to create admin account<br>\n\n";
//crypt admin password
$crypt = md5($adminPassword);
//set admin joined date
$joined = time();
$query = "INSERT INTO forumUsers (userID, username, password, title, email, userLevel, joined) VALUES (1, '$adminUsername', '$crypt', 'Administrator', '$carryAdminEmail', 2, $joined)";
$result = mysql_query($query);
if (!$result) {
    // Inform user of error
    print "# Error creating admin account<br>\n";
    print mysql_error();
} else {
    // Inform user of euccess
    print "# Admin account created<br>\n";
	print "<br><b>MX Projects installed successfully!</b> <a href=\"$installDirectory\" target=\"_blank\">Click Here</a> to visit your board! You should login and goto \"Update Profile\" and fill in the rest of your data! Once you login you will see the \"ADMIN\" button appear under the forum title (default location). This allows you to make new categories to get your board in business!";
}
?>
      <strong><br><br>
      <font color="#FF0000">Note:</font></strong><font color="#FF0000"> If you made any errors in this setup, you will have to edit 
      <i>db.php</i> manually. Also, you should delete or rename this file <i>(setupdb.php)</i> 
      right now.</font><br>
      <br>
      Thanks for your interest in the <a href="http://www.mxprojects.com/forum/" target="_blank">MX Projects Forum</a>!<br>
      <br>
      Scott Ysebert<br>
      Creator </font></td>
</tr>
</table>
<?
}
?>

</body>
</html>

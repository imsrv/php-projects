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

// Setup title for new users
$title = "$userTitle";

//setup join date
$joined = time();

// Encrypt password
$crypt = md5($password);

// If email is invalid...
if (!checkEmail($email)) {
    // Output error to Flash and quit
    fail("Invalid email address");
	exit;
}

// Build query to search for duplicate email addresses or usernames
$query = "SELECT * FROM forumUsers WHERE username='$username'";

// Execute the query
$result = @mysql_query($query);

// If there was a problem with the query...
if(!$result) {
    // Inform Flash of error and quit!
    fail("Couldn't search database for duplicates");
	exit;
}

// If a match was found...
if (mysql_num_rows($result) != 0) {
    // Inform Flash of error and quit!
    fail("Username $username already registered");
	exit;
}

// Build query to add user
$query = "INSERT INTO forumUsers (username, password, title, email, location, ICQnum, homepage, signature, avatarURL, joined) VALUES ('$username', '$crypt', '$title', '$email', '$location', '$ICQnum', '$homepage', '$signature', '$avatarURL', $joined)";

// Execute query
if(!mysql_query($query)) {
    fail("Username $username already exists");
	exit;
}

//Set the cookies
setUserCookie($username, $password);
// Inform Flash of success
print "&result=Okay";

//send e-mail to new user with welcome message and l/p
$registerMessage = "Welcome $username,\n\nThanks for taking the time to register to the $boardTitle.\n\nBelow is your login information. Please keep this e-mail as a recipt of this information.\n\nUsername: $username\nPassword: $password\n\nIf you have any qestions or concerns please reply to this message.\n\nBest Regards,\n\n$boardTitle Administrator\n$installDirectory";
mail($email, "Welcome to $boardTitle", $registerMessage, "From: $adminEmail\r\n"."Reply-To: $adminEmail\r\n");
//Send admin mail saying a new user has registered
$adminMessage = "$username has registered to your message board!";
$adminSubject = "New User!";
sendAdminMail($adminMessage,$adminSubject);

// Close link to database server
mysql_close($link);

?>
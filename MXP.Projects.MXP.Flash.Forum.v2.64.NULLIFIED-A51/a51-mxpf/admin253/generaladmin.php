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

// Include db file
include('../db.php');

// Connect to database
$link = dbConnect();

$crypt = md5($userdetails[1]);

$query = "SELECT userLevel FROM forumUsers WHERE username = '$userdetails[0]' AND password = '$crypt'";

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
print "&errorMsg=Bad Query";
exit;
}

// If auth failed...
if ($userLevel < 2) {
    // Inform Flash and quit
    print "&errorMsg=You do not have enough rights to perform this action";
	exit;
}

if($action == "load"){
//fetch categories
$query = "SELECT * FROM forumCatagories ORDER BY displayOrder ASC";
// Execute query
$result = mysql_query($query);
// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't list categories from database";
}
//count the cats
$catCount = mysql_num_rows($result);
$output = "&catCount=$catCount";
// For each forum returned...
for ($count = 0; $count < $catCount; $count++)
{
    // Extract post details from database
    $cat = mysql_fetch_array($result);
    $catID = $cat['catagoryID'];
    $catTitle = $cat['title'];
	$catOrder = $cat['displayOrder'];

    // Add thread details to output
    $output .= "&category" . $count . "catID=" . $catID;
    $output .= "&category" . $count . "catTitle=" . $catTitle;
	$output .= "&category" . $count . "catOrder=" . $catOrder;
}
//fetch forums
$query = "SELECT * FROM forumForums ORDER BY catagoryID, displayOrder ASC";

// Execute query
$result = mysql_query($query);

// If query failed...
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't list forums from database";
}

// Find out how many forums in this forum
$forumCount = mysql_num_rows($result);

// Setup our variable to hold output
$output .= "&forumCount=$forumCount";

// For each forum returned...
for ($count = 0; $count < $forumCount; $count++)
{
    // Extract post details from database
    $forum = mysql_fetch_array($result);
    $catagoryID = $forum['catagoryID'];
	$forumID = $forum['forumID'];
    $title = $forum['title'];
    $description = $forum['description'];
	$readMode = $forum ['readMode'];
	$displayOrder = $forum ['displayOrder'];

    // Add thread details to output
    $output .= "&forum" . $count . "catagoryID=" . $catagoryID;
	$output .= "&forum" . $count . "forumID=" . $forumID;
    $output .= "&forum" . $count . "title=" . $title;
    $output .= "&forum" . $count . "description=" . $description;
	$output .= "&forum" . $count . "readMode=" . $readMode;
	$output .= "&forum" . $count . "displayOrder=" . $displayOrder;
}

$query = "SELECT username, title FROM forumUsers WHERE userLevel = 2 ORDER BY username ASC";
$result = mysql_query($query);
if (!$result) {
    print "&errorMsg=Couldn't list admins from database";
}
$adminCount = mysql_num_rows($result);
$output .= "&adminCount=$adminCount";
for ($count = 0; $count < $adminCount; $count++)
{
	//extract the admins and send to flash
	$admin = mysql_fetch_array($result);
    $username = $admin['username'];
	$title = $admin['title'];
	$output .= "&adminName".$count."=" . $username;
	$output .= "&adminTitle".$count."=" . $title;
}
$query = "SELECT username, title FROM forumUsers WHERE userLevel = 1 ORDER BY username ASC";
$result = mysql_query($query);
if (!$result) {
    print "&errorMsg=Couldn't list mods from database";
}
$modCount = mysql_num_rows($result);
$output .= "&modCount=$modCount";
for ($count = 0; $count < $modCount; $count++)
{
	//extract the mods and send to flash
	$mod = mysql_fetch_array($result);
    $username = $mod['username'];
	$title = $mod['title'];
	$output .= "&modName".$count."=" . $username;
	$output .= "&modTitle".$count."=" . $title;
}
$query = "SELECT username, title FROM forumUsers WHERE userLevel = 0 ORDER BY username ASC";
$result = mysql_query($query);
if (!$result) {
    print "&errorMsg=Couldn't list users from database";
}
$userCount = mysql_num_rows($result);
$output .= "&userCount=$userCount";
for ($count = 0; $count < $userCount; $count++)
{
	//extract the mods and send to flash
	$user = mysql_fetch_array($result);
    $username = $user['username'];
	$title = $user['title'];
	$output .= "&userName".$count."=" . $username;
	$output .= "&userTitle".$count."=" . $title;
}
// Output all threads in one go
echo $output;

// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//***************************************************
// Start Save Forum Action
//***************************************************
if($action == "save"){
// Build and execute query to update the category
$query = "UPDATE forumForums SET catagoryID = $catagoryID, title = '$title', description = '$description', readMode = $readMode, displayOrder = $displayOrder WHERE forumID = $forumID";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Update!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//***************************************************
// Start Save Category Action
//***************************************************
if($action == "saveCat"){
// Build and execute query to update the category
$query = "UPDATE forumCatagories SET title = '$catTitle', displayOrder = $catOrder WHERE catagoryID = $catID";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Update!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//**************************************************
// Start New Forum Action
//**************************************************
if($action == "new"){
// Build and execute query to create the category
$query = "INSERT INTO forumForums (catagoryID, title, description, readMode, displayOrder) VALUES($catagoryID, '$title', '$description', $readMode, $displayOrder)";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Create!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//**************************************************
// Start New Category Action
//**************************************************
if($action == "newCat"){
// Build and execute query to create the category
$query = "INSERT INTO forumCatagories (title, displayOrder) VALUES('$catTitle', $catOrder)";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Create!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//***************************************************
// Start Delete Forum Action
//***************************************************
if($action == "delete"){
$query = "SELECT threadID FROM forumThreads WHERE forumID = $forumID";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't grab threads";
}
// Find out how many threads to delete
$threadCount = mysql_num_rows($result);
for ($count = 0; $count < $threadCount; $count++){
    // Extract post details from database
    $thread = mysql_fetch_array($result);
    $threadID = $thread['threadID'];
	$query2 = "DELETE FROM forumPosts WHERE threadID = $threadID";
	$result2 = mysql_query($query2);
		if (!$result2) {
    	// Inform Flash of error and quit
    	print "&errorMsg=Having a hard time deleting posts";
		}
	}
	$query3 = "DELETE FROM forumThreads WHERE forumID = $forumID";
	$result3 = mysql_query($query3);
		if (!$result3) {
    	// Inform Flash of error and quit
    	print "&errorMsg=Having a hard time deleting threads";
		}
	$query4 = "DELETE FROM forumForums WHERE forumID = $forumID";
	$result4 = mysql_query($query4);
		if (!$result4) {
    	// Inform Flash of error and quit
    	print "&errorMsg=Having a hard time deleting the forum";
		}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//**************************************************
// Start Delete Category Action
//**************************************************
if($action == "deleteCat"){
// Build and execute query to create the category
$query = "DELETE FROM forumCatagories WHERE catagoryID = $catID";
$result = mysql_query($query);
if (!$result) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Delete!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server
mysql_close($link);
exit;
}
//*************************************************
// Start Update User Action
//*************************************************
if($action == "updateuser"){
// Build and execute query to update the user
//protect the admin!!!
$query = "SELECT userID FROM forumUsers WHERE username = '$updateUsername'";
$result = @mysql_query($query);
$adminID = mysql_fetch_array($result);
$adminUserID = $adminID['userID'];
//if not the owner of the forum
if($adminUserID != 1){
//continue
$query2 = "UPDATE forumUsers SET userLevel = $userStatus, title = '$updateUserTitle' WHERE username = '$updateUsername'";
$result2 = mysql_query($query2);
if (!$result2) {
    // Inform Flash of error and quit
    print "&errorMsg=Couldn't Update User!!!";
}
// Inform Flash of success
print "&result=Okay";
// Close link to database server

}else{
	//print error
	print "&errorMsg=You can not change the owner of the forum!";
	}
mysql_close($link);
}
?>
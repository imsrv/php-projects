<?
session_start();

// connect to database and pull up info
include "../config.php";
$user123=$_POST['Username'];
$db = mysql_connect($db_host,$db_user,$db_pass); 
mysql_select_db ($db_name) or die ("Cannot connect to database"); 
//Get the data
$query = "SELECT id, level, username, password FROM users WHERE username='$user123' AND level='1'"; 
 
$result = mysql_query($query); 
/* Here we fetch the result as an array */ 
while($r=mysql_fetch_array($result)) 
{ 
/* This bit sets our data from each row as variables, to make it easier to display */ 
$id=$r["id"]; 
$_level=$r["level"]; 
$_Username=$r["username"]; 
$_Password=$r["password"]; 

// If the form was submitted
if ($_POST['Submitted'] == "True") {

    // If the username and password match up, then continue...
    if ($_POST['Username'] == $_Username && $_POST['Password'] == $_Password && $_level == 1) {

        // Username and password matched, set them as logged in and set the
        // Username to a session variable.
        $_SESSION['Logged_In'] = "True-Admin";
        $_SESSION['Level'] = "1";
        $_SESSION['Username'] = $_Username;
    }
}
} 
mysql_close($db); 
// If they are NOT logged in then show the form to login...
if ($_SESSION['Logged_In'] != "True-Admin") {
?>
<?
include "style.php";
?>
<div class="boxxy"><br><br><form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
<table cellpadding="0" cellspacing="0" border="0" align="center"><tr><td style="border-left: 1px solid gray; border-top: 1px solid gray; border-bottom: 1px solid gray;">Username:</td><td><input type="text" name="Username" style="border: 1px solid gray;"></td></tr><tr><td height="2"></td></tr><tr><td style="border-left: 1px solid gray; border-top: 1px solid gray; border-bottom: 1px solid gray;">Password:</td><td><input type="password" name="Password" style="border: 1px solid gray;"></td></tr><tr><td height="2"></td></tr><tr><td colspan="2" align="right"><input type="submit" style="border: 1px solid gray; font-family: verdana; font-size: 11px; background-color: white;" name="Submit" value="Submit"></td></tr><tr><td height="2"></td></tr><tr><td colspan="2" align="right"><a href="../fpass.php">Forget your Password?</a></td></tr></table>        <input type="hidden" name="Submitted" value="True"></form>
</div>
<div class="boxtext" align="center">&nbsp;<b>aWebBB Admin Login</b>&nbsp;</div>

<?
}
else
{
include "header.php";

if($_GET['id'] == "") {
echo "<b>Select a category to edit:</b><br><br>";
echo "<ol type=\"1\">";
//connection to database
include "../config.php";
$db = mysql_connect($db_host,$db_user,$db_pass); 
mysql_select_db ($db_name) or die ("Cannot connect to database"); 
$query = "SELECT id, category FROM fcat"; 
$result = mysql_query($query); 
while($r=mysql_fetch_array($result)) 
{ 
$id=$r["id"]; 
$category=$r["category"]; 
echo "<li><a href=\"edit_cat.php?id=$id\">$category</a></li>"; 
} 
mysql_close($db);
echo "</ol>";
} else {
//connection to database
include "../config.php";
$db = mysql_connect($db_host,$db_user,$db_pass); 
mysql_select_db ($db_name) or die ("Cannot connect to database"); 
$query = "SELECT id, category, description FROM fcat WHERE id = '$_GET[id]'"; 
$result = mysql_query($query); 
while($r=mysql_fetch_array($result)) 
{ 
$id=$r["id"]; 
$category=$r["category"]; 
$description=$r["description"]; 
?>
<b>Edit a category:</b><br><br>
<form name="keyword" method="post" action="edit_cat.php?id=<?=$_GET['id'];?>&a=edit"> 
Category Name:<br>
<input type="text" name="category" value="<?=$category;?>"><br>
<input type="hidden" name="oldcat" value="<?=$category;?>">
Description:<br>
<textarea rows="5" cols="35" name="description"><?=$description;?></textarea><br>
<input type="submit" name="Submit" value="Edit Category">
</form>
<?
} 
mysql_close($db);
if ($_GET['a'] == "edit") {
include "../config.php"; // As you can see we connected to the database with config
$db = mysql_connect($db_host, $db_user, $db_pass); 
mysql_select_db ($db_name) or die ("Cannot connect to database"); 
$query = "UPDATE fcat SET category='$_POST[category]', description ='$_POST[description]' WHERE id = '$_GET[id]'"; 
$result = mysql_query($query); 

$query2 = "UPDATE forum SET categories='$_POST[category]' WHERE categories = '$_POST[oldcat]'"; 
$result2 = mysql_query($query2); 

$query3 = "UPDATE flist SET categories='$_POST[category]' WHERE categories = '$_POST[oldcat]'"; 
$result3 = mysql_query($query3); 
echo "Modified ";
echo '<meta http-equiv="refresh" content="0;url=index.php">'; 
mysql_close($db); 
} else { }

?>
</td></tr></table>

<?
}
include "footer.php"; 

// If they want to logout then
if ($_GET['mode'] == "logout") {
    // Start the session
    session_start();

    // Put all the session variables into an array
    $_SESSION = array();

    // and finally remove all the session variables
    session_destroy();

    // Redirect to show results..
    echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=" . $_SERVER['PHP_SELF'] . "\">";
}
} 


?> 

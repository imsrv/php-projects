<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Quick Comment Check</title>
</head>
<body style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;">
<h4>New User Comments Summary</h4>
<p title="login"><a href="index.php" title="Login">Login</a></p>
<?
//This is an optional file that can be used to quickly check for new comments
//  without having to login to the system.
//_______________________
// Enter Database Details
$host = "localhost";
$un = "root";
$pw = "pass";
$database = "construction";
// ___________________________

// SQL Query
$sql = 'SELECT count(comment_title) FROM `site_task_comments` where new_user = 1';
//$sql = "SELECT comment_title FROM site_task_comments WHERE new_user = 1";
// Connect to the database
$db = mysql_connect($host,$un,$pw);
mysql_select_db ($database);
$result = mysql_query($sql);
echo "<table border='1' cellspacing='0' cellpadding='6' align='left'>\n";
echo "<tr><th>new comments</th></tr>\n";
while ($rows = mysql_fetch_row($result))
{
echo "<tr bgcolor='#FFFFBB'><td align='center'>$rows[0]</td></tr>\n";
}

echo "</table>\n";
?>

<br>
</body>
</html>

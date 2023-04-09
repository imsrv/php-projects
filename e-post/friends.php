<?
echo '<p>Friends list for <b>'.$_SESSION['valid_user'].'</b>.</p>';
$showf = "SELECT username,friend FROM e_friends WHERE username='$_SESSION[valid_user]'";
$showfq = mysql_query($showf, $db_conn) or die("Query orders failed".mysql_error());
if (isset($_GET['action']))
{
	if ($_GET['action']=='rem')
	{
		$remf = "DELETE FROM e_friends WHERE username='$_SESSION[valid_user]' AND friend='$_GET[name]'";
		$remfq = mysql_query($remf, $db_conn) or die("Query remf failed".mysql_error());
		header("Location: $siteurl/index.php?page=friends");
	}
}
if (mysql_num_rows($showfq)==0)
{
	echo '<p>You currently have no users added to your friend list.</p>';
}
else
{
echo '<table cellspacing="2" cellpadding="5" bgcolor="#000000">';
echo '<tr bgcolor="#eeeeee">';
echo '<td><b>Username</b></td><td colspan="2"><b>Action</b></td>';
echo '</tr>';
while ($frow = mysql_fetch_assoc($showfq))
{
	echo '<tr bgcolor="#cccccc">';
	echo '<td>'.$frow['friend'].'</td>';
	echo '<td><a href="index.php?page=friends&&action=rem&&name='.$frow['friend'].'" />Remove</a></td>';
	echo '<td><a href="index.php?page=e-new&&recip='.$frow['friend'].'" />Send mail</a></td>';
	echo '</tr>';
}
echo '</table>';
}
?>

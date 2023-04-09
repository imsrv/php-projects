<?php
if (isset($_GET['friend']))
{
	if ($_GET['friend']=='add')
	{
	$addf = "INSERT INTO e_friends (username,friend) VALUES ('$_SESSION[valid_user]','$_GET[name]')";
	$addfq = mysql_query($addf, $db_conn) or die("Query addf failed".mysql_error());
	echo '<p>Friend '.$_GET['name'].' added.</p>';
	}
}
echo '<form method="post" action="index.php?page=users">';
echo '<table cellspacing="2" cellpadding="5" bgcolor="#000000"  align="center">';
echo '<tr bgcolor="#cccccc">';
echo '<td><b>Enter user name</b></td><td><input type"text" name="search" size="30"></td>';
echo '</tr>';
echo '<tr bgcolor="#eeeeee">';
echo '<td colspan="2">';
echo '<input type="submit" name="searchusers" value="search">';
echo '</td>';
echo '</tr></table>';
echo '</form>';
if (isset($_POST['searchusers']))
{
$users = "SELECT username FROM e_users WHERE username!='$_SESSION[valid_user]' AND groupname='$_SESSION[groupname]' AND username LIKE '%$_POST[search]%'";
$usersq = mysql_query($users, $db_conn) or die("Query orders failed".mysql_error());
echo '<table cellspacing="2" cellpadding="5" bgcolor="#000000">';
echo '<tr bgcolor="#cccccc">';
echo '<td><b>Username</b></td><td><b>Action</b></td>';
echo '</tr>';
while ($urow = mysql_fetch_assoc($usersq))
{
	echo '<tr bgcolor="#eeeeee">';
	echo '<td>'.$urow['username'].'</td><td>';
	$friend = "SELECT friend FROM e_friends WHERE username='$_SESSION[valid_user]' AND friend='$urow[username]'";
	$friendq = mysql_query($friend, $db_conn) or die("query friend failed".mysql_error());
	if (mysql_num_rows($friendq)>0)
	{
		echo 'Friend</td>';
	}
	else
	{
		echo '<a href="index.php?page=users&&friend=add&&name='.$urow['username'].'" />Add as friend</a></td>';
	}
	echo '</tr>';
}
echo '</table>';
}
?>
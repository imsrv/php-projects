<?
//alter preferences
if (isset($_GET['mail']))
{
	if ($_GET['mail']=='off')
	{
		$notifyupdate = '0';
	}
	else
	{
		$notifyupdate = '1';
	}
	$changemail = "UPDATE e_users SET notify='$notifyupdate' WHERE username='$_SESSION[valid_user]'";
	$changeq = mysql_query($changemail, $db_conn) or die ("query changemail failed".mysql_error());
	echo '<p>Mail notification settings updated.</p>';
}
//preferences show
$pref = "SELECT notify FROM e_users WHERE username='$_SESSION[valid_user]'";
$prefq = mysql_query($pref, $db_conn) or die("Query pref Failed".mysql_error());
$prow = mysql_fetch_assoc($prefq);
if ($prow['notify']=='0')
{
	$notify = 'Off';
	$change = '<a href="index.php?page=pref&&mail=on" />Turn on</a>';
}
else
{
	$notify = 'On';
	$change = '<a href="index.php?page=pref&&mail=off" />Turn off</a>';
}
echo '<p>Preferences for <b>'.$_SESSION['valid_user'].'</b>.</p>';
echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5"><tr bgcolor="#cccccc">';
echo '<td>Email notification of new messages</td>';
echo '<td>'.$notify.'</td>';
echo '<td>'.$change.'</td>';
echo '</tr></table>';
?>
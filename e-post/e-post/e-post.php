<?
if (isset($_POST['e-postmain']))
{
	while(list($key, $val) = each($_POST["delete"])) 
		{ 
    if($val == 'del')
        $deleteIds[] = $key;
	$delmail = "DELETE FROM e_post WHERE id='$key'";
	$delmailq = mysql_query($delmail, $db_conn) or die("Query delmail failed".mysql_error());
	header("Location: index.php?page=e-post");
	} 
}
echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5"><tr bgcolor="#cccccc"><td>';
echo 'inbox for '.$_SESSION['valid_user'].'.</td>';
echo '<td><a href="index.php?page=e-new" />New message</a></td>';
echo '<td><img src="images/env_closed.gif" border="0"> = message unread | <img src="images/env_open.gif" border="0">= message read</td>';
echo '</tr></table>';
$showmail = "SELECT id,groupname,username,whofrom,DATE_FORMAT(date, '%d-%m-%Y') AS sentdate,time,readstate,subject,message FROM e_post WHERE username='$_SESSION[valid_user]' AND groupname='$_SESSION[groupname]' ORDER BY sentdate DESC";
$showresult = mysql_query($showmail, $db_conn) or die("Query showmail failed".mysql_error());

if (mysql_num_rows($showresult)<1)
{
	echo '<p>You have no messages.</p>';
}
else
{
echo '<p>';
echo 'Click the subject to read a message</p>';
echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5">';
echo '<form method="post" action="index.php?page=e-post">';
echo '<tr bgcolor="#cccccc"><td align="center"><img src="images\delete.gif" alt="Delete" /></td><td><b>Status</b></td><td><b>From</b></td><td><b>Date sent</b></td><td><b>Time sent</b></td><td><b>Subject</b></td></tr>';
while ($showrow = mysql_fetch_assoc($showresult))
{
	if ($showrow['readstate']=='0')
	{
		$status = '<img src="images/env_closed.gif" border="0">';
	}
	else
	{
		$status = '<img src="images/env_open.gif" border="0">';
	}
	echo '<tr bgcolor="#eeeeee">';
	echo '<td align="center"><input type="checkbox" name="delete['.$showrow['id'].']" value="del"></td>'; 
	echo '<td align="center">'.$status.'</td>';
	echo '<td>'.$showrow['whofrom'].'</td>';
    echo '<td>'.$showrow['sentdate'].'</td>';
	echo '<td>'.$showrow['time'].'</td>';
	echo '<td><a href="index.php?page=e-open&&id='.$showrow['id'].'&&status=read" />'.$showrow['subject'].'</a></td>';
	echo '</tr>';
}
echo '<table><tr><td><input type="submit" name="e-postmain" value="Delete selected"></td></tr></table>';
echo '</form>';
echo '</p>';
}
?>
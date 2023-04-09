<?
if (isset($_GET['status']))
{
	header('Location:index.php?page=e-open&&id='.$_GET['id'].'');
}
$openmail = "SELECT id,groupname,username,whofrom,DATE_FORMAT(date, '%d-%m-%Y') AS sentdate,time,readstate,subject,message FROM e_post WHERE id='$_GET[id]'";
$openresult = mysql_query($openmail, $db_conn) or die("Query openmail failed".mysql_error());
$openrow = mysql_fetch_assoc($openresult);
if (!isset($_GET['action'])=='delete')
{
	$string = ''.$openrow['message'].'';
	$string = str_replace("^", "'", $string);
	$string = str_replace("<script>", "<--Javascript in message disabled, code is below--><br />", $string);
	$string = str_replace("</script>", "<br /><--Javascript code section end-->", $string);
	$string = str_replace("<?", "<--PHP in message disabled, code is below--><br />", $string);
	$string = str_replace("?>", "<br /><--PHP code section end-->", $string);
	$string = str_replace("\n", "<br />", $string);
echo '<p>';
echo '<table cellspacing="1" cellpadding="5" bgcolor="#000000">';
echo '<tr bgcolor="#cccccc"><td><b>From: </b>'.$openrow['whofrom'].'</td><td><b>Date sent: </b>'.$openrow['sentdate'].'</td><td><b>Time sent: </b>'.$openrow['time'].'</td><td><b>Subject: </b>'.$openrow['subject'].'</td></tr>';
echo '<tr bgcolor="#eeeeee"><td colspan="4"><b>Message:</b><br />';
echo '<br />'.$string.'</td></tr>';
echo '<tr bgcolor="#cccccc"><td colspan="4"><a href="index.php?page=e-open&&id='.$_GET['id'].'&&action=reply" />Reply</a> | <a href="index.php?page=e-open&&id='.$_GET['id'].'&&action=delete" />Delete</a></td></tr>';
echo '</table>';
echo '</p>';
if ($openrow['readstate']=='0')
{
	$mark = $openrow['id'];
	$markread = "UPDATE e_post SET readstate='1' WHERE id='$mark'";
	$markq = mysql_query($markread, $db_conn) or die("Query markread failed".mysql_error());
}
}
if ($_GET['action']=='reply')
{
	$time = date('H:i:s');
	$date2 = date('d-m-Y');
	echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5">';
	echo '<form method="post" action="index.php?page=e-open&&id='.$openrow['id'].'&&sendreply=1">';
	echo '<input type="hidden" value="'.$openrow['whofrom'].'" name="reto">';
	echo '<tr bgcolor="#cccccc"><td><b>To: </b>'.$openrow['whofrom'].'</td><td><b>Date: </b>'.$date2.'</td><td><b>Time: </b>'.$time.'</td><td><b>Subject: </b><input type="text" name="resub" value="RE:'.$openrow['subject'].'"></td></tr>';
echo '<tr bgcolor="#eeeeee"><td colspan="4"><b>Original Message:</b><br />';
echo '<br /><div style="height: 100px; overflow: auto;">'.$openrow['message'].'</div></td></tr>';
echo '<tr bgcolor="#eeeeee"><td colspan="4"><b>Reply:</b><br /><textarea name="remsg" rows=10 cols=60></textarea></td></tr>';
echo '<tr bgcolor="#cccccc"><td colspan="4"><input type="submit" name="reply" value="Send reply"></td></tr>';
echo '<input type="hidden" name="message" value="'.$openrow['message'].'">';
echo '</form>';
echo '</table>';
}
if (isset($_POST['reply']))
{
	$date = date('Y-m-d');
	$time = date('H:i:s');
	//create message
	$divider = '<br />------------------------------------------------------<br />';
	$build = ''.$_POST['remsg'].' '.$divider.' '.$_POST['message'].'';
	$newmessage = str_replace("<br />", "\r\n", $build);
	$insreply = "INSERT INTO e_post (id,groupname,username,whofrom,date,time,readstate,subject,message) VALUES ('','$_SESSION[groupname]','$_POST[reto]','$_SESSION[valid_user]','$date','$time','','$_POST[resub]','$build')";
		$replyq = mysql_query($insreply, $db_conn) or die("Query send failed".mysql_error());
		echo '<p>Your reply has been sent.</p>';
}
if ($_GET['action']=='delete')
{
	$delmsg = "DELETE FROM e_post WHERE id='$_GET[id]'";
	$delmsgq = mysql_query($delmsg, $db_conn) or die("Query delmsg failed".mysql_error());
	echo '<p>Your message has been deleted.</p>';
}
?>
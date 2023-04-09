<?
$stringnew = ''.$_POST['newmsg'].'';
$stringnew = str_replace($banned,$edited,$stringnew);
$stringnew = str_replace("'", "^", $stringnew);
if (isset($_POST['newsent']))
{
	if ($_POST['recip']=='blank')
	{
		echo '<p>Please select a recipient</p>';
	}
    elseif (strlen($_POST['newsub'])<1)
	{
		echo '<p>Please enter a subject</p>';
		
	}
	elseif ($_POST['type']=='all')
	{
		$mass = "SELECT username FROM e_users WHERE groupname='$_SESSION[groupname]'";
		$massq = mysql_query($mass, $db_conn) or die("Query mass failed".mysql_error());
		while ($mrow = mysql_fetch_assoc($massq))
		{
		$time = date('H:i:s');
		$date = date('Y-m-d');
		$send = "INSERT INTO e_post (id,groupname,username,whofrom,date,time,readstate,subject,message) VALUES ('','$_SESSION[groupname]','$mrow[username]','$_SESSION[valid_user]','$date','$time','','$_POST[newsub]','$stringnew')";
		$sent = mysql_query($send, $db_conn) or die("Query send failed".mysql_error());
		$checkread = "SELECT readstate FROM e_post WHERE username='$_POST[recip]' AND readstate='0'";
		$checkreadq = mysql_query($checkread, $db_conn) or die("Query checkread Failed".mysql_error());
		//change ==1 to >0 to receive a notification email for each message received rather than just the first new message
		if (mysql_num_rows($checkreadq)==1)
		{
			$userinfo = "SELECT email,notify FROM e_users WHERE username='$_POST[recip]'";
			$userinfoq = mysql_query($userinfo, $db_conn) or die("Query userinfo Failed".mysql_error());
			$infor = mysql_fetch_assoc($userinfoq);
			if ($infor['notify']=='1')
			{
			$email = $infor['email'];
      $subj = "New messages \r\n"; 
      $mesg = "You have 1 or more new messages at, $sitename \r\n";
            mail($email, $subj, $mesg, $additional_headers2) or die("mail not sent");
			}
		}
		}
		echo '<p>Message sent.</p>';
	}
	else
	{
		if ($_POST['type']=='blank')
		{
			echo '<p>Please choose a send option.</p>';
		}
		elseif (strlen($_POST['recip'])<1)
		{
			echo '<p>Please enter a recipient.</p>';
		}
		else
		{
		$check = "SELECT username FROM e_users WHERE username='$_POST[recip]'";
		$cq = mysql_query($check, $db_conn) or die("Query $check Failed".mysql_error());
		if (mysql_num_rows($cq)<1)
		{
			echo '<p>The recipient you entered does not exist in our database, please try again.</p>';
		}
		else
		{
		$time = date('H:i:s');
		$date = date('Y-m-d');
		$send = "INSERT INTO e_post (id,groupname,username,whofrom,date,time,readstate,subject,message) VALUES ('','$_SESSION[groupname]','$_POST[recip]','$_SESSION[valid_user]','$date','$time','','$_POST[newsub]','$stringnew')";
		$sent = mysql_query($send, $db_conn) or die("Query send failed".mysql_error());
		echo '<p>Message sent.</p>';
		$checkread = "SELECT readstate FROM e_post WHERE username='$_POST[recip]' AND readstate='0'";
		$checkreadq = mysql_query($checkread, $db_conn) or die("Query checkread Failed".mysql_error());
		//change ==1 to >0 to receive a notification email for each message received rather than just the first new message
		if (mysql_num_rows($checkreadq)==1)
		{
			$userinfo = "SELECT email,notify FROM e_users WHERE username='$_POST[recip]'";
			$userinfoq = mysql_query($userinfo, $db_conn) or die("Query userinfo Failed".mysql_error());
			$infor = mysql_fetch_assoc($userinfoq);
			if ($infor['notify']=='1')
			{
			$email = $infor['email'];
      $subj = "New messages \r\n"; 
      $mesg = "You have 1 or more new messages at, $sitename \r\n";
            mail($email, $subj, $mesg, $additional_headers2) or die("mail not sent");
			}
		}
		}
		}
	}
}
if (isset($_GET['recip']))
{
echo '<p>';
echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5" border="0">';
echo '<form method="post" action="index.php?page=e-new&&recip='.$_GET['recip'].'">';
echo '<tr bgcolor="#cccccc"><td><b>Recipitent:  '.$_GET['recip'].'</b>';
echo '<input type="hidden" name="recip" value="'.$_GET['recip'].'">';
echo '</td>';
}
else
{
echo '<p>';
echo '<table bgcolor="#000000" cellspacing="1" cellpadding="5" border="0">';
echo '<form method="post" action="index.php?page=e-new">';
echo '<tr bgcolor="#cccccc"><td><b>Recipient:  </b>';
echo '<select name="type" id="type">';
echo '<option value="blank">-select a send option-</option>';
echo '<option value="all">Mail all customers</option>';
echo '<option value="user">Enter a username --></option>';
echo '</select>';
echo '<input type="text" name="recip">';
echo '</select>';
echo '</td>';
}
echo '<td><b>Subject:  </b>';
echo '<input type="text" name="newsub"></td>';
echo '<tr bgcolor="#eeeeee"><td colspan="2"><b>Message:</b><br /><br />';
echo '<textarea name="newmsg" rows=10 cols=60></textarea></td></tr>';
echo '<tr bgcolor="#cccccc"><td colspan="2"><input type="submit" name="newsent" value="Send Message"></td></tr>';
echo '</table>';
echo '</form>';
echo '</p>';
?>

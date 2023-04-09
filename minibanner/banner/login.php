<?php
	
	if($action=='logout')
	{
		session_start();
		session_destroy();
	}
	include('conn.php');
	$message = '';
	if(isset($submitForm))
	{
		$SQL = "SELECT id, group_id FROM user WHERE user_id = '$login_id' AND pass = '$pass'";
		$result = @mysql_query($SQL,$con);
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$id = $row[0];
			$group = $row[1];
			session_start();
			session_register("id");
			session_register("group");
			header('Location: banner_main.php');
			exit;
		}
		else
		{
			$message = 'Your ID / password is incorrect. Please try again.';
		}
		
	}
	
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Service Login</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
</head>
<body bgcolor="white">
<center>
<form action="login.php" method="post">
<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="78%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b>Administration Login</b></font><br><hr width="80%">
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><font face="arial" size="2" color="red"><?php print($message); ?></font></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><font face="arial" size="2"><b>Login ID</font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="login_id" maxlength="20"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Password</font></td><td><font face="arial" size="2">:</font></td><td><input type="password" name="pass" maxlength="15"></td>
		</tr>
		
		
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><font face="arial" size="1"><i>** Login ID and password are case sensitive.</i></font></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3" align="right"><input type="reset" value="Clear">&nbsp;&nbsp;&nbsp;<input type="submit" name="submitForm" value="Login"></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3" align="center"><font face="arial" size="1"><a href="bug_report.php">Report a Bug</a></font></td></tr>
		</table>
		</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>
</form>
<font face="arial" size="1"><i>&copy 2001 miniScript.com</i></font>
</center>
</body>
</html>

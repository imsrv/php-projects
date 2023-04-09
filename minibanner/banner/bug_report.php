<?php

	$message = '';
	if(isset($submitForm))
	{
		if($bug_message != '')
		{
			mail("ykf2000@yahoo.com","Bug Report From $sender",$bug_message,"From:$email");

			$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
			$html .= '<html><head><title>Report a Bug</title><meta name="Author" content="Yip Kwai Fong">';
			$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
			$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
			$html .= '</head><body bgcolor="white"><center><br><br><br>';
			$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
			$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">We thank you very much for helping us constantly upgrade our services. It is because people like you that we manage to upgrade our site to best suit your needs. We appreciated that and will try our best to fix the problem sonnest possible. <br>Thank you again.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="javascript:self.close();"><b><font face="arial" size="2">Close</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
		}
		else
		{
			$message = "Please describe the bug.";
		}
	}
?>


<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Forgot Password</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
</head>
<body bgcolor="white">
<center>
<form action="bug_report.php" method="post">
<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="78%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="2">
				<font face="arial" size="3"><b>Report a Bug</b></font><br><hr width="80%">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2"><font face="arial" size="2" color="red"><?php print($message); ?></font></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><font face="arial" size="2"><b>Name</b></font></td><td><font face="arial" size="2">:</font><input type="text" name="sender"></td></tr>
		<tr><td><font face="arial" size="2"><b>Email</b></font></td><td><font face="arial" size="2">:</font><input type="text" name="email"></td></tr>
		<tr>
			<td colspan="2"><font face="arial" size="2"><b>Description</font></td>
		</tr>
		<tr>
			<td colspan="2"><textarea name="bug_message" rows="10" cols = "60"></textarea></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td align="right" colspan="2"><input type="submit" name="submitForm" value="Catch The Bug!"></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr>
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

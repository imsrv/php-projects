<?php 

$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
$html .= '<html><head><title>Banner Manager</title><meta name="Author" content="Yip Kwai Fong">';
$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
$html .= '</head><body bgcolor="white"><center><br><br><br>';
$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
$html .= '<tr><td align="center"><br><br><font face="arial" size="2">Your have not login or your login session has expired. Please re-login. <br>Thank you.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="index.php"><font face="arial" size="2"><b>Home</b></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.php"><b><font face="arial" size="2">Login</b></font></a><br><br></td></tr></table></td></tr></table>';
$html .= '<br><br><font face="arial" size="1"><i>&copy 2001 miniScript.com</i></font></body></html>';
print($html);
exit;

?>
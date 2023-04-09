<?
// ************************************************************
// * Cedric email reader, lecture des emails d'une boite IMAP.*
// * Function library for IMAP email reading.                 *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>         *
// * Web : www.isoca.com                                      *
// * Version : 0.4                                            *
// * Date : Septembre 2001                                    *
// ************************************************************

// This job is licenced under GPL Licence.

include('skin/emailreaderskin_'.$lang.'.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/style.css" rel=stylesheet>
</head>
<body text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td bgcolor="C0C0C0" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
  <tr>
    <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
  <tr>
    <td bgcolor="A9A9A9"><font color="#FF0000"><? echo $cer_login_error_message; ?></font></td>
  </tr>
    <tr>
    <td bgcolor="A9A9A9">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="A9A9A9"><a href="emailreader.php?lang=<? echo "$lang&server=$server&username=$username"; ?>"><? echo $cer_back_to_login; ?></a></td>
  </tr>
  <tr>
    <td bgcolor="C0C0C0" height="1"><img src="image/spacer.gif" height="1" alt="spacer"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="666666"><img src="image/spacer.gif" height="1" alt="spacer"></td>
  </tr>
</table>
</body>
</html>

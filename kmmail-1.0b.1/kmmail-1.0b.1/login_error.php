<?
// @(#) $Id: login_error.php,v 1.3 2001/09/07 00:16:24 ryanf Exp $
include_once('include/settings.inc');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><? echo $config[title]; ?> - Login Error</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="stylesheet" href="css/style-xhtml-strict.css" type="text/css" />
</head>
<body class="normal">
<table border="0" cellpadding="1" cellspacing="0" width="300" class="backblack">
  <tr> 
    <td> 
      <table border="0" cellpadding="5" cellspacing="0" width="298" class="main">
        <tr> 
          <td class="titleheader"> 
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="titlebar">
              <tr> 
                <td align="left"><img src="images/titleleft.gif" width="48" height="26" alt="*" class="normal" /></td>
                <td class="titleheader">Login Error</td>
                <td align="right"><img src="images/titleright.gif" width="48" height="26" alt="*" class="normal" /></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td class="normal">
            <p>Sorry, but an attempt to login has failed.  Either you have hit the "Cancel" button, or your username or password is incorrect.  Please reload to try again.</p>
<?
if($last_error) {
  ?>
            <p>The error received from the mail server was: <i><? echo $last_error; ?></i></p>
  <?
}
?>
            <p>If you are absolutely sure the login information you specified is correct, the mail server may be down.  Please contact your system administrator if that is the case.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

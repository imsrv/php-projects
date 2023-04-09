<?php
require_once("include/vars.php");
require_once("include/functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td><?php
	require_once("header.php");
	?></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td><table width="70%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td class="ltxt"> <h4>How Does It Work?</h4>
                  <hr> </td>
              </tr>
              <tr> 
                <td class="ltxt"><div align="justify"><strong>New to 
                    <?=SITE_NAME?>
                    ? Here's what you do.</strong><br>
                    <br>
                    <strong>1.</strong> Choose who you want to send a file to. 
                    It can be anyone with an email address. You can specify multiple 
                    email addresses separated by commas.<br>
                    <br>
                    <strong>2.</strong> Select a file to send. You can send photos, 
                    audio, documents or anything else. Your file will be stored 
                    by <strong>
                    <?=SITE_NAME?>
                    </strong> without ever filling up your recipient's mailbox. 
                    <br>
                    <br>
                    <strong>3.</strong> Click on Send. <strong>
                    <?=SITE_NAME?>
                    </strong> will automatically 
                    email your recipient a link to your file stored on our server. 
                    Your file will be deleted after seven days. <br>
                    <br>
                    No passwords to share, no software to install, no accounts 
                    to create, and no full mailboxes. <A 
            href="index.php">Start sending now</A>! </div></td>
              </tr>
              <tr>
                <td class="ltxt"><strong><a href="index.php">&laquo; Back</a></strong></td>
              </tr>
            </table>
            <br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
	<?php
	require_once("footer.php");
	?>
	</td>
  </tr>
</table>  
</body>
</html>

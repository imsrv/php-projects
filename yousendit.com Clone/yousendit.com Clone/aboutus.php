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
                <td class="ltxt"> <h4>About Us</h4>
                  <hr> </td>
              </tr>
              <tr> 
                <td class="ltxt"><div align="justify"><strong> Our Technology.</strong><br>
                    <br>
                    <P><A href="why.php"><STRONG>Why 
                      <?=SITE_NAME?>
                      </STRONG></A><B> »</B><BR>
                      <?=SITE_NAME?> is the only true complete solution. You don't 
                      have to take our word for it. Just look at the proof.</P>
                    <P><A href="how.php"><STRONG>How does it work</STRONG></A><B> 
                      »</B><BR>
                      New to <?=SITE_NAME?>? Here's what you do. Step by step instructions 
                      on how to use <?=SITE_NAME?>.</P>
                  </div>
                  </td>
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

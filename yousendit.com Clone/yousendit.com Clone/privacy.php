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
                <td class="ltxt"> <h4><strong>Privacy Policy</strong></h4>
                  <hr> </td>
              </tr>
              <tr> 
                <td class="ltxt"><H4 align="justify" class="ltxt">Collecting Email 
                    Addresses</H4>
                  <P align="justify">We collect the e-mail addresses of <strong>
                    <?=SITE_NAME?>
                  </strong>                    Delivery recipients and senders for the purpose of logging 
                    and measuring usage. <strong>
                    <?=SITE_NAME?>
                    </strong> does not rent, sell, or share 
                    personal information about you with nonaffiliated companies.</P>
                  <H4 align="justify" class="ltxt">Certain Exceptional Disclosures</H4>
                  <P align="justify">We may disclose your information if necessary 
                    to protect our legal rights or if the information relates 
                    to actual or threatened harmful conduct or potential threats 
                    to the physical safety of any person. Disclosure may be required 
                    by law or if we receive legal process.</P>
                  <H4 align="justify" class="ltxt">File Transfer Security</H4>
                  <P align="justify">We have appropriate security measures in 
                    place in our physical facilities to protect against the loss, 
                    misuse or alteration of information that we have collected 
                    from you at our site. Files stored for delivery are only accessible 
                    by <strong><?=SITE_NAME?></strong>
                    and through the clickable link generated for your 
                    recipient. All files stored for delivery are deleted when 
                    they expire.</P></td>
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

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

include('lib/emailreader_execute_on_each_page.inc.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><? echo $cer_title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/menustyle.css" rel=stylesheet>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td bgcolor="A9A9A9">&nbsp;</td>
    <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
    <td bgcolor="CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
    <td bgcolor="EBEBEB" width="280" valign="top"> 
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="C0C0C0"><a href="<? echo $cer_logo_link; ?>"><img src="image/<? echo $cer_logo; ?>" width="100" height="52" hspace="20" vspace="5" alt="<? echo $cer_logo_alttext; ?>" border="0"></a></td>
          <td bgcolor="C0C0C0" align="right" valign="top"><a href="http://www.977design.com"><img src="image/977.gif" width="23" height="5" border="0" alt="977design"></a></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="CCCCCC" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
	  <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#D7D7D7" height="30"><font class=x>&nbsp;<? echo $cer_logout_message; ?></font></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#D7D7D7" height="30" valign="center">
            <div align="center"><a href="http://www.isoca.com" target="_self">&nbsp;Visit 
              Isoca website </a></div>
          </td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#D7D7D7" height="30" valign="center"> 
            <div align="center"><a href="http://www.977design.com" target="_blank">&nbsp;Visit 
              977design</a></div>
          </td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#D7D7D7" height="30" valign="center"> 
            <div align="center"><a href="http://www.netbusinessdesign.com" target="_blank">&nbsp;Visit 
              Net Business Design</a></div>
          </td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="B6B6B6" align="right" height="28">
<table width="95" border="0" cellspacing="0" cellpadding="0">
              <tbody> 
              <tr align=right> 
                <td bgcolor="#666666" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
                <td bgcolor="B6B6B6" height="28" nowrap> 
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#CCCCCC"> 
                      <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
                    </tr>
                    <tr> 
                      <td bgcolor="#CCCCCC" width="1" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
                      <td align=CENTER width="92" height="27"><a href="emailreader.php"><? echo $cer_back_to_login; ?></a></td>
                    </tr>
                  </table>
                  
                </td>
                <td bgcolor="#666666" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              </tbody> 
            </table>
          </td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#666666" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>
    </td>
    <td bgcolor="C0C0C0" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
    <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
    <td bgcolor="A9A9A9">&nbsp;</td>
  </tr>
</table>
</body>
</html>


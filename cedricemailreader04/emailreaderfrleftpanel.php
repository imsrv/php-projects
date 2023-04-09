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
<html>
<head>
    <title><? echo $cer_title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="style/menustyle.css" rel=stylesheet>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="109" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="808080" width="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="404040" width="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
    <td valign="top" align="center" width="105">
      <div align="center"><a href="<? echo $cer_logo_link; ?>" target="_top"><img src="image/<? echo $cer_logo; ?>" width="100" height="52" vspace="10" align="top" border="0"></a> 
        <br>
        <table width="95" border="0" cellspacing="0" cellpadding="0" align="center" height="700">
          <tr align=middle> 
            <td bgcolor="#666666" height="142" nowrap rowspan="16" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
            <td bgcolor="#666666" height="1" nowrap width="93"><img src="image/spacer.gif" width="1" height="1"></td>
            <td bgcolor="#666666" height="142" nowrap rowspan="16" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="B6B6B6" height="28" nowrap>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27"><?
                    print("<a href=\"#\" onClick=\"window.open('email.php?login=$login', '_blank', 'width=780,height=570,scrollbars=yes,resizable=yes')\">$cer_new_msg</a><br>\n");
                  ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="B6B6B6" height="28" nowrap>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27"><? print("<a href=\"emailreaderlist.php?login=$login\" target=\"listpanel\">$cer_inbox</a><br>\n"); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="B6B6B6" height="28" nowrap> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27" class="x"><? print("$cer_sent<br>\n"); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="B6B6B6" height="28" nowrap> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27" class="x"><? print("$cer_adress_book<br>\n"); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="B6B6B6" height="28" nowrap> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27" class="x"><? print("$cer_options<br>\n"); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>

          <tr align=middle> 
            <td bgcolor="A9A9A9" height="28" nowrap>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27"><a href="emailreaderabout.html" target="detailpanel"><? print($cer_about);?></a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle> 
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>
          <tr align=middle> 
            <td bgcolor="A9A9A9" height="28" nowrap>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="28">
                <tr bgcolor="#CCCCCC"> 
                  <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle width="92" height="27"><? print("<a href=\"emailreaderlogout.php?login=$login\" target=\"_top\">$cer_logout</a>\n"); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align=middle>
            <td bgcolor="#666666" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td bgcolor="C0C0C0" nowrap align="left" valign="top" height="554"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" height="554">
                <tr bgcolor="#CCCCCC" valign="top"> 
                  <td colspan="2" height="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                  <td align=middle height="554" width="92">
                    <div align="center">
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p><a href="http://www.977design.com" target="_blank"><img src="image/977.gif" width="23" height="5" border="0" alt="977design"></a></p>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </td>
    <td bgcolor="#666666" width="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="C0C0C0" width="1" nowrap><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
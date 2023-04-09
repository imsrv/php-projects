<?
// ************************************************************
// * Cedric email reader, lecture des emails d'une boite IMAP.*
// * Function library for IMAP email reading.                 *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>         *
// * Web : www.isoca.com                                      *
// * Version : 0.4                                            *
// * Date : Septembre 2001                                         *
// ************************************************************

// This job is licenced under GPL Licence.


// if user and password are known, it's a call from the page emailreaderloginerror.php
if(isset($server) && isset($username) && isset($lang)){
    $cer_default_server = $server;
    $cer_default_user = $username;
    $cer_default_pass = '';
    $cer_default_lang = $lang;
} else {
    require('common/emailreaderdefault.ini.php');
};

if (!$lang) {
  $cer_skin = 'skin/emailreaderskin_'.$cer_default_lang.'.php';
  $lang = $cer_default_lang;
} else {
  $cer_skin = 'skin/emailreaderskin_'.$lang.'.php';
}
include($cer_skin);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><? echo $cer_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/menustyle.css" rel=stylesheet>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="aform" action="emailreaderfr.php" method="post">
<input type="hidden" name="lang" value="<? echo $lang; ?>">
<input type="hidden" name="server_type" value="imap">
<table width="280" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
  <tr> 
    <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="EBEBEB" width="280" valign="top"> 
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="C0C0C0" width="200"><img src="image/<? echo $cer_logo; ?>" width="100" height="52" hspace="20" vspace="5" alt="Logo Isoca"></td>
          <td bgcolor="C0C0C0" align="right" valign="top" width="80"><a href="http://www.977design.com"><img src="image/977.gif" width="23" height="5" border="0" alt="977design"></a></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="CCCCCC" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>

      <table width="280" border="0" cellspacing="0" cellpadding="0" bgcolor="D7D7D7">
        <tr> 
          <td bgcolor="D7D7D7">
            <div align="center"><a href="emailreader.php?lang=de"><img src="image/de.gif" width="24" height="16" border="0" alt="Deutsch"></a></div>
          </td>
          <td bgcolor="D7D7D7">
            <div align="center"><a href="emailreader.php?lang=en"><img src="image/uk.gif" width="24" height="16" border="0" alt="English"></a></div>
          </td>
          <td bgcolor="D7D7D7">
            <div align="center"><a href="emailreader.php?lang=es"><img src="image/sp.gif" width="24" height="16" border="0" alt="Espanol"></a></div>
          </td>
          <td bgcolor="D7D7D7" height="20"> 
            <div align="center"><a href="emailreader.php?lang=fr"><img src="image/fr.gif" width="24" height="16" border="0" alt="Fran&ccedil;ais"></a></div>
          </td>
          <td bgcolor="D7D7D7">
            <div align="center"><a href="emailreader.php?lang=se"><img src="image/se.gif" width="24" height="16" border="0" alt="Swedish"></a></div>
          </td>
        </tr>
      </table>

      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
        </tr>
      </table>

      <table width="280" border="0" cellspacing="0" cellpadding="0" bgcolor="D7D7D7">
        <tr> 
          <td bgcolor="D7D7D7" width="80" class="g">&nbsp;<? echo $cer_txt_login; ?></td>
          <td bgcolor="D7D7D7" height="30" width="200" class="g"> 
            <input type="text" name="username" value="<? echo $cer_default_user; ?>">&nbsp;</td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="D7D7D7" width="80" class="g">&nbsp;<? echo $cer_txt_pass; ?></td>
          <td bgcolor="D7D7D7" height="30" width="200" class="g"> 
            <input type="password" name="password" value="<?echo $cer_default_pass; ?>">&nbsp;</td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="D7D7D7" width="80" class="g">&nbsp;<? echo $cer_txt_server; ?></td>
          <td bgcolor="D7D7D7" height="30" width="200" class="g"> 
            <input type="text" name="server" value="<? echo $cer_default_server; ?>">&nbsp;</td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="B6B6B6" align="right" height="28"> 
            <table width="95" border="0" cellspacing="0" cellpadding="0">
              <tbody> 
              <tr align=right> 
                <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                <td bgcolor="B6B6B6" height="28" nowrap> 
                  <table width="100" border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="CCCCCC"> 
                      <td colspan="2" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                    </tr>
                    <tr> 
                      <td bgcolor="CCCCCC" width="1" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
                      <td align="center" width="92" height="27"><!--<input STYLE="FONT-SIZE: 11px; FONT-FAMILY: tahoma,sans-serif; COLOR: FFFFFF; FONT-WEIGHT: bold; BACKGROUND-COLOR:A9A9A9" name="go" type="submit" value="<? echo $cer_button_open; ?>">-->
					  <a href="javascript:document.aform.submit();"><? echo $cer_button_open; ?></a>
					  </td>
                    </tr>
                  </table>
                </td>
                <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              </tbody> 
            </table>
          </td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="280" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"  class="g"> 
              <br><? echo $cer_txt_comment."<br>\r\n<br>\r\n".$cer_copyright; ?>
          </td>
        </tr>
      </table>
    </td>
    <td bgcolor="C0C0C0" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
    <td bgcolor="666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
</form>
</body>
</html>

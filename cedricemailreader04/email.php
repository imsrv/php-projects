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


if ($login > "") {
    include('lib/emailreader_execute_on_each_page.inc.php');
} else {
    $emailreader_ini = '$common/emailreaderdefault.ini.php';
    @include($emailreader_ini);
    @include('lib/'.$cer_server_type.'.inc.php');
    if(!isset($lang)) $lang = $cer_default_lang;
    @include('skin/emailreaderskin_'.$lang.'.php');
    $login = imap_binary("lang=$lang&emailreader_ini=$emailreader_ini");
};

// If reply then read original message
if(isset($msgid)){
 // Open message box
 $mbox = open_mailbox($server, $username, $password);
 $text = htmlspecialchars(get_part($mbox,$msgid, "TEXT/PLAIN"));

// prepare for answere
$mailheader=imap_header($mbox,$msgid);
$rawsubject = imap_mime_header_decode($mailheader->subject);
$msubject=$cer_reply_prefix.$rawsubject[0]->text;
$mfrom=htmlspecialchars(str_replace("\"","",$mailheader->fromaddress));
$mto=$mailheader->toaddress;
$mcc=$mailheader->ccaddress;
$mreply=$mailheader->reply_toaddress;
$mdate=$mailheader->Date;
ereg("([a-zA-Z]{3}), ([0-9]+) ([a-zA-Z]{3}) ([0-9]{4}) ([0-9:]{8}) (.*)", $mdate, $regs);
$translate_date =  $days_full[$regs[1]].' '.sprintf("%02d",$regs[2]).' '.$month_full[$regs[3]].' '.$regs[4].' '.$regs[5];


$anstext = splittext($text);
$anstext = str_replace("\r\n","\r\n$cer_reply_char",$anstext);
$anstext = "\r\n\r\n$cer_reply_separator\r\n $cer_reply_date_txt $translate_date $mfrom $cer_reply_wrote_txt :\r\n$cer_reply_separator\r\n \r\n$cer_reply_char".$anstext;
$anstext = stripslashes($anstext);

close_mailbox($mbox);
}; /// if(isset($msgid)){

// Add signature
if($cer_signature > ''){
    $anstext = "\r\n".$cer_signature."\r\n".$anstext;
};

// Read off adressBook
$cer_adress_book_file_name = $cer_adressbook;

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><? echo $cer_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/style.css" rel=stylesheet>
<SCRIPT>
function addTo(toadd, list){
  if (list.value > " ") {
    list.value=list.value + ", " + toadd.options[toadd.selectedIndex].value;
  } else {
    list.value=toadd.options[toadd.selectedIndex].value;
  }
}
</SCRIPT> 

</head>
<body text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form ENCTYPE="multipart/form-data" action="emailreadersend.php" method="post" name="formemail">
<INPUT TYPE="HIDDEN" name="MAX_FILE_SIZE" VALUE="100000">
<input type="hidden" name="login" value="<? echo $login; ?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="A9A9A9">
  <tr> 
    <td> 
      <table width="600" border="0" cellspacing="10" cellpadding="0">
        <tr> 
          <td><b><font size="5" color="#999999" face="Tahoma, san-serif"><i><? echo $cer_new_msg; ?></i></font></b></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td bgcolor="#CCCCCC"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="A9A9A9">
  <tr>
    <td>
      <table width=595 cellspacing=0 cellpadding=2 bgcolor="A9A9A9">
        <tr> 
          <td align=right nowrap width="100"><b><font class="s"><? echo $cer_to_txt; ?>&nbsp;:&nbsp;</font></b></td>
          <td> 
            <input type="text" name="destinataire" value="<? print($mreply); ?>" size=30 maxlength=1000 style="width:377px;" tabindex="1">
          </td>
          <td rowspan="4" valign="top"><img src="image/spacer.gif" width="15" height="1" alt="spacer"></td>
          <td rowspan="4" valign="top">
            <table width="115" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#666666"> 
                <td colspan="5" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td rowspan="6" bgcolor="#666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                <td rowspan="6" bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                <td colspan="3" bgcolor="#CCCCCC" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td height="20" bgcolor="#666666"> 
                  <div align="center"><font class="s" color="#FFCE00"><b><? echo $cer_adress_book_title; ?></b></font></div>
                </td>
                <td rowspan="3" bgcolor="#666666" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
                <td rowspan="5" bgcolor="#CCCCCC" width="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td height="25" align="center"> 
                  <select name="desttoadd" size="1">
                     <? include($cer_adress_book_file_name); ?>
                  </select>
                </td>
              </tr>
              <tr> 
                <td height="21"> 
                  <table cellspacing=0 cellpadding=0 border=0>
                    <tr align=center> 
                      <td noWrap><input STYLE="FONT-SIZE: 11px; FONT-FAMILY: tahoma,sans-serif; COLOR: FFFFFF; FONT-WEIGHT: bold; BACKGROUND-COLOR:A9A9A9" name="adddest" type="button" value="<? print($cer_to_txt); ?>" onClick="addTo(document.formemail.desttoadd, document.formemail.destinataire)"></td>
                      <td valign=bottom align=center width="2"><img height=14 src="image/format.vertical.separator.gif" width=2 alt="grey"></td>
                      <td noWrap><input STYLE="FONT-SIZE: 11px; FONT-FAMILY: tahoma,sans-serif; COLOR: FFFFFF; FONT-WEIGHT: bold; BACKGROUND-COLOR:A9A9A9" name="addcc" type="button" value="<? print($cer_copy_txt); ?>" onClick="addTo(document.formemail.desttoadd, document.formemail.cc)"></td>
                      <td valign=bottom align=center width="2"><img height=14 src="image/format.vertical.separator.gif" width=2 alt="grey"></td>
                      <td noWrap><input STYLE="FONT-SIZE: 11px; FONT-FAMILY: tahoma,sans-serif; COLOR: FFFFFF; FONT-WEIGHT: bold; BACKGROUND-COLOR:A9A9A9" name="addcci" type="button" value="<? print($cer_blind_copy_txt); ?>" onClick="addTo(document.formemail.desttoadd, document.formemail.cci)"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td colspan="2" bgcolor="#666666" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
              <tr> 
                <td colspan="2" bgcolor="#CCCCCC" height="1"><img src="image/spacer.gif" width="1" height="1"></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr> 
          <td align=right nowrap width="100"> 
            <p><b><font class="s" color="#104A7B"><? echo $cer_copy_txt; ?>&nbsp;:&nbsp;</font> 
              </b></p>
          </td>
          <td> 
            <input type="text" name="cc" value="<? echo $mcc; ?>" size="30" maxlength="1000" style="width:377px;">
          </td>
        </tr>

        <tr> 
          <td align=right nowrap width="100"> 
            <p><b><font class="s" color="#104A7B"><? echo $cer_blind_copy_txt; ?>&nbsp;:&nbsp;</font> 
              </b></p>
          </td>
          <td> 
            <input type="text" name="cci" value="" size="30" maxlength="1000" style="width:377px;">
          </td>
        </tr>
        <tr> 
          <td align=right nowrap width="100"> 
            <p><b><font class="s" color="#104A7B"><? echo $cer_subject_txt; ?>&nbsp;:&nbsp;</font> 
              </b></p>
          </td>
          <td> 
            <input type="text" name="sujet" value="<? print($msubject); ?>" size="30" maxlength="80" style="width:377px;" tabindex="2">
          </td>
        </tr>

        <tr> 
          <td align=right nowrap width="100"> 
            <p><b><font class="s" color="#104A7B"><? echo $cer_from_txt; ?>&nbsp;:&nbsp;</font> 
              </b></p>
          </td>
          <td> 
			<select name="from" size="1">
				<? include($cer_fromoption);?>
			</select>
          </td>
        </tr>
        <tr> 
          <td align=right nowrap width="100"><b><font class="s"><? echo $cer_attach_txt; ?>&nbsp;:&nbsp;</font></b></td>
          <td style="border-bottom:1px solid #C0C0C0;padding-bottom:5px;" height="10"> 
			<INPUT NAME="attach" TYPE="file" size=40 STYLE="FONT-SIZE: 11px; FONT-FAMILY: tahoma,sans-serif; FONT-WEIGHT: bold">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<table cellspacing=0 cellpadding=0 width=100% border=0 bgcolor="A9A9A9">
  <tr> 
          
    <td width="50"><img src="image/spacer.gif" width="50" height="1" alt="spacer"></td>
    <td noWrap width="559">
      <table cellspacing=0 cellpadding=0 width=559 border=0>
        <tbody> 
        <tr align=center> 
          <td noWrap> 
            <div align="right"> 
              <table width="100" border="0" cellspacing="0" cellpadding="0">
                <tbody> 
                <tr align=center> 
                  <td noWrap><a class=tab href="javascript:document.formemail.submit();"><b><? echo $cer_button_send; ?></b></a></td>
                  <td width="2"><img src="image/format.vertical.separator.gif" width="2" height="14" alt="grey"></td>
                  <td nowrap><a class=tab href="javascript:document.formemail.reset();"><b><? echo $cer_del_cancel_txt;?></b></a></td>
                </tr>
                </tbody> 
              </table>
            </div>
          </td>
        </tr>
        </tbody> 
      </table>
    </td>
    <td noWrap align=right height="25">&nbsp;</td>
  </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>

<table width="600" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td valign="top">
      <textarea name="body" style="width:600px;" tabindex="2" rows="17" cols="70"><? print($anstext); ?></textarea>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
<table cellspacing=0 cellpadding=3 width="100%" bgcolor=A9A9A9 border=0>
  <tbody> 
  <tr> 
    <td valign=top noWrap> 
      <table cellspacing=0 cellpadding=0 width=590 border=0>
        <tbody>
        <tr> 
          <td><img src="image/spacer.gif" width="32" height="1" alt="spacer"></td>
          <td noWrap> 
            <table cellspacing=0 cellpadding=0 width=559 border=0>
              <tbody> 
              <tr align=center> 
                <td noWrap> 
                  <div align="right"> 
                    <table width="100" border="0" cellspacing="0" cellpadding="0">
                      <tbody> 
                      <tr align=center> 
						  <td noWrap><a class=tab href="javascript:document.formemail.submit();"><b><? echo $cer_button_send; ?></b></a></td>
						  <td width="2"><img src="image/format.vertical.separator.gif" width="2" height="14" alt="grey"></td>
						  <td nowrap><a class=tab href="javascript:document.formemail.reset();"><b><? echo $cer_del_cancel_txt;?></b></a></td>
                      </tr>
                      </tbody> 
                    </table>
                  </div>
                </td>
              </tr>
              </tbody> 
            </table>
          </td>
          <td noWrap align=right>&nbsp;</td>
      </table>
    </td>
  </tr></TBODY>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1" alt="spacer"></td>
  </tr>
</table>
</form>
</body>
</html>

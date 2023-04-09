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

// Open message box
$mbox = open_mailbox($server, $username, $password);

$mailheader=imap_header($mbox,$msgid);
$rawsubject = imap_mime_header_decode($mailheader->subject);
$msubject=$rawsubject[0]->text;
$mfrom=htmlspecialchars(str_replace("\"","",$mailheader->fromaddress));
$mto=htmlspecialchars(str_replace("\"","",$mailheader->toaddress));
$mcc=htmlspecialchars(str_replace("\"","",$mailheader->ccaddress));
$mreply=$mailheader->reply_toaddress;
$mdate=$mailheader->Date;

$mailcheck = imap_check($mbox);
$mailnumber = $mailcheck->Nmsgs;

// Get the structure of the email
$structure = imap_fetchstructure($mbox,$msgid);

// Get the first part, assuming it's the message text
$apart = imap_fetchbody($mbox,$msgid, 1);
$apart_info = $structure->parts[0];
if($apart_info->type == 1){ // multipart type
    $apart = imap_fetchbody($mbox,$msgid, 1.1);
    $apart_info = $structure->parts[0]->parts[0];
    $ahtmlpart = imap_fetchbody($mbox,$msgid, 1.2);
    $anencode = $apart_info->encoding;
    if($anencode == 3){
        $msghtmlbody = imap_base64($ahtmlpart);
    } else if($anencode == 4){
        $msghtmlbody = imap_qprint($ahtmlpart);
    } else {
        $msghtmlbody = $ahtmlpart;
    };
}; /// multipart part
$anencode = $apart_info->encoding;
if($anencode == 3){
	$msgtextbody = imap_base64($apart);
} else if($anencode == 4){
	$msgtextbody = imap_qprint($apart);
} else {
	$msgtextbody = $apart;
};

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><? $cer_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/style.css" rel=stylesheet>
<script language="JavaScript">
<!--
function confirm_del(newlocation){
    if(confirm("<? echo $cer_del_confirm_txt; ?>")) top.listpanel.location = newlocation;
}; /// end func confirm
//-->
</script>

</head>
<body text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td bgcolor="#A9A9A9"><img height=1 src="image/spacer.gif" width=612><br>
    </td>
  </tr>
</table>

<table cellspacing=0 cellpadding=1 width="100%" bgcolor=A9A9A9 border=0>
  <tr> 
    <td valign=top noWrap align=right width=100><font class=s><? echo $cer_from_txt; ?>&nbsp;:</font> </td>
    <td style="BORDER-BOTTOM: #C0C0C0 1px solid" width=480> 
      <table id=MsgHeaders cellspacing=0 cellpadding=0 width=480>
        <tr> 
          <td><FONT class=f size=2><? echo $mfrom; ?></FONT> </td>
        </tr>
      </table>
    </td>
    <td width="100%">&nbsp; </td>
  </tr>

  <tr>
    <td valign=center noWrap align=right width=100><font class=s><? echo $cer_to_txt; ?>&nbsp;:</font> </td>
    <td style="WIDTH: 480px; BORDER-BOTTOM: #C0C0C0 1px solid" width=480> 
      <table cellspacing=0 cellpadding=0 width=480>
        <tr> 
          <td><FONT class=f size=2><? echo $mto; ?></FONT></td>
        </tr>
      </table>
    </td>
    <td width="100%">&nbsp;</td>
  </tr>
  <?
  if($mcc > ''){
  ?>
  <tr>
    <td valign=center noWrap align=right width=100><font class=s><? echo $cer_copy_txt; ?>&nbsp;:</font> </td>
    <td style="WIDTH: 480px; BORDER-BOTTOM: #C0C0C0 1px solid" width=480> 
      <table cellspacing=0 cellpadding=0 width=480>
        <tr> 
          <td><FONT class=f size=2><? echo $mcc; ?></FONT></td>
        </tr>
      </table>
    </td>
    <td width="100%">&nbsp;</td>
  </tr>
  <?
  }; /// if mcc
  ?>
  <tr>   
    <td valign=center noWrap align=right width=100><font class=s><? echo $cer_subject_txt; ?>&nbsp;:</font> </td>
    <td style="BORDER-BOTTOM: #C0C0C0 1px solid" width=480> 
      <table cellspacing=0 cellpadding=0 width=480>
        <tr> 
           <td><FONT class=f size=2><? echo $msubject; ?></FONT></td>
        </tr>
      </table>
    </td>
    <td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td noWrap align=right width=100><font class=s><? echo $cer_date_txt; ?>&nbsp;:</font> </td>
    <td style="BORDER-BOTTOM: #C0C0C0 1px solid" width=480> 
      <table cellspacing=0 cellpadding=0 width=480>
        <tr> 
           <td><FONT class=f size=2><?
           // Fri, 3 Aug 2001 17:30:32
           ereg("([a-zA-Z]{3}), ([0-9]+) ([a-zA-Z]{3}) ([0-9]{4}) ([0-9:]{8}) (.*)", $mdate, $regs);
           echo $days_full[$regs[1]].' '.sprintf("%02d",$regs[2]).' '.$month_full[$regs[3]].' '.$regs[4].' '.$regs[5];
           ?></FONT></td>
         </tr>
      </table>
    </td>
    <td width="100%">&nbsp;</td>
  </tr>
</table>

<table cellspacing=0 cellpadding=3 width="100%" bgcolor=#A9A9A9 border=0 nowrap>
  <tr> 
    <td valign=top noWrap> 
      <table cellspacing=0 cellpadding=0 width=590 border=0>
        <tr>
          <td><img src="image/spacer.gif" width="1" height="10"></td>
        </tr>
        <tr>
          <td><img src="image/spacer.gif" width="32" height="1"></td>
          <td noWrap> 
            <table cellspacing=0 cellpadding=0 width=559 border=0>
              <tr align=middle> 
                <td noWrap><a class="tab" href="#" <? echo "onClick=\"window.open('email.php?&login=$login&msgid=$msgid', '_blank', 'width=780,height=580,scrollbars=yes,resizable=yes');\"";?>><b><? echo $cer_reply_txt; ?></b></a></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap class="swb"><b><? echo $cer_reply_all;?></b></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap><a class="tab" href="#" <? echo "onClick=\"window.open('emailreadersource.php?&login=$login&msgid=$msgid', '_blank', 'width=740,height=580,scrollbars=yes,resizable=yes,menubar=yes')\""; ?>><b><? echo $cer_source_txt;?></b></a></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap><a class="tab" href="<? echo "javascript:confirm_del('emailreaderdeleted.php?&login=$login&msgid=$msgid');";?>" target="listpanel"><b><? echo $cer_del_txt; ?></b></a></td>
				<td><img src="image/spacer.gif" width="100" height="1"></td>
                <td noWrap> 
                  <div align="right"> 
                    <table width="100" border="0" cellspacing="0" cellpadding="0">
                      <tr align=middle> 
                        <td noWrap> <?
                        if($msgid > 1) echo "<a class=\"tab\" href=\"emailreaderdetail.php?&login=$login&msgid=".($msgid-1)."\"><b>$cer_prev_txt</b></a>";?>&nbsp;</td>
                        <td width="2"> <img src="image/separator.gif" width="2" height="14"> </td>
                        <td nowrap>&nbsp;<?
                        if($msgid < $mailnumber) echo "<a class=\"tab\" href=\"emailreaderdetail.php?&login=$login&msgid=".($msgid+1)."\"><b>$cer_next_txt</b></a>";?></b></a></td>
                      </tr>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
          </td>
          <td noWrap align=right>&nbsp;</td>
        </table>
      </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="600" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td>
      <table class=Wf cellspacing=0 cellpadding=0 width="100%" align=center border=0 nowrap bgcolor="#EBEBEB">
        <tr> 
          <td>
          <? 
            if($msghtmlbody > '') {
                    echo $msghtmlbody;
            } else {
          ?>
              <div style="BACKGROUND-COLOR: #EBEBEB"> 
                <font face=Arial size=3><? echo "<pre>".splittext($msgtextbody)."</pre>"; ?></font>
              </div>
          <?
            }; /// if html
          ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
// Print the message attached documents
if(isset($structure->parts)){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td>
      <?
    echo "<span class=\"p\">$cer_attach : </span>";
    while (list ($key, $val) = each ($structure->parts)) {
        if($key > 0){
            if($val->ifparameters) {
                $aparamdetail = $val->parameters;
                echo " &nbsp; <a href=\"emailreaderattach.php?login=$login&msgid=$msgid&partnumber=$key\" target=\"_blanck\">".$aparamdetail[0]->value."</a>&nbsp;";
            } else {
                echo " &nbsp; <a href=\"emailreaderattach.php?login=$login&msgid=$msgid&partnumber=$key\" target=\"_blanck\">(no name)</a>&nbsp;";
            };
        }; /// if key
    }; /// while
      ?>
    </td>
  </tr>
</table>
<?
}; /// if(isset($structure->parts

close_mailbox($mbox);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table cellspacing=0 cellpadding=3 width="100%" bgcolor=#A9A9A9 border=0 nowrap>
  <tr> 
    <td valign=top noWrap> 
      <table cellspacing=0 cellpadding=0 width=590 border=0>
        <tr>
          <td><img src="image/spacer.gif" width="1" height="10"></td>
        </tr>
        <tr>
          <td><img src="image/spacer.gif" width="32" height="1"></td>
          <td noWrap> 
            <table cellspacing=0 cellpadding=0 width=559 border=0>
              <tr align=middle> 
                <td noWrap><a class="tab" href="#" <? echo "onClick=\"window.open('email.php?&login=$login&msgid=$msgid', '_blank', 'width=780,height=580,scrollbars=yes,resizable=yes');\"";?>><b><? echo $cer_reply_txt; ?></b></a></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap class="swb"><b><? echo $cer_reply_all;?></b></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap><a class="tab" href="#" <? echo "onClick=\"window.open('emailreadersource.php?&login=$login&msgid=$msgid', '_blank', 'width=740,height=580,scrollbars=yes,resizable=yes,menubar=yes')\""; ?>><b><? echo $cer_source_txt;?></b></a></td>
                <td valign=bottom align=middle width="2"> <img height=14 src="image/separator.gif" width=2> </td>
                <td noWrap><a class="tab" href="<? echo "javascript:confirm_del('emailreaderdeleted.php?&login=$login&msgid=$msgid');";?>" target="listpanel"><b><? echo $cer_del_txt; ?></b></a></td>
				<td><img src="image/spacer.gif" width="100" height="1"></td>
                <td noWrap> 
                  <div align="right"> 
                    <table width="100" border="0" cellspacing="0" cellpadding="0">
                      <tr align=middle> 
                        <td noWrap> <?
                        if($msgid > 1) echo "<a class=\"tab\" href=\"emailreaderdetail.php?&login=$login&msgid=".($msgid-1)."\"><b>$cer_prev_txt</b></a>";?>&nbsp;</td>
                        <td width="2"><img src="image/separator.gif" width="2" height="14"></td>
                        <td nowrap>&nbsp;<?
                        if($msgid < $mailnumber) echo "<a class=\"tab\" href=\"emailreaderdetail.php?&login=$login&msgid=".($msgid+1)."\"><b>$cer_next_txt</b></a>";?></b></a></td>
                      </tr>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
          </td>
          <td noWrap align=right>&nbsp;</td>
        </table>
      </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#C0C0C0"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#666666"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<?
if($cer_debug){
	echo "<!--\r\nDebug informations : result of imap_fetchstructure\r\n";
	echo var_dump($structure);
	echo "\r\n-->";
};
?>

</body>
</html>

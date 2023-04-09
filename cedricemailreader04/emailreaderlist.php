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

$today = date('d/m/Y');

// Open message box
$mbox = open_mailbox($server, $username, $password);
if (!$mbox) {
    $message = "<tr><td colspan=\"6\">Invalid connection parameters.</td>";
} else { // Connection ok
   $mailcheck = imap_check($mbox);
   $mailnumber = $mailcheck->Nmsgs;
   $overview = imap_fetch_overview($mbox,"1:$mailnumber",0);
   if(is_array($overview)) {

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Inbox</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/style.css" rel=stylesheet>

<script language="JavaScript">
<!--
function confirm_del(newlocation){
    if(confirm("<? echo $cer_del_confirm_txt; ?>")) self.location = newlocation;
}; /// end func confirm
//-->
</script>


</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
    <td bgcolor="#A9A9A9"> 
      <table width="100%" border="0" cellspacing="10" cellpadding="0">
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr> 
                <td> <b><font size="5" color="#999999" face="Tahoma, sans-serif"><i><? echo $cer_inbox;?></i></font></b></td>
                <td align="right" class="swb"><? echo $mailnumber.' '.$cer_mail_msg;?></td>
              </tr>
            </table>
          </td>
        </tr>
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
    <td bgcolor="#CCCCCC"><img src="image/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table cellspacing=0 cellpadding=0 width="100%" border="0">
  <tr> 
    <td valign=top width="100%" height=20> 
      <table class=Mtable cellspacing=0 cellpadding=1 width="100%" border="0">
        <tr> 
          <td width="10" bgcolor="808080"><img src="image/spacer.gif" width="10" height="1"></td>
          <td width="200" height="23" bgcolor="808080" class="swb"><? echo $cer_from_txt; ?></td>
          <td width="100%" height="23" bgcolor="808080" class="swb"><? echo $cer_subject_txt; ?></td>
          <td width="100" height="23" bgcolor="808080" align="center" class="swb"><? echo $cer_date_txt; ?></td>
          <td width="62" height="23" bgcolor="808080" align="center" class="swb"><? echo $cer_del_txt; ?></td>
          <td width="10" height="23" bgcolor="808080"><img src="image/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10" height="1"><img src="image/spacer.gif" width="10" height="1"></td>
          <td width="200" height="1"><img src="image/spacer.gif" width="200" height="1"></td>
          <td width="100%" height="1"><img src="image/spacer.gif" width="200" height="1"></td>
          <td width="100" height="1"><img src="image/spacer.gif" width="100" height="1"></td>
          <td width="62" height="1"><img src="image/spacer.gif" width="62" height="1"></td>
          <td width="10" height="1"><img src="image/spacer.gif" width="10" height="1"></td>
        </tr>
<?
    if(isset($message)) {
        echo $message;
    } else {
        $nbm = sizeof($overview);
        for($i= $nbm-1; $i >= 0; $i--){
            $val = $overview[$i];
            $nb = $val->msgno;
            $rawsubject = imap_mime_header_decode($val->subject);
            $subject = $rawsubject[0]->text;
            if($subject == '') {$subject = "(no subject)";};
            //$from = htmlspecialchars($val->from);
            $from = $val->from;
            $a_date = $val->date; // Tue, 7 Aug 2001 03:33:08 +0200
            ereg("([a-zA-Z]{3}), ([0-9]+) ([a-zA-Z]{3}) ([0-9]{4}) ([0-9:]{8}) (.*)", $a_date, $regs);
            $thedate = sprintf("%02d",$regs[2]).'/'.$month[$regs[3]].'/'.$regs[4];
            if($thedate == $today){
                $datetoshow = $regs[5];
            } else {
                $datetoshow = $thedate;
            };
?>
        <tr> 
          <td><img src="image/spacer.gif" width="10" height="20"></td>
          <td><? print("<a href=\"#\" onClick=\"window.open('email.php?login=$login&mreply=".urlencode($val->from)."', '_blank', 'width=740,height=580,scrollbars=yes,resizable=yes')\">$from</a>");  ?></td>
          <td><? print("<a href=\"emailreaderdetail.php?&login=$login&msgid=$nb\" target=\"detailpanel\">$subject</a>"); ?></td>
          <td align="center" class="f"><? echo $datetoshow; ?></td>
          <td align="center"><? print("<a href=\"javascript:confirm_del('emailreaderdeleted.php?&login=$login&msgid=$nb');\">+</a>"); ?></td>
          <td><img src="image/spacer.gif" width="10" height="1"></td>
        </tr>
<?
        }; /// for nbm
    }; /// if message
}; /// if overview
close_mailbox($mbox);
}; /// if msbox
?>

      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#CCCCCC"><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table cellspacing=0 cellpadding=0 border=0 width="100%" height="15">
        <tbody> 
        <tr> 
          <td bgcolor="808080"><img src="image/spacer.gif" width="1" height="15"></td>
        </tr>
        </tbody> 
      </table>
    </td>
  </tr>
</table>
</body>
</html>



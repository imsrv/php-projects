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
    <title><? $cer_title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=emailreaderlist.php?login=<? echo $login; ?>">
    <LINK href="style/style.css" rel=stylesheet>
</head>


<body bgcolor="#A9A9A9" onLoad="javascript:parent.frames.detailpanel.open('blanck.html', 'detailpanel')">
<?
// Open message box
$mbox = open_mailbox($server, $username, $password);

 // Delete message
   $returnvalue=imap_delete($mbox, $msgid);
   if ($returnvalue) {
     print("<br><br><span class=\"swb\">$cer_del_ok</span>");
   } else {
     print($cer_del_error);
   };
   // close_mailbox($mbox);
   imap_close($mbox, CL_EXPUNGE);

?>

</body>
</html>
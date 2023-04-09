<?
/*
   File name         : attachments.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Adding and deleting attachments to the e-mail to be send.
   Last modified     : 10 Sep 2000
*/

include ("includes/global.inc");
session_start();

// ID comparison between logged hash and session. If they are both the same, let the user to go on...
$dbq = $db->execute("select * from tblLoggedUsers where hash = '$ID'");
$log_id   = $dbq->fields['log_id'];
$user_id  = $dbq->fields['user_id'];
$username = $dbq->fields['username'];
$password = $dbq->fields['password'];
$dbq->close();

if ($log_id == ""){
  Header("Location: index.php?error_id=1");
} else {

  $dbq = $db->execute("update tblUsers set real_name='$txtreal_name', signature='$txtsignature' where user_id = $user_id");
  $dbq->close();

  Header("Location: mailbox.php?mbox_id=INBOX");
}

?>

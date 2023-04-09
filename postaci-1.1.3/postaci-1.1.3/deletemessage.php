<?
/*
   File name         : deletemessage.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : It can delete any kind of message POP3/IMAP/DB with a single click.
   Last modified     : 15 Sep 2000
*/

include ("includes/global.inc");
session_start();
include ("$postaci_directory" . "classes/imap_pop3.inc");

// ID comparison between logged hash and session. If they are both the same, let the user to go on...
$dbq = $db->execute("select * from tblLoggedUsers where hash = '$ID'");
$log_id = $dbq->fields['log_id'];
$user_id = $dbq->fields['user_id'];
$username = $dbq->fields['username'];
$password = $dbq->fields['password'];
$dbq->close();
if ($log_id == ""){
  Header("Location: index.php?error_id=1");
} else {
  $mbox_id = rawurldecode($mbox_id);
  if ($default_protocol == "imap" || $mbox_id == "INBOX") {
    $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,$mbox_id);
    $email->empty_mailbox();
    $count=count($chk);
    for ($i=0; $i<$count; $i++) {
      $msg_no = $chk[$i];
      @imap_delete($email->mbox, $msg_no);
    }
    @imap_close($email->mbox,CL_EXPUNGE);
  } else {
    $count=count($chk);
    for ($i=0; $i<$count; $i++) {
      $msg_no = $chk[$i];
      $dbq = $db->execute("delete from tblMessages where mbox_id=$mbox_id and user_id = $user_id and message_id = $msg_no");
      $dbq->close();

      $dbq = $db->execute("select file_actual_name from tblAttachments where message_id = $msg_no");
      $act_name = $dbq->fields['file_actual_name'];
      while (!$dbq->EOF) {
        if (file_exists($act_name)) {
          unlink($act_name);
        }
        $dbq->nextRow();
      }
      $dbq->close();

      $dbq = $db->execute("delete from tblAttachments where user_id=$user_id and message_id = $msg_no");
      $dbq->close();
    }
  }

  Header("Location: mailbox.php?mbox_id=$mbox_id");

}

?>

<?
/*
   File name         : deletefolder.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Deletes a mailbox
   Last modified     : 16 Sep 2000
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

$mbox_id = rawurldecode($mbox_id);
if ($log_id == ""){
  Header("Location: index.php?error_id=1");
} else {
  if ($default_protocol == "imap") {   // protocol = imap
    include ("$postaci_directory" . "classes/imap_pop3.inc");
    $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,"INBOX");
    imap_unsubscribe($email->mbox, "{" . $default_host . "}$mbox_id");
    $sonuc = imap_deletemailbox($email->mbox, "{" . $default_host . "}$mbox_id");
    if (!$sonuc) {
      Header("Location: folders.php?error_id=6");
      exit;
    }
  } else {                             // protocol = pop3
    $dbq = $db->execute("select user_id from tblMailBoxes where mbox_id = $mbox_id"); // security check
    $auth_user   = $dbq->fields['user_id'];
    if ($auth_user != $user_id) {
      Header("Location: index.php?error_id=1");
    }

    // delete the folder
    $dbq = $db->execute("delete from tblMailBoxes where mbox_id = $mbox_id and user_id = $user_id");
    $dbq->close();

    // delete the attachments and messages
    $dbq = $db->execute("select message_id from tblMessages where mbox_id = $mbox_id and user_id = $user_id");
    while (!$dbq->EOF) {
      $message_id = $dbq->fields['message_id'];
      $dbq2 = $db->execute("select file_actual_name from tblAttachments where message_id = $message_id and user_id = $user_id");
      while (!$dbq2->EOF) {
        $act_name = $dbq2->fields['file_actual_name'];
        if (file_exists($act_name)) {
          unlink($act_name);
        }
        $dbq2->nextRow();
      }
      $dbq2->close();
      $dbq3 = $db->execute("delete from tblAtachments where message_id = $message_id and user_id = $user_id");
      $dbq3->close();
      $dbq->nextRow();
    }
    $dbq->close();
    $dbq = $db->execute("delete from tblMessages where mbox_id = $mbox_id and user_id = $user_id");
    $dbq->close();
  } // end if

  Header("Location: folders.php");
}

?>

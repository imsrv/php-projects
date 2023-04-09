<?
/*
   File name         : renamefolder_action.php
   Version           : 1.1.3
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Deleting attachments from the temporary place before sending them. 
   Last modified     : 7 Nov 2000
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
  if(isset($pnspace)) {
    $newfoldername = $pnspace.$newfoldername;
  }
  if ($default_protocol == "imap") {   // protocol = imap
    include ("$postaci_directory" . "classes/imap_pop3.inc");
    $newfoldername = imap_utf7_encode($newfoldername);
    $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,"INBOX");

    imap_unsubscribe($email->mbox, "{" . $default_host . "}$mbox_id");
    $sonuc = imap_renamemailbox($email->mbox, "{" . $default_host . ":" . $default_port . "}$mbox_id","{".$default_host. ":" . $default_port . "}$newfoldername");

    imap_subscribe($email->mbox, "{" . $default_host . "}$newfoldername");
    if (!$sonuc)  {
      Header("Location: folders.php?error_id=7");
      exit;
    }
  } else {
    $dbq = $db->execute("select user_id from tblMailBoxes where mbox_id = $mbox_id"); // security check
    $auth_user   = $dbq->fields['user_id'];
    if ($auth_user != $user_id) {
      Header("Location: index.php?error_id=1");
    }

    $dbq = $db->execute("select mbox_id from tblMailBoxes where mboxname = '$newfoldername'");
    $mbox_id   = $dbq->fields['mbox_id'];
    if ($mbox_id != 0) {
      Header("Location: folders.php?error_id=7");
      exit;
    }

    $dbq = $db->execute("update tblMailBoxes set mboxname = '$newfoldername' where mbox_id = $mbox_id and user_id = $user_id");
    $dbq->close();
  }

  Header("Location: folders.php");
}

?>

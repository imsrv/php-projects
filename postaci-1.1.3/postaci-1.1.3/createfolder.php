<?
/*
   File name         : createfolder.php
   Version           : 1.1.3
   Last Modified By  : RDC
   e-mail            : rdc@mail.bcd.pt
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
  exit;
} else {
  if (trim($newfolder) != ""){
    if(isset($pnspace)) {
      $newfolder = $pnspace.$newfolder;
    }
    if ($default_protocol == "imap") {   // protocol = imap
      include ("$postaci_directory" . "classes/imap_pop3.inc");
      $newfolder = imap_utf7_encode($newfolder);
      $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,"INBOX");
      $sonuc = imap_createmailbox($email->mbox, "{" . $default_host . "}" . $newfolder);
      imap_subscribe($email->mbox, "{" . $default_host . "}" . $newfolder);

      if (!$sonuc) {
        Header("Location: folders.php?error_id=4");
        exit;
      }
    } else {                             // protocol = pop3
      $dbq = $db->execute("select mbox_id from tblMailBoxes where user_id = $user_id order by mbox_id desc");
      $max_mbox_id   = $dbq->fields['mbox_id'];
      $max_mbox_id++;
      $dbq->close();

      $dbq = $db->execute("select mbox_id from tblMailBoxes where user_id = $user_id and mboxname = '$newfolder'");
      $mbox_exists   = $dbq->fields['mbox_id'];
      if ($mbox_exists == 0) {
        $dbq = $db->execute("insert into tblMailBoxes values($max_mbox_id,$user_id,'$newfolder',3)");
        $dbq->close();
      } else {
        Header("Location: folders.php?error_id=4");
        exit;
      }
    } // end if
  } else {
    Header("Location: folders.php?error_id=5");
    exit;
  }

  Header("Location: folders.php");
}

?>

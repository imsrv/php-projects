<?
/*
   File name         : postmail.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : MIME encodes the message and sends it.
   Last modified     : 10 Sep 2000
*/

include ("includes/global.inc");
session_start();

// ID comparison between logged hash and session. If they are both the same, let the user to go on...
$dbq = $db->execute("select log_id from tblLoggedUsers where hash = '$ID'");
$log_id = $dbq->fields['log_id'];
$dbq->close();
if ($log_id == ""){
  Header("Location: index.php?error_id=1");
} else {
  include ("$postaci_directory" . "classes/mime_mail.inc");
  include ("$postaci_directory" . "classes/imap_pop3.inc");
  include ("$postaci_directory" . "includes/functions.inc");

  $dbq = $db->execute("select user_id,username,password from tblLoggedUsers where hash='$ID'");
  $username = $dbq->fields['username'];
  $password = $dbq->fields['password'];
  $user_id = $dbq->fields['user_id'];
  $dbq->close();

  $msgbody = $msgbody . $footer_message;

  $mailadress    = getMailAdress($user_id);
  $mail          = new mime_mail;
  $mail->from    = $mailadress;
  $mail->to      = $to;
  $mail->cc      = $cc;
  $mail->bcc     = $bcc;
  $mail->subject = stripslashes($subject);
  $mail->body    = stripslashes($msgbody);

  $handle=opendir($attach_directory);
  while ($file = readdir($handle)) {
    $idvar = strstr($file,$ID);
    if ($idvar) {
      $attachedfile = strstr($file,"######");
      $attach_name  = substr($attachedfile,6);

      // Find the MIME type from th extension...
      $tersname = strrev($attach_name);
      $dosya_isim = stristr($tersname,".");
      $lenisim = strlen($dosya_isim);
      $extension=trim(strtolower(substr($attach_name,$lenisim)));

      $mime_type = "application/octet-stream";
      $dbq = $db->execute("select mime_type from tblMIME where mime_ext = '$extension'");
      $mime_type = $dbq->fields['mime_type'];
      $dbq->close();

      // adding the attachments.
      $fd = fopen($attach_directory . $file, "r");
      $data = fread($fd, filesize($attach_directory . $file));
      fclose($fd);

      $mail->add_attachment($data, $attach_name, $mime_type);
    }
  }

  closedir($handle);

  // send it right now!!!!
  $remote_ip = $REMOTE_ADDR;
  $mail->send();

  if ($default_protocol == "imap") {
    $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,"Sent Items");

    imap_append($email->mbox, "{" . $default_host . "}Sent Items", $mail->message_all);
    $handle=opendir($attach_directory);
    while ($file = readdir($handle)) {
      $idvar = strstr($file,$ID);
      if ($idvar) {
        unlink($attach_directory . $file);
      }
    }
  } else {
    $dbq = $db->execute("select message_id from tblMessages order by message_id desc");
    $max_msg_id = $dbq->fields['message_id'];
    $dbq->close();
    $msg_id  = $max_msg_id + 1;

    $dbq = $db->execute("select mbox_id from tblMailBoxes where user_id = $user_id and mbox_type=1");
    $mailbox = $dbq->fields['mbox_id'];
    $dbq->close();

    $cur_date = date('Y M d - H : i');
    $dbq = $db->execute("insert into tblMessages values($msg_id,$mailbox,$user_id,'$mail->from','$mail->to','$mail->cc','','$cur_date','$mail->subject','','$mail->body')");
    $dbq->close();

    $handle=opendir($attach_directory);
    while ($file = readdir($handle)) {
      $idvar = strstr($file,$ID);
      if ($idvar) {
        $attachedfile = strstr($file,"######");
        $attach_name  = substr($attachedfile,6);

        // Find the MIME type from the extension...
        $tersname = strrev($attach_name);
        $dosya_isim = stristr($tersname,".");
        $lenisim = strlen($dosya_isim);
        $extension=trim(strtolower(substr($attach_name,$lenisim)));

        $mime_type = "application/octet-stream";
        $dbq = $db->execute("select mime_type from tblMIME where mime_ext = '$extension'");
        $mime_type = $dbq->fields['mime_type'];
        $dbq->close();

        mt_srand((double)microtime()*10000);
        $id_name = md5(mt_rand(1,6000));
        $id_name=ereg_replace("/","X",$id_name);

        $file_new_name = $id_name . "######" . $attach_name;
        copy($attach_directory . $file , $pop3_attach_dir . $file_new_name);
        unlink($attach_directory . $file);
        $attach_no++;

        $dbq = $db->execute("select attach_id from tblAttachments order by attach_id desc");
        $max_attach_id = $dbq->fields['attach_id'];
        $dbq->close();
        $attach_id  = $max_attach_id + 1;
        $actual_name = $pop3_attach_dir . $file_new_name;
        $dbq = $db->execute("insert into tblAttachments values($attach_id,$msg_id,$user_id,'$mime_type','$attach_name','$actual_name')");
        $dbq->close();
      } // end if
    } // end while
  } // end if

  Header("Location: mailbox.php?mbox_id=INBOX");
}

?>

<?
/*
   File name         : upload.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Uploads attachments to a temporary disk place on the server.
   Last modified     : 11 Sep 2000
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
  // Saving the message body to a temporary file.
  $dosyaadi = "msgbody.txt";
  $fp = fopen($attach_directory . $ID . "#####" . "msgbody.txt", "w+");
  if ($fp) {
    $sonuc = fputs($fp, $msgbody);
    fclose($fp);
  } //end if


  if(copy($userfile, $attach_directory . $ID . "######" . $userfile_name)) {
    Header("Location: attachments.php?to=$to&cc=$cc&bcc=$bcc&subject=$subject&attached=1&mbox_id=$mbox_id&post_act=$post_act");
  } else {
    echo "&nbsp;<p>&nbsp;<p><div align='center'><h2>$text90</h2><p>";
    echo "<a href='attachments.php?to=$to&cc=$cc&bcc=$bcc&subject=$subject&attached=1'>$text47</a></div>\n";
  } // end if
}

?>

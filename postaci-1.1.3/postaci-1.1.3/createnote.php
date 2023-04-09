<?
/*
   File name         : createnote.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Last modified     : 10 Sep 2000
*/

include ("includes/global.inc");
session_start();

if (trim($txttitle) == "") {
  $txttitle = $text40;
}

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

  $dbq = $db->execute("select note_id from tblNotebook order by note_id desc");
  $max_note_id   = $dbq->fields['note_id'];
  $dbq->close();
  $max_note_id++;

  $tarih = date('Y-m-d');
  $dbq = $db->execute("insert into tblNotebook values($max_note_id,$user_id,'$txttitle','$txtnote','$tarih')");
  Header("Location: notebook.php");
}

?>

<?
/*
   File name         : notebookupdate.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Purpose           : Update script for notebook.
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

// security check
$dbq = $db->execute("select user_id from tblNotebook where note_id=$note_id");
$auth_user = $dbq->fields['user_id'];
if ($auth_user != $user_id) {
  Header("Location: index.php?error_id=1");
}
$dbq->close();


if ($log_id == ""){
  Header("Location: index.php?error_id=1");
} else {
  $dbq = $db->execute("update tblNotebook set notetitle='$txttitle',notes = '$txtnote' where user_id = $user_id and note_id = $note_id");
  $dbq->close();

  Header("Location: notebook.php");
}

?>

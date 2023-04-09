<?
/*
   File name         : createcontact.php
   Version           : 1.1.0
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
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

	$txtnamesurname = trim($txtnamesurname);
	if ($txtnamesurname == "") {
		$txtnamesurname = "-----------";
	}

  $dbq = $db->execute("select item_id from tblAdressbook order by item_id desc");
  $max_item_id   = $dbq->fields['item_id'];
  $dbq->close();
  $max_item_id++;

  $dbq = $db->execute("insert into tblAdressbook values($max_item_id,$user_id,'$txtnamesurname','$txtemail','','$txttelephone')");
  $dbq->close();

  if ($rm == 1) {
    //$mbox_id = rawurlencode($mbox_id);
  	Header("Location: readmessage.php?ek=1&mbox_id=$mbox_id&msg_no=$msg_no");
  } else {
  	Header("Location: adressbook.php");
  }

}

?>

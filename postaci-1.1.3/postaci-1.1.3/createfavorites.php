<?
/*
   File name         : createfavorites.php
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

	$txttitle = trim($txttitle);
	if ($txtnamesurname == "") {
		$txttitle = "-----------";
	}

  $dbq = $db->execute("select favorite_id from tblFavorites order by favorite_id desc");
  $max_favorite_id   = $dbq->fields['favorite_id'];
  $dbq->close();
  $max_favorite_id++;

  $dbq = $db->execute("insert into tblFavorites values($max_favorite_id,$user_id,'$txturl','$txttitle','')");
  Header("Location: favorites.php");
}

?>

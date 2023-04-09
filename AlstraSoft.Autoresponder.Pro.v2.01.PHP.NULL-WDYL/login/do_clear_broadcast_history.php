<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;
	
	$query = "DELETE FROM broadcastmessages
				WHERE broadcastmessages_user_id = $UserID AND
					broadcastmessages_sent = 1";
	$db->query($query);

	redirect("messages_broadcast.php");
?>
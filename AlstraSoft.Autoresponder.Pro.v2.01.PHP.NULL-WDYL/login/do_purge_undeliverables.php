<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;
	
	$query = "DELETE FROM subscribers
				WHERE subscribers_user_id = $UserID AND
					subscribers_trouble_mailing = 1";
	$db->query($query);

	redirect("prospects_undeliverables.php");
?>
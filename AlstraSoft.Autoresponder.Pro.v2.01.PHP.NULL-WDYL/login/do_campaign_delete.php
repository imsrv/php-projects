<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");

	$db = new DB_Sql;
	$query="select * from users where users_id=users_general_id and users_id='$id'";
	$db->query($query);
	if ($db->nf()!=0) error_page("You can't delete your main account");
	if (isset($id))
	{
			$user_id=$id;
			// stergem toate mesajele user-ului dat
			$query = "DELETE FROM messages
						WHERE messages_user_id = '$user_id'";
			$db->query($query);

			// stergem toate mesajele de broadcast ale user-ului dat
			$query = "DELETE FROM broadcastmessages
						WHERE broadcastmessages_user_id = '$user_id'";
			$db->query($query);

			// stergem toate variabilele user-ului dat
			$query = "DELETE FROM variables
						WHERE variables_user_id = '$user_id'";
			$db->query($query);

			// stergem toti subscrisii user-ului dat
			$query = "DELETE FROM subscribers
						WHERE subscribers_user_id = '$user_id'";
			$db->query($query);

			// in sfarsit, stergem user-ul
			$query = "DELETE FROM users
						WHERE users_id = '$user_id'";
			$db->query($query);
	}

	redirect("campaigns.php");
?>

<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// determinam ce trebuie sa facem cu subscrisii selectati

	if (isset($inactivate_only) && strtoupper($inactivate_only) == "ON")
	{
		// ** INACTIVATE only ** 

		if (isset($subscriber_check))
			foreach ($subscriber_check as $subscriber_id => $value)
			{
				$query = "UPDATE subscribers
							SET subscribers_active = '0'
							WHERE subscribers_id= '$subscriber_id'";
				$db->query($query);
			}
	}
	else
	{
		// ** COMPLETELY REMOVE ** 

		if (isset($subscriber_check))
			foreach ($subscriber_check as $subscriber_id => $value)
			{
				$query = "DELETE FROM subscribers
							WHERE 
								subscribers_user_id = '$UserID' AND
								subscribers_id = '$subscriber_id'";
				$db->query($query);
			}
	}

	redirect("prospects_mailinglist.php");
?>
<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");

	$db = new DB_Sql;
	if (isset($UserID))
	{
		$query="select * from users where users_id='$UserID'";
		$db->query($query);
		$db->next_record();
		$query="select * from users where users_id='$id' and users_general_id='".$db->f("users_general_id")."'";
		$db->query($query);
		if ($db->nf()==0)
			error_page("You do not own that campaign !!!");
		$UserID=$id;
		session_register("UserID");
		
	}
	else
	{
		error_page("Something is wrong !!!");
	}

	redirect("campaigns.php");
?>

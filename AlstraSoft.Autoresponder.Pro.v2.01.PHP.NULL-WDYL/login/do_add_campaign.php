<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	AssumeIsNotEmpty($name, "You must specify an username");
	$query="select * from users where users_username='$name'";
	$db->query($query);
	if ($db->nf()!=0)
	{
			error_page("Campaign username already exists. Please choose another.");
	}
	else
	{
		$query="select * from users where users_id='$UserID'";
		$db->query($query);
		$db->next_record();
		$query="select * from users where users_id='".$db->f("users_general_id")."'";
		$db->query($query);
		$db->next_record();
		$query = "INSERT INTO users (users_username, users_password, users_email, users_name, users_accounttype_id, users_general_id)
					VALUES ('".$name.".".$db->f("users_username")."', '".$db->f("users_password")."', '".$db->f("users_email")."', '".$db->f("users_name")."','".$db->f("users_accounttype_id")."','".$db->f("users_general_id")."')";
		$db->query($query);
	}
	redirect("campaigns.php");
?>

<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;

	// obtinem variabilele din form
	AssumeIsNotEmpty($name, "You must specify a name");
	AssumeIsNotEmpty($username, "You must specify an {sitename} name");
	AssumeIsEmailAddress($email, "You must specify a valid email address");

	$md5password = md5($password);

	// vedem daca nu avem deja un user cu username-ul dat
	$query = "SELECT * 
				FROM users
				WHERE users_username = '$username'";
	$db->query($query);
	
	if ($db->num_rows() != 0)
	{
		// exista deja
		error_page("{sitename} of this name already exists. Please chose another responder name.");
	}
	else
	{
		// nu exista inca un user cu username-ul dat
		// il cream

		$query = "INSERT INTO users (users_username, users_password, users_email, users_name, users_accounttype_id)
					VALUES ('$username', '$md5password', '$email', '$name', '$account_type')";
		$db->query($query);
		$query = "select * from users where users_username='$username'";
		$db->query($query);
		$db->next_record();
		$query="update users set users_general_id='".$db->f("users_id")."' where users_id='".$db->f("users_id")."'";
		$db->query($query);
	}

	redirect("members_list.php");
?>
<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// obtinem adresa de mail la care trimitem mail-urile
	AssumeIsNotEmpty($email, "You must specify a valid E-mail address");
	AssumeIsEmailAddress($email, "You must specify a valid E-mail address");

	if (!isset($message_id))
		$message_id = "";

	if (isset($test_newsletters))
		$test_newsletters = true;
	else
		$test_newsletters = false;

	// vedem daca avem un mesaj de testat, sau toate
	if ($message_id != "")
	{
		// ** UNUL SINGUR
		SendMessage2EmailAddress($message_id, $email);
	}
	else
	{
		// ** TOATE MESAJELE
		$query = "SELECT * 
					FROM messages ";
		if ($test_newsletters)
			$query .= "WHERE messages_template_id IS NOT NULL ";
		else
			$query .= "WHERE messages_template_id IS NULL ";

		$db->query($query);

		if ($db->num_rows() == 0)
			error_page("You don't have any messages");

		// pentru fiecare mesaj existen trimitem cate un email pe adresa data
		while ($db->next_record())
		{
			SendMessage2EmailAddress($db->f("messages_id"), $email);
		}
	}

	if ($test_newsletters)
		redirect("newsletters_test.php");
	else
		redirect("messages_test.php");
?>
<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/newsletters_test");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_newsletters_test", "newsletters_test.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de mesaje
	$template->set_file("tpl_option", "option.tpl");

	$query = "SELECT * FROM messages 
				WHERE 
					messages_user_id = '$UserID' AND
					messages_template_id IS NOT NULL
				ORDER BY messages_interval, messages_subject";
	$db->query($query);

	while ($db->next_record())
	{
		// cream o descriere a mesajului (un subject + interval)

		$subject = $db->f("messages_subject");
		$maxlength = 25;

		if (strlen($subject) > $maxlength)
			$short_subject = substr($db->f("messages_subject"), 0, $maxlength)."...";
		else
			$short_subject = $subject;

		$interval = $db->f("messages_interval");
		if ($interval == 0)
			$interval = "instant";
		else 
			$interval = "day ".$interval;

		$description = $short_subject." ($interval)";

		$template->set_var("VALUE", $db->f("messages_id"));
		$template->set_var("DESCRIPTION", $description);
		$template->parse("MESSAGE_LIST", "tpl_option", true);
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_newsletters_test");
	require("template_make.php");
?>

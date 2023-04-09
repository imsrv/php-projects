<?php
/* Nullified by WDYL-WTN */
	require("include/globals.php");
	require("include/db_mysql.php");
	require("include/template.php");
	require("include/functions.php");
	require("include/validation.php");
	require("include/phpmailer.php");
	require("include/mail.php");
		
	$db = new DB_Sql;

	// obtinem datele despre noul subscris:	$email, $name
	if (!isset($name))
		error_page("You must specify a name");
	if (!isset($email))
		error_page("You must specify an e-mail address");

	AssumeIsNotEmpty($name, "You must specify a name");
	AssumeIsString($name, "Your name is not a valid string");
	AssumeIsNotEmpty($email, "You must specify an e-mail address");
	AssumeIsString($email, "Your e-mail address is not a valid string");
	AssumeIsEmailAddress($email, "Your e-mail address is not a valid e-mail address");
	AssumeIsNotEmpty($user_id, "User ID is invalid");
	AssumeIsNumber($user_id, "User ID is invalid");

	$came_from = $HTTP_REFERER;

	// verificam daca nu avem deja un subscriber cu email-ul dat
	// pt user-ul caruia i s-a trimis email
	$query = "SELECT * 
				FROM subscribers
				WHERE 
					subscribers_user_id = '$user_id' AND
					subscribers_email = '$from_address' ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		// nu avem inca un subscris cu email-ul dat pt user-ul dat
		// adaugam subscrisul
		$query = "INSERT INTO subscribers (
					subscribers_user_id, 
					subscribers_name, 
					subscribers_email,
					subscribers_trouble_mailing,
					subscribers_active,
					subscribers_came_from,
					subscribers_join_date
					) VALUES (
					'$user_id', 
					'$name', 
					'$email', 
					'0', 
					'1', 
					'$came_from',
					NOW())";
		$db->query($query);

		// gasim id-ul subscrisului numai ce adaugat
		$subscriber_id = mysql_insert_id($db->link_id());

		// trimitem toate mesajele instant noului subscris
		$query = "SELECT * 
					FROM messages 
					WHERE 
						messages_user_id = '$user_id' AND
						messages_interval = '0' AND
						messages_disabled = '0' ";
		$db->query($query);

		while ($db->next_record())
		{
			SendMessage2Subscriber($db->f("messages_id"), $subscriber_id);
		}
	}
	
	$template = new Template("templates/subscription_done");
	$template->set_file("tpl_subscription_done", "subscription_done.tpl");

	$template->parse("output", "tpl_subscription_done");
	$template->p("output");
?>
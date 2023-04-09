<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;

	// verificam validitatea datelor
	AssumeIsNotEmpty($nr_autoresponse_messages, "Number of autoresponse messages must not be empty");
	AssumeIsNumber($nr_autoresponse_messages, "Number of autoresponse messages must be a number");

	AssumeIsNotEmpty($nr_followup_messages, "Number of follow up messages must not be empty");
	AssumeIsNumber($nr_followup_messages, "Number of follow up messages must be a number");

	AssumeIsNotEmpty($nr_subscribers, "Number of subscribers must not be empty");
	AssumeIsNumber($nr_subscribers, "Number of subscribers must be a number");

	AssumeIsString($text_ad, "Text Ad is not a valid string");
	AssumeIsString($banner_ad, "Banner Ad is not a valid string");

	// facem modificarile in baza de date
	$query = "UPDATE settings 
				SET settings_value = '$nr_autoresponse_messages'
				WHERE settings_name = 'freeaccount_nr_autoresponse_messages' ";
	$db->query($query);

	$query = "UPDATE settings 
				SET settings_value = '$nr_followup_messages'
				WHERE settings_name = 'freeaccount_nr_followup_messages' ";
	$db->query($query);

	$query = "UPDATE settings 
				SET settings_value = '$nr_subscribers'
				WHERE settings_name = 'freeaccount_nr_subscribers' ";
	$db->query($query);

	$query = "UPDATE settings 
				SET settings_value = '$text_ad'
				WHERE settings_name = 'freeaccount_text_ad' ";
	$db->query($query);

	$query = "UPDATE settings 
				SET settings_value = '$banner_ad'
				WHERE settings_name = 'freeaccount_banner_ad' ";
	$db->query($query);

	redirect("edit_settings.php");
?>
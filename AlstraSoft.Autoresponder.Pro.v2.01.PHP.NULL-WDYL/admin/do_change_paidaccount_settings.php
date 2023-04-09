<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;

	// verificam validitatea datelor
	AssumeIsNotEmpty($nr_autoresponse_messages, "Number of autoresponse messages must not be empty");
	AssumeIsNumber($nr_autoresponse_messages, "Number of autoresponse messages must be a number");

	AssumeIsNotEmpty($nr_followup_messages, "Number of follow up messages must not be empty");
	AssumeIsNumber($nr_followup_messages, "Number of follow up messages must be a number");

	// facem modificarile in baza de date
	$query = "UPDATE settings 
				SET settings_value = '$nr_autoresponse_messages'
				WHERE settings_name = 'paidaccount_nr_autoresponse_messages' ";
	$db->query($query);

	$query = "UPDATE settings 
				SET settings_value = '$nr_followup_messages'
				WHERE settings_name = 'paidaccount_nr_followup_messages' ";
	$db->query($query);

	redirect("edit_settings.php");
?>
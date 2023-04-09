<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// obtinem datele despre noul mesaj:	$subject $disabled $body $interval
	if (isset($type) && $type == "html")
		$type = 1;
	else
		$type = 0;

	if (isset($disabled) && strtoupper($disabled) == "ON")
		$disabled = 1;
	else
		$disabled = 0;

	if (!isset($template_id))
		$template_id = "NULL";
	else
		$template_id = "'" . $template_id . "'";

	AssumeIsWithinRange($interval, "Interval must be within range: 0 - 9999", 0, 9999);
	AssumeIsNotEmpty($subject, "Subject must not be empty");
	AssumeIsString($subject, "Subject is not a valid string");
	AssumeIsString($body, "Body is not a valid string");

	// adaugam mesajul
	$query = "INSERT INTO messages 
				(messages_user_id, messages_subject, messages_body,
				messages_type, messages_disabled, messages_interval, messages_template_id)
				VALUES
				('$UserID', '$subject', '$body', 
				'$type', '$disabled', '$interval', $template_id)";

	$db->query($query);

	if ($template_id == "NULL")
		redirect("messages_edit.php");
	else
		redirect("newsletters_edit.php");
?>
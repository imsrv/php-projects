<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// obtinem datele despre noul mesaj:	$message_id $subject $disabled $body $interval
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
	AssumeIsNumber($message_id, "Message ID is invalid");
	AssumeIsNotEmpty($subject, "Subject must not be empty");
	AssumeIsString($subject, "Subject is not a valid string");
	AssumeIsString($body, "Body is not a valid string");

	// adaugam mesajul
	$query = "UPDATE messages SET
				messages_subject = '$subject', 
				messages_body = '$body',
				messages_type = '$type', 
				messages_disabled = '$disabled', 
				messages_interval = '$interval',
				messages_template_id = $template_id
				WHERE messages_id = '$message_id'";

	$db->query($query);

	if ($template_id == "NULL")
		redirect("messages_edit.php");
	else
		redirect("newsletters_edit.php");
?>
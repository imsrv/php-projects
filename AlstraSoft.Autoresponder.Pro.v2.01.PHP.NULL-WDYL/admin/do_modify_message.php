<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$db = new DB_Sql;

	// obtinem datele despre noul mesaj:	$message_id $subject $body 
	if (isset($type) && $type == "html")
		$type = 1;
	else
		$type = 0;

	AssumeIsNumber($message_id, "Message ID is invalid");
	AssumeIsNotEmpty($subject, "Subject must not be empty");
	AssumeIsString($subject, "Subject is not a valid string");
	AssumeIsString($body, "Body is not a valid string");

	// adaugam mesajul
	$query = "UPDATE newslettertemplates SET
				newslettertemplates_subject = '$subject', 
				newslettertemplates_body = '$body',
				newslettertemplates_type = '$type'
				WHERE newslettertemplates_id = '$message_id'";

	$db->query($query);

	redirect("newsletter_templates.php");
?>
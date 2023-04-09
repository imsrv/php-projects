<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;
	$db2 = new DB_Sql;

	// vin urmatoarele variabile:
	//
	//		$subject, $body, $type
	//		$delivery_type
	//			($delivery_day, $delivery_month, $delivery_year, $delivery_hour, $delivery_minute)
	//		$broadcast_type
	//			($email)

	AssumeIsNotEmpty($subject, "You must specify a subject for your broadcast message");
	AssumeIsNotEmpty($delivery_type, "Delivery type must not be empty");
	AssumeIsString($delivery_type, "Delivery type is not a valid string");
	AssumeIsNotEmpty($broadcast_type, "Broadcast type must not be empty");
	AssumeIsString($broadcast_type, "Broadcast type is not a valid string");

	if (isset($type) && $type == "html") 
		$type = 1;
	else
		$type = 0;

	// pre-cream query-ul de selectare a subscrisilor la care vom trimite mesaje de broadcast
	$querySelect = "SELECT * 
					FROM subscribers 
					WHERE 
						subscribers_user_id = '$UserID' ";

	// pre-cream query-ul de inserare in db a mesajelor de broadcast
	$queryInsert = "INSERT INTO broadcastmessages (
					broadcastmessages_user_id,
					broadcastmessages_subject,
					broadcastmessages_body,
					broadcastmessages_type,
					broadcastmessages_delivery_date,
					broadcastmessages_sent,
					broadcastmessages_subscriber_id
					) VALUES (
					'$UserID',
					'$subject', 
					'$body', 
					'$type', ";
	// OBS: am mai ramas de adaugat: delivery_date, subscriber_id si sent

	// adaugam conditii in query in dependenta de tipul broadcast-ului
	switch ($broadcast_type)
	{
	case "to_active_prospects":
		$querySelect .= "AND subscribers_active = 1 ";
		break;
	case "to_inactive_prospects":
		$querySelect .= "AND subscribers_active = 0 ";
		break;
	case "to_mailing_list":
		// nu adaugam nici o conditie la query :)
		break;
	default:
		error_page("Invalid Broadcast Type");
		break;
	}

	// modificam query-ul de inserare si cream data de delivery
	switch ($delivery_type)
	{
	case "asap":
		$delivery_date = "NOW(), ";
		$queryInsert .= $delivery_date;
		$queryInsert .= "'1', "; // sent = true
		break;

	case "future":
		// verificam variabilele care vor forma data
		AssumeIsNumber($delivery_year, "Invalid Year Value");
		AssumeIsWithinRange($delivery_month, "Invalid Month Value", 1, 12);
		AssumeIsWithinRange($delivery_day, "Invalid Day Value", 1, 31);
		AssumeIsWithinRange($delivery_hour, "Invalid Hour Value", 0, 23);
		AssumeIsWithinRange($delivery_minute, "Invalid Minute Value", 0, 59);

		// adaugam zerouri pt valorile cu 1 singura cifra
		if ($delivery_month < 10)
			$delivery_month = "0" . $delivery_month;
		if ($delivery_day < 10)
			$delivery_day = "0" . $delivery_day;
		if ($delivery_hour < 10)
			$delivery_hour = "0" . $delivery_hour;
		if ($delivery_minute < 10)
			$delivery_minute = "0" . $delivery_minute;

		$delivery_date =	$delivery_year . "-" . 
							$delivery_month . "-" .
							$delivery_day . " " . 
							$delivery_hour . ":" . 
							$delivery_minute . ":00";
		echo "delivery date = $delivery_date <BR>";

		if (! Date::isMysqlDatetimeValid($delivery_date))
			error_page("Invalid Delivery Date");

		$queryInsert .= "'" . $delivery_date . "', ";
		$queryInsert .= "'0', "; // sent = false
		break;

	default:
		error_page("Invalid Delivery Type");
		break;
	}

	// obtinem lista de subscribers pt care trimitem mesajul
	$db->query($querySelect);

	while ($db->next_record())
	{
		$subscriber_id = $db->f("subscribers_id");

		// inseram in tabelul broadcastmessages cate o inregistrare 
		// pt fiecare subscriber care va primi mesajul
		$db2->query($queryInsert . "'$subscriber_id')");

		// obtinem id-ul inregistrarii numai ce inserate
		$broadcastmessage_id = mysql_insert_id($db2->link_id());
		
		// daca e "ASAP", trimitem si mesajul acum
		if ($delivery_type == "asap")
		{
			SendBroadcastMessage($broadcastmessage_id);
		}
	}

	redirect("messages_broadcast.php");
?>
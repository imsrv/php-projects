<?php
/* Nullified by WDYL-WTN */
	// scriptul se executa o data la N minute
	// si verifica daca nu sunt mesaje de broadcast care erau programate
	// sa fie trimise (in viitor) la o anumita data si ora
	// si pt care a sosit momentul sa fie trimise
	// scriptul trimite mesajele respective si le marcheaza drept trimise

	require("../include/globals.php");
	require("../include/db_mysql.php");
	require("../include/phpmailer.php");
	require("../include/mail.php");

	set_time_limit(0);
	$db = new DB_Sql;
	$db2 = new DB_Sql;

	// gasim mesajele de broadcast care trebuie trimise
	$query = "SELECT * 
				FROM broadcastmessages
				WHERE 
					broadcastmessages_delivery_date <= NOW() AND
					broadcastmessages_sent = '0' ";
	$db->query($query);

	while ($db->next_record())
	{
		$broadcast_message_id = $db->f("broadcastmessages_id");

		// trimitem mesajul
		SendBroadcastMessage($broadcast_message_id);

		// marcam mesajul trimis ca a fost trimis
		$query = "UPDATE broadcastmessages
					SET broadcastmessages_sent = '1'
					WHERE broadcastmessages_id = '$broadcast_message_id' ";
		$db2->query($query);
	}

?>
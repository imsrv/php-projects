<?php
/* Nullified by WDYL-WTN */
	// scriptul se executa o data pe zi la ora HH
	// si verifica daca nu sunt mesaje de follow-up (mai putin instante) 
	// care trebuie trimise azi (azi = toata ziua)

	require("../include/globals.php");
	require("../include/db_mysql.php");
	require("../include/phpmailer.php");
	require("../include/mail.php");

	set_time_limit(0);
	$db = new DB_Sql;

	// gasim mesajele follow-up care trebuie trimise
	$query = "SELECT * 
				FROM messages, subscribers, users
				WHERE 
					users_id = messages_user_id AND
					users_id = subscribers_user_id AND
					subscribers_active = '1' AND
					messages_interval <> '0' AND
					TO_DAYS(subscribers_join_date + INTERVAL messages_interval DAY) = TO_DAYS(NOW()) ";
	$db->query($query);

	while ($db->next_record())
	{
		$message_id = $db->f("messages_id");
		$subscriber_id = $db->f("subscribers_id");

		// trimitem mesajul
		SendMessage2Subscriber($message_id, $subscriber_id);
	}
?>
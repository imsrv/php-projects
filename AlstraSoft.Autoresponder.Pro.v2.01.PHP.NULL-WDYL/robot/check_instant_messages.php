<?php
/* Nullified by WDYL-WTN */
	// scriptul se executa la fiecare 1 minut
	// si verifica daca in INBOX (pt account-ul autoresp@{sitename})
	// au sosit mesaje destinate utilizatorilor (de ex: myuser@{sitename})
	// daca da, atunci inregistram persoana care a trimis mail ca si 
	// un subscriber pt utilizatorul "myuser", si in trimitem toate mesajele instante

	require("imap_globals.php");
	require("imap_functions.php");
	require("../include/globals.php");
	require("../include/db_mysql.php");
	require("../include/phpmailer.php");
	require("../include/mail.php");

	set_time_limit(0);
	$db = new DB_Sql;

	$message_box = imap_open("{".$MailHost.":110/pop3}INBOX", $MailUser, $MailPassword);

	if ($message_box != false)
	{
		$message_number = imap_num_msg($message_box);
		$headers = getHeaders($message_box, 1, $message_number);

		// parcurgem mesajele
		for ($i=1; $i<=$message_number; $i++)
		{
			$subject = $headers[$i][2];
			$uid = $headers[$i][6];
			$from_name = $headers[$i][1];

			// extragem numai numele (fara adresa de mail)
			$pos = strpos($from_name, "<");

			if ($pos === false)
				$from_name = $from_name;
			else
			    $from_name = substr($from_name, 0, $pos);

			$head = imap_fetchheader($message_box, $uid, FT_UID);
			$header_info = imap_headerinfo($message_box, $uid, FT_UID);

			$from = $header_info->from;
			$to = $header_info->to;

			foreach ($from as $id => $object)
			{
				$from_address = $object->mailbox . "@" . $object->host;
			}

			foreach ($to as $id => $object)
			{
				$to_address = $object->mailbox . "@" . $object->host;
				$to_user = $object->mailbox;
			}

			$body = imap_body($message_box, $uid, FT_INTERNAL);

			// vedem daca mesajul este adresat vreunui user al aplicatiei
			$query = "SELECT * 
						FROM users 
						WHERE users_username = '$to_user' ";
			$db->query($query);

			if ($db->num_rows() != 0)
			{
				// da, exista un user caruia i se adreseaza mailul primit
				$db->next_record();
				$user_id = $db->f("users_id");

				// verificam daca nu avem deja un subscriber cu email-ul dat
				// pt user-ul caruia i s-a trimis email
				$query = "SELECT * 
							FROM subscribers
							WHERE 
								subscribers_user_id = '$user_id' AND
								subscribers_email = '$from_address' ";
				$db->query($query);

				if ($db->num_rows() != 0)
				{
					// gasim id-ul subscrisului
					$db->next_record();
					$subscriber_id = $db->f("subscribers_id");
				}
				else
				{							
					// inregistram persoana care a trimis mail 
					// ca subscriber al user-ului caruia ii era destinat mail-ul
					$query = "INSERT INTO subscribers (
							    subscribers_name,
							    subscribers_email,
							    subscribers_user_id,
							    subscribers_join_date
							    ) VALUES (
							    '$from_name',
								'$from_address',
							    '$user_id',
							    NOW()
							    )";
					$db->query($query);

					// gasim id-ul subscrisului numai ce adaugat
					$subscriber_id = mysql_insert_id($db->link_id());
				}

				// trimitem toate mesajele instante ale user-ului subscrisului				
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

				// stergem mesajul
				imap_delete ($message_box, $uid, FT_UID);
			}
		}

		imap_expunge($message_box);
		imap_close($message_box);
	}

?>
<?php
/* Nullified by WDYL-WTN */

	// ************************************************************************
	// SendMessage2Subscriber
	// ************************************************************************
	function SendMessage2Subscriber($message_id, $subscriber_id)
	{
		global $SelfPath;

		$db = new DB_Sql;

		// obtinem informatiile despre mesajul ce trebui trimis
		// si despre user-ul care trimite mesajul

		$query = "SELECT * 
					FROM messages, users
					WHERE messages_id = '$message_id' AND
						messages_user_id = users_id";
		$db->query($query);

		if ($db->num_rows() != 1)
			error_page("Invalid message ID");

		$db->next_record();
		$UserID = $db->f("users_id");
		$from_email = $db->f("users_email");
		$from_name = $db->f("users_name");
		$is_free_account = ($db->f("users_accounttype_id") == 0);

		$subject = $db->f("messages_subject");
		$body = $db->f("messages_body");
		$type = $db->f("messages_type");

		// obtinem informatiile despre destinatarul mesajului

		$query = "SELECT * 
					FROM subscribers
					WHERE subscribers_id = '$subscriber_id'";
		$db->query($query);

		if ($db->num_rows() != 1)
			error_page("Invalid subscriber ID");

		$db->next_record();
		$to_email = $db->f("subscribers_email");
		$to_name = $db->f("subscribers_name");

		// determinam "first name" al subscriber-ului
		if (($pos = strpos($to_name, " ")) === false)
			$to_first_name = $to_name;
		else
			$to_first_name = substr($to_name, 0, $pos);

		// determinam unsubscribe url pt subscriber-ul dat
		$unsubscribe_url = $SelfPath . "unsubscribe.php?id=" . md5($db->f("subscribers_id"));

		// ** inlocuitm variabilele predefinite cu valorile respective
		$subject = str_replace("[[firstname]]", $to_first_name, $subject);
		$body = str_replace("[[firstname]]", $to_first_name, $body);

		$subject = str_replace("[[name]]", $to_name, $subject);
		$body = str_replace("[[name]]", $to_name, $body);

		$subject = str_replace("[[email]]", $to_email, $subject);
		$body = str_replace("[[email]]", $to_email, $body);
		
		$subject = str_replace("[[remove]]", $unsubscribe_url, $subject);
		$body = str_replace("[[remove]]", $unsubscribe_url, $body);

		// ** inlocuim variabilele definite de utilizator 
		// din subject si din body cu valorile lor respective
		$query = "SELECT * 
					FROM variables
					WHERE variables_user_id = '$UserID'";
		$db->query($query);

		while ($db->next_record())
		{
			$subject = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $subject);
			$body = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $body);
		}

		// ** trimitem mail-ul

		$mail = new phpmailer();
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to_email);
		$mail->Subject = $subject;

		if ($type == 1)
		{
			$mail->IsHTML(true);
			$mail->Body    = $body;

			$text_body = strip_tags($body, "<br><BR>");
			$text_body = str_replace("<br>", "\r\n", $text_body);			
			$text_body = str_replace("<BR>", "\r\n", $text_body);			
			$mail->AltBody = $text_body; 
		}
		else
		{
			$mail->IsHTML(false);
			$mail->Body = $body;
		}

		// adaugam banner-e pt mesajele trimise de pe free account
		if ($is_free_account)
		{
			// obtinem valoarea "text_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_text_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$text_ad = "";
			else
			{
				$db->next_record();
				$text_ad = $db->f("settings_value");
			}

			// obtinem valoarea "banner_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_banner_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$banner_ad = "";
			else
			{
				$db->next_record();
				$banner_ad = $db->f("settings_value");
			}

			// adaugam banner-ele
			if ($type == 1)
			{
				// html message
				$mail->Body .= "<BR><BR>" . $banner_ad;
				$mail->AltBody .= "\r\n\r\n" . $text_ad;
			}
			else
			{
				// text message
				$mail->Body .= "\r\n\r\n" . $text_ad;
			}
		} // sfarsit adaugare banner-e pt mesajele trimise de pe free account 

		if (! $mail->Send())
			error_page("Could not send message to $to_email");
	}

	// ************************************************************************
	// SendMessage2EmailAddress
	// ************************************************************************
	function SendMessage2EmailAddress($message_id, $email)
	{
		global $SelfPath;

		$db = new DB_Sql;

		// obtinem informatiile despre mesajul ce trebui trimis
		// si despre user-ul care trimite mesajul

		$query = "SELECT * 
					FROM messages, users
					WHERE messages_id = '$message_id' AND
						messages_user_id = users_id";
		$db->query($query);

		if ($db->num_rows() != 1)
			error_page("Invalid message ID");

		$db->next_record();
		$UserID = $db->f("users_id");
		$from_email = $db->f("users_email");
		$from_name = $db->f("users_name");
		$is_free_account = ($db->f("users_accounttype_id") == 0);

		$subject = $db->f("messages_subject");
		$body = $db->f("messages_body");
		$type = $db->f("messages_type");

		$to_email = $email;

		// ** inlocuitm variabilele predefinite cu valorile respective
		// OBS: nu se vor inlocui: [[name]], [[first_name]], [[remove]]
		$subject = str_replace("[[email]]", $to_email, $subject);
		$body = str_replace("[[email]]", $to_email, $body);
		
		// ** inlocuim variabilele definite de utilizator 
		// din subject si din body cu valorile lor respective
		$query = "SELECT * 
					FROM variables
					WHERE variables_user_id = '$UserID'";
		$db->query($query);

		while ($db->next_record())
		{
			$subject = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $subject);
			$body = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $body);
		}

		// ** trimitem mail-ul

		$mail = new phpmailer();
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to_email);
		$mail->Subject = $subject;

		if ($type == 1)
		{
			$mail->IsHTML(true);
			$mail->Body    = $body;

			$text_body = strip_tags($body, "<br><BR>");
			$text_body = str_replace("<br>", "\r\n", $text_body);			
			$text_body = str_replace("<BR>", "\r\n", $text_body);			
			$mail->AltBody = $text_body; 
		}
		else
		{
			$mail->IsHTML(false);
			$mail->Body = $body;
		}

		// adaugam banner-e pt mesajele trimise de pe free account
		if ($is_free_account)
		{
			// obtinem valoarea "text_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_text_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$text_ad = "";
			else
			{
				$db->next_record();
				$text_ad = $db->f("settings_value");
			}

			// obtinem valoarea "banner_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_banner_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$banner_ad = "";
			else
			{
				$db->next_record();
				$banner_ad = $db->f("settings_value");
			}

			// adaugam banner-ele
			if ($type == 1)
			{
				// html message
				$mail->Body .= "<BR><BR>" . $banner_ad;
				$mail->AltBody .= "\r\n\r\n" . $text_ad;
			}
			else
			{
				// text message
				$mail->Body .= "\r\n\r\n" . $text_ad;
			}
		} // sfarsit adaugare banner-e pt mesajele trimise de pe free account 

		if (! $mail->Send())
			error_page("Could not send message to $to_email");
	}

	// ************************************************************************
	// SendBroadcastMessage
	// ************************************************************************
	function SendBroadcastMessage($broadcastmessage_id)
	{
		global $SelfPath;

		$db = new DB_Sql;

		// obtinem informatiile despre mesajul ce trebui trimis
		// si despre user-ul care trimite mesajul

		$query = "SELECT * 
					FROM broadcastmessages, users, subscribers
					WHERE broadcastmessages_id = '$broadcastmessage_id' AND
						broadcastmessages_user_id = users_id AND
						broadcastmessages_subscriber_id = subscribers_id";
		$db->query($query);

		if ($db->num_rows() != 1)
			error_page("Invalid broadcast message ID");

		$db->next_record();
		$UserID = $db->f("users_id");
		$from_email = $db->f("users_email");
		$from_name = $db->f("users_name");
		$is_free_account = ($db->f("users_accounttype_id") == 0);

		$subject = $db->f("broadcastmessages_subject");
		$body = $db->f("broadcastmessages_body");
		$type = $db->f("broadcastmessages_type");

		$to_email = $db->f("subscribers_email");
		$to_name = $db->f("subscribers_name");

		// determinam "first name" al subscriber-ului
		if (($pos = strpos($to_name, " ")) === false)
			$to_first_name = $to_name;
		else
			$to_first_name = substr($to_name, 0, $pos);

		// determinam unsubscribe url pt subscriber-ul dat
		$unsubscribe_url = $SelfPath . "unsubscribe.php?id=" . md5($db->f("subscribers_id"));

		// ** inlocuitm variabilele predefinite cu valorile respective
		$subject = str_replace("[[firstname]]", $to_first_name, $subject);
		$body = str_replace("[[firstname]]", $to_first_name, $body);

		$subject = str_replace("[[name]]", $to_name, $subject);
		$body = str_replace("[[name]]", $to_name, $body);

		$subject = str_replace("[[email]]", $to_email, $subject);
		$body = str_replace("[[email]]", $to_email, $body);
		
		$subject = str_replace("[[remove]]", $unsubscribe_url, $subject);
		$body = str_replace("[[remove]]", $unsubscribe_url, $body);

		// ** inlocuim variabilele definite de utilizator 
		// din subject si din body cu valorile lor respective
		$query = "SELECT * 
					FROM variables
					WHERE variables_user_id = '$UserID'";
		$db->query($query);

		while ($db->next_record())
		{
			$subject = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $subject);
			$body = str_replace("[[" . $db->f("variables_name") . "]]", $db->f("variables_value"), $body);
		}

		// ** trimitem mail-ul

		$mail = new phpmailer();
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to_email);
		$mail->Subject = $subject;

		if ($type == 1)
		{
			$mail->IsHTML(true);
			$mail->Body    = $body;

			$text_body = strip_tags($body, "<br><BR>");
			$text_body = str_replace("<br>", "\r\n", $text_body);			
			$text_body = str_replace("<BR>", "\r\n", $text_body);			
			$mail->AltBody = $text_body; 
		}
		else
		{
			$mail->IsHTML(false);
			$mail->Body = $body;
		}

		// adaugam banner-e pt mesajele trimise de pe free account
		if ($is_free_account)
		{
			// obtinem valoarea "text_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_text_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$text_ad = "";
			else
			{
				$db->next_record();
				$text_ad = $db->f("settings_value");
			}

			// obtinem valoarea "banner_ad"
			$query = "SELECT settings_value 
						FROM settings
						WHERE settings_name = 'freeaccount_banner_ad' ";
			$db->query($query);

			if ($db->num_rows() == 0)
				$banner_ad = "";
			else
			{
				$db->next_record();
				$banner_ad = $db->f("settings_value");
			}

			// adaugam banner-ele
			if ($type == 1)
			{
				// html message
				$mail->Body .= "<BR><BR>" . $banner_ad;
				$mail->AltBody .= "\r\n\r\n" . $text_ad;
			}
			else
			{
				// text message
				$mail->Body .= "\r\n\r\n" . $text_ad;
			}
		} // sfarsit adaugare banner-e pt mesajele trimise de pe free account 

		if (! $mail->Send())
			error_page("Could not send message to $to_email");
	}

?>
<?php	

	include("global.inc");

	function mailfrom($fromaddress, $body, $headers)
	{
		$fp = popen("/usr/sbin/sendmail -t -f" . $fromaddress, "w");

		fputs($fp, $headers);
		fputs($fp, $body);
		fputs($fp, "\r\n");

		pclose($fp);
	}

	//$mailheaders  = "From: $user$SERVER_SUFFIX\r\n";
	//$mailheaders .= "Reply-To: $user$SERVER_SUFFIX\r\n";

	$mailheaders = "To: ".removecrlf($to)."\n";
	$mailheaders .= "Cc: ".removecrlf($cc)."\n";

	$mailheaders .= "X-Mailer: AeroMail (http://the.cushman.net/reverb/aeromail/)\r\n";

	$msg_body = stripslashes($body);

	if (( $attach != "none" ) && ( $attach != "" ) and (is_uploaded_file($attach)))
	{
		$file = fopen($attach, "r");
		$contents = fread($file, $attach_size);
		$encoded_attach = chunk_split(base64_encode($contents));
		fclose($file);
		
		$mailheaders .= "MIME-version: 1.0\r\n";
		$mailheaders .= "Content-type: multipart/mixed; ";
		$mailheaders .= "boundary=\"Message-Boundary\"\r\n";
		$mailheaders .= "Content-transfer-encoding: 7BIT\r\n";
		$mailheaders .= "X-attachments: $attach_name\r\n";

		$body_top = "--Message-Boundary\r\n";
		$body_top .= "Content-type: text/plain; charset=US-ASCII\r\n";
		$body_top .= "Content-transfer-encoding: 7BIT\r\n";
		$body_top .= "Content-description: Mail message body\r\n\r\n";

		$msg_body = $body_top . $msg_body;

		$msg_body .= "\r\n\r\n--Message-Boundary\r\n";
		$msg_body .= "Content-type: $attach_type; name=\"$attach_name\"\r\n";		
		$msg_body .= "Content-Transfer-Encoding: BASE64\r\n";
		$msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\r\n\r\n";
		$msg_body .= "$encoded_attach\r\n";
		$msg_body .= "--Message-Boundary--\r\n";
	}

	$mailheaders .= "Subject: " . removecrlf(stripslashes($subject)) . "\r\n\r\n";

	$from_user = $FORCE_FROM ? "$user@$IMAP_SERVER" : $user;

	mailfrom($from_user, $msg_body, $mailheaders);

	// add message to the sent mail folder


	if(is_string($SENT_MAIL))
	{
		$mailbox = mailbox_log_in($SENT_MAIL);
		$snt_folder = construct_folder_str($SENT_MAIL);

		if(imap_last_error())
		{
			//if there was an error, it was because there was no sent mail folder
			//we'll just create one here, then re-login

			imap_createmailbox($mailbox, "$IMAP_STR$snt_folder");
			$mailbox = mailbox_log_in($SENT_MAIL);
		}

		$waxer = imap_append($mailbox, "$IMAP_STR$snt_folder", "From: $user@$IMAP_SERVER\r\n" . $mailheaders . $msg_body);
	}

	header("Location: index.php?folder=" . urlencode($return));  

?>

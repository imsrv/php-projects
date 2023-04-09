<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	// gasim numele utilizatorului logat
	$db = new DB_Sql;
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	$email = $db->f("users_email");

	// request ammount == earned ammount (ii dam tot ce are :))
	$request_ammount = $db->f("users_earned_ammount");

	$mail = new phpmailer();
	$mail->From = "affiliates_program@_i-dont-exist.com";
	$mail->FromName = "affiliates program";
	$mail->AddAddress("webmaster@{sitename}");
	$mail->Subject = "Request money for affiliate program";
	$mail->IsHTML(true);
	$msg_body = "
				 <h3>Money Request:</h3>
				 id: $UserID <br>
				 name: $name <br>
				 email: $email <br>
				 request ammount: \$$request_ammount <br>
				 ";
	$mail->Body = $msg_body;

	if (! $mail->Send())
		error_page("Could not send message to webmaster");

	redirect("account.php");
?>
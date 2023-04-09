<?php
/* Nullified by WDYL-WTN */
	require("include/template.php");
	require("include/functions.php");
	require("include/phpmailer.php");

	if (!isset($fool_name) ||
		!isset($fool_email) ||
		!isset($fool_address) ||
		!isset($fool_city) ||
		!isset($fool_state) ||
		!isset($fool_zip) ||
		!isset($fool_phone) ||
		!isset($smart_name) ||
		!isset($smart_email) ||
		!isset($smart_address) ||
		!isset($smart_city) ||
		!isset($smart_state) ||
		!isset($smart_zip) ||
		!isset($smart_phone))
		error_page("Not enough data");

	$mail = new phpmailer();
	$mail->From = "2checkout@i-dont-exist.com";
	$mail->FromName = "2Checkout";
	$mail->AddAddress("webmaster@{sitename}");
	$mail->Subject = "new software instalation purchase made";
	$mail->IsHTML(true);
	$msg_body = "
				 <h2>Who bought:</h2>
				 name: $smart_name <br>
				 e-mail: $smart_email <br>
				 address: $smart_address <br>
				 city: $smart_city <br>
				 state: $smart_state <br>
				 zip: $smart_zip <br>
				 phone: $smart_phone <br>
				 <br>
				 <h2>Who paid:</h2>
				 name: $fool_name <br>
				 e-mail: $fool_email <br>
				 address: $fool_address <br>
				 city: $fool_city <br>
				 state: $fool_state <br>
				 zip: $fool_zip <br>
				 phone: $fool_phone <br>
				 ";
	$mail->Body = $msg_body;

	if (! $mail->Send())
		echo("Could not send message to webmaster");

	$template = new Template("templates/pay_installation_send_mail");
	$template->set_file("tpl_pay_installation_send_mail", "pay_installation_send_mail.tpl");

	$template->parse("output", "tpl_pay_installation_send_mail");
	$template->p("output");
?>
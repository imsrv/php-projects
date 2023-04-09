<?php
/* Nullified by WDYL-WTN */
	require("include/template.php");
	require("include/functions.php");
		
	$template = new Template("templates/pay_installation");
	$template->set_file("tpl_pay_installation", "pay_installation.tpl");

	// setam variabilele venite de pe 2checkout in form pt transmiterea ulterioara
	if (!isset($card_holder_name) ||
		!isset($email) ||
		!isset($street_address) ||
		!isset($city) ||
		!isset($state) ||
		!isset($zip) ||
		!isset($phone))
		error_page("You didn't came from 2checkout.com!");

	$template->set_var("FOOL_NAME", $card_holder_name);
	$template->set_var("FOOL_EMAIL", $email);
	$template->set_var("FOOL_ADDRESS", $street_address);
	$template->set_var("FOOL_CITY", $city);
	$template->set_var("FOOL_STATE", $state);
	$template->set_var("FOOL_ZIP", $zip);
	$template->set_var("FOOL_PHONE", $phone);

	$template->parse("output", "tpl_pay_installation");
	$template->p("output");
?>
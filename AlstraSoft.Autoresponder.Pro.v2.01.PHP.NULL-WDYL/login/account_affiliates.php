<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/account_affiliates");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	$earned_ammount = $db->f("users_earned_ammount");
	
	// cream pagina din template
	$template->set_file("tpl_account_affiliates", "account_affiliates.tpl");
	$template->set_var("USER_NAME", $name);

	// setam link-ul de afiliat
	global $SelfPath;
	$affiliate_link = $SelfPath . "signup.php?affiliate=$UserID";
	$template->set_var("AFFILIATE_LINK", $affiliate_link);

	// obtinem suma prag necesara obtinerii banilor
	$query = "SELECT settings_value
				FROM settings
				WHERE settings_name = 'affiliate_request_minimum' ";
	$db->query($query);
	
	if ($db->num_rows() != 1)
		error_page("unknown setting: affiliate_request_minimum");

	$db->next_record();
	$affiliate_request_minimum = $db->f("settings_value");
	$affiliate_request_minimum = intval($affiliate_request_minimum);

	$template->set_var("EARNED_AMMOUNT", $earned_ammount);

	// daca suma acumulata depaseste pragul minim, ii dam posibilitate sa ceara banii
	if ($earned_ammount >= $affiliate_request_minimum)
	{
		$template->set_file("tpl_request_money", "request_money.tpl");
		$template->parse("REQUEST_MONEY", "tpl_request_money");
	}
	
	// crearea output-ului propriu-zis
	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_account_affiliates");
	//$template->p("output");			
	require("template_make.php");
?>

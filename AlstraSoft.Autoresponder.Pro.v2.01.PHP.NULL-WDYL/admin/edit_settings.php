<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/affiliate_functions.php");
	
	$template = new Template("templates/edit_settings");
	$db = new DB_Sql;
	
	// cream pagina din template
	$template->set_file("tpl_edit_settings", "edit_settings.tpl");

	// setam campurile cu valorile variabilelor
	function SetSetting($tpl_var_name, $db_field_name)
	{
		global $db;
		global $template;

		$query = "SELECT settings_value
					FROM settings
					WHERE settings_name = '$db_field_name' ";
		$db->query($query);

		if ($db->num_rows() != 1)
			error_page("Could not find existing setting ($db_field_name) :)");

		$db->next_record();
		$template->set_var($tpl_var_name, $db->f("settings_value"));
	}

	SetSetting("FREEACCOUNT_NR_AUTORESPONSE_MESSAGES", "freeaccount_nr_autoresponse_messages");
	SetSetting("FREEACCOUNT_NR_FOLLOWUP_MESSAGES", "freeaccount_nr_followup_messages");
	SetSetting("FREEACCOUNT_NR_SUBSCRIBERS", "freeaccount_nr_subscribers");
	SetSetting("FREEACCOUNT_TEXT_AD", "freeaccount_text_ad");
	SetSetting("FREEACCOUNT_BANNER_AD", "freeaccount_banner_ad");

	SetSetting("PAIDACCOUNT_NR_AUTORESPONSE_MESSAGES", "paidaccount_nr_autoresponse_messages");
	SetSetting("PAIDACCOUNT_NR_FOLLOWUP_MESSAGES", "paidaccount_nr_followup_messages");
	
	// obtinem lista de nivele de afiliere
	$query = "SELECT * 
				FROM affiliatelevels
				ORDER BY affiliatelevels_level ";
	$db->query($query);
	$template->set_file("tpl_row_affiliate_level", "row_affiliate_level.tpl");

	while ($db->next_record())
	{
		$template->set_var("AFFILIATE_LEVEL_NR", $db->f("affiliatelevels_level"));
		$template->set_var("AFFILIATE_LEVEL_PRICE", $db->f("affiliatelevels_price"));
		$template->parse("AFFILIATE_LEVELS_LIST", "tpl_row_affiliate_level", true);
	}

	$max_affiliate_level = GetMaxAffiliateLevel();
	$template->set_var("NEW_AFFILIATE_LEVEL", $max_affiliate_level + 1);
	$template->set_var("MAX_AFFILIATE_LEVEL", $max_affiliate_level);

	// crearea output-ului propriu-zis
	$template->parse("output", "tpl_edit_settings");
	$template->p("output");			
?>

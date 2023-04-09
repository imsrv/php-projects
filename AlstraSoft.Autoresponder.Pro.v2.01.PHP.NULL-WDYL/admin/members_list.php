<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$template = new Template("templates/members_list");
	$db = new DB_Sql;
	if ($user!=""){$rt = " and  users_username='$user' or users_email='$user'";}
	// cream pagina din template
	$template->set_file("tpl_members_list", "members_list.tpl");

	// obtinem lista membrilor
	$template->set_file("tpl_member_row", "member_row.tpl");
	if ($show==1)
	{
		$query = "SELECT * 
					FROM users, accounttypes
					WHERE users_accounttype_id = accounttypes_id $rt
					ORDER BY users_name";
	}
	else
	{
		$query = "SELECT * 
					FROM users, accounttypes
					WHERE users_accounttype_id = accounttypes_id and users_general_id=users_id $rt
					ORDER BY users_name";
	}
	$db->query($query);

	$template->set_var("MEMBERS_NUMBER", $db->num_rows());

	if ($db->num_rows() == 0)
	{
		$template->set_file("tpl_row_none", "row_none.tpl");
		$template->parse("MEMBERS_LIST", "tpl_row_none");
		$template->set_var("MEMBERS_MENU", "");
	}
	else
	{
		while ($db->next_record())
		{
			$template->set_var("MEMBER_ID", $db->f("users_id"));
			$template->set_var("MEMBER_NAME", $db->f("users_name"));
			$template->set_var("MEMBER_USERNAME", $db->f("users_username"));
			$template->set_var("MEMBER_EMAIL", $db->f("users_email"));
			$template->set_var("MEMBER_ACCOUNTTYPE", $db->f("accounttypes_description"));
			$template->set_var("EARNED", $db->f("users_earned_ammount"));

			$template->parse("MEMBERS_LIST", "tpl_member_row", true);
		}

		// afisam meniu referitor la lista de subscrisi
		$template->set_file("tpl_members_menu", "members_menu.tpl");
		$template->parse("MEMBERS_MENU", "tpl_members_menu");
	}

	// afisam lista de account types
	$template->set_file("tpl_option", "option.tpl");

	$query = "SELECT * FROM accounttypes ORDER BY accounttypes_id ";
	$db->query($query);

	while ($db->next_record())
	{
		$template->set_var("VALUE", $db->f("accounttypes_id"));
		$template->set_var("DESCRIPTION", $db->f("accounttypes_description"));

		$template->parse("ACCOUNTTYPE_LIST", "tpl_option", true);
	}

	// crearea output-ului propriu-zis
	$template->parse("output", "tpl_members_list");
	$template->p("output");			
?>

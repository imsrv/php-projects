<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/prospects_variables");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_prospects_variables", "prospects_variables.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de variabile
	$template->set_file("tpl_variable_row", "variable_row.tpl");

	$query = "SELECT * FROM variables
				WHERE variables_user_id = '$UserID' 
				ORDER BY variables_name ";
	$db->query($query);

	$template->set_var("VARIABLES_NUMBER", $db->num_rows());

	if ($db->num_rows() == 0)
	{
		$template->set_file("tpl_row_none", "row_none.tpl");
		$template->parse("VARIABLES_LIST", "tpl_row_none");
		$template->set_var("LIST_MENU", "");
	}
	else
	{
		while ($db->next_record())
		{
			$template->set_var("VARIABLE_ID", $db->f("variables_id"));
			$template->set_var("NAME", $db->f("variables_name"));
			$template->set_var("VALUE", $db->f("variables_value"));

			$template->parse("VARIABLES_LIST", "tpl_variable_row", true);
		}

		// afisam meniu referitor la lista de subscrisi
		$template->set_file("tpl_list_menu", "list_menu.tpl");
		$template->parse("LIST_MENU", "tpl_list_menu");
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_prospects_variables");
	require("template_make.php");
?>

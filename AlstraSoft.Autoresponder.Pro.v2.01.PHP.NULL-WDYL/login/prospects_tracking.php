<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$template = new Template("templates/prospects_tracking");
	$db = new DB_Sql;
	
	// gasim numele utilizatorului logat
	$query = "SELECT * 
				FROM users 
				WHERE users_id = '$UserID'";
	$db->query($query);
	$db->next_record();
	$name = $db->f("users_name");
	
	// cream pagina din template
	$template->set_file("tpl_prospects_tracking", "prospects_tracking.tpl");
	$template->set_var("USER_NAME", $name);

	// obtinem lista de adrese de unde au venit subscrisii
	$template->set_file("tpl_address_row", "address_row.tpl");
	$template->set_file("tpl_address_unknown", "address_unknown.tpl");

	$query = "SELECT 
					subscribers_came_from, 
					COUNT(*) AS TOTAL
				FROM subscribers
				WHERE subscribers_user_id = '$UserID'
				GROUP BY subscribers_came_from
				ORDER BY TOTAL DESC ";
	$db->query($query);

	if ($db->num_rows() == 0)
	{
		$template->set_file("tpl_row_none", "row_none.tpl");
		$template->parse("ADDRESS_LIST", "tpl_row_none");
	}
	else
	{
		while ($db->next_record())
		{
			$address = $db->f("subscribers_came_from");

			$template->set_var("ADDRESS", $address);
			$template->set_var("TOTAL", $db->f("TOTAL"));

			if ($address != "")
				$template->parse("ADDRESS_LIST", "tpl_address_row", true);
			else
				$template->parse("ADDRESS_LIST", "tpl_address_unknown", true);
		}
	}

	// crearea output-ului propriu-zis
	$template->parse("content", "tpl_prospects_tracking");
	require("template_make.php");
?>

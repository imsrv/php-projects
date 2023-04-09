<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	$template = new Template("templates/statistics");
	$db = new DB_Sql;
	
	// cream pagina din template
	$template->set_file("tpl_statistics", "statistics.tpl");

	// obtinem lista membrilor
	$template->set_file("tpl_member_row", "member_row.tpl");

	$query = "SELECT * FROM users ORDER BY users_name ";
	$db->query($query);

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
			$template->set_var("MEMBER_NAME", $db->f("users_name"));
			$template->set_var("MEMBER_USERNAME", $db->f("users_username"));
			$template->set_var("SENT_TOTAL", MailsSentToday($db->f("users_id")));

			$template->parse("MEMBERS_LIST", "tpl_member_row", true);
		}
	}

	// crearea output-ului propriu-zis
	$template->parse("output", "tpl_statistics");
	$template->p("output");			
?>

<?php
	function MailsSentToday($user_id)
	{
		$db = new DB_Sql;

		$query = "SELECT COUNT(messages_id) AS NR_MESSAGES
					FROM users
					LEFT JOIN messages ON
						users_id = messages_user_id
					WHERE users_id = '$user_id'
					ORDER BY users_name";
		$db->query($query);

		$total_messages = 0;
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$total_messages += $db->f("NR_MESSAGES");
		}
		
		return $total_messages;
	}
?>
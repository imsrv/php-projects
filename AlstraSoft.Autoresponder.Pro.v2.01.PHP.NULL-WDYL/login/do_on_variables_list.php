<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// ** COMPLETELY REMOVE SELECTED VARIABLES ** 

	if (isset($variable_check))
		foreach ($variable_check as $variable_id => $value)
		{
			$query = "DELETE FROM variables
						WHERE 
							variables_user_id = '$UserID' AND
							variables_id = '$variable_id'";
			$db->query($query);
		}

	redirect("prospects_variables.php");
?>
<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// obtinem datele despre noua varibila:	$variable_name, $variable_value
	AssumeIsNotEmpty($variable_name, "Variable name must not be empty");
	AssumeIsString($variable_name, "Variable name is not a valid string");
	AssumeIsNotEmpty($variable_value, "Variable value must not be empty");
	AssumeIsString($variable_value, "Variable value is not a valid string");
//	$variable_name = str_replace("'", "''", $variable_name);
//	$variable_value = str_replace("'", "''", $variable_value);

	// verificam daca nu exista deja o variabila cu numele dat
	$query = "SELECT * 
				FROM variables 
				WHERE 
					variables_user_id = '$UserID' AND
					variables_name = 'pre_$variable_name' ";
	$db->query($query);

	if ($db->num_rows() > 0)
		error_page("A variable with the specified name already exists!");

	// adaugam variabila
	$query = "INSERT INTO variables (
				variables_user_id, 
				variables_name, 
				variables_value
				) VALUES (
				'$UserID', 
				'pre_$variable_name', 
				'$variable_value') ";
	$db->query($query);

	redirect("prospects_variables.php");
?>
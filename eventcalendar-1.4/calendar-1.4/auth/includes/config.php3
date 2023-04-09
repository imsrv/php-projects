<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: config.php3,v 1.4 2001/05/27 23:27:02 fluffy Exp $  

if (!isSet($CONFIG_INCLUDED))
{
	$CONFIG_INCLUDED = 1;

	include('sql/sql.php3');
	include('error/error.php3');

	/* This is called down below... */
	function loadCalConfig()
	{
		$config;

		if (!$my_conn = @connectROToCalendar())
		{
			reportError($php_errormsg,
"while connecting to the database to load the configuration");
			return 0;
		}

		$my_query = "SELECT * FROM srcconfig";

		if (!$result_id = @pg_exec($my_conn, $my_query))
		{
			reportError($php_errormsg,
"while searching the database for configuration info");
			return 0;
		}

		$num_rows = pg_numRows($result_id);
		for ($index = 0; $index < $num_rows; $index++)
		{
			$array = pg_fetch_array($result_id, $index);
			$config[$array["key"]] = $array["value"];
		}

		return $config;
	}
}
?>

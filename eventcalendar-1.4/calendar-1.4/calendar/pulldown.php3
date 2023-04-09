<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: pulldown.php3,v 1.4 2001/05/27 23:27:02 fluffy Exp $  

if (!$PULLDOWN_INCLUDED)
{
	$PULLDOWN_INCLUDED = 1;

// This function outputs a pull-down menu for a form, using two columns
// from a table.  This is used in the submit forms so the names can be
// displayed in the pulldown, but the ID stored in the event
	function outputPulldownFromTable($db_conn, $table, $value_col,
		$label_col, $name = "", $selection = "")
	{
		if (!isSet($name))
		{
			$name = $table;
		}

		$query = "SELECT * from $table ORDER BY $label_col";

		if (!$result_id = @pg_exec($db_conn, $query))
		{
			return $php_errormsg;
		}

		echo("<SELECT NAME=\"" . $name . "\">\n");
		$index = 0;

		if (isSet( $GLOBALS[$name]))
		{
			$selected = $GLOBALS[$name];
		}
		else
		{
			$selected = "";
		}

		while ($option = @pg_fetch_array($result_id, $index++))
		{
			echo("<OPTION VALUE=\"" . $option[$value_col] . "\"" .
				($selection != "" ?
					($option[$value_col] == $selection ?
						" SELECTED" : "") :
					($option[$value_col] == $selected ?
						" SELECTED" : ""))
				. ">");
			echo($option[$label_col] . "\n");
		}

		echo("</SELECT>\n");

		return 0;
	}

	function parsePulldown($name)
	{
		return $GLOBALS[$name];
	}
}
?>

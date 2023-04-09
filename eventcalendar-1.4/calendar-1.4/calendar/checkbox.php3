<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: checkbox.php3,v 1.4 2001/05/27 23:27:02 fluffy Exp $

if (!$CHECKBOX_INCLUDED)
{
	$CHECKBOX_INCLUDED = 1;

// This function outputs a pull-down menu for a form, using two columns
// from a table.  This is used in the submit forms so the names can be
// displayed in the pulldown, but the ID stored in the event
	function outputCheckboxFromTable($db_conn, $table, $value_col,
		$label_col, $name = "", $row_width = 0, $include_default = 0,
		$default = 0, $sort = 1, $selections = "")
	{
// if we're not given a name, we'll assume the table name
		if (!isSet($name))
		{
			$name = $table;
		}

// set up an array to easily determine which boxes are checked
		if ($selections)
		{
			for ($i = 0; $i < count($selections); $i++)
			{
				$selected[strval($selections[$i])] = 1;
			}
		}

// fetching label and value from the given table, excluding the default where necessary
		$query = "SELECT * FROM $table " .
			($include_default ? "" : "WHERE $value_col != $default ") .
			($sort ? "ORDER BY $label_col" : "");

		if (!($result_id = @pg_exec($db_conn, $query)))
		{
			return $php_errormsg;
		}

		$num_items = pg_numrows($result_id);
// if we have a row width, we'll use a table, otherwise we'll just spit them out
		if ($row_width)
		{
			echo("<TABLE>\n<TR ALIGN=left>\n");
			$column = 0;
		}

		for ($index = 0; $index < $num_items; $index++)
		{
			$option = @pg_fetch_array($result_id, $index);

			if($row_width)
			{
				if ($column >= $row_width)
				{
					echo("</TR>\n<TR ALIGN=left>");
					$column = 0;
				}
				echo("<TD>");
				$column++;
			}

// have a checkbox
			echo("<INPUT TYPE=checkbox NAME=\"" .
				$name . "_" . $index . "\" VALUE=\"" .
				$option[$value_col] . "\"" .
				(isSet($selected) ?
					(isSet($selected[strval($option[$value_col])]) ?
						" CHECKED>" : ">") :
					(isSet($GLOBALS[$name . "_" . $index]) ?
						" CHECKED>" : ">")));

			echo($option[$label_col] . "\n");
			if ($row_width)
			{
				echo("</TD>");
			}
		}

		echo("</TR>\n");
		echo("</TABLE>\n");
		echo("<INPUT TYPE=hidden NAME=\"" . $name . "_count\"" .
			" VALUE=$num_items>\n");

		return 0;
	}

	function parseCheckbox($name, $default = 0)
	{
		$result_count = 0;
		$num_items = $GLOBALS[$name . "_count"];

// if the outputCheckbox function was used, we'll have some globals we
//  can parse to get our results
		for ($i = 0; $i < $num_items; $i++)
		{
			if (isSet($GLOBALS[$name . "_" . $i]))
			{
				$results[$result_count++] =
					$GLOBALS[$name . "_" . $i];
			}
		}

		if ($result_count)
		{
			 return $results;
		}
		else
		{
			 return $default;
		}
	}
}
?>

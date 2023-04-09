<HTML><BODY>
<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: genIndex.php3,v 1.8 2001/05/27 23:27:02 fluffy Exp $

include('sql/sql.php3');
include('error/error.php3');
include('gettext.php3');

function genIndex()
{
	$database_name = "srccalendar";
	$index_table_name = "srcindex";
	$event_table_name = "srcevent";
	$weekday_list_table_name = "srcweekdaylist";

	$db_conn = connectRWToCalendar();
	$query = "SELECT E.event_id, E.start_time, E.end_time, W.day from " .
		$event_table_name . " E, " . $weekday_list_table_name . " W " .
		"WHERE W.event_id = E.event_id";

	$select = pg_exec($db_conn, $query);
	$num_rows = pg_numrows($select);

        echo(_wv("%s1 rows selected.", array($num_rows)) . "<BR>");

	$foo = pg_exec($db_conn, "BEGIN WORK");
	$foo = pg_exec($db_conn, "delete from srcindex");

	for ($i = 0; $i < $num_rows; $i++)
	{
		$cur_row = pg_fetch_array($select, $i);
		$event_id = $cur_row["event_id"];
		$start_time = $cur_row["start_time"];
		$end_time = $cur_row["end_time"];
		$weekday_id = $cur_row["day"];
		$inserted = 0;

		echo("Row $i, event:$event_id, Time:$start_time - $end_time, $weekday_id <BR>\n");
		echo(date("F j, Y, h:i A", $start_time) . " - " .
			date("F j, Y, h:i A", $end_time) . "<BR>\n");

		$start_date = mktime(0, 0, 0, date("m", $start_time),
			date("j", $start_time), date("Y", $start_time));

		if ($end_time)
		{
			$end_date = mktime(0, 0, 0, date("m", $end_time),
				date("j", $end_time), date("Y", $end_time));
		}

		if ((!$end_time) || ($end_date == $start_date))
		{
			InsertIndexRow($event_id, $start_date, $db_conn,
				$index_table_name);
			$inserted = 1;
		}
		else
		{
			$current_date = mktime(0, 0, 0, date("m", $start_date),
				date("j", $start_date) + $weekday_id -
				date("w", $start_date) +
				(date("w",$start_date) > $weekday_id ? 7 : 0),
				date("Y", $start_date));
			while ($current_date <= $end_date)
			{
				InsertIndexRow($event_id, $current_date,
					$db_conn, $index_table_name);
				$inserted = 1;
				$current_date = mktime(0, 0, 0,
					date("m", $current_date),
					date("j", $current_date) + 7,
					date("Y", $current_date));
			}
		}

		if (!$inserted)
		{
			echo("<B>" . _("ERROR") . "</B><BR>\n");
		}
	}

	if ($GLOBALS["debug"])
	{
		$foo = pg_exec($db_conn, "ROLLBACK WORK");
	}
	else
	{
		$foo = pg_exec($db_conn, "COMMIT WORK");
	}

	echo(_("Index generation completed.") . "\n");
}

function InsertIndexRow($event_id, $timestamp, $db_conn, $index_name)
{
	$query = "INSERT into $index_name ( event_id, timestamp ) VALUES (" .
		" $event_id , $timestamp )";
	echo($query . " - " . date("F j, Y, h:i A", $timestamp) . "<BR>\n");
	$result_id = pg_exec($db_conn, $query);
	if (!pg_cmdtuples($result_id))
	{
		reportError($php_errormsg, "while inserting an index row");
		pg_exec($db_conn, "ROLLBACK WORK");
		exit;
	}
}

if (isSet($genIndex))
{
	genIndex();
}
else
{
	echo("<FORM METHOD=GET>\n");
	echo("<INPUT TYPE=hidden NAME=\"genIndex\" VALUE=\"go for it\">\n");
	echo(_("Click the submit button to regenerate your calendar's index."));
	echo("<BR>\n<INPUT TYPE=submit>\n");
	echo("</FORM>");
}
?>

</BODY></HTML>

<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: calendar-box.php3,v 1.13 2001/05/30 23:00:13 fluffy Exp $

if (!isSet($CALENDAR_BOX_INCLUDED))
{
	$CALENDAR_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('sql/sql.php3');
	include('event.php3');
	include('gettext.php3');

	class SRCCalendarBox extends SRCBox
	{

		function SRCCalendarBox($new_action_url = "",
				$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 1;
			$this->help_available = 1;
			$this->help_topic = _("The Month View");
			$this->error = "";
		}

		function outputBox()
		{
// For some reason the vars set in updateVars
//   don't stick unless run from parseBox()
			if (!isSet($this->event_index))
			{
				$this->updateVars();
			}

			$this->outputCalendar();
		}

		function parseBox()
		{
			if (isSet($GLOBALS["view_unapproved"]))
			{
				if ($GLOBALS["view_unapproved"] != "no")
				{
					setCookie("SRCViewUnapproved", "1",
						(mktime() + 31536000), "/");
					$GLOBALS["SRCViewUnapproved"] = 1;
				}
				else
				{
					setCookie("SRCViewUnapproved", "", "",
						"/");
					unset($GLOBALS["SRCViewUnapproved"]);
				}
			}

			$this->updateVars();

			if ($GLOBALS["text_only"])
			{
				$this->outputResults();
				exit;
			}
		}

		function updateVars()
		{
			$this->approved_only = !($GLOBALS["SRCViewUnapproved"]
					&& !$GLOBALS["oc_remote_host"]);

// If the timestamp isn't set, get the current time
//  and add any additional time arguments
			if (!$GLOBALS["timestamp"])
			{
				$temp_stamp = mktime();
				$temp_date = getDate($temp_stamp);
				if (isSet($GLOBALS["month"]))
				{
					$temp_date["mon"] = $GLOBALS["month"];
				}
				if (isSet($GLOBALS["date"]))
				{
					$temp_date["mday"] = $GLOBALS["date"];
				}
				if (isSet($GLOBALS["year"]))
				{
					$temp_date["year"] = $GLOBALS["year"];
				}
				$temp_stamp = mktime($temp_date["hours"],
					$temp_date["minutes"],
					$temp_date["seconds"],
					$temp_date["mon"],
					$temp_date["mday"],
					$temp_date["year"]);
			}
			else
			{
				$temp_stamp = $GLOBALS["timestamp"];
			}

// change the timestamp to the beginning of the month
			$temp_stamp = mktime(0, 0, 0, date("m", $temp_stamp),
				1, date("Y", $temp_stamp));
// get date array for the beginning of the month
			$this->month_begin = $temp_stamp;

// beginning of the last day of the month
			$temp_stamp = mktime(0, 0, 0, date("m", $temp_stamp)+1,
				0, date("Y", $temp_stamp));
			$this->month_end = $temp_stamp;
			$this->event_index = $this->fetchIndex(
				$this->month_begin, $this->month_end); 

		}


		function outputResults()
		{
			switch ($GLOBALS["cal_view"])
			{
				case "detail":
					$this->outputDetailView(
						$GLOBALS["event_id"], 1);
					break;
				case "day":
					$this->outputDayView(1);
// Messy text-only view
					if (!$GLOBALS["text_only"])
					{
						$this->outputTextOnlyLink();
					}
					break;
				case "week":
					$this->outputDayView(7);
					if (!$GLOBALS["text_only"])
					{
						echo("<HR>");
						$this->outputTextOnlyLink();
					}
					break;
				case "weekday":
					$this->outputWeekdayView(
						$GLOBALS["weekday"]);
					break;
				case "month":
					$this->outputMonthView(
						$this->month_begin);
					break;
				default:
					$this->outputDayView(1);
					if (!$GLOBALS["text_only"])
					{
						echo("<HR>");
						$this->outputTextOnlyLink();
					}
			}
		}

// This just needs to spit out a link that sets the "text_only" var
		function outputTextOnlyLink()
		{
			echo(_wv("View these events as %s1text-only%s2.",
				array("<A HREF=\"" . $this->action_url .
					"&amp;text_only=1" .
					(isSet($GLOBALS["timestamp"]) ?
					"&amp;timestamp=" . $GLOBALS["timestamp"]
					: "") .
					(isSet($GLOBALS["cal_view"]) &&
					$GLOBALS["cal_view"] != "detail" ?
					"&amp;cal_view=" . $GLOBALS["cal_view"]
					: "") . "\">",
					"</A>")) . "<BR>\n");
		}

		// Output a centered header with the month and year
		//  that is a link to the month view
		function outputCalMonthHeader($month_stamp)
		{
			echo("<H2 ALIGN=\"center\"><A HREF=\"" .
				$this->action_url . "&amp;timestamp=" .
				$month_stamp . "&amp;cal_view=month\">" .
				ucfirst(strftime("%B&nbsp;%Y",
				$month_stamp)) . "</A></H2>\n");
		}

		// output a table row with the names of days of the week
		// with an optional empty first cel
		function outputCalWeekdayRow($spacer = 1)
		{
			echo("<TR>\n" . ($spacer ? "<TD> </TD>\n" : ""));

			$sunday_stamp = $this->month_begin -
				(86400 * strftime("%w", $this->month_begin));

			for ($i = 0; $i < 7; $i++)
			{
// week headers are links to the week view
				echo("<TD ALIGN=\"center\"><A HREF=\"" .
					$this->action_url . "&amp;timestamp=" .
					$this->month_begin .
					"&amp;cal_view=weekday" .
					"&amp;weekday=" . $i . "\">");
				echo(strftime("%a",
					$sunday_stamp + (86400 * $i)));
				echo("</A></TD>\n");
			}

			echo("</TR>\n");
		}

		// output table rows with the numbered days of the week
		// with an optional "Week #" first cel
		function outputCalRows($month_stamp, $spacer = 1)
		{
// today used to make today's header red
			$today = mktime(0, 0, 0);

// get date array for the beginning of the month
			$month_begin = getDate($month_stamp);

			$current_weekday = $month_begin["wday"];
			$current_date = 1;
			$current_week = 1;

// display the "week #" link
// there's an if here to keep the first "week #" from being
// output twice when the month starts on sunday.
			if ($current_weekday)
			{
				echo("<TR>\n<TD>" .
					"<A HREF=\"$this->action_url" .
					"&amp;cal_view=week&amp;timestamp=" .
					mktime( 0, 0, 0, $month_begin["mon"],
					$current_date, $month_begin["year"] ) .
					"\">" . _("Week") .
					"&nbsp;$current_week</A></TD>\n");
			}

// blanks spaces up to the first day of the month
			for ($i = $current_weekday; $i > 0; $i--)
			{
				echo("<TD> </TD>\n");
			}

// and we go through all the numbers until the date is invalid
			while (checkDate($month_begin["mon"], $current_date,
				$month_begin["year"]))
			{
				$current_stamp = mktime(0, 0, 0,
					$month_begin["mon"], $current_date,
					$month_begin["year"]);

				if (!$current_weekday)
				{
					echo("<TR>\n<TD>" .
						"<A HREF=\"$this->action_url" .
						"&amp;cal_view=week" . 
						"&amp;timestamp=" .
						$current_stamp .
						"\">" . _("Week") .
						"&nbsp;$current_week</A>" .
						"</TD>\n");
				}

				echo("<TD ALIGN=\"center\">");
				echo("<A HREF=\"$this->action_url&amp;cal_view=day&amp;timestamp=" .
					$current_stamp . "\" " .
					($current_stamp == $today ? " CLASS=red>"
					: (isSet($this->event_index[$current_stamp])
						? " CLASS=green>" : ">"))
					. "$current_date</A>");
				echo("</TD>\n");
				$current_date++;
				if (++$current_weekday >= 7)
				{
					$current_weekday = 0;
					$current_week++;
					echo("</TR>\n");
				}
			}

		}

		// Output a centered footer with links for previous
		//  and next months
		function outputCalPrevNextMonthFooter($month_stamp)
		{
// get date array for the beginning of the month
			$month_begin = getDate($month_stamp);

			echo("<A HREF=\"$this->action_url&amp;cal_view=month" .
				"&amp;timestamp=" .
				mktime(0, 0, 0, ($month_begin["mon"] - 1), 1,
				$month_begin["year"]) ."\">");
			echo(_("Previous month"));
			echo("</A> | ");
			echo("<A HREF=\"$this->action_url&amp;cal_view=month&amp;timestamp=" .
				mktime(0, 0, 0, ($month_begin["mon"] + 1), 1,
				$month_begin["year"] ) . "\">");
			echo(_("Next month"));
			echo("</A>\n");
		}

		// Output a link to view or hide unapproved events
		function outputCalViewHideUnapproved()
		{
			$link = $this->action_url . "&amp;view_unapproved=";

			if ($GLOBALS["SRCViewUnapproved"])
			{
				$link .= "no";
			}
			else
			{
				$link .= "yes";
			}

			if (isSet($GLOBALS["timestamp"]))
			{
				$link .= "&amp;timestamp=" .
					$GLOBALS["timestamp"];
			}

			if (isSet($GLOBALS["cal_view"]) &&
				($GLOBALS["cal_view"] != "detail"))
			{
				$link .= "&amp;cal_view=" .
					$GLOBALS["cal_view"];
			}

			echo("<A HREF=\"" . $link . "\">");

			if ($GLOBALS["SRCViewUnapproved"])
			{
				echo(_("Hide unapproved events."));
			}
			else
			{
				echo(_("View unapproved events."));
			}

			echo("</A>");
		}

		function outputCalendar()
		{
// output some HTML
// title and week headers first
			$this->outputCalMonthHeader($this->month_begin);

			echo("<TABLE BORDER ALIGN=\"center\">\n");

			$this->outputCalWeekdayRow();

			$this->outputCalRows($this->month_begin);

			echo("</TABLE>\n");

// some more stuff beneath the calendar
// next month and previous month links
			echo("<P ALIGN=\"center\">\n");

			$this->outputCalPrevNextMonthFooter($this->month_begin);

// let people look at unapproved events if they're on campus
			if(!$GLOBALS["oc_remote_host"])
			{
				echo("<BR>");
				$this->outputCalViewHideUnapproved();
			}
		}

// Thanks to Bruce Tenison for the following function that searches for
// events on the date of a timestamp, returning 1 for events present,
// and 0 for no events.
//
// Modified heavily by me to check the index table and return a hash with
//  event IDs for a range of dates.  The hash uses the timestamp as the
//  key and an array of event IDs for the value.
		function fetchIndex($startstamp, $endstamp)
		{
			if (!($my_conn = connectROToCalendar()))
			{
				$during = "while connecting to the calendar database";
				reportError($php_errormsg, $during);
				return;
			}

			$my_query = "";

// See if we need to consult srcevent for approval or hide_oc
			if ($this->approved_only || $GLOBALS["oc_remote_host"])
			{
				$my_query = "SELECT I.event_id as event_id, " .
					"I.timestamp as timestamp " .
					"FROM srcindex I, srcevent E " .
					"WHERE ";

				if ($endstamp)
				{
					$my_query .= "( I.timestamp >= " .
						$startstamp . " ) AND ( " .
						"I.timestamp <= " . $endstamp .
						" )";
				}
				else
				{
					$my_query .= "I.timestamp = " .
						$startstamp;
				}

				if ($this->approved_only)
				{
					$my_query .=
						" AND E.approver_id notNull ";
				}

				if ($GLOBALS["oc_remote_host"])
				{
					$my_query .= " AND E.hide_oc isNull ";
				}

				$my_query .= " AND E.event_id = I.event_id " .
					"ORDER BY I.timestamp ASC";
			}
			else
			{
				$my_query = "SELECT * FROM srcindex WHERE ";

				if ($endstamp)
				{
					$my_query .= "( timestamp >= " .
						$startstamp .
						" ) AND ( timestamp <= " .
						$endstamp . " ) ";
				}
				else
				{
					$my_query .= " timestamp = " .
						$startstamp;
				}

				$my_query .= " ORDER BY timestamp ASC";
			}

			if (!($result_id = @pg_exec($my_conn, $my_query)))
			{
				$during = "while searching the event database";
				$error = $php_errormsg . " -QUERY= " . $my_query;
				reportError($error, $during);
				return;
			}

			$num_rows = pg_NumRows($result_id);
			$currentstamp = 0;
			$j = 0;
			for ($i = 0; $i < $num_rows; $i++)
			{
				$stuff = pg_fetch_array($result_id, $i);
				if ($stuff["timestamp"] != $currentstamp)
				{
					$found[$currentstamp] = $events;
					$currentstamp = $stuff["timestamp"];
					$j = 0;
					unset($events);
				}
				$events[$j++] = $stuff["event_id"];
			}
			$found[$currentstamp] = $events;

			return $found;
		}

// this function is pretty simple, just checks the index for event IDs
		function outputDayView($num_days=1)
		{
// we've got a timestamp, a number of days, and whether or not to display
// unapproved stuff.
			global $timestamp;
			$today = mktime(0, 0, 0);

			if (!isSet($timestamp))
			{
				$timestamp = mktime();
			}

			if (!($my_conn = connectROToCalendar()))
			{
				$during = "while connecting to the calendar database";
				reportError($php_errormsg, $during);
				return;	
			}

// for each day...
			for ($i = 0; $i < $num_days; $i++)
			{
				if(!$GLOBALS["text_only"])
				{
					if ($i)
					{
						echo("<HR>\n");
					}
				}

				$current_stamp = mktime(0, 0, 0,
					date("m", $timestamp),
					(date("j", $timestamp) + $i),
					date("Y", $timestamp));
				$date = ucwords(strftime("%A, %B %d, %Y", $current_stamp));
				$use_red = ($current_stamp == $today);

// we only need the event_id, title, and starting time to display the short info
// in text-only we only need the event_id, since we create an event object from that
//  but there's no point in pulling out the other stuff
				if(isSet($this->event_index[$current_stamp]))
				{
					$events = $this->event_index[$current_stamp];

					$my_query = "SELECT event_id, title, " .
						"start_time FROM srcEvent WHERE ";

					for($q = 0; $q < count($events); $q++)
					{
						if ($q)
						{
							$my_query .= " OR ";
						}
						$my_query .= " event_id = " .
							$events[$q];
					}

					$my_query .= " ORDER BY start_time ASC";

					if (!($result_id = @pg_exec($my_conn, $my_query)))
					{
						$during = "while searching the event database";
						reportError($php_errormsg, $during);
						return;
					}

					$num_rows = pg_NumRows($result_id);
					if (!$num_rows)
					{
reportError("The event index listed events, but none were found.");
						return;
					}

					if(!$GLOBALS["text_only"])
					{
						echo("<BIG CLASS=\"" .
							($use_red ? "red"
							: "green") .
							"\">" . $date.  
							"</BIG><BR>\n");
						echo("<EM>");
						if ($num_rows == 1)
						{
							echo(_("1 event found."));
						}
						else
						{
							echo(_wv("%s1 events found.",
								array($num_rows)));
						}
						echo("</EM><BR><UL>\n");
					} else {
						echo("<BIG>$date</BIG>\n");
					}

// fetch the results and output the short info,
//  or if in text-only, create a new event object and output the text-only form
					for ($j = 0; $j < $num_rows; $j++)
					{
						$current_event = pg_fetch_object($result_id, $j);
						if ($GLOBALS["text_only"])
						{
$event = new SRCEventWithStringsFromEventID($current_event->event_id);
$event->outputTextOnly();
						}
						else
						{
							echo("<LI>\n" .
"<A HREF=\"$this->action_url" . "&amp;timestamp=$timestamp&amp;cal_view=detail&amp;" .
"event_id=$current_event->event_id\">" . $current_event->title . "</A>\n" .
								"</LI>\n" );
						}
					}
					if (!$GLOBALS["text_only"])
					{
						echo("</UL>\n");
					}
				}
				else
				{
					if (!$GLOBALS["text_only"])
					{
						echo("<BIG" . ($use_red ?
							" CLASS=\"red\">"
							: ">" ) . $date .
							"</BIG><BR>\n" .
							"<EM>");
					        echo(_( "No events for today."));
						echo("</EM><BR>\n");
					}
				}
			}
		}

// here we only want a certain day of the week
		function outputWeekdayView($weekday = 0)
		{
			$current_stamp = $this->month_begin;

// Get us to the first day of the month of the given weekday
			$year = date("Y", $current_stamp);
			$month = date("m", $current_stamp);
			$date = 1 + $weekday - date("w", $current_stamp)
				+ (date("w", $current_stamp) > $weekday ? 7 : 0);
			$current_stamp = mktime(0, 0, 0, $month, $date, $year);
			
// Header
			echo("<BIG>");
			echo(_wv("Events on %s1 in %s2",
				array(
					date("l", $current_stamp),
					date("F", $current_stamp)))
				. "</BIG><BR>\n");

// Searching the index
			$j = 0;	
			while (checkdate($month, $date, $year))
			{
				$current_stamp = mktime(0, 0, 0,
					$month, $date, $year);
				if (isSet($this->event_index[$current_stamp]))
				{
					$events = $this->event_index[$current_stamp];
					for ($i = 0; $i < count($events); $i++)
					{
						$found[$j++] = $events[$i];
					}
				}
				$date += 7;
			}

// No events listed in the index
			if (!$j)
			{
				echo("<EM>");
				echo(_( "No events found."));
				echo("</EM><BR>\n");
				return;
			}

// There were some events.  Lets sort them and get rid of duplicates
			sort($found);
			$j = 0;
			for ($i = 0; $i < count($found); $i++)
			{
				if ($found[$i] != $found[$i+1])
				{
					$unique[$j++] = $found[$i];
				}
			}
			$unique[$j] = $found[$i++];

			if (!$my_conn = connectROToCalendar())
			{
				$during = "while connecting to the calendar database";
				reportError($php_errormsg, $during);
				return;	
			}

			$my_query = "SELECT event_id, title, start_time ";
			$my_query .= " FROM srcEvent WHERE event_id IN (";
			for ($q = 0; $q < count($unique); $q++)
			{
				if ($q && ($unique[$q] != ""))
				{
					$my_query .= ", ";
				}
				$my_query .= $unique[$q];
			}
			$my_query .= ") ORDER BY start_time ASC";

			if (!($result_id = @pg_exec($my_conn, $my_query)))
			{
				$during = "while searching the event database";
				reportError($php_errormsg . " QUERY = $my_query", $during);
				return;
			}

			$num_rows = pg_NumRows($result_id);
			if (!$num_rows)
			{
reportError("The event index listed events, but none were found.");
				return;
			}

			echo("<EM>");
			if ($num_rows > 1)
			{
				echo(_("1 event found."));
			}
			else
			{
				echo(_wv("%s1 events found.",
					array($num_rows)));
			}
			echo("</EM><BR><UL>\n");

			for ($j = 0; $j < $num_rows; $j++)
			{
// fetch some results and output the short info
				$current_event = pg_fetch_object(
					$result_id, $j);
				echo("<LI>\n" .
"<A HREF=\"$this->action_url" . "&amp;timestamp=" . $GLOBALS["timestamp"]
. "&amp;cal_view=detail&amp;event_id=$current_event->event_id\">" .
$current_event->title . "</A>\n" . "</LI>\n");
			}
			echo("</UL>\n");
		}

// let's look at the whole month
		function outputMonthView($month_stamp = 0)
		{
			if(!$month_stamp)
			{
				$month_stamp = $this->month_begin;
			}

			$year = date("Y", $month_stamp);
			$month = date("m", $month_stamp);
			$date = 1;

// Header
			echo("<BIG>");
			echo(_wv("Events in %s1",
				array(ucwords(strftime("%B, %Y", $month_stamp)))
			));
			echo("</BIG><BR>\n");

// Searching the index
			$j = 0;	
			while (checkdate($month, $date, $year))
			{
				$current_stamp = mktime(0, 0, 0,
					$month, $date, $year);
				if (isSet($this->event_index[$current_stamp]))
				{
					$events = $this->event_index[$current_stamp];
					for($i=0; $i < count($events); $i++)
					{
						$found[$j++] = $events[$i];
					}
				}
				$date++;
			}

// No events listed in the index
			if (!$j)
			{
				echo("<EM>");
				echo(_( "No events found."));
				echo("</EM><BR>\n");
				return;
			}

// There were some events.  Lets sort them and get rid of duplicates
			sort($found);
			$j = 0;
			for($i = 0; $i < count($found); $i++)
			{
				if ($found[$i] != $found[$i+1])
				{
					$unique[$j++] = $found[$i];
				}
			}
			$unique[$j] = $found[$i++];

			if (!($my_conn = connectROToCalendar()))
			{
				$during = "while connecting to the calendar database";
				reportError($php_errormsg, $during);
				return;	
			}

			$my_query = "SELECT event_id, title, start_time ";
			$my_query .= " FROM srcEvent WHERE event_id IN (";
			for($q = 0; $q < count($unique); $q++)
			{
				if ($q && $unique[$q])
				{
					$my_query .= ", ";
				}
				$my_query .= $unique[$q];
			}
			$my_query .= ") ORDER BY start_time ASC";

			if (!($result_id = pg_exec( $my_conn, $my_query)))
			{
				$during = "while searching the event database";
				reportError($php_errormsg . " QUERY = " . $my_query, $during);
				return;
			}

			$num_rows = pg_NumRows($result_id);
			if (!$num_rows)
			{
reportError("The event index listed events, but none were found.");
				return;
			}

			echo("<EM>");
			if ($num_rows == 1)
			{
				echo(_("1 event found."));
			}
			else
			{
				echo(_wv("%s1 events found.",
					array($num_rows)));
			}
			echo("</EM><BR><UL>\n");

			for ($j = 0; $j < $num_rows; $j++)
			{
// fetch some results and output the short info
				$current_event = pg_fetch_object(
					$result_id, $j);
				echo("<LI>\n" .
"<A HREF=\"$this->action_url" . "&amp;timestamp=" . $GLOBALS["timestamp"]
. "&amp;cal_view=detail&amp;" . "event_id=$current_event->event_id\">" .
$current_event->title . "</A>\n" . "</LI>\n");
			}
			echo("</UL>\n");
		}

// this is basically just a wrapper
		function outputDetailView($event_id, $prev_link)
		{
			$event = new SRCEventWithStringsFromEventID($event_id);
			$event->outputDetailView($prev_link);
		}

// lots of html goes here
		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG>
<P>The &quot;Calendar&quot; box displays a month at a time.  You can browse
through these months by following the &quot;Previous month&quot; and &quot;Next
month&quot; links beneath it.  While in the desired month, you can view the
events for a given day, by clicking on that date, or a week at a time, by
following the &quot;Week <I>n</I>&quot; links.  (Actually, the week view views
seven days at a time, so if some week of the month has less than seven days,
you'll see some from the next week or month.)  You can also look at the events
that occur on a given day of the week in a month by clicking on the column
title for that day of the week (&quot;S&quot;, &quot;M&quot;, etc)</P>

<P>If you're using a computer in the <I><?php echo $GLOBALS["CONFIG"]["domain"]; ?></I> domain, you also
have the option to &quot;View unapproved events.&quot;  If you follow this,
link, you will be able to see events that have been submitted, but not yet been
approved for general viewing.  This does not necessarily mean the events are
bad, just that nobody has gotten around to approving them yet.  You can hide
unapproved events by following the &quot;Hide unapproved events&quot; link,
which replaces the &quot;View unapproved events&quot; link.</P>

<P>Some approved events may still be hidden from browsers outside the
<?php echo $GLOBALS["CONFIG"]["shortname"] . " "; ?>
network.  This is an option that can be selected while submitting an
event, if it's something that only <?php echo $GLOBALS["CONFIG"]["shortname"]; ?> Community members need to know
about (for instance, if a certain well-known band is putting on a show for <?php echo $GLOBALS["CONFIG"]["abbrvname"]; ?>
 people, and outsiders are not invited).</P>

<?php
		}

	}
}
?>

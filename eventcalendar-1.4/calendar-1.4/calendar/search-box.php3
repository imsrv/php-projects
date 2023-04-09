<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: search-box.php3,v 1.15 2001/05/30 21:17:04 fluffy Exp $  

if (!isSet($SEARCH_BOX_INCLUDED))
{
	$SEARCH_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('sql/sql.php3');
	include('event.php3');
	include('gettext.php3');

	class SRCSearchBox extends SRCBox
	{
		function SRCSearchBox($new_action_url = "",
			$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->help_available = 1;
			$this->help_topic = _("Searching for Events");
			$this->uses_headers = 0;
			$this->error = "";
		}

		function outputBox()
		{
			$this->outputSearchBox();
		}

		function outputSearchBox()
		{
			$temp = split("\?", "$this->action_url");
			$other_args = split("&amp;", $temp[1]);
?>
<FORM METHOD=GET ACTION="<?php echo $this->action_url ?>">
<P><BIG><?php echo(_("Search")); ?></BIG><BR>
<INPUT TYPE=hidden NAME="form_action" VALUE="basic_search">
<?php
// need to stick the additional args passed from the main page in here,
// since the GET method drops them, and POST won't let us use a URL to go back
			for ($i = 0; $i < count($other_args); $i++)
			{
				$pair = split("=", $other_args[$i]);
				echo("<INPUT TYPE=hidden NAME=\"" . $pair[0] .
					"\" VALUE=\"" . $pair[1] . "\">\n");
			}

			echo(_("Search for events containing:"));
?>
<INPUT TYPE=text NAME="search_string" <?php
			if (isSet($GLOBALS["search_string"]))
			{
				echo("VALUE=\"" .
					stripSlashes($GLOBALS["search_string"])
					. "\"");
			}
?>><BR>
<INPUT TYPE=submit VALUE=<?php echo(_("Search")); ?>>
</FORM>
<A HREF="<?php echo $this->action_url ?>&amp;form_action=advanced_form">
<?php
			echo(_("Advanced Search"));
			echo("</A>");
		}

		function outputResults()
		{
			echo("<BIG>" . _("Search") . ":</BIG><BR>\n");

			switch ($GLOBALS["form_action"])
			{
				case "basic_search": $this->parseBasicSearch();
					break;
				case "advanced_form": $this->outputAdvancedSearchForm();
					break;
				case "advanced_search": $this->parseAdvancedSearch();
					break;
				case "item_details": $this->outputDetailView(
					$GLOBALS["event_id"], 1);
					break;
			}
		}

		function parseBasicSearch()
		{
			if (!$GLOBALS["search_string"])
			{
				return;
			}
			$db_conn = connectROToCalendar();
// might want to pull out regex characters, but oh well
			$query = "SELECT event_id, title, start_time " .
				"FROM srcEvent WHERE (" .
				"description ~* '" . $GLOBALS["search_string"]
				. "' OR title ~* '" . $GLOBALS["search_string"]
				. "') " . ( $GLOBALS["oc_remote_host"] ?
				"AND ( approver_id notNull AND hide_oc isNull ) "
				: "" )
				. "ORDER BY start_time";

			$result_id = pg_exec($db_conn, $query);
			$this->outputMatchedItems($result_id);
		}

		function outputAdvancedSearchForm()
		{
// this is a bit messy.  can't use the edittable event though, cause some stuff
//  is a bit different
			echo("<BIG>" . _("Advanced Search Form") . ":</BIG><BR>\n");
			$temp = split("\?", $this->action_url);
			$other_args = split("&amp;", $temp[1]);
?>
<FORM METHOD=GET ACTION="<?php echo $this->action_url ?>">
<INPUT TYPE=hidden NAME="form_action" VALUE="advanced_search">
<?php
// need to stick the additional args passed from the main page in here,
// since the GET method drops them, and POST won't let us use a URL to go back
			for ($i = 0; $i < count($other_args); $i++)
			{
				$pair = split("=", $other_args[$i]);
				echo("<INPUT TYPE=hidden NAME=\"" . $pair[0] .
					"\" VALUE=\"" . $pair[1] . "\">\n");
			}
			echo(_("Search for events that match the following:"));
?>
<BR>
<B><?php echo(_("Title contains:")); ?>:</B>
<INPUT TYPE=text NAME="title" <?php
			if (isSet($GLOBALS["title"]))
			{
				echo("VALUE=\"" .
					stripSlashes($GLOBALS["title"]) .
					"\"");
			}
?>><BR>
<B><?php echo(_("Description contains:")); ?></B>
<INPUT TYPE=text NAME="description" <?php
			if (isSet($GLOBALS["description"]))
			{
				echo("VALUE=\"" .
					stripSlashes($GLOBALS["description"])
					. "\"");
			}

			echo("><BR>\n");

	if (!$my_conn = @connectROToCalendar())
	{
		reportError($php_errormsg, "while connecting to the database");
		return;
	}

	echo("<B>" . _("Occurs on a:") . "</B>\n");
	if ($error = outputCheckboxFromTable($my_conn, "srcWeekday", "day",
		"name", "weekday", 4, 0, -1, 0))
	{
		reportError($error, "while fetching items for a checkbox menu");
		return;
	}

	echo("<B>" . _("Location is any of:") . "</B>\n");
	if ($error = outputCheckboxFromTable($my_conn, "srcLocation",
		"location_id", "name", "location", 3, 1))
	{
		reportError($error, "while fetching items for a checkbox menu");
		return;
	}

	echo("<B>" . _("Category is any of:") . "</B>\n");
	if ($error = outputCheckboxFromTable($my_conn, "srcCategory",
		"category_id", "name", "category", 3, 1))
	{
		reportError($error, "while fetching items for a checkbox menu");
		return;
	}

	echo("<B>" . _("Audience is any of:") . "</B>\n");
	if ($error = outputCheckboxFromTable( $my_conn, "srcAudience",
		"audience_id", "name", "audience", 3, 1))
	{
		reportError($error, "while fetching items for a checkbox menu");
		return;
	}

	echo("<INPUT TYPE=checkbox NAME=\"hide_oc\" VALUE=\"check\"" .
		(isSet($GLOBALS["hide_oc"]) ? " CHECKED" : "") .
		">Is hidden from off-campus browsers<BR>\n");
	echo("<INPUT TYPE=checkbox NAME=\"not_hide_oc\" VALUE=\"uncheck\"" .
		(isSet($GLOBALS["not_hide_oc"]) ? " CHECKED" : "") .
		">Is visible to off-campus browsers<BR>\n");
	echo("<INPUT TYPE=checkbox NAME=\"modification\" VALUE=\"check\"" .
		(isSet($GLOBALS["modification"]) ? " CHECKED" : "") .
		">Is a submitted modification<BR>\n");
	echo("<INPUT TYPE=checkbox NAME=\"not_modification\" VALUE=\"uncheck\"" .
		(isSet($GLOBALS["not_modification"]) ? " CHECKED" : "") .
		">Is not a submitted modification<BR>\n");
?>
<INPUT TYPE=submit VALUE="Search">
<INPUT TYPE=reset VALUE="Reset form">
</FORM>
<?php
		}

		function parseAdvancedSearch()
		{
			global $title, $description, $hide_oc, $not_hide_oc,
				$modification, $not_modification;

			$locations = parseCheckbox("location");
			$audiences = parseCheckbox("audience");
			$categories = parseCheckbox("category");
			$weekdays = parseCheckbox("weekday", -1);

// if nothing was entered, don't bother
			if (!($title || $description || $hide_oc ||
				$not_hide_oc ||	$locations || $categories ||
				$modification || $not_modification ||
				$audiences || is_array($weekdays)))
			{
				$this->outputAdvancedSearchForm();
				return;
			}

			$db_conn = connectROToCalendar();
			$query = "SELECT DISTINCT " .
				"E.event_id, E.title, E.start_time, E.end_time " .
				"FROM srcEvent E" .
				(is_array($audiences) ? ", srcAudienceList A" : "")
				. (is_array($categories) ? ", SRCCategoryList C" : "")
				. (is_array($weekdays) ? ", SRCWeekdayList W" : "")
				. " WHERE " .
				($description ? "E.description ~* '" .
					$GLOBALS["description"] . "' AND ": "")
				. ($title ? "E.title ~* '" .
					$GLOBALS["title"] . "' AND " : "");

			if (is_array($locations))
			{
				$query .= " E.location_id IN (";
				for ($i = 0; $i < count($locations); $i++)
				{
					$query .= ($i ? ", " : "") .
						$locations[$i];
				}
				$query .= ") AND ";
			}

			if (is_array($audiences))
			{
				$query .= " A.audience_id IN (";
				for ($i = 0; $i < count($audiences); $i++)
				{
					$query .= ($i ? ", " : "") .
						$audiences[$i];
				}
				$query .= ") AND A.event_id = E.event_id AND ";
			}

			if (is_array($categories))
			{
				$query .= " C.category_id IN (";
				for ($i = 0; $i < count($categories); $i++)
				{
					$query .= ($i ? ", " : "" ) .
						$categories[$i];
				}
				$query .= ") AND C.event_id = E.event_id AND ";
			}

			if (is_array($weekdays))
			{
				$query .= " W.day IN (";
				for ($i = 0; $i < count($weekdays); $i++)
				{
					$query .= ($i ? ", " : "" ) .
						$weekdays[$i];
				}
				$query .= ") AND W.event_id = E.event_id AND ";
			}

			if ($GLOBALS["oc_remote_host"])
			{
				$query .= " E.approver_id notNull " .
					"AND E.hide_oc isNull AND ";
			}

// Kick ass!  I've never used an xor in programming before! :)
// no point in adding this stuff if both are checked
			if ($hide_oc xor $not_hide_oc)
			{
				$query .= ($hide_oc ? " E.hide_oc notNull AND " :
					" E.hide_oc isNull AND ");
			}

			if ($modification xor $not_modification)
			{
				$query .= ($modification ?
					" E.modify_id notNull AND "
					: " E.modify_id isNull AND ");
			}

			$query .= "E.event_id notNull ORDER BY E.start_time";

			$result_id = pg_exec($db_conn, $query);
			if (!$result_id)
			{
				reportError($php_errormsg . " QUERY = $query",
					"running an advanced search");
			}
			else
			{
				$this->outputMatchedItems($result_id);
			}
			$this->outputAdvancedSearchForm();
		}

		function outputMatchedItems($result_id)
		{
// just going to output a couple things about the event and a link to details
			$num_rows = pg_numrows($result_id);

			if (!$num_rows)
			{
				echo(_("No events found.") . "<BR>");
			}
			else
			{
				if ($num_rows > 1)
				{
					echo(_("1 event found."));
				}
				else
				{
					echo(_wv("%s1 events found.",
						array($num_rows)));
				}
				echo("<BR>\n");
				echo("<OL>\n");
				for ($i = 0; $i < $num_rows; $i++)
				{
					$current_event = pg_fetch_object($result_id, $i);
					echo("<LI>\n" .
date("m/j/Y", $current_event->start_time) .
(($current_event->end_time && (date("m/j/Y", $current_event->start_time) !=
	($temp = date("m/j/Y", $current_event->end_time)))) ? "-" .$temp : "")
. " - " .
"<A HREF=\"$this->action_url" . "&amp;event_id=$current_event->event_id" .
"&amp;form_action=item_details\">" . $current_event->title . "</A>\n</LI>\n");
				}
				echo("</OL>\n");
			}

		}

		function outputDetailView($event_id, $prev_link)
		{
// another wrapper
			$event = new SRCEventWithStringsFromEventID($event_id);
			$event->outputDetailView($prev_link);
		}

		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG><BR>
<P>Searching for events can be done either through the monthly calendar by
selecting the desired date, or through one of two forms available through the
&quot;Search&quot; box.  The Search box on the left side of the window contains
a basic search form, where you can type in a keyword, which then searches the
events database for events that contain that keyword in the title or description
of the event.</P>

<P>There's also a link in the basic form to an advanced search form.  The
advanced form is, unfortunately, much more complicated, thus earning its
&quot;advanced&quot; status.  The advanced search form contains separate text
fields for the title and description, as well as several groups of checkboxes
for the event's location, category, audience, and the day of the week on which
the event occurs.  You can also specifically select whether or not the event
you're looking for is hidden from off-campus browsers.  You can choose from
any of the search fields in the form.  Using the checkboxes will search for
events that contain any of the selected values, so for instance, selecting
audiences of &quot;alumni&quot;, &quot;faculty&quot;, and &quot;student&quot;
will result in events that have any combination of those three values. 
However, specifying values for multiple fields will require that the search
results contain values from each field.  As another example, selecting a
couple categories and a couple locations will give you results that contain
any combination of the locations, <EM>and</EM> any combination of the
categories you selected.</P>


<?php
		}

	}
}
?>

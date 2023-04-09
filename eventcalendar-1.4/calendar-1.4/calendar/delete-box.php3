<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: delete-box.php3,v 1.12 2001/05/30 21:17:03 fluffy Exp $

if (!isSet($DELETE_BOX_INCLUDED))
{
	$DELETE_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('sql/sql.php3');
	include('../auth/session.php3');
	include('event.php3');
	include('../auth/permissions.php3');
	include('gettext.php3');

	class SRCDeleteBox extends SRCBox
	{
		var $max_events;

		function SRCDeleteBox($new_action_url = "",
			$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->help_available = 1;
			$this->help_topic = _("Deleting Events");
			$this->error = "";
			$this->max_events = 5;
		}

		function outputBox()
		{
			if(!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}
			$this->outputDeleteBox();
		}

		function outputDeleteBox()
		{
			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_form\"><BIG>" .
				_("Delete") . "</BIG></A>");
		}

		function outputPDeniedNotice()
		{
			echo("<P><BIG>" . _("Delete") . "</BIG><BR>\n");
			echo(_("You are not allowed to delete events."));
			echo("</P>");
		}

		function outputResults()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			echo("<BIG>" . _("Delete") . ":</BIG><BR>\n");

// we'll either output the form, parse the first form (delete_event) or
//  parse the confirm form and actually delete stuff (confirm_delete)
			switch ($GLOBALS["form_action"])
			{
				case "delete_event": $this->parseDeleteForm();
					break;
				case "confirm_delete": $this->parseConfirmForm();
					break;
				case "output_form":
				default:
					$this->outputDeleteForm();
					break;
			}
		}

		function outputDeleteForm()
		{
// here's a form that lists the first five deletable events with radio buttons
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;
			$user_id = $GLOBALS[$this->session_var]->user_id;

			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url .
				"\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\" " .
				"VALUE=\"delete_event\">\n");

			if (!($my_conn = @connectROToCalendar()))
			{
				reportError($php_errormsg, "while connecting to the database");
				return 0;
			}

			$my_query = "SELECT event_id FROM srcEvent WHERE ";

			$my_query .= " ( ";
			while ($loc = each($perms_list))
			{
				$loc_id = $loc["key"];
				$perms = $loc["value"];

				if ($perms & $GLOBALS["pDeleteAll"])
				{
					$my_query .= " ( ";
					if (($perms & $GLOBALS["pDeleteAll"])
						!= $GLOBALS["pDeleteAll"])
					{
						$my_query .= "submitter_id ";
						if ($perms & $GLOBALS["pDeleteOwn"])
						{
							$my_query .= " = ";
						}
						elseif ($perms & $GLOBALS["pDeleteOther"])
						{
							$my_query .= " != ";
						}
						$my_query .= $user_id . " AND ";
					}
					$my_query .= " location_id " .
						($loc_id == -1 ? "notNull" :
							"= $loc_id ") . ") OR ";
				}
			}
			$my_query .= " location_id isNull ) ";

			if (isSet($GLOBALS["start_id"]))
			{
				$my_query .= " AND event_id >= " .
					$GLOBALS["start_id"];
			}
			$my_query .= " ORDER BY event_id ";

			if (!($result_id = @pg_exec($my_conn, $my_query)))
			{
				reportError($php_errormsg . " QUERY = $my_query", "while searching the database");
				return 0;
			}

			if (!($num_rows = pg_numRows($result_id)))
			{
				echo(_("No deleteable events."));
			}
			else
			{
				echo("<BIG>");

				if ($num_rows == 1)
				{
					echo(_("1 event is deleteable."));
				}
				else
				{
					echo(_wv("%s1 events are deleteable.",
						array($num_rows)));
				}

				echo("</BIG><BR>\n");

				if ($num_rows > $this->max_events)
				{
					echo(_wv("Only the first %s1 will be displayed.",
						array($this->max_events)) . "<BR>");
					$limit = $this->max_events;
				}
				else
				{
					$limit = $num_rows;
				}
				echo("<HR>\n");

// We need to know how many events were listed when we parse the form
				echo("<INPUT TYPE=hidden NAME=\"num_events\"" .
					" VALUE=" . $limit . ">\n");

				for ($index = 0; $index < $limit; $index++)
				{
					$array = @pg_fetch_array($result_id, $index);
// Output the event details first, then the radio buttons
					$event = new SRCEventWithStringsFromEventID($array["event_id"]);
					$event->outputDetailView(0);
// We need the event ID so we know which event we're rejecting or approving
					echo("<INPUT TYPE=hidden NAME=\"event_" .
						$index . "_id\" VALUE=" .
						$array["event_id"] . ">\n");
// And each radio button set is numbered so events can be approved separately
					echo("<BR>\n<INPUT TYPE=radio NAME=\"delete_" . $index
						. "\" VALUE=\"delete\">");
					echo(_("Delete event") . "<BR>\n");
					echo("<INPUT TYPE=radio NAME=\"delete_" . $index .
						"\" VALUE=\"ignore\" CHECKED>");
					echo(_("Ignore event") . "<BR>\n");
					echo("<HR>\n");
				}

// The submit button goes at the very bottom
				echo("<BR>\n<INPUT TYPE=submit VALUE=\"");
				echo(_("Process events"));
				echo("\">\n");
				echo("<INPUT TYPE=reset VALUE=\"");
				echo(_("Reset Selections"));
				echo("\">\n");
			}

			echo("<BR>\n");
			echo("</FORM>\n");

			if ($num_rows > $this->max_events)
			{
				echo(_wv("Ignore these and look at the %s1next batch%s2.",
					array("<A HREF=\"" . $this->action_url .
						"&amp;start_id=" .
						($array["event_id"]+1), "</A>")));
			}
			
		}

		function parseDeleteForm()
		{
// For each event listed in the form...
			$num_events = $GLOBALS["num_events"];
			$delete_count = 0;
			for ($i = 0; $i < $num_events; $i++)
			{
				$event_id = $GLOBALS["event_" . $i . "_id"];
				$delete = $GLOBALS["delete_" . $i];

// if we're not ignoring it, load the event and either approve or reject it
				if (($delete != "ignore") && ($delete == "delete"))
				{
					$deletions[$delete_count++] = $event_id;
				}
			}

			$this->outputConfirmForm($deletions);
		}

		function parseConfirmForm()
		{
// If this function gets called, we should be logged in already

// For each event listed in the form...
			$num_events = $GLOBALS["num_events"];
			$delete_count = 0;
			for ($i = 0; $i < $num_events; $i++)
			{
				$event_id = $GLOBALS["event_" . $i . "_id"];
				$delete = $GLOBALS["delete_" . $i];

// if we're not ignoring it, load the event and either approve or reject it
				if (($delete != "ignore") && ($delete == "confirm"))
				{
					$event = new SRCEventFromEventID($event_id);
					if (!$event->deleteEvent())
					{
						reportError($event->error,
							"while deleting event " . $i);
					}
					$delete_count++;
				}
			}

			if ($delete_count)
			{
				echo(_wv("%s1 events deleted.",
					array($delete_count)) . "\n");
			}
			else
			{
				echo(_("No events deleted.") . "\n");
			}
		}

		function outputConfirmForm($deletions)
		{
			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url .
				"\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\"" .
				" VALUE=\"confirm_delete\">\n");

			if (!($delete_count = count($deletions)))
			{
				echo(_("No events were selected to be deleted."));
			}
			else
			{
				echo("<BIG>");

				if ($delete_count > 1)
				{
echo(_("Please confirm the deletion of the following %s1 events."));
				}
				else
				{
echo(_("Please confirm the deletion of the following event."));
				}
				echo("</BIG><BR>");

// We need to know how many events were listed when we parse the form
				echo("<INPUT TYPE=hidden NAME=\"num_events\" " .
					"VALUE=" . $delete_count . ">\n");

				for ($index = 0; $index < $delete_count; $index++)
				{
// Output the event details first, then the radio buttons
					$event = new SRCEventWithStringsFromEventID($deletions[$index]);
					$event->outputDetailView(0);
// We need the event ID so we know which event we're rejecting or approving
					echo("<INPUT TYPE=hidden NAME=\"event_" .
						$index . "_id\" VALUE=" .
						$deletions[$index] . ">\n");
// And each radio button set is numbered so events can be approved separately
					echo("<BR>\n<INPUT TYPE=radio NAME=\"delete_" .
						$index . "\" VALUE=\"confirm\">");
					echo(_("Yes, delete the event!"));
					echo("<BR>\n" .
						"<INPUT TYPE=radio NAME=\"delete_" .
						$index . "\" VALUE=\"ignore\" CHECKED>");
					echo(_("Oops... nevermind."));
					echo("<BR>\n");
					echo("<HR>\n");
				}

// The submit button goes at the very bottom
				echo("<BR>\n<INPUT TYPE=submit VALUE=\"");
				echo(_("Delete events"));
				echo("\">\n" );
				echo("<INPUT TYPE=reset VALUE=\"");
				echo(_("Reset Selections"));
				echo("\">\n");
			}

			echo("<BR>\n");
			echo("</FORM>\n");
		}

		function verifyPermissions()
		{
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;

			if (!is_array($perms_list))
			{
				return 0;
			}

			if (isSet($perms_list["-1"]) && ($perms_list["-1"] < 0))
			{
				return 0;
			}

			while ($loc = each($perms_list))
			{
				if (($loc["value"] > 0) &&
					($loc["value"] & $GLOBALS["pDeleteAll"]))
				{
					return 1;
				}
			}
			return 0;
		}

		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG>
<P>The preferred method of deleting an event is to log in, browse to the event
in the calendar box in the left corner of the page, and click the
&quot;Delete&quot; link diplayed beneath the event details.  This will display
a confirmation form to delete the event.</P>

<P>If you have the ability to delete events, then logging in should also make
available a &quot;Delete&quot; box.  Following the link in this box will
conduct a search for events which you are able to delete.  If there are any,
then they will be listed in detail, with a set of radio buttons for each event.
These radio buttons allow you to either delete the event, or ignore it.  If you
ignore the event, it is left alone.  If you choose to delete any events, then
they will be listed on a confirmation form, giving you the option to back out
of deleting an event, or go ahead and delete it.  Once you confirm the deletion
of an event, it's gone forever.  Hitting the back button in your browser won't
put it back on the calendar, so make sure you want to delete the event before
you do it.</P>

<P>If there are more than <?php echo $this->max_events ?> events which are
deleteable, the delete form will display a warning, and list only the first
chunk of deleteable events.  If you wish to see the other events, there will
be a link beneath the delete form to skip to the next batch.  Skipping the
currently displayed events will ignore any choices you have made on deleting
them.</P>

<?php
		}

	}
}
?>

<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: approve-box.php3,v 1.14 2001/05/30 21:17:03 fluffy Exp $

if (!isSet($APPROVE_BOX_INCLUDED))
{
	$APPROVE_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('sql/sql.php3');
	include('../auth/session.php3');
	include('../auth/permissions.php3');
	include('event.php3');
	include('gettext.php3');

	class SRCApproveBox extends SRCBox
	{
		function SRCApproveBox($new_action_url = "", $new_session_var = "")
		{
			$this->action_url = $new_action_url;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->login_required = 1;
			$this->help_available = 1;
			$this->help_topic = _("Approving Events");
			$this->error = "";
		}

		function outputBox()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			$this->outputApproveBox();
		}

		function outputApproveBox()
		{
			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_form\"><BIG>" .
				_("Approve") . "</BIG></A>\n");

		}

		function outputPDeniedNotice()
		{
			echo("<P><BIG>" . _("Approve") . "</BIG><BR>\n" .
				_("You are not allowed to approve events.") .
				"</P>\n");
		}

		function outputResults()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			echo("<BIG>" . _("Approve") . ":</BIG><BR>\n");

			switch ($GLOBALS["form_action"])
			{
				case "approve_event": $this->parseApproveForm();
					break;
				case "output_form":
				default:
					$this->outputApproveForm();
					break;
			}
		}

		function outputApproveForm()
		{
// Need permissions and a user_id to approve the event
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;
			$user_id = $GLOBALS[$this->session_var]->user_id;

			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url .
				"\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\" " .
				"VALUE=\"approve_event\">");

			if (!$my_conn = @connectROToCalendar())
			{
				reportError($php_errormsg,
					"while connecting to the database");
				return 0;
			}

			$my_query = "SELECT event_id,start_time FROM " .
				"srcEvent WHERE ( ";

// Go through each category to see which ones we're allowed to approve
			while ($loc = each($perms_list))
			{
				$loc_id = $loc["key"];
				$perms = $loc["value"];

				if ($perms & $GLOBALS["pApproveAll"])
				{
					$my_query .= " ( ";
					if (($perms & $GLOBALS["pApproveAll"])
						!= $GLOBALS["pApproveAll"])
					{
						$my_query .= "submitter_id ";
						if ($perms & $GLOBALS["pApproveOwn"])
						{
							$my_query .= " = ";
						}
						elseif ($perms & $GLOBALS["pApproveOther"])
						{
							$my_query .= " != ";
						}
						$my_query .= $user_id . " AND ";
					}
					$my_query .= " modify_id isNull AND " .
						"location_id " .
						($loc_id == -1 ? "notNull" :
							" = $loc_id " ) .
						") OR ";
				}

				// look for submitted modifications
				if ($perms & $GLOBALS["pModifyAll"])
				{
					$my_query .= " ( ";
					if (($perms & $GLOBALS["pModifyAll"])
						!= $GLOBALS["pModifyAll"])
					{
						$my_query .= "submitter_id ";
						if ($perms & $GLOBALS["pModifyOwn"])
						{
							$my_query .= " = ";
						}
						elseif ($perms & $GLOBALS["pModifyOther"])
						{
							$my_query .= " != ";
						}
						$my_query .= $user_id . " AND ";
					}
					$my_query .= " modify_id notNull AND " .
						"location_id " .
						($loc_id == -1 ? "notNull" :
							" = $loc_id " ) .
						") OR ";
				}
			}

			$my_query .= " location_id isNull ) AND ";

			$my_query .= " approver_id isNull ORDER BY start_time ";

			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				reportError($php_errormsg . " QUERY = $my_query",
					"while searching the database");
				return 0;
			}

			if (!$num_rows = pg_numRows($result_id))
			{
				echo(_("There are currently no unapproved events."));
			} else {
				echo("<BIG>");

				if ($num_rows == 1)
				{
					echo(_("1 event is awaiting approval."));
				}
				else
				{
					echo(_wv("%s1 events are awaiting approval.",
						array($num_rows)));
				}
				echo("</BIG><HR>\n");

// We need to know how many events were listed when we parse the form
				echo("<INPUT TYPE=hidden NAME=\"num_events\" " .
					"VALUE=" . $num_rows . ">\n" );

				for ($index = 0; $index < $num_rows; $index++)
				{
					$array = @pg_fetch_array($result_id, $index);

// Output the event details first, then the radio buttons
// This isn't very consistent with the delete and modify boxes, which only
//  display the title and must be changed individually
					$event = new SRCEventWithStringsFromEventID($array["event_id"]);
					$event->outputDetailView(0);

// We need the event ID so we know which event we're rejecting or approving
					echo("<INPUT TYPE=hidden " .
						"NAME=\"event_" . $index .
						"_id\" VALUE=" .
						$array["event_id"] . "><BR>\n");

// And each radio button set is numbered so events can be approved separately
					echo("<INPUT TYPE=radio " .
						"NAME=\"approve_" . $index
						. "\" VALUE=\"approve\">");
					echo(_("Approve event") . "<BR>\n");
					echo("<INPUT TYPE=radio " .
						"NAME=\"approve_" . $index .
						"\" VALUE=\"reject\">");

					echo(_("Reject event") . "<BR>\n");
					echo("<B>" . _("Reason for rejection") .
						":</B> (" . _("optional") . ")\n");
					echo("<INPUT TYPE=text NAME=\"reason_" .
						$index . "\"><BR>\n");

					echo("<INPUT TYPE=radio " .
						"NAME=\"approve_" . $index .
						"\" VALUE=ignore CHECKED>");
					echo(_("Ignore event") . "<BR>\n");
					echo("<HR>\n");
				}

// The submit button goes at the very bottom
				echo("<BR>\n<INPUT TYPE=submit VALUE=\"" .
					_("Process events") . "\">\n");
				echo("<INPUT TYPE=reset VALUE=\"" .
					_("Reset Selections") . "\">\n");
			}

			echo("<BR>\n</FORM>\n");
		}

		function parseApproveForm()
		{
// Get the user_id again.  The event will verify permissions when we try to
//  approve it.
			$user_id = $GLOBALS[$this->session_var]->user_id;


// For each event listed in the form...
			$num_events = $GLOBALS["num_events"];
			for ($i = 0; $i < $num_events; $i++)
			{
				$event_id = $GLOBALS["event_" . $i . "_id"];
				$approve = $GLOBALS["approve_" . $i];
				$reason = $GLOBALS["reason_" . $i];

// if we're not ignoring it, load the event and either approve or reject it
				if ($approve != "ignore")
				{
					$event = new SRCEventWithStringsFromEventID($event_id);
					if ($approve == "reject")
					{
						if (!$event->rejectEvent($user_id,
							($reason ? $reason : "")))
						{
							reportError($event->error,
								"while rejecting event " . $i);
						}
					}
					elseif ($approve == "approve")
					{
						if (!$event->approveEvent($user_id))
						{
							reportError($event->error,
								"while approving event " . $i);
						}
					}
					$events_processed++;
				}
		
			}

			echo(_wv("%s1 events processed.",
				array($events_processed)) . "\n");

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
					($loc["value"] & $GLOBALS["pApproveAll"]))
				{
					return 1;
				}

				// for submitted modifications...
				if (($loc["value"] > 0) &&
					($loc["value"] & $GLOBALS["pModifyAll"]))
				{
					return 1;
				}
			}

			return 0;
		}

		function outputHelp()
		{
			echo("<BIG>" . $this->help_topic . "</BIG>\n");
?>
<P>If you have the ability to approve or modify events, then logging in
should make available an &quot;Approve&quot; box.  Following the link in
this box will conduct a search for events which you are able to approve,
or modifications which have been submitted for events that you are able to
modify. If there are any, then they will be listed in detail, with a set
of radio buttons for each event. These radio buttons allow you to either:
approve an event as-is, reject an event with an optional field for the
reason you're rejecting it, and ignore an event.  Rejecting an event will
send an e-mail notification to the submitter, along with the reason for
rejection if you supplied one.  The event is also removed from the
calendar.  Ignoring an event will neither approve nor delete it, letting
you come back to approve it later, or let somebody else approve it.
</P>

<?php
		}

	}
}
?>

<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: modify-box.php3,v 1.11 2001/05/27 23:27:02 fluffy Exp $  

if (!isSet($MODIFY_BOX_INCLUDED))
{
	$MODIFY_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('../auth/session.php3');
	include('../auth/permissions.php3');
	include('event.php3');
	include('gettext.php3');

	class SRCModifyBox extends SRCBox
	{
		var $max_events;

		function SRCModifyBox($new_action_url = "",
			$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->help_available = 1;
			$this->help_topic = _("Event Modification");
			$this->error = "";
			$this->max_events = 5;
		}

		function outputBox()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}
			$this->outputModifyBox();
		}

		function outputModifyBox()
		{
			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_form\"><BIG>" .
				_("Modify") . "</BIG></A>\n");
		}

		function outputPDeniedNotice()
		{
			echo("<P><BIG>" . _("Modify") . "</BIG><BR>\n");
			echo(_("You are not allowed to modify events.") . "</P>");
		}

		function outputResults()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			echo("<BIG>" . _("Modify") . ":</BIG><BR>\n");

			switch ($GLOBALS["form_action"])
			{
				case "output_form": $this->outputModifyForm();
					break;
				case "modify_event":
					$this->parseModifyForm();
					break;
			}
		}

		function outputModifyForm($event = "")
		{
// we will either be passed an event or can get an ID from a global var
//  if we can't get one, will output the selection form instead
			if (!$event)
			{
				if (!(isSet($GLOBALS["event_id"]) && ($event =
					new SRCEventWithStringsFromEventID($GLOBALS["event_id"]))))
				{
					$this->outputEventSelectionForm();
					return;
				}
			}
?>
You can use the &quot;Help&quot; box for more information on this page.<BR>

	<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
	<INPUT TYPE=hidden NAME="form_action" VALUE="modify_event">
<?
// we set up the form and let the event handle the rest

	$event->outputEditableEvent();
?>
		<BR>
		<INPUT TYPE=submit NAME="modify_label" VALUE="Modify">
		<INPUT TYPE=submit NAME="modify_label" VALUE="Preview">
		<INPUT TYPE=reset VALUE="Clear">
		</FORM>
<?php
		}

		function parseModifyForm()
		{
			global $modify_label;

// create the new event...
			$event = new SRCEventFromGlobals($this->session_var);

			if (!$event->verifyAction("Modify"))
			{
				$event->modify_id = $event->event_id;
				$submit_mod = 1;
			}
			else
			{
				$submit_mod = 0;
			}

			$event->getStringsForIDs();
			$event->outputDetailView(0);

			if (!$event->validateEvent())
			{
				reportError($event->error,
					"while validating your event");
				return;
			}

			if ($modify_label == "Preview")
			{
				echo("<HR>\n");
				$this->outputModifyForm($event);
				return;
			}

// validate it and submit it
			if ($submit_mod)
			{
				$event->event_id = "";
				$event->approver_id = "";
				$return = $event->submitEvent();
			}
			else
			{
				$return = $event->updateEvent();
			}

			echo("<HR>\n");
			if (!$return)
			{
				reportError($event->error,
					"while saving your changes");
			}
			else
			{
				if ($submit_mod)
				{
echo(_("You are not allowed to modify events, but your changes have been submitted for approval.") . "<BR>\n");
				}
				echo(_("Event update succeeded.") . "<BR>\n");
			}

		}

		function verifyPermissions()
		{
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;
			if (isSet($perms_list["-1"]) && ($perms_list["-1"] < 0))
			{
				return 0;
			}

// With submitted modifications, almost anyone can modify stuff
			return 1;
		}

		function outputEventSelectionForm()
		{
// we'll do this like the delete form, showing 5 events at a time
			$perms_list = $GLOBALS[$this->session_var]->permissions_list;
			$user_id = $GLOBALS[$this->session_var]->user_id;

?>
	<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
	<INPUT TYPE=hidden NAME="form_action" VALUE="output_form">
<?php
			if (!$my_conn = @connectROToCalendar())
			{
				reportError($php_errormsg,
					"while connecting to the database");
				return 0;
			}

			$my_query = "SELECT event_id FROM srcEvent WHERE ";

			$my_query .= " ( ";
			if (is_array($perms_list))
			{
				while ($loc = each($perms_list))
				{
					$loc_id = $loc["key"];
					$perms = $loc["value"];

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
						$my_query .= " location_id " .
							($loc_id == -1 ? "notNull" :
							"= $loc_id ") . ") OR ";
					}
				}
			}
			$my_query .= " location_id isNull )";

			if (isSet($GLOBALS["start_id"]))
			{
				$my_query .= " AND event_id >= " .
					$GLOBALS["start_id"];
			}
			$my_query .= " ORDER BY event_id ";

			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				reportError($php_errormsg . "QUERY = $my_query",
					"while searching the database");
				return 0;
			}
			if (!$num_rows = pg_numRows($result_id))
			{
?>
No modifiable events.  If you'd like to submit a modification for approval,
please browse to the event in the calendar and click the "Modify" link
beneath its description.
<?php
			}
			else
			{
				echo("<BIG>");

				if ($num_rows == 1)
				{
					echo(_("1 event is modifiable."));
				}
				else
				{
					echo(_wv("%s1 events are modifiable.",
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

				echo("<INPUT TYPE=hidden NAME=\"num_events\" " .
					"VALUE=" . $limit . ">\n");

				for ($index = 0; $index < $limit; $index++)
				{
					$array = @pg_fetch_array($result_id, $index);
					$event = new SRCEventWithStringsFromEventID($array["event_id"]);
					$event->outputDetailView(0);
					echo("<A HREF=\"" . $this->action_url .
						"&amp;form_action=output_form" .
						"&amp;event_id=" .
						$array["event_id"] . "\">" .
						_("Modify this event.") .
						"</A><BR>\n");
					echo("<HR>\n");
				}
			}

			echo("</FORM>\n");

			if ($num_rows > $this->max_events)
			{
				echo(_wv("Ignore these and look at the %s1next batch%s2.",
					array("<A HREF=\"" . $this->action_url .
					"&amp;form_action=output_form" .
					"&amp;start_id=" . ($array["event_id"] + 1)
					. "\">", "</A>")));
			}
		}

		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG><BR>
<P>The preferred method of modifying events is to log in and browse to the
desired event using the calendar box in the corner of the page.  Viewing the
details of any event should make available a &quot;Modify&quot; link
beneath the event details.  Clicking this link should bring up an event
modification form.</P>

<P>Another method of selecting an event to modify is by clicking the
&quot;Modify&quot; link listed in the left column of the page.  This will
search for all events that you can modify and list them, <?
echo $this->max_events ?> at a time, with a link beneath each one that will
display the event modification form.  If there are more than <?
echo $this->max_events ?> events for you to modify, a link at the bottom will
display the next batch of events.</P>

<P>The actual event modification form is very similar to the event submission
form.  You can modify the event, preview the changes that you made before
committing them, and then save the modifications.  Changes should take place
immediately after you submit the modifications.</P>

<P>If you are not specifically allowed to modify an event, then any
changes you make to the event will be stored for approval, similarly to
submitting an event.  If the modification which you submit is approved,
the old event will be deleted and the modification put in its place.</P>

<?php
		}


	}
}
?>

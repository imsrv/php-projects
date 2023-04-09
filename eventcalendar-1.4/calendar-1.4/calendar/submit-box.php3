<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: submit-box.php3,v 1.10 2001/05/27 23:27:02 fluffy Exp $  

if (!isSet($SUBMIT_BOX_INCLUDED))
{
	$SUBMIT_BOX_INCLUDED = 1;

	include('box.php3');
	include('error/error.php3');
	include('../auth/session.php3');
	include('../auth/permissions.php3');
	include('event.php3');
	include('gettext.php3');

	class SRCSubmitBox extends SRCBox
	{
		function SRCSubmitBox($new_action_url = "",
			$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->help_available = 1;
			$this->help_topic = _("Event Submission");
			$this->error = "";
		}

		function outputBox()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}
			$this->outputSubmitBox();
		}

		function outputSubmitBox()
		{
			echo("<A HREF=\"" . $this->action_url .
				"&amp;form_action=output_form\"><BIG>" .
				_("Submit") . "</BIG></A>\n");
		}

		function outputPDeniedNotice()
		{
			echo("<P><BIG>" . _("Submit") . "</BIG><BR>\n");
			echo(_("You are not allowed to submit events."));
			echo("</P>");
		}

		function outputResults()
		{
			if (!$this->verifyPermissions())
			{
				$this->outputPDeniedNotice();
				return;
			}

			echo("<BIG>" . _("Submit") . ":</BIG><BR>\n");

			switch ($GLOBALS["form_action"])
			{
				case "output_form": $this->outputSubmitForm();
					break;
				case "submit_event":
					$this->parseSubmitForm();
					break;
			}
		}

		function outputSubmitForm($event = "")
		{
// relatively simple, using the edittable event
// we need to look for an event in case it was previewed
			if (!$event)
			{
				$event = new SRCEmptyEvent();
			}

			echo(_(
"You can use the &quot;Help&quot; box for more information on this page.  " .
"All that is required for an event is the title, description, and a " .
"starting date (the starting time is optional).") . "<BR>");
?>
	<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
	<INPUT TYPE=hidden NAME="form_action" VALUE="submit_event">
<?
			$event->outputEditableEvent();
?>
		<BR>
		<INPUT TYPE=submit NAME="submit_label" VALUE="Submit">
		<INPUT TYPE=submit NAME="submit_label" VALUE="Preview">
		<INPUT TYPE=reset VALUE="Clear">
		</FORM>
<?php
		}

		function parseSubmitForm()
		{
			global $submit_label;

// create the new event...
			$event = new SRCEventFromGlobals($this->session_var);

			if (!$event->validateEvent())
			{
				reportError($event->error,
					"while validating your event");
				return;
			}

			$event->getStringsForIDs();
			$event->outputDetailView(0);

			if ($submit_label == "Preview")
			{
				echo("<HR>\n");
				$this->outputSubmitForm($event);
				return;
			}

// validate it and submit it
			if (!$event->submitEvent())
			{
				reportError($event->error,
					"while submitting your event");
			}
			else
			{
				echo(_("Event submission succeeded.") . "<BR>\n");
			}

		}

		function verifyPermissions()
		{
			return ($GLOBALS[$this->session_var]->permissions_list["-1"] >=
				$GLOBALS["pSubmit"]);
		}

		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG><BR>
<P>If you are logged in, then there should be a &quot;Submit&quot; box
available on the left side of the page.  Following the link therein, an event
submission form should be displayed on the right half of the page.</P>

<P>There are a lot of options in the submission form, but don't be intimidated,
most of them are optional.  The few that are required are: the title, the
description, and the date of the event.  The date is even filled in as the
current date by default.  You don't need to put in a time unless your event
has a specific beginning time.  The ending time is optional, and will be ignored
if you don't enter anything in its fields.  To minimize the typing you have to
do, if you enter something in one of the ending time fields, but leave the
others blank, the blank date fields will be filled in from the starting date,
and the blank time fields are filled in as midnight.</P>

<P>If you have an event that repeats (every Monday, for example) you can give
first and last dates that the event occurs on, and select which days of the
week it occurs on.</P>

<P>The description field is pretty self explanatory... You can enter HTML if
you'd like to include a link or some formatting in your event.</P>

<P>Beneath the description is a menu to choose from a location.  If the
location you want isn't listed, you can select &quot;Other&quot; and mention
it in the description.</P>

<P>Next are some checkboxes for the event category and audiences.  If you don't
choose any categories, it will default to &quot;Other&quot;.  The audience
will also default to &quot;all&quot; if you don't select any.  Otherwise, you
can select as many as you want, as long as they apply to your event.</P>

<P>Nearing the end, we have some optional fields for a contact's e-mail address,
or a URL for a webpage that contains information relevant to your event.  Please
include a full e-mail address (<I>username@domain.end</I>) and/or a full URL
(including the <I>http://</I>) so the links will work properly when your event
is displayed.</P>

<P>Finally, there's a checkbox that allows your event to be hidden from
off-campus users.  This is available for events that are inappropriate for
non-members of the <?php echo $GLOBALS["CONFIG"]["abbrvname"]; ?> community.</P>

<P>If you're permitted to approve your own events, there's also a checkbox
which will allow you to preapprove your event, so you don't need to load the
approve form to approve it.</P>

<P>At the bottom of the form are buttons to either clear the form, or submit
your event.  After submitting your event, the form should be replaced either
by an error message, in which case you can hit the back button on your browser
and fill in some required field, or a message indicating success.  Your event
should then be included in the calendar, although unapproved.  If your message
is later rejected, you should receive an e-mail to notify you.</P>

<?php
		}


	}
}
?>

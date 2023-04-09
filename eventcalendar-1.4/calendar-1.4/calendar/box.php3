<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: box.php3,v 1.11 2001/05/30 21:17:03 fluffy Exp $

if (!isSet($BOX_INCLUDED))
{
	$BOX_INCLUDED = 1;

	include('gettext.php3');

// This is a pretty generic class that the real boxes will inherit from
	class SRCBox {
// login_required tells us if a session should exist for the box to be active
// login_url is the page to point to if a login is required
// action is what the box is doing ( login, submit, etc )
// perms is permissions
// action_url is the url to use in the form tag
// uses_headers is whether or not the box needs to be parsed before sending html
// error and during are used if there's an error to report while outputting results
// help_available tells the help box whether or not to display help for this box
//  help_topic is what to list the help as.
		var $login_required, $action_url, $session_var,
			$uses_headers, $error, $during,
			$help_available, $help_topic;

		function SRCBox($new_action_url = "", $new_session_var = "",
				$new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->help_available = 0;
			$this->error = "";
		}

// not allowed to approve anything
		function outputPDeniedNotice()
		{
			echo(_("You are not allowed to use this box.") . " " .
				_wv("If you think you've received this " .
					"message in error, you can try " .
					"logging in, or send an email to %s1.",
					array("<A HREF=\"mailto:" .
					$GLOBALS["CONFIG"]["errormailto"] .
					"\">" .
					$GLOBALS["CONFIG"]["errormailto"] .
					"</A>")));
		}

// The form action may place the action variable in the url, or it could
// be placed in a hidden input.  Things like searches should use the url
// so they can be bookmarked
		function outputBox()
		{
			echo("<P>" . _("This is a box.") . "</P>\n");
			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url . "\">\n");
			echo("<INPUT TYPE=hidden NAME=\"form_action\" VALUE=\"click\">\n");
			echo("<INPUT TYPE=submit VALUE=\"" . _("Click me") . "\">\n");
			echo("</FORM>\n");
		}

// Parse the submitted stuff before html is output
		function parseBox()
		{
			return;
		}

// This will probably be used on the right side of the page
		function outputResults()
		{
			if (isSet($GLOBALS["form_action"]))
			{
				echo("<P>" . _("You clicked in the box.") . "</P>\n");
			}
			else
			{
				echo("<P>" . _("Click in the box.") . "</P>\n");
			}
		}

		function outputHelp()
		{
		}

		function verifyPermissions()
		{
			return 1;
		}
	}
}
?>

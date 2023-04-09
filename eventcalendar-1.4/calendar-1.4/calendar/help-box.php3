<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: help-box.php3,v 1.9 2001/05/27 23:27:02 fluffy Exp $

if (!isSet($HELP_BOX_INCLUDED))
{
	$HELP_BOX_INCLUDED = 1;

	include('box.php3');
	include('gettext.php3');

	class SRCHelpBox extends SRCBox
	{
		var $login_required, $action_url, $session_var,
			$uses_headers, $error, $during;

		function SRCHelpBox($new_action_url = "", $new_session_var = "",
			$new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 0;
			$this->error = "";
		}

// The form action may place the action variable in the url, or it could
// be placed in a hidden input.  Things like searches should use the url
// so they can be bookmarked
		function outputBox()
		{
			echo("<A HREF=\"" . $this->action_url . "\"><BIG>" .
				_("Help") . "</BIG></A>\n");
		}

// This will probably be used on the right side of the page
		function outputResults()
		{
			global $boxes, $topic;

			echo("<BIG>" . _("Help") . ":</BIG><BR>\n");

			$this->outputContents();

			if (isSet($boxes[$topic]))
			{
				$boxes[$topic]->outputHelp();
			}
			else
			{
				$this->outputHelp();
			}
		}

		function outputHelp()
		{
?>
<P>Welcome to the <?php echo $GLOBALS["CONFIG"]["shortname"]; ?> Event Calendar.</P>
<P>You can browse events using the calendar to the left.  You can also search
for events by keyword using the &quot;Search&quot; box.  In order to do
anything else, like submitting events, you'll need to log in. This calendar
system uses the <I><?php echo $GLOBALS["CONFIG"]["account_host"]; ?></I> user accounts for submitting and editting
events, so if you don't have a <?php echo $GLOBALS["CONFIG"]["account_host"]; ?> account, you'll only be able to browse
and search for events.</P>

<P>There are currently two features that require cookies to be enabled in your
browser.  Those are logging in and viewing unapproved events.  If you have
cookies disabled, these features may appear to work at first, but will not last
when you follow another link.</P>
<?php
		}

// give us a list of help topics
		function outputContents()
		{
			$boxes = $GLOBALS["boxes"];
			$i = 0;

			for ( ; $current_box = each($boxes); )
			{
				if ($current_box["value"]->help_available)
				{
					$help_topics[$i++] = $current_box["key"];
				}
			}

			if (count($help_topics))
			{
				echo("<P>" . _("Help is available for the following topics:") . "\n");
				echo("<UL>\n<LI><A HREF=\"$this->action_url" .
					"&amp;topic=help\">" .
					_("General help") . "</A></LI>\n");

				for ($i = 0; $i < count($help_topics); $i++)
				{
					echo("<LI><A HREF=\"$this->action_url" .
						"&amp;topic=" .
						$help_topics[$i] . "\">" .
						$boxes[$help_topics[$i]]->help_topic .
						"</A></LI>\n");
				}

				echo("</UL>\n");
			}
		}
	}
}
?>

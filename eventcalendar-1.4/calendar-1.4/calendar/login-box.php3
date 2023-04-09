<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: login-box.php3,v 1.13 2001/05/30 21:26:17 fluffy Exp $  

if (!isSet($LOGIN_BOX_INCLUDED))
{
	$LOGIN_BOX_INCLUDED = 1;

	include('box.php3');
	include('../auth/session.php3');
	include('error/error.php3');
	include("../auth/" . $GLOBALS["CONFIG"]["auth_module"]);
	include('../auth/permissions.php3');
	include('gettext.php3');

	class SRCLoginBox extends SRCBox
	{
		function SRCLoginBox($new_action_url = "",
			$new_session_var = "", $new_login_req = 0)
		{
			$this->action_url = $new_action_url;
			$this->login_required = $new_login_req;
			$this->session_var = $new_session_var;
			$this->uses_headers = 1;
			$this->help_available = 1;
			$this->help_topic = _("Logging In");
			$this->error = "";
		}

		function outputBox()
		{
// if we don't have SSL, tell people to switch over
			if (!isSet($GLOBALS["SRCSessionKey"]) &&
				$GLOBALS["CONFIG"]["ssl_required"] &&
				!(isSet($GLOBALS["SSL_PROTOCOL_VERSION"]) ||
				isSet($GLOBALS["SSL_PROTOCOL"])))
			{
				$this->outputSSLNotice();
			}
			else
			{
				if (!$GLOBALS["cookies_enabled"])
				{
					$this->outputCookieNotice();
				}
				else
				{
					if (!$GLOBALS["SRCSessionKey"])
					{
						$this->outputLoginBox();
					}
					else
					{
						$this->outputLogoutBox();
					}
				}
			}
		}

		function outputSSLNotice()
		{
			echo("<BIG>" . _("Log in") . "</BIG><BR>");
			echo(_wv("In order to log in, you must use a secure " .
				"connection (SSL).  Click %s1here%s2 to " .
				"switch to an SSL connection.",
				array("<A HREF=\"https://" .
				$GLOBALS["HTTP_HOST"] .
				$GLOBALS["REQUEST_URI"] . "\">", "</A>")));
		}

		function outputCookieNotice()
		{
?>
In order to log in, you must have cookies enabled in your web browser.
You do not appear to have cookies enabled.  Re-enable them and reload this
page to try again.  If this problem persists, please notify the calendar
administrator.
<?php
		}

		function outputLoginBox()
		{
			echo("<FORM METHOD=POST ACTION=\"" . $this->action_url .
				"\">\n");
			echo("<P><BIG>" . _("Log in") . "</BIG><BR>\n");
			echo("This calendar uses your <EM>" .
				$GLOBALS["CONFIG"]["account_host"] .
				"</EM> username and password.<BR>\n");
?>
<INPUT TYPE=hidden NAME="form_action" VALUE="login">
<B>Username:</B><INPUT TYPE=text SIZE=8 MAXLENGTH=8 NAME="username"><BR>
<B>Password:</B><INPUT TYPE=password SIZE=8 NAME="password"><BR>
Expires in:
<SELECT NAME="renew_time">
<OPTION VALUE=300>5 minutes
<OPTION VALUE=600>10 minutes
<OPTION VALUE=1800>30 minutes
<OPTION VALUE=31536000>1 year
</SELECT><BR>
<INPUT TYPE=submit VALUE="Login">
<INPUT TYPE=reset VALUE="Clear">
</FORM>

<?php
		}

		function outputLogoutBox()
		{
?>
<FORM METHOD=POST ACTION="<?php echo $this->action_url ?>">
<INPUT TYPE=hidden NAME="form_action" VALUE="renew">
<P><BIG>Logged in</BIG><BR>
Get <A HREF="<?php echo $this->action_url ?>">session info</A>,
<A HREF="<?php echo $this->action_url ?>&amp;form_action=logout">log out</A>,
or renew your session.<BR>
<INPUT TYPE=submit VALUE="Renew">
for:
<SELECT NAME="renew_time">
<OPTION VALUE=300>5 minutes
<OPTION VALUE=600>10 minutes
<OPTION VALUE=1800>30 minutes
<OPTION VALUE=31536000>1 year
</SELECT>
</FORM>

<?php
		}

// this page looks for a whole bunch of hidden inputs in the form to determine
// whether it should ouput a login form or an error or whatever.
// other than that, it's pretty self explanatory.
		function parseBox()
		{
			switch ($GLOBALS["form_action"])
			{
				case "login": $this->error = $this->login();
					$this->during = "while logging in";
					break;
				case "logout": $this->error = $this->logout();
					$this->during = "while logging out";
					break;
				case "renew": $this->error = $this->renew();
					$this->during = "while renewing your session";
					break;
			}
		}

		function login()
		{
			global $username, $password, $renew_time,
				$SRCSessionKey;

			$pass = stripSlashes($password);
			$login_error = verifyPassword($username, $pass);
			if (!$login_error)
			{
				$renew_time += time();
				$session = new SRCSession($username, $renew_time);
				if (!$session->saveSession())
				{
					$login_error = $session->error;
				}
				else
				{
					$SRCSessionKey = getEnv("SRCSessionKey");
					$GLOBALS[$this->session_var] = $session;
				}
			}

			return $login_error;
		}

		function logout()
		{
			$GLOBALS[$this->session_var]->killSession($GLOBALS["SRCSessionKey"]);
			unset($GLOBALS["SRCSessionKey"]);
		}

		function renew()
		{
			global $SRCSessionKey, $renew_time;

			$renew_time += time();
			$GLOBALS[$this->session_var]->renewSession($renew_time);
			if (!$GLOBALS[$this->session_var]->saveSession())
			{
				return $GLOBALS[$this->session_var]->error;
			}
			$SRCSessionKey = getEnv("SRCSessionKey");
		}

		function outputResults()
		{
			global $cookies_enabled;

			echo("<BIG>Login:</BIG><BR>\n");

			if (!$cookies_enabled)
			{
				$this->outputCookieNotice();
				$error = "Cookies disabled.";
				reportError($error);
				return;
			}

			if (!isSet($GLOBALS["SRCSessionKey"]))
			{
				echo("<P>" . _("You are currently not logged in.") . "\n");
				echo("<P>" . _("Use the login box to the left to log in.") . "\n");
			}
			else
			{
				$GLOBALS[$this->session_var]->outputSessionStatus();
			}
		}

		function outputHelp()
		{
?>
<BIG><?php echo $this->help_topic ?></BIG>
<P>The <?php echo $GLOBALS["CONFIG"]["shortname"]; ?> Event Calendar system uses the <I><?php echo $GLOBALS["CONFIG"]["account_host"]; ?></I> accounts to
keep track of who's submitting and approving events.  If you want to do
anything that involves changing the calendar, you must first log in.</P>

<P>Logging in also requires that you be using SSL. (SSL is a security measure,
supported by most recent browsers, which encrypts everything you send and
receive through your web browser.)  Since you need to send your password to log
in, we require that you use SSL to make it less vulnerable to prying eyes.
This does not make it completely secure, but it helps.  If you are not currently
using SSL, the login box will display a notice, along with a link to switch
over to SSL.</P>

<P>When you've connected with SSL, the notice should be replaced with a form to
enter your <I><?php echo $GLOBALS["CONFIG"]["account_host"]; ?></I> username and password, as well as a menu to select
how long you would like to remain logged in.  Make sure you have cookies enabled
in your web browser, or you won't be able to log in properly.</P>

<P>When you've logged in, you are given the options to log out, renew your
session, or view information about your session, such as when it will expire.
If your session is about to expire, you can renew it for a given length of time,
determined by the menu next to the renew button.</P>

<P>You may notice that there's an option for your session to last for one year.
This option is meant for people to use on their personal machines when they
don't feel like logging in every time they use the calendar.  We recommend that
you log out when you've finished if people have access to the machine you're
using. Otherwise, people will be able to use your session to submit events in
your name.  Remember also that you don't need to be logged in to simply browse
the event calendar.</P>

<?php
		}

	}
}
?>

<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: index.php3,v 1.10 2001/05/30 22:44:43 fluffy Exp $  

$GLOBALS["CALENDAR_VERSION"] = "1.4";

include('includes/config.php3');
$GLOBALS["CONFIG"] = loadCalConfig();

if ($GLOBALS["CONFIG"]["textdomain_dir"] && $GLOBALS["CONFIG"]["textdomain"])
{
	bindtextdomain($GLOBALS["CONFIG"]["textdomain"],
		$GLOBALS["CONFIG"]["textdomain_dir"]);
	textdomain($GLOBALS["CONFIG"]["textdomain"]);
}

if ($GLOBALS["CONFIG"]["locale"])
{
	putenv("LANG=" . $GLOBALS["CONFIG"]["locale"]);
	setlocale(LC_TIME, $GLOBALS["CONFIG"]["locale"]);
}

//include('box.php3');
include('login-box.php3');
include('calendar-box.php3');
include('search-box.php3');
include('submit-box.php3');
include('approve-box.php3');
include('delete-box.php3');
include('modify-box.php3');
include('help-box.php3');
include('admin-box.php3');
include('../auth/session.php3');

// color is for alternating box backgrounds
$color = 0;
$action_url = basename(__FILE__);

if (isSet($timestamp))
{
	$action_suffix = "&amp;timestamp=$timestamp";
}

// Do a little testing for cookies
$action_suffix .= "&amp;test_cookies=1";
if ($test_cookies)
{
	if (!$cookie_test)
	{
		$cookies_enabled = 0;
		SetCookie("cookie_test", 1, mktime() + 60*60*24*365, "/");
	}
	else
	{
		$cookies_enabled = 1;
	}
}
else
{
	SetCookie("cookie_test", 1, mktime() + 60*60*24*365, "/");
// Give them the benefit of the doubt, we'll catch it in time
	$cookies_enabled = 1;
}

$session_var = "session";

$session = new SRCSession();
if (isSet($SRCSessionKey))
{
	$session->loadSession($SRCSessionKey);
}

// determine whether we're on campus or not
if (strcasecmp("." . $GLOBALS["CONFIG"]["internaldomain"],
	substr((gethostbyaddr(trim(getenv("REMOTE_ADDR")))),
	-(strlen($GLOBALS["CONFIG"]["internaldomain"]) + 1))) != 0)
{
	$oc_remote_host = 1;
}
else
{
	$oc_remote_host = 0;
}

// Initialize the boxes
//$boxes["box"] = new SRCBox("$action_url?action=box$action_suffix", $session_var);
$boxes["calendar"] = new SRCCalendarBox("$action_url?action=calendar", $session_var);
$boxes["help"] = new SRCHelpBox("$action_url?action=help$action_suffix", $session_var);
$boxes["admin"] = new SRCAdminBox("$action_url?action=admin$action_suffix", $session_var);
$boxes["submit"] = new SRCSubmitBox("$action_url?action=submit$action_suffix", $session_var, 1);
$boxes["approve"] = new SRCApproveBox("$action_url?action=approve$action_suffix", $session_var, 1);
$boxes["delete"] = new SRCDeleteBox("$action_url?action=delete$action_suffix", $session_var, 1);
$boxes["modify"] = new SRCModifyBox("$action_url?action=modify$action_suffix", $session_var, 1);
$boxes["search"] = new SRCSearchBox("$action_url?action=search$action_suffix", $session_var);
$boxes["login"] = new SRCLoginBox("$action_url?action=login$action_suffix", $session_var);

// default action
if (!isSet($action))
{
	$action = "calendar";
}

// if we need to use headers (setcookie) do stuff before we output html
if (isSet($boxes[$action]) && $boxes[$action]->uses_headers)
{
	$boxes[$action]->parseBox();
}

include('includes/header.inc');
?>
   <TABLE WIDTH=640>
    <TR VALIGN=top>
     <TD WIDTH=260>
      <TABLE CELLPADDING=10>
<?php
// go through each box, output (checking login reqs)
	for ( ; $current_box = each($boxes); )
	{
		if ((!$current_box["value"]->login_required) || (isSet($SRCSessionKey)
			&& $current_box["value"]->verifyPermissions()))
		{ 
			echo("<TR>\n");
			echo("<TD BGCOLOR=\"" .
				(($color++ % 2) ? "#FFFFFF" : "#9999CC") . "\">\n");
			$current_box["value"]->outputBox();
			echo( "</TD>\n");
			echo( "</TR>\n");
		}
	}
?>
      </TABLE>
     </TD>
     <TD WIDTH=380 BGCOLOR="#FFFFFF" VALIGN="top">
<?php
// do box stuff in the results section
	if ($action && isSet($boxes[$action]))
	{
		if ($boxes[$action]->error)
		{
			reportError($boxes[$action]->error, $boxes[$action]->during);
		}
		$boxes[$action]->outputResults();
	}
	elseif ($action)
	{
		reportError("\"$action\" is not a valid action.",
			"while parsing the URL");
	}
?>
     </TD>
    </TR>
   </TABLE>
<?php include('includes/footer.inc') ?>

<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information

include('../auth/last_login.php3');
include('sql/sql.php3');

// PAM module written by Bruce Tenison (btenison@dibbs.net)
// Instead of generating hashes from the entered plaintext pass,
// Let's pass it to a PAM program on the systems (setuid) and have
// IT authenticate for us.  This alleviates the different types of
// Hashes that we will need to take care of here, and does not open the
// /etc/shadow file to lusers.  Only drawback.  System must be using PAM!

// The last_login table keeps track of failures and all that, but
// that's handled by the LastLogin class.
// Sessions are handled by the main auth page.
function verifyPassword($username, $password)
{
	$config_getpwinfo = $GLOBALS["CONFIG"]["getpwinfo"];
	$config_chkpass = $GLOBALS["CONFIG"]["chkpass"];

	if ($username == "root")
	{
		syslog(LOG_NOTICE | LOG_AUTHPRIV ,
			"php3_auth:  attempted root login from " .
			trim(getenv("REMOTE_ADDR")));
		return "Login as root is forbidden.";
	}

	exec("$config_getpwinfo $username", $dummy, $err_num);
	if ($err_num)
	{
		return "User information for $username could not be retrieved.";
	}

	$temp_array = split(":", $dummy[0]);
	$user_id = $temp_array[2];

	$last_login = new LastLogin();

	if (!$last_login->loadLastLogin($user_id))
	{
		if ($last_login->error)
		{
			return $last_login->error;
		}
	}
	else
	{
		if ($last_login->testLockout())
		{
			syslog(LOG_NOTICE | LOG_AUTHPRIV ,
				"php3_auth:  " . $username .
				" failed login from " .
				trim(getEnv("REMOTE_ADDR")) .
				" - account is locked from login failures.");
$error = "Login failed for user \"" . $username . "\".";
$error .= "  The account is temporarily locked due to multiple failed" .
	" login attempts.";
			return $error;
		}
	}

	$auth = exec("$config_chkpass $username \"$password\"",
		$dummy, $err_num);
	if ($err_num)
	{
		$error = "Login failed for user \"" . $username . "\".";
		syslog(LOG_NOTICE | LOG_AUTHPRIV ,
			"php3_auth:  " . $username . " failed login from " .
			trim(getEnv("REMOTE_ADDR")));

		$last_login->loginFailed();

		if (!$last_login->saveLastLogin())
		{
			return $last_login->error;
		}
		return $error;
	}

	$last_login->loginSucceeded();

	if (!$last_login->saveLastLogin())
	{
		return $last_login->error;
	}

	syslog(LOG_NOTICE | LOG_AUTHPRIV ,
		"php3_auth:  $username logged in from " .
		trim(getEnv("REMOTE_ADDR")));

	return 0;
}

?>

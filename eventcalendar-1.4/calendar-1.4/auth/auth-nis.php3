<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: auth-nis.php3,v 1.8 2001/05/27 23:26:46 fluffy Exp $  

include('../auth/last_login.php3');
include('sql/sql.php3');

// This is rather simple.  we verify the username and password
// using /etc/shadow on the local system.
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

	exec("$config_chkpass $username", $dummy, $err_num);
	if ($err_num)
	{
		$error = "Login failed for user \"" . $username . "\".";
		syslog(LOG_NOTICE | LOG_AUTHPRIV ,
			"php3_auth:  " . $username . " failed login from " .
			trim(getEnv("REMOTE_ADDR")));
		return $error;
	}
	$shadow = $dummy[0];

	unset($dummy);
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


// Bruce Tenison is a work-a-holic.  He made this thing look for MD5 salts.
	if (!strcmp("$1$", substr($shadow, 0, 3)))
	{
// MD5 salt
		$salt = substr($shadow, 0, 12);
	}
	else
	{
// crypt salt
		$salt = substr($shadow, 0, 2);
	}	
	$crypted = crypt($password, $salt); 

	if (strcmp($crypted, $shadow))
	{
		$error = "Login failed for user \"" . $username . "\".";
		syslog(LOG_NOTICE | LOG_AUTHPRIV ,
			"php3_auth:  " . $username . " failed login from " .
			trim(getEnv("REMOTE_ADDR")));

		$last_login->loginFailed();
		
		if (!$last_login->saveLastLogin())
		{
			if ($last_login->error)
			{
				return $last_login->error;
			}
			else
			{
				return "Last Login information could not be saved.";
			}
		}

		return $error;
	}

	$last_login->loginSucceeded();

	if (!$last_login->saveLastLogin())
	{
		if ($last_login->error)
		{
			return $last_login->error;
		}
		else
		{
			return "Last Login information could not be saved.";
		}
	}

	syslog(LOG_NOTICE | LOG_AUTHPRIV ,
		"php3_auth:  $username logged in from " .
		trim(getEnv("REMOTE_ADDR")));

	return 0;
}

?>

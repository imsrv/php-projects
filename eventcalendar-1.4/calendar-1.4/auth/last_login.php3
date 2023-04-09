<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: last_login.php3,v 1.8 2001/05/27 23:26:46 fluffy Exp $  

if (!$LAST_LOGIN_INCLUDED)
{
	$LAST_LOGIN_INCLUDED = 1;

	include('sql/sql.php3');

	class LastLogin
	{

// Contains all the vars from the table and an error var.
// exists tells us whether to insert a new row or update an existing one
		var $failures, $recent_failures, $failure_timestamp,
			$last_failed_source, $user_id, $last_login_source,
			$login_timestamp, $exists, $error;

		function LastLogin($new_user_id = "")
		{
// if a user_id is supplied, try to load the info from the table
			if ($new_user_id)
			{
				$this->user_id = $new_user_id;
				$this->loadLastLogin();
			}

			return $this;
		}

		function loadLastLogin($new_user_id = "")
		{
			if ($new_user_id)
			{
				$this->user_id = $new_user_id;
			}

			if (!$this->user_id)
			{
$this->error = "Tried to load last login info without a user ID.";
				return 0;
			}

// try to load the info from the table
			if (!$my_conn = connectROToAuth())
			{
				$this->error = $php_errormsg;
				return 0;
			}

			$my_query = "SELECT * FROM last_login WHERE user_id = " .
				$this->user_id;
			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				$this->error = $php_errormsg;
				return 0;
			}

// if there's no info in the table, set exists to 0...
			if (!$temp_array = @pg_fetch_array($result_id, 0))
			{
				$this->exists = 0;
				return 0;
			}

// otherwise load the info into the instance vars and set exists to 1
			$this->user_id = $temp_array["user_id"];
			$this->failures = $temp_array["failures"];
			$this->recent_failures = $temp_array["recent_failures"];
			$this->failure_timestamp = $temp_array["failure_timestamp"];
			$this->last_failed_source = $temp_array["last_failed_source"];
			$this->last_login_source = $temp_array["last_login_source"];
			$this->login_timestamp = $temp_array["login_timestamp"];
			$this->exists = 1;

			return $this;
		}

// either insert or udpate depending on exists
		function saveLastLogin()
		{
			if (!$this->exists)
			{
$my_query = "INSERT INTO last_login( user_id, failures, recent_failures," .
"failure_timestamp, last_failed_source, last_login_source, login_timestamp )" .
" VALUES ( " . $this->user_id . ", " . ($this->failures ? $this->failures : 0)
. ", " . ($this->recent_failures ? $this->recent_failures : 0) . ", " .
($this->failure_timestamp ? $this->failure_timestamp : 0) . ", " .
($this->last_failed_source ? "'" . $this->last_failed_source . "'" : "NULL") .
", " . ($this->last_login_source ? "'" . $this->last_login_source . "'" : "NULL")
. ", " . ($this->login_timestamp ? $this->login_timestamp : 0) . " )";
			}
			else
			{
$my_query = "UPDATE last_login SET failures = " .
($this->failures ? $this->failures : 0) .
", recent_failures = " .
($this->recent_failures ? $this->recent_failures : 0) .
", failure_timestamp = " .
($this->failure_timestamp ? $this->failure_timestamp : 0) .
", last_failed_source = " .
($this->last_failed_source ? "'" . $this->last_failed_source . "'" : "NULL")
. ", last_login_source = " .
($this->last_login_source ? "'" . $this->last_login_source . "'" : "NULL")
. ", login_timestamp = "
. $this->login_timestamp . " WHERE user_id = " . $this->user_id;
			}

			if (!$my_conn = connectRWToAuth())
			{
				$this->error = $php_errormsg; 
				return 0;
			}

			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				$this->error = $php_errormsg; 
				return 0;
			}

			return $this;
		}

// if the failure_timestamp is set to something after the current time,
// then the account is considered locked until that time
		function testLockout()
		{
			if ($this->failure_timestamp > time())
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

// set all the failure stuff...
// keeping track of recent failures to determine lockout status,
// and keeping track of total failures to be reported on a successful login
		function loginFailed()
		{
			($this->failure_timestamp > $this->login_timestamp) ?
				$this->failures++ : $this->failures = 1;
			((time() - $this->failure_timestamp) < 30 ) ?
				$this->recent_failures++ : $this->recent_failures = 1;
			$this->failure_timestamp = time();
			if ($this->recent_failures >= 5)
			{
				$this->failure_timestamp += 30;
			}
			$this->last_failed_source = trim(getEnv("REMOTE_ADDR"));

			return $this;
		}

// update all the login stuff
		function loginSucceeded()
		{
			if ($this->failure_timestamp <= $this->login_timestamp)
			{
				$this->failures = 0;
			}

			$this->last_login_source = trim(getEnv("REMOTE_ADDR"));
			$this->login_timestamp = time();

			return $this;
		}
	}
}
?>

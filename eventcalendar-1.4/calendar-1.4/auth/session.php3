<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: session.php3,v 1.12 2001/05/28 15:42:38 fluffy Exp $  

if (!$SESSION_INCLUDED)
{
	$SESSION_INCLUDED = 1;

	include('sql/sql.php3');
	include('../auth/permissions.php3');
	include('../auth/last_login.php3');

	class SRCSession
	{
// contains vars from table and an error var
// old_key is used when the session is renewed, so we can update the old row
		var $session_key, $user_id, $username, $gecos, $expires,
			$source_host, $permissions, $old_key, $error,
			$permissions_list;

		function SRCSession($new_user = "", $new_expires = 0)
		{
// if there's no user ID then don't do anything, otherwise create a new session
// the expire time defaults to 10 minutes from now
			if (!$new_user)
			{
				return $this;
			}

			if (!$new_expires)
			{
				$new_expires = time() + 600;
			}

			$this->username = $new_user;
			$this->expires = $new_expires;

// Getting info from /etc/passwd
			exec($GLOBALS["CONFIG"]["getpwinfo"] . " $new_user",
				$dummy, $err_num);
			if ($err_num)
			{
				$this->error = "Could not retrieve user information.";
				return 0;
			}

			$temp_array = split(":", $dummy[0]);
			$this->user_id = $temp_array[2];
			$this->gecos = $temp_array[4];

// fetch permissions with the UID
			$this->loadPermissions();

			$this->source_host = trim(getEnv("REMOTE_ADDR"));
			$this->session_key = $this->generateKey();

			return $this;
		}

		function generateKey($salt = "")
		{
// we use md5 here to encrypt all the session info, which is concated to 1 string
// the md5 salt is the crypt string generated from this big string w/random salt
			$base = $this->user_id . $this->username . $this->gecos .
				$this->expires . $this->source_host . $this->permissions;
			$md5_salt = substr(crypt($base, $salt), 0, 12);
			return crypt($base, "\$1\$" . $md5_salt);
		}

		function loadSession($new_key)
		{
// load info from the database
			if (!$my_conn = connectROToAuth())
			{
				$this->error = $php_errormsg;
				return 0;
			}

			$my_query = "SELECT * FROM session WHERE session_key = '" .
				$new_key . "'";
			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				$this->error = $php_errormsg;
				return 0;
			}

			if (!$temp_array = @pg_fetch_array($result_id, 0))
			{
				$this->error = $php_errormsg;
				return 0;
			}

			$this->session_key = $temp_array["session_key"];
			$this->user_id = $temp_array["user_id"];
			$this->username = $temp_array["username"];
			$this->gecos = $temp_array["gecos"];
			$this->expires = $temp_array["expires"];
			$this->source_host = $temp_array["source_host"];
			$this->old_key = $this->session_key;

			$this->loadPermissions();

			return $this;
		}

		function verifySession($new_key = "")
		{
// regenerate the key using the 3rd and 4th character as the salt
// the md5 salt is $2$ and a crypt string generated from the session info, so
// to properly regenerate the md5 string, we grab the crypt salt
			if ($new_key)
			{
				if (!$this->loadSession($new_key))
				{
					return 0;
				}
			}

			if (($this->expires < time()) ||
				($this->source_host != trim(getEnv("REMOTE_ADDR"))) ||
				($this->generateKey(substr($this->session_key,3,2))
				!= $this->session_key))
			{
				$this->error = "Key has expired or is otherwise invalid.";
				return 0;
			}

			return $this;
		}

		function renewSession($new_expires = 0)
		{
// reset the expiration timestamp and regen the key
			if (!$new_expires)
			{
				$new_expires = $this->expires + 600;
			}

			$this->loadPermissions();

			$this->expires = $new_expires;
			$this->session_key = $this->generateKey();
		}

		function saveSession()
		{
// insert a new row, or update an old one if we have the old key
			if (!$this->old_key)
			{
$my_query = "INSERT INTO session( session_key, username, user_id, " .
"gecos, expires, source_host ) VALUES ( '" . $this->session_key .
"', '" . $this->username . "', " . $this->user_id . ", '" . $this->gecos .
"', " . $this->expires . ", '" . $this->source_host . "' )";
			}
			else
			{
$my_query = "UPDATE session SET session_key = '" . $this->session_key .
"', expires = ". $this->expires . " WHERE session_key = '" . $this->old_key .
"'";
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

// a little garbage collection here to get rid of expired sessions
			@pg_exec($my_conn,
				"DELETE FROM session WHERE expires < " . time());

// setting the cookie.  we also set the session key as an environment variable,
// because the cookie won't be available until the next page is loaded.
			SetCookie("SRCSessionKey", $this->session_key, $this->expires, "/");
			putEnv("SRCSessionKey=" . $this->session_key);
			return $this;
		}

		function killSession($key = "")
		{
// remove the session from the database and delete the cookie
// a key supplied to this function will delete that session instead of the
// currently loaded one
			if ($key)
			{
				$my_query = "DELETE FROM session WHERE session_key = '"
					. $key . "'";
			}
			else
			{
				$my_query = "DELETE FROM session WHERE session_key = '"
					. $this->session_key . "'";
			}

			if (!$my_conn = connectRWToAuth())
			{
				$this->error = $php_errormsg;
				return $this->error;
			}
			if (!$result_id = @pg_exec($my_conn, $my_query))
			{
				$this->error = $php_errormsg;
				return $this->error;
			}

			SetCookie("SRCSessionKey", "", 0, "/");
			return 0;
		}

		function outputSessionStatus()
		{
			$last_login = new LastLogin($this->user_id);
			echo("You are currently logged in as " .
				$this->username . ".<BR>\n");
			echo("Your session will expire " .
				($GLOBALS["CONFIG"]["daybeforemonth"] == 0 ?
				date("m/j/Y h:iA", $this->expires) :
				date("j/m/Y h:iA", $this->expires)) .
				", but please log out (using the &quot;Logout&quot; box)" .
				" if you finish before then.<BR>\n");
			if ($last_login->failures)
			{
				echo($last_login->failures .
					" failures since your last login.<BR>\n");
			}
		}

		function loadPermissions()
		{
			$this->permissions = $GLOBALS["pDefault"];
			unset($this->permissions_list);
			$db_conn = connectROToAuth();
			$query = "SELECT * from permissions WHERE user_id = "
				. $this->user_id;
			$result_id = @pg_exec($db_conn, $query);
			$i = 0;
			while ($perms = @pg_fetch_array($result_id, $i++))
			{
				if (($loc = $perms["location_id"]) == -1)
				{
					$this->permissions = $perms["permissions"];
				}
				$this->permissions_list["$loc"] = $perms["permissions"];
			}
		}
	}
}
?>

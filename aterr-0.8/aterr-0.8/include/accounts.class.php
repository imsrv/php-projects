<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class accounts
{
	function create_account($username, $password, $email, &$error)
	{
		global $db, $session, $config;

		$sql = 'SELECT 1
			FROM users u
			WHERE u.username = "%s" OR u.user_email = "%s"';

		$sql = sprintf($sql, $username, $email);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (!empty($data))
		{
		    $error = 'Either the username or the email address you entered is in use. Please choose another.';
			return false;
		}

		$activation_code = rand(1, 400000);
		$activation_code = substr(md5($activation_code), 0, 12);

		$md5_password = md5($password);

		/* generate the next user id */

		$sql = 'SELECT u.user_id
			FROM users u
			ORDER BY u.user_id DESC
			LIMIT 1';

		$db->sql_query($sql);
		$db->sql_data($data, true);

		$user_id = @implode('', $data) + 1;

		$sql = 'INSERT INTO users (
			user_id, username, user_password, user_email, user_active, user_actkey, user_regdate
			) VALUES (
			%d, "%s", "%s", "%s", 0, "%s", %d
			)';

		$sql = sprintf($sql, $user_id, $username, $md5_password, $email, $activation_code, time());

		$db->sql_query($sql);

		$message = "Hi %s,

Thankyou for signing up at %s!  Before you can sign in and use your account, you must
activate your account. Please follow the link below to do so:
 --> %s

If you do not activate your account within 3 days, your new account will be deleted from the
database, and will be free to use by other people.

As a reminder, the details you registered with are below:

\tusername: %s
\tpassword: %s

If you did not sign up at %s, please ignore this email. If you repeatedly get a
registration email, please contact %s.

If you need help activating your account, please contact %s.

--
%s";

		$activation_link = 'http://' . $config['domain_name'] . $config['install_path'] . accounts::aurl('activate', $activation_code);

		$activation_link = str_replace('&amp;', '&', $activation_link);

		$message = sprintf($message, $username, $config['site_name'], $activation_link,
			$username, $password, $config['site_name'], $config['contact_email'],
			$config['contact_email'], $config['email_signature']);

		$to = $email;
		$subject = '[' . $config['site_name'] . '] Account Activation';
		$headers = sprintf("From: %s <%s>\r\n", $config['contact_name'], $config['contact_email']);

		$mailed = mail($email, $subject, $message, $headers);

		if (!$mailed)
		{
		    $error = sprintf('Unable to send you the activation mail. Please contact <a href="mailto:%s">%s</a> from the email address you have signed up with for assistance.', $config['contact_email'], $config['contact_email']);
			return false;
		}

		return true;
	}

	function activate_account($activation_key, &$error)
	{
		global $db;

		$sql = 'SELECT u.*
			FROM users u
			WHERE u.user_actkey = "%s"';

		$sql = sprintf($sql, $activation_key);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!empty($data))
		{
		    $sql = 'UPDATE users
		    	SET user_active = 1
			WHERE user_actkey = "%s"';

			$sql = sprintf($sql, $activation_key);

			$db->sql_query($sql);

			return true;
		}

		$error = 'The activation key you have entered is invalid.';

		return false;
	}

	function signin($username, $password)
	{
		global $session, $db;

		$error = '';

		if (!$username)
		{
			$error = 'No username supplied.';
		}
		else if (!$password)
		{
			$error = 'No password supplied';
		}
		else
		{
			$password = md5($password);

			$sql = 'SELECT u.user_id, u.user_password, u.user_active
				FROM users u
				WHERE u.username = "%s"';

			$sql = sprintf($sql, $username);

			$db->sql_query($sql);
			$db->sql_data($data, true);

			if (empty($data) || $data['user_password'] != $password)
			{
				$error = 'Username/password combination are incorrect.';
			}
			else if (!$data['user_active'])
			{
				$error = 'Account has not yet been activated.';
			}
			else
			{
				$session->signin($data['user_id']);
			}
		}

		if ($error)
		{
			echo 'An error occured: ' . $error;
		}
	}

	function aurl($opt1 = '', $opt2 = '', $opt3 = '')
	{
		switch ($opt1)
		{
			case 'register':
			case 'help':
			case 'editsig':
			case 'changepass':

				if ($opt2)
				{
					return (REWRITE ? "accounts/$opt1/$opt2" : "accounts.php?op=$opt1&amp;sub=$opt2");
				}

				return (REWRITE ? "accounts/$opt1" : "accounts.php?op=$opt1");

			case 'activate':

				return (REWRITE ? "accounts/activate/$opt2" : "accounts.php?op=activate&amp;key=$opt2");

			case 'signin':
			case 'signout':

				return (REWRITE ? "accounts/$opt1?from=$opt2" : "accounts.php?op=$opt1&amp;from=$opt2");

			case 'viewprofile':

				return (REWRITE ? "accounts/viewprofile/$opt2" : "accounts.php?op=viewprofile&amp;u=$opt2");

			default:

				return (REWRITE ? "accounts" : "accounts.php");
		}
	}
}

?>

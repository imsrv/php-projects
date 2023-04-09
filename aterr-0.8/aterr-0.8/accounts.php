<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

define('INCLUDE_PATH', 'include/');
include_once INCLUDE_PATH . 'common.inc.php';

include_once INCLUDE_PATH . 'accounts.class.php';
$account = new accounts;

echo $display->header();

if (empty($_GET['op']))
{
	$op = 'index';
}
else
{
	$op = $_GET['op'];
	$location = array(
		'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
		'<a href="' . $config['install_path'] . accounts::aurl() . '">Accounts</a>'
	);

	$sub = '';

	if (!empty($_GET['sub']))
	{
		$sub = $_GET['sub'];
	}
}

switch ($op)
{
	case 'signin':

		$title = 'Sign In';

		$username = (!empty($_POST['username'])) ? $_POST['username'] : '';
		$password = (!empty($_POST['password'])) ? $_POST['password'] : '';

		$from = (isset($_GET['from']) ? $_GET['from'] : $config['domain_name'] . $config['install_path'] . accounts::aurl());

		if ($session->logged_in == true)
		{
			redirect('http://' . urldecode($from));
		}

		$account->signin($username, $password);

		break;

	case 'signout':

		$title = 'Sign Out';

		$from = (isset($_GET['from']) ? $_GET['from'] : $config['domain_name'] . $config['install_path'] . accounts::aurl());

		$session->signout();

		redirect('http://' . urldecode($from));

		break;

	case 'editsig':

		$title = 'Edit Signature';

		if (!$session->logged_in)
		{
			/* must be signed in to edit signature */
			redirect('http://' . $config['domain_name'] . $config['install_path'] . accounts::aurl());
		}

		if ($sub == 'update')
		{
			$signature = $_POST['signature'];

			$a_sig = explode("\n", $signature);

			if (count($a_sig) > 3)
			{
				$a_sig = array_splice($a_sig, 0, 3);
				$signature = implode("\n", $a_sig);
			}

			if (strlen($signature) > 200)
			{
				$signature = substr($signature, 0, 200);
			}

			$sql = 'UPDATE users
				SET user_sig = "%s"
				WHERE user_id = %d';

			$sql = sprintf($sql, $signature, $session->user_id);

			$db->sql_query($sql);

			echo '<p>Your signature has been updated.</p>';
		}
		else
		{
?>
<p>To change your signature, simply enter it in the box below. If you wish to have no
	signature, delete all text from the text box and click submit.</p>
<p>Signatures may be a maximum of 3 lines and 200 characters. You may use normal forum
	formatting in your signature.</p>
<p>Signatures will appear under all posts you make on the forums.</p>
<form action="<?php echo $config['install_path'] . accounts::aurl('editsig', 'update'); ?>" method="post">
	<table class="forum">
		<tr>
			<td valign="top"><textarea style="width:350px; height: 100px" name="signature"><?php echo stripslashes($session->userdata['user_sig']); ?></textarea></td>
		</tr>
		<tr>
			<td align="center"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
	</form>
<?php
		}

		break;

	case 'changepass':

		$title = 'Change Password';

		if ($sub == 'update')
		{
			if (!empty($_POST['oldpass']) && $session->userdata['user_password'] == md5($_POST['oldpass']))
			{
				if (!empty($_POST['newpass']) && !empty($_POST['repeatpass']) && md5($_POST['newpass']) == md5($_POST['repeatpass']))
				{
					$sql = 'UPDATE users
						SET user_password = "%s"
						WHERE user_id = %d';

					$sql = sprintf($sql, md5($_POST['newpass']), $session->user_id);

					$db->sql_query($sql);

					echo '<p>Your password has been changed successfully. An email has been sent
						to your stored email address for your convenience.</p>';

					$message = "Hi %s,

Your password has been changed on %s successfully. Here
are your new login details:

\tusername: %s
\tpassword: %s

You can login at %s immediately with your new password.

If you did not request this change, please contact %s
immediately, giving the time you received this message and your username
so we may take action.

--
%s";

					$message = sprintf($message,
						$session->userdata['username'],
						$config['site_name'],
						$session->userdata['username'],
						$_POST['newpass'],
						$config['domain_name'] . $config['install_path'] . forums::furl(),
						$config['contact_email'],
						$config['email_signature']
					);

					$headers = sprintf("From: %s <%s>\r\nContent-type: text/plain; charset=\"iso-8859-1\"\r\n", $config['contact_name'], $config['contact_email']);

					@mail($session->userdata['user_email'], 'Password Change', $message, $headers)
						or printf('<p>Error: an email informing you of your new password could not be sent. Please contact <a href="mailto:%s">%s</a> informing them of this error.</p>',
							$config['contact_email'], $config['contact_name']);
				}
				else
				{
					echo '<p>The passwords you entered did not match.</p>';
				}
			}
			else
			{
				echo '<p>The current password you entered was incorrect.</p>';
			}
		}
		else
		{
?>
<p>To change your password, please enter your current password in the text box below, and
	enter your chosen new password in the remaining two text boxes. After you click
	submit, your new password will take effect immediately.</p>
<form action="<?php echo $config['install_path'] . accounts::aurl('changepass', 'update'); ?>" method="post">
	<table class="forum">
		<tr>
			<td align="right" valign="top">Current Password:</td>
			<td valign="top"><input type="password" name="oldpass" style="width:400px" value="" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">New Password:</td>
			<td valign="top"><input type="password" name="newpass" style="width:400px" value="" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Repeat Password:</td>
			<td valign="top"><input type="password" name="repeatpass" style="width:400px" value="" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
</form>
<?php
		}

		break;

	case 'viewprofile':

		$user = $_GET['u'];

		$sql = 'SELECT u.*
			FROM users u
			WHERE u.user_id = %d';

		$sql = sprintf($sql, $user);

		$db->sql_query($sql);
		$db->sql_data($user, true);

		$title = 'Profile: ' . $user['username'];

		echo '<p>';

		echo 'Joined: ' . date('d M Y', $user['user_regdate']) . '<br />';
		echo 'Last Visit: ' . date(' d M Y', $user['user_lastvisit']) . '<br />';

		if (!empty($user['user_title']))
		{
			echo '<i>' . $user['user_title'] . '</i><br />';
		}

		echo '</p>';

		if (!empty($user['user_sig']))
		{
			echo '<p><i>Signature</i>:</p>' . format_text($user['user_sig']);
		}

		break;

	case 'register':

		if ($session->logged_in)
		{
			/* already signed in and therefore registered */
			redirect('http://' . $config['domain_name'] . $config['install_path'] . accounts::aurl());
		}

		$title = 'Register';
		$valid = false;
		$error_text = '';

		$username = (!empty($_POST['username']) ? $_POST['username'] : '');
		$password = (!empty($_POST['password']) ? $_POST['password'] : '');
		$pass_confirm = (!empty($_POST['password_confirm']) ? $_POST['password_confirm'] : '');
		$email = (!empty($_POST['email']) ? $_POST['email'] : '');
		$email_confirm = (!empty($_POST['email_confirm']) ? $_POST['email_confirm'] : '');

		if ($sub == 'process')
		{
			/* check all values entered, including matching passwords */

			if (!$username)
			{
			    $error_text .= '<li>No username entered.</li>';
			}
			if (!preg_match("/^([A-z0-9\-\_]+)$/", $username))
			{
				$error_text .= '<li>Your username may only be one word, and can consist of only alphanumeric characters.</li>';
			}
			if (!$password)
			{
			    $error_text .= '<li>No password entered.</li>';
			}
			if ($password != $pass_confirm)
			{
			    $error_text .= '<li>Passwords do not match.</li>';
			}
			if (!$email)
			{
			    $error_text .= '<li>No email address entered.</li>';
			}
			if (!check_email_format($email))
			{
				$error_text .= '<li>Email address is in an invalid format.</li>';
			}
			if ($email != $email_confirm)
			{
			    $error_text .= '<li>Email addresses do not match.</li>';
			}

			if (!$error_text)
			{
				/* no error, create the account */

				if (!$account->create_account($username, $password, $email, $create_error))
				{
			    	$error_text .= '<li>' . $create_error . '</li>';
				}
				else
				{
					$valid = true;
				}
			}
		}

		if (!$valid)
		{
			if ($error_text)
			{
			    echo '<p>The following errors were detected, please correct them before registration can continue.</p>';
				echo '<ul>' . $error_text . '</ul>';
			}

			?>
			<div class="data">
			<form action="<?php echo $config['install_path'] . accounts::aurl('register', 'process'); ?>" method="post">
			<table class="form">
				<tr>
					<td align="right" valign="top">Username:<br /><span class="smaller">the name you will be known by.</span></td>
					<td valign="top"><input style="width:400px" type="text" name="username" value="<?php echo $username; ?>" /></td>
				</tr>
				<tr>
					<td align="right" valign="top">Password:<br /><span class="smaller">please use a unique password <br />not including common words/phrases.</span></td>
					<td valign="top"><input style="width:400px" type="password" name="password" value="" /></td>
				</tr>
				<tr>
					<td align="right" valign="top">Repeat Password:<br /><span class="smaller">enter exactly as above.</span></td>
					<td valign="top"><input style="width:400px" type="password" name="password_confirm" value="" /></td></tr>
				<tr>
					<td align="right" valign="top">Email Address:<br /><span class="smaller">an active, valid e-mail address <br />required to complete registration.</span></td>
					<td valign="top"><input style="width:400px" type="text" name="email" value="<?php echo $email; ?>" /></td>
				</tr>
				<tr>
					<td align="right" valign="top">Repeat Email Address:<br /><span class="smaller">confirm the e-mail entered above.</span></td>
					<td valign="top"><input style="width:400px" type="text" name="email_confirm" value="" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
			</form>
			</div><?php
		}
		else
		{
			printf('<p>Thank you for registering at <a href="http://%s">%s</a>. An email has been sent to
				the address you specified. Please follow the instructions within the email to activate your account and
				complete registration.</p>', $config['domain_name'] . $config['install_path'] . forums::furl(), $config['site_name']);
		}

		break;

	case 'activate':

		if ($session->logged_in)
		{
			/* already signed in and therefore activated */
			redirect('http://' . $config['domain_name'] . $config['install_path'] . accounts::aurl());
		}

		$act_key = '';

		if (!empty($_GET['key']))
		{
			$act_key = $_GET['key'];
		}

		if ($act_key)
		{
			if ($account->activate_account($act_key, $activation_error))
			{
				$title = 'Account Activated';

				echo '<p>Your account has now been activated! You can now sign in and post on the forums.</p>';
			}
			else
			{
				$title = 'Activate Account';

				echo '<p>An error occured: ' .  $activation_error . '</p>';
			}
		}

		break;

	case 'index':

		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>'
		);

		$title = 'Accounts';

		echo '<p>This is where you can manage your account at ' . $config['site_name'] . '; below is some general information about
		the user you are currently logged in as, as well as controls to edit your personal information.</p>';

		echo '<ul>';

		if (!$session->logged_in)
		{
			echo '<li><a href="' . $config['install_path'] . accounts::aurl('register') . '">Register Account</a></li>';
		}
		else
		{
			echo '<li><a href="' . $config['install_path'] . accounts::aurl('editsig') . '">Edit Signature</a></li>';
			echo '<li><a href="' . $config['install_path'] . accounts::aurl('changepass') . '">Change Password</a></li>';
			echo '<li><a href="' . $config['install_path'] . accounts::aurl('signout', $config['domain_name'] . $_SERVER['REQUEST_URI']) . '">Sign Out</a></li>';
		}

		echo '</ul>';

		break;

	default:

		redirect('http://' . $config['domain_name'] . $config['install_path'] . accounts::aurl());

		break;
}

echo $display->footer();
$display->output();

?>

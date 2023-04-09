<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

error_reporting(E_ALL);
ob_start();

/* get recommended values for config table */

$config['domain_name'] = (!empty($_POST['c_domain_name']) ? $_POST['c_domain_name'] : $_SERVER['HTTP_HOST']);
$config['install_path'] = (!empty($_POST['c_install_path']) ? $_POST['c_install_path'] : dirname($_SERVER['PHP_SELF']) . '/');
$config['cookie_domain'] = (!empty($_POST['c_cookie_domain']) ? $_POST['c_cookie_domain'] : $config['domain_name']);
$config['cookie_path'] = (!empty($_POST['c_cookie_path']) ? $_POST['c_cookie_path'] : $config['install_path']);
$config['system_path'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/';

/* default database name and permission */

$db['name'] = (!empty($_POST['d_name']) ? $_POST['d_name'] : '');
$db['user'] = (!empty($_POST['d_user']) ? $_POST['d_user'] : '');
$db['host'] = (!empty($_POST['d_host']) ? $_POST['d_host'] : '');
$db['thishost'] = ($db['host'] == 'localhost' ? 'localhost' : '*');
$db['userpass'] = (!empty($_POST['d_userpass']) ? $_POST['d_userpass'] : '');
$db['rootpass'] = (!empty($_POST['d_rootpass']) ? $_POST['d_rootpass'] : '');
$db['gen_userpass'] = ($db['userpass'] ? $db['userpass'] : md5(uniqid(rand(), true)));

/* versions */

$version['php'] = phpversion();
$version['aterr'] = '0.8';
$version['aterr_latest'] = $version['aterr'];

/* permission checks */

$permission['config'] = is_writable($config['system_path'] . 'include/config.inc.php');
$permission['safe_mode'] = ini_get('safe_mode');

/* user details */

$user['name'] = (!empty($_POST['u_name']) ? $_POST['u_name'] : '');
$user['pass'] = (!empty($_POST['u_pass']) ? $_POST['u_pass'] : '');
$user['pass2'] = (!empty($_POST['u_pass2']) ? $_POST['u_pass2'] : '');
$user['email'] = (!empty($_POST['u_email']) ? $_POST['u_email'] : '');

$error = array(
	'db' => '',
	'user' => ''
);

$db_tables = array('config', 'bookmarks', 'categories', 'data', 'data_categories', 'forums', 'permissions', 'post_read', 'posts', 'report_categories', 'reports', 'sessions', 'user_permission', 'users');

/* sql queries */

$sql['db_create'] =	sprintf('CREATE DATABASE %s', $db['name']);
$sql['user_create'] =	sprintf('GRANT USAGE ON *.* TO "%s"@"%s" IDENTIFIED BY "%s"', $db['user'], $db['thishost'], $db['gen_userpass']);
$sql['user_grant'] =	sprintf('GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES ON `%s`.* TO "%s"@"%s"', $db['name'], $db['user'], $db['thishost']);

$sql['tables'] = array(
	'config' => "CREATE TABLE config (name varchar(255) NOT NULL default '', value varchar(255) NOT NULL default '', PRIMARY KEY (name)) TYPE=MyISAM",
	'bookmarks' => "CREATE TABLE bookmarks (user_id mediumint(8) NOT NULL default '0', post_id mediumint(8) NOT NULL default '0', email tinyint(1) NOT NULL default '0', email_sent tinyint(1) NOT NULL default '0', KEY user_id (user_id,post_id)) TYPE=MyISAM",
	'categories' => "CREATE TABLE categories (id mediumint(8) NOT NULL default '0', title varchar(255) NOT NULL default '', unix_title varchar(255) NOT NULL default '', image_path varchar(255) NOT NULL default '', description text NOT NULL, PRIMARY KEY (id)) TYPE=MyISAM",
	'data' => "CREATE TABLE data (id mediumint(8) NOT NULL default '0', date int(11) NOT NULL default '0', title varchar(255) NOT NULL default '', unix_title varchar(255) NOT NULL default '', u_id mediumint(8) NOT NULL default '0', text text NOT NULL, format_type varchar(10) NOT NULL default 'text', ip_addr varchar(15) NOT NULL default '', PRIMARY KEY (id), FULLTEXT KEY title (title,text)) TYPE=MyISAM",
	'data_categories' => "CREATE TABLE data_categories (c_id mediumint(8) NOT NULL default '0', d_id mediumint(8) NOT NULL default '0', `order` mediumint(8) NOT NULL default '0') TYPE=MyISAM",
	'forums' => "CREATE TABLE forums (id mediumint(8) NOT NULL default '0', is_forum tinyint(1) NOT NULL default '0', position mediumint(8) NOT NULL default '0', parent_id mediumint(8) NOT NULL default '0', posts mediumint(8) NOT NULL default '0', PRIMARY KEY (id)) TYPE=MyISAM",
	'permissions' => "CREATE TABLE permissions (id mediumint(8) NOT NULL default '0', name varchar(50) NOT NULL default '', sub_id mediumint(8) NOT NULL default '0', description varchar(250) NOT NULL default '', default_flags mediumint(8) NOT NULL default '0', KEY name (name), KEY id (id)) TYPE=MyISAM",
	'post_read' => "CREATE TABLE post_read (d_id mediumint(8) NOT NULL default '0', u_id mediumint(8) NOT NULL default '0', UNIQUE KEY d_id (d_id,u_id)) TYPE=MyISAM",
	'posts' => "CREATE TABLE posts (d_id mediumint(8) NOT NULL default '0', forum mediumint(8) NOT NULL default '0', parent_id mediumint(8) NOT NULL default '0', fp_id mediumint(8) NOT NULL default '0', is_post tinyint(1) NOT NULL default '0', is_locked tinyint(1) NOT NULL default '0', is_sticky tinyint(1) NOT NULL default '0', is_unapproved tinyint(1) NOT NULL default '0', is_reported tinyint(1) NOT NULL default '0', replies mediumint(8) NOT NULL default '0', last_reply int(11) NOT NULL default '0', edited_by mediumint(8) NOT NULL default '0', edited_time int(11) NOT NULL default '0', reply_ids text NOT NULL, PRIMARY KEY (d_id)) TYPE=MyISAM",
	'report_categories' => "CREATE TABLE report_categories (id mediumint(8) NOT NULL default '0', title text NOT NULL, PRIMARY KEY (id)) TYPE=MyISAM",
	'reports' => "CREATE TABLE reports (id mediumint(8) NOT NULL default '0', p_id mediumint(8) NOT NULL default '0', u_id mediumint(8) NOT NULL default '0', time int(11) NOT NULL default '0', report_category mediumint(8) NOT NULL default '0', description text NOT NULL, PRIMARY KEY (id), KEY p_id (p_id,report_category)) TYPE=MyISAM",
	'sessions' => "CREATE TABLE sessions (id varchar(32) NOT NULL default '', u_id mediumint(8) NOT NULL default '0', ip varchar(40) NOT NULL default '', method varchar(6) NOT NULL default '', time_start int(11) NOT NULL default '0', time_last int(11) NOT NULL default '0', browser varchar(100) NOT NULL default '', page varchar(100) NOT NULL default '', PRIMARY KEY (id), KEY u_id (u_id), KEY ip (ip)) TYPE=HEAP",
	'user_permission' => "CREATE TABLE user_permission (p_id mediumint(8) NOT NULL default '0', sub_id mediumint(8) NOT NULL default '0', u_id mediumint(8) NOT NULL default '0', flags mediumint(8) NOT NULL default '0', PRIMARY KEY (p_id,sub_id,u_id)) TYPE=MyISAM",
	'users' => "CREATE TABLE users (user_id mediumint(8) NOT NULL default '0', user_active tinyint(1) default '0', username varchar(25) NOT NULL default '', user_password varchar(32) NOT NULL default '', user_email varchar(255) default '', user_lastvisit int(11) NOT NULL default '0', user_regdate int(11) NOT NULL default '0', user_posts mediumint(8) unsigned NOT NULL default '0', user_viewemail tinyint(1) default NULL, user_attachsig tinyint(1) default NULL, user_view_online tinyint(1) NOT NULL default '1', user_notify tinyint(1) NOT NULL default '1', user_avatar varchar(100) default NULL, user_icq varchar(15) default NULL, user_website varchar(100) default NULL, user_from varchar(100) default NULL, user_sig text, user_aim varchar(255) default NULL, user_yim varchar(255) default NULL, user_msnm varchar(255) default NULL, user_about text, user_actkey varchar(32) default NULL, user_newpasswd varchar(32) default NULL, user_title varchar(255) NOT NULL default '', PRIMARY KEY (user_id)) TYPE=MyISAM"
);

$sql['config'] = array(
	"INSERT INTO config VALUES ('domain_name', '$config[domain_name]')",
	"INSERT INTO config VALUES ('cookie_domain', '$config[domain_name]')",
	"INSERT INTO config VALUES ('site_name', 'Your Forums')",
	"INSERT INTO config VALUES ('site_desc', 'Subtitle')",
	"INSERT INTO config VALUES ('install_path', '$config[install_path]')",
	"INSERT INTO config VALUES ('contact_email', '$user[email]')",
	"INSERT INTO config VALUES ('contact_name', '$user[name]')",
	"INSERT INTO config VALUES ('cookie_path', '$config[install_path]')",
	"INSERT INTO config VALUES ('guest_sessions', '1')",
	"INSERT INTO config VALUES ('email_signature', 'Thanks,\n$user[name] ($user[email])')",
	"INSERT INTO config VALUES ('site_img', 'aterr-logo.png')",
	"INSERT INTO config VALUES ('rewrite', '0')",
	"INSERT INTO config VALUES ('stats_forums', '0')",
	"INSERT INTO config VALUES ('force_preview', '0')",
	"INSERT INTO config VALUES ('track_read', 'database')"
);

$sql['default_permissions'] = 'INSERT INTO permissions (id, name, sub_id, description, default_flags) VALUES (1, "forums", 0, "Global Forum Permissions", 0)';

$sql['admin_create'] = sprintf('INSERT INTO users (user_id, username, user_password, user_email, user_active, user_actkey, user_regdate) VALUES (1, "%s", "%s", "%s", 1, "", %d)', $user['name'], md5($user['pass']), $user['email'], time());
$sql['admin_permissions'] = 'INSERT INTO user_permission (p_id, sub_id, u_id, flags) VALUES (1, 0, 1, 16883)';

$sql['default_report'] = 'INSERT INTO report_categories (id, title) VALUES (1, " Other - use the description field.")';

function check_latest_version()
{
	global $version;

	if (extension_loaded('curl'))
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'http://chimaera.starglade.org/aterr/latest.txt');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: aterr-' . $version['aterr'] . ' version check'));

		$text = curl_exec($ch);

		if (curl_errno($ch))
		{
			return false;
		}

		curl_close($ch);

		return trim($text);
	}

	return false;
}

/* config file */
$conf_file = <<<CONF
<?php

/*
	This configuration file was automatically generated by aterr-$version[aterr].
	If you wish to make changes, it is recommended that you keep a backup of this file.
*/

\$database = array(
	'host' =>	'$db[host]',
	'user' =>	'$db[user]',
	'password' =>	'$db[gen_userpass]',
	'database' =>	'$db[name]'
);

?>
CONF;

$sub = (!empty($_GET['sub']) ? $_GET['sub'] : '');

if (file_exists($config['system_path'] . 'include/config.inc.php'))
{
	include $config['system_path'] . 'include/config.inc.php';

	if (!empty($database))
	{
		//$sub = 'installed';
	}
}

?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html>
	<head>
		<title>aterr-<?php echo $version['aterr']; ?> installer</title>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $config['domain_name'] . $config['install_path']; ?>style.css" />
	</head>
	<body>
		<p class="location"><a href="http://chimaera.starglade.org/">Chimaera Project</a> <strong>&raquo;</strong> <a href="http://chimaera.starglade.org/aterr/">aterr</a> <strong>&raquo;</strong>
<?php

switch ($sub)
{
	case 'installed':

		echo 'Installed!</p>';
?>
<h1>Installation complete!</h1>
<p>Installation of aterr-<?php echo $version['aterr']; ?> is complete. To administer your <a href="http://<?php echo $config['domain_name'] . $config['install_path']; ?>">new forums</a>, you must first sign in. After signing in, a link to the administration panel will appear at the bottom of the page, just above the copyright notice.</p>
<p>For support with aterr, please visit the <a href="http://chimaera.starglade.org/forums/">official support forums</a>.</p>
<p>For security reasons, please remove this file.</p>
<?php

		break;

	default:

		$php_version_test = (!(!function_exists('version_compare') || (version_compare($version['php'], '4.2.0') == -1)));

		echo 'Installer</p><h1>aterr-' . $version['aterr'] . ' installer</h1>';
?>

<style>
.yes { color: green; }
.no { color: red; }
input.text { width: 200px; }
</style>

<p>Thank you for downloading <b>aterr</b> and choosing to use it as your forum software. Installing aterr is a simple process which this page will guide you through. To continue, please supply the information required.</p>

<?php

		if (!$php_version_test)
		{
			echo '<p>The version of PHP running on this webserver is <b class="no">not</b> capable of running aterr. Please install version 4.2.0 or newer of PHP. PHP can be obtained at <a href="http://www.php.net/">http://www.php.net/</a>.</p>';

			die();
		}

		if ($permission['safe_mode'])
		{
			echo '<p>PHP is running in safe mode on this webserver. Some features of aterr may be disabled.</p>';
		}

		if (empty($_POST))
		{
			$version['aterr_latest'] = check_latest_version();

			if (false !== $version['aterr_latest'])
			{
				if (version_compare($version['aterr_latest'], $version['aterr']))
				{
					echo '<p>You are <b class="no">not</b> installing the latest version of aterr (which is <b>' . $version['aterr_latest'] . '</b>). You can download the latest version from <a href="http://chimaera.starglade.org/aterr/">http://chimaera.starglade.org/aterr/</a>. The latest version may include security fixes and extra features. You can continue with the installation of this version of aterr.</p>';
				}
			}
		}

		if (!$permission['config'])
		{
			echo '<p>aterr <b class="no">cannot</b> create the configuration file. Please make <tt>' . $config['system_path'] . 'include/config.inc.php</tt> writable.</p>';

			echo '<p>To make the configuration file writable on a Unix/Linux system:</p>';
?>
<pre>
	cd <?php echo $config['system_path']; ?>include
	chmod a+w config.inc.php
</pre>
<?php
			die();
		}

		if (!extension_loaded('mysql'))
		{
			echo '<p>MySQL support is <b class="no">not</b> enabled on this webserver. aterr requires MySQL to store data. Please install MySQL, which can be obtained from <a href="http://www.mysql.com/">http://www.mysql.com/">.</p>';
			die();
		}

		$success = '';

		if (!empty($_POST['testconn']) || !empty($_POST['install']))
		{
			$connected = $db_exists = $connected_root = false;
			$errno = 0;

			if (!$db['host'])
			{
				$error['db'] = 'No database host entered.';
			}
			else
			{
				if (false === ($d = @mysql_connect($db['host'], 'root', $db['rootpass'])))
				{
					if ($db['rootpass'] || !$db['user'])
					{
						$error['db'] = 'Tried connecting as <i>root</i>; password incorrect.';
					}
					else
					{
						if (false === ($d = @mysql_connect($db['host'], $db['user'], $db['userpass'])))
						{
							$error['db'] = 'Tried connecting as <i>' . $db['user']. '</i>; password incorrect.';
						}
						else
						{
							$connected = true;
						}
					}
				}
				else
				{
					if (!$db['user'])
					{
						$db['user'] = 'aterr';
					}

					if (false === ($d2 = @mysql_connect($db['host'], $db['user'], $db['userpass'])))
					{
						$error['db'] = 'Password incorrect.';
					}
					else
					{
						$connected = true;
						$connected_root = true;

						mysql_close($d2);
					}
				}

				if ($connected)
				{
					if (!$connected_root && !$db['name'])
					{
						$error['db'] = 'No database name entered.';
					}
					else if ($connected_root)
					{
						if (!$db['name'])
						{
							$db['name'] = 'aterr';
						}

						if (!@mysql_select_db($db['name'], $d))
						{
							$errno = mysql_errno($d);

							switch($errno)
							{
								case '1044': /* access denied */

									$error['db'] = 'Could not access database.';

									break;

								case '1046': /* no database selected */

									if (!$connected_root)
									{
										$error['db'] = 'Database does not exist.';
									}

									break;

								case '1049': /* unknown database */

									if (!$connected_root)
									{
										$error['db'] = 'Could not access database.';
									}

									break;
							}
						}
						else
						{
							$db_exists = true;
						}

						if (!$errno)
						{
							$table_sql = 'SHOW TABLES FROM ' . $db['name'];

							$q = mysql_query($table_sql, $d);

							while ($row = mysql_fetch_row($q))
							{
								if (in_array($row[0], $db_tables))
								{
									$error['db'] = 'The table <i>' . $row[0] . '</i> already exists in this database.';
									break;
								}
							}
						}
					}
				}

				mysql_close($d);
			}

			if (!$error['db'])
			{
				$create_database = ($connected_root && !$db_exists);
				$create_password = ($connected_root && !$db['userpass']);

				$success = sprintf('<tr><td colspan="2" class="even" style="text-align: center"><span class="smaller yes"><b>Connection successful!</b>%s%s</span></td></tr>',
					($create_database ? ' A database called <i>' . $db['name'] . '</i> will be created, ' : ' aterr will connect '),
					(!$create_password ? 'using the username/password you provided.' : 'using the username <i>' . $db['user'] . '</i> and an automatically-generated password.')
				);
			}
		}

		if (!empty($_POST['install']))
		{
			if (!$user['name'])
			{
				$error['user'] = 'No username entered.';
			}
			else if (!preg_match("/^([A-z0-9\-\_]+)$/", $user['name']))
			{
				$error['user'] = 'Your username may only be one word, and can consist of only alphanumeric characters.';
			}
			else if (!$user['pass'])
			{
				$error['user'] = 'No password entered.';
			}
			else if (md5($user['pass']) != md5($user['pass2']))
			{
				$error['user'] = 'Passwords do not match.';
			}
			else if (!$user['email'])
			{
				$error['user'] = 'No email address entered.';
			}
			else if (!preg_match('/[a-zA-Z0-9._%-]+@[a-zA-Z0-9._%-]+\.[a-zA-Z0-9._%-]{2,4}/', $user['email']))
			{
				$error['user'] = 'Email address is invalid.';
			}

			if (!$error['user'] && !$error['db'])
			{
				$fp = fopen($config['system_path'] . 'include/config.inc.php', 'w');
				fwrite($fp, $conf_file, strlen($conf_file));
				fclose($fp);

				if ($connected_root)
				{
					$r = @mysql_connect($db['host'], 'root', $db['rootpass']);

					if ($create_database)
					{
						mysql_query($sql['db_create']);
					}

					if ($create_password)
					{
						mysql_query($sql['user_create']);
					}

					mysql_query($sql['user_grant']);

					mysql_close();
				}

				include 'include/config.inc.php';
				include 'include/db.class.php';

				$d = new sql_db($database['host'], $database['user'], $database['password'], $database['database']);

				foreach ($db_tables as $table)
				{
					$d->sql_query($sql['tables'][$table]);
				}

				foreach ($sql['config'] as $conf)
				{
					$d->sql_query($conf);
				}

				$d->sql_query($sql['admin_create']);
				$d->sql_query($sql['admin_permissions']);
				$d->sql_query($sql['default_permissions']);
				$d->sql_query($sql['default_report']);

				header('Location: http://' . $config['domain_name'] . $config['install_path'] . 'install.php?sub=installed');
			}
		}
?>
<form method="post" action="<?php echo $config['install_path'] . 'install.php'; ?>">
<table class="forum" cellpadding="0" cellspacing="0" width="500px">
	<tr>
		<th colspan="2">Database information</th>
	</tr>
<?php echo ($error['db'] ? '<tr><td colspan="2" class="even" style="text-align: center"><span class="smaller no">' . $error['db'] . '</span></td></tr>' : ($success ? $success : '')); ?>
	<tr>
		<td>MySQL server</td>
		<td><input type="text" name="d_host" class="text" value="<?php echo $db['host']; ?>" />
	</tr>
	<tr>
		<td>Database name</td>
		<td><input type="text" name="d_name" class="text" value="<?php echo $db['name']; ?>" />
	</tr>
	<tr>
		<td>Database username</td>
		<td><input type="text" name="d_user" class="text" value="<?php echo $db['user']; ?>" />
	</tr>
	<tr>
		<td>Database password</td>
		<td><input type="password" name="d_userpass" class="text" value="<?php echo $db['userpass']; ?>" />
	</tr>
	<tr>
		<td>Root password</td>
		<td><input type="password" name="d_rootpass" class="text" value="<?php echo $db['rootpass']; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
	</tr>
	<tr>
		<td colspan="2"><p class="smaller" style="padding: 0; margin: 3px;">You can optionally enter the database root password, which will automatically create the database and user if they do not exist. If you enter the root password, you do not need to specify the database name, username or password.</p>
		<p class="smaller" style="padding: 0; margin: 3px;">Due to the way MySQL handles non-existent users, if you wish to create a new user, you must not enter a password.</p></td>
	</tr>
	<tr>
		<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><input type="submit" name="testconn" value="Test Connection" /></td>
	</tr>
</table>

<table class="forum" cellpadding="0" cellspacing="0" width="500px">
	<tr>
		<th colspan="2">Account details</th>
	</tr>
<?php echo ($error['user'] ? '<tr><td colspan="2" class="even" style="text-align: center"><span class="smaller no">' . $error['user'] . '</span></td></tr>' : '') ?>
	<tr>
		<td>Username</td>
		<td><input type="text" name="u_name" class="text" value="<?php echo $user['name']; ?>" />
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="u_pass" class="text" value="<?php echo $user['pass']; ?>" />
	</tr>
	<tr>
		<td>Repeat password</td>
		<td><input type="password" name="u_pass2" class="text" value="<?php echo $user['pass2']; ?>" />
	</tr>
	<tr>
		<td>Email address</td>
		<td><input type="text" name="u_email" class="text" value="<?php echo $user['email']; ?>" />
	</tr>
</table>

<table class="forum" cellpadding="0" cellspacing="0" width="500px"><tr><td style="text-align: center"><input type="submit" value="Install" name="install" style="font-weight: bold" /></td></tr></table>

</form>
<?php
}
?>

		</div>
	</body>
</html>

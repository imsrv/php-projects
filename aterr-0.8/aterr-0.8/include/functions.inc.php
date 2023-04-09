<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

function __autoload($class)
{
	if (file_exists(INCLUDE_PATH . $class . '.class.php'))
	{
		include_once INCLUDE_PATH . $class . '.class.php';
	}
}

function spellcheck(&$text)
{
	global $config;

	if (!$config['spellcheck'])
	{
		return false;
	}

	$no_html_text = preg_replace('/\<(.*)\>/U', '', $text);

	$words = preg_split('/[\W]+?/', $no_html_text);

	$misspelled = $return = array();

	$int = @pspell_new('en');

	if (!$int)
	{
		return false;
	}

	foreach ($words as $value)
	{
		if (!pspell_check($int, $value))
		{
			$misspelled[] = $value;
		}
	}

	foreach ($misspelled as $value)
	{
		$return[$value] = pspell_suggest($int, $value);
	}

	foreach($return as $key => $value)
	{
		$text = preg_replace("/([\W]+)$key([\W]+)/U", '$1<acronym title="' . (isset($value[0]) ? 'suggested: ' . $value[0] : 'no suggestions') . '" style="border-style: dashed; border-width: 0 0 1px 0; border-color: #f88;">' . $key . '</acronym>$2', $text);
	}

	return true;
}

function microtime_float()
{
	list($usec, $sec) = explode(' ', microtime());

	return ((float) $usec + (float) $sec);
}

function get_config()
{
	global $db;

	$sql = 'SELECT c.*
		FROM config c
		ORDER BY c.name';

	$db->sql_query($sql);
	$db->sql_data($data);

	foreach ($data as $datum)
	{
		$config[$datum['name']] = $datum['value'];
	}

	return $config;
}

function update_config($new_config)
{
	global $db, $config;

	foreach ($new_config as $array)
	{
		$name = $array[0];
		$value = $array[1];

		if (isset($config[$name]))
		{
			$sql = 'UPDATE config
				SET value = "%s"
				WHERE name = "%s"';

			$sql = sprintf($sql, $value, $name);

			$db->sql_query($sql);
		}
		else
		{
			$sql = 'INSERT INTO config (
				name, value
				) VALUES (
				"%s", "%s
				)';

			$sql = sprintf($sql, $name, $value);

			$db->sql_query($sql);
		}
	}
}

function unixify($text)
{
	/* somewhat borrowed from wordpress */

	$text = strtolower($text);

	$text = preg_replace('/&.+?;/', '', $text);
	$text = preg_replace('/[^a-z0-9 -]/', '', $text);
	$text = preg_replace('/\s+/', ' ', $text);

	$text = trim($text);

	$text = str_replace(' ', '-', $text);

	$text = preg_replace('|-+|', '-', $text);

	return $text;
}

function htmlspecialchars_array($array = array())
{
	$rs =  array();

	while (list($key, $value) = each($array))
	{
		if (is_array($value))
		{
			$rs[$key] = htmlspecialchars_array($value);
		}
		else
		{
			$rs[$key] = htmlspecialchars($value);
		}
	}

	return $rs;
}

function unhtmlspecialchars($text)
{
	$trans = get_html_translation_table();
	$trans = array_flip($trans);

	return strtr($text, $trans);
}

function unhtmlspecialchars_array($array = array())
{
	$rs =  array();

	while (list($key, $value) = each($array))
	{
		if (is_array($value))
		{
			$rs[$key] = unhtmlspecialchars_array($value);
		}
		else
		{
			$rs[$key] = unhtmlspecialchars($value);
		}
	}

	return $rs;
}

function cleanup_text($text)
{
	return $text;
}

function format_text($text)
{
	$text = unhtmlspecialchars($text);

	$text = htmlspecialchars($text);

	$text = "\n\n$text\n\n";

	$text = str_replace("\r\n", "\n", $text);
	$text = str_replace("\r", "\n", $text);

	$text = preg_replace('/\/(\s+)\//U', '$1', $text);
	$text = preg_replace('/\*(\s+)\*/U', '$1', $text);

	$text = preg_replace('/\[url\=(.*)\](.*)\[\/url\]/U', '<a href="$1">$2</a>', $text);

	$text = preg_replace('/(\s)(\*|\/|)(http|ftp|irc|https)\:\/\/(\S+)(\*|\/|)(\s)/', '$1<a href="$3://$4">$3://$4</a>$6', $text);
	$text = preg_replace('/(\s)(\*|\/|)www.(\S+)(\*|\/|)(\s)/U', '$1<a href="http://www.$3/">http://www.$3</a>$5', $text);

	$text = preg_replace('/(\s)\/(.+)\/(\s)/msU', '$1<i>$2</i>$3', $text);
	$text = preg_replace('/(\s)\*(.+)\*(\s)/msU', '$1<b>$2</b>$3', $text);

	$text = preg_replace('/(.+)\n\n/m', "$1</p>\n\n", $text);
	$text = preg_replace('/\n\n(.+)/m', "<p>$1", $text);

	$text = preg_replace('/\n(.+)/m', '<br />$1', $text);

	$text = str_replace('</p><p>', "</p>\n\n<p>", $text);

	$text = preg_replace('/\<p\>\[quote\](.+)\[\/quote\]\<\/p\>$/smU', '<blockquote class="forum-quote"><p>$1</p></blockquote>', $text);

	return $text;
}

function redirect($url)
{
	header(str_replace('&amp;', '&', "Location: $url"));
	die('<a href="' . $url . '">' . $url . '</a>');
}

function add_magic_quotes($array)
{
	foreach ($array as $key => $value)
	{
		if (is_array($value))
		{
			$array[$key] = add_magic_quotes($value);
		}
		else
		{
			$array[$key] = addslashes($value);
		}
	}

	return $array;
}

function del_magic_quotes($array)
{
	foreach ($array as $key => $value)
	{
		if (is_array($value))
		{
			$array[$key] = del_magic_quotes($value);
		}
		else
		{
			$array[$key] = stripslashes($value);
		}
	}

	return $array;
}

function check_email_format($email)
{
	return preg_match('/[a-zA-Z0-9._%-]+@[a-zA-Z0-9._%-]+\.[a-zA-Z0-9._%-]{2,4}/', $email);
}

function username_to_id($username)
{
	global $db;

	$sql = 'SELECT u.user_id
		FROM users u
		WHERE u.username = "%s"';

	$sql = sprintf($sql, $username);

	$db->sql_query($sql);
	$db->sql_data($u_id, true);

	return $u_id['user_id'];
}

function id_to_username($id)
{
	global $db;

	$sql = 'SELECT u.username
		FROM users u
		WHERE u.user_id = %d';

	$sql = sprintf($sql, $id);

	$db->sql_query($sql);
	$db->sql_data($user, true);

	if (!empty($user))
	{
		return $user['username'];
	}

	return false;
}

function select_users($text = '*')
{
	global $db;

	$text = str_replace('*', '%', $text);

	$sql = 'SELECT u.username, u.user_id
		FROM users u
		WHERE u.username LIKE "%s"
		ORDER BY u.username ASC';

	$sql = sprintf($sql, $text);

	$db->sql_query($sql);
	$db->sql_data($users);

	return $users;
}

?>

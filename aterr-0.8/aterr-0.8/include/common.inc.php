<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

error_reporting(E_ALL);

function src_include($files)
{
	foreach ($files as $file)
	{
		include_once INCLUDE_PATH . $file . '.class.php';
	}
}

include_once INCLUDE_PATH . 'db.class.php';

include_once INCLUDE_PATH . 'functions.inc.php';
include_once INCLUDE_PATH . 'config.inc.php';

src_include(array(
	'accounts',
	'categories',
	'data',
	'display',
	'forums',
	'permission',
	'session'
));

$db = new sql_db($database['host'], $database['user'], $database['password'], $database['database']);

$config = get_config();

if (false !== ($rw = getenv('ATERR_REWRITE')))
{
	define('REWRITE', true);
}
else
{
	define('REWRITE', $config['rewrite']);
}

if (!get_magic_quotes_gpc())
{
	$_GET = add_magic_quotes($_GET);
	$_POST = add_magic_quotes($_POST);
	$_COOKIE = add_magic_quotes($_COOKIE);
}

$session = new session;
$display = new display;
$data = new data;

?>

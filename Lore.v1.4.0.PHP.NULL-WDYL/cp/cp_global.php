<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

error_reporting (E_ALL & ~E_NOTICE);

require_once('../inc/config.inc.php');
require_once('../third_party/smarty/Smarty.class.php');
require_once('../inc/db_class.inc.php');
require_once('../inc/pt_system.inc.php');
require_once('../inc/user_session.inc.php');
require_once('../inc/category_tree.inc.php');
require_once('../inc/template_engine.inc.php');
require_once('../inc/functions.inc.php');
require_once('../inc/form.inc.php');
require_once('../inc/table_browse.inc.php');
require_once('../inc/lib.inc.php');

///////////////////////////////////////////////////////////////////////////////
// PHP SETTINGS
///////////////////////////////////////////////////////////////////////////////

if( !@get_magic_quotes_gpc() )
{
	my_array_walk($_REQUEST, 'addslashes');
	my_array_walk($_GET, 'addslashes');
	my_array_walk($_POST, 'addslashes');
	my_array_walk($_COOKIE, 'addslashes');
	my_array_walk($_FILES, 'addslashes');
}
@set_magic_quotes_runtime(0);
@ini_set('allow_url_fopen', 0);

///////////////////////////////////////////////////////////////////////////////
// SEND NO-CACHE HEADERS
///////////////////////////////////////////////////////////////////////////////

header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

///////////////////////////////////////////////////////////////////////////////
// SOFTWARE SYSTEM INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

define('IN_PT_SYSTEM', 1);
$lore_system = new lore_system;

///////////////////////////////////////////////////////////////////////////////
// CHECK FOR INSTALL/UPGRADE DIRECTORIES
///////////////////////////////////////////////////////////////////////////////

if( !$CONFIG['development_mode'] )
{
	if( @file_exists('../install') )
	{
		$lore_system->trigger_error('The installation files still exist; this is a security hazard. If you have already installed the software, please delete the "install/" directory before proceeding.');
	}
	if( @file_exists('../upgrade') )
	{
		$lore_system->trigger_error('The upgrade files still exist; this is a security hazard. If you have already run all necessary upgrades, please delete the "upgrade/" directory before proceeding.');
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATABASE INITIALIZATION
///////////////////////////////////////////////////////////////////////////////


$lore_system->db = new db_mysql($CONFIG['db_hostname'], 
				$CONFIG['db_username'], 
				$CONFIG['db_password'], 
				$CONFIG['db_database']);
$lore_system->db->use_persistent_connections = $CONFIG['use_persistent_connections'];
$lore_system->db->error_handler_func = array( &$lore_system, 'trigger_error' );
$lore_system->db->die_on_error = true;

if( !$lore_system->db->connect() )
{
	$lore_system->trigger_error('Unable to connect to the MySQL database at <strong>' . $DB_INFO['hostname'] . '</strong>. Please ensure that a MySQL database server is running, and check your login credentials in the configuration file.');
}
if( !$lore_system->db->select_db() )
{
	$lore_system->trigger_error('Unable to select the MySQL database "' . $DB_INFO['database'] . '". Please ensure that the database exists and that the specified database user can access it.');
}
$lore_system->get_settings();

///////////////////////////////////////////////////////////////////////////////
// USER SESSION INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

$lore_user_session = new lore_user_session;
$lore_user_session->db =& $lore_system->db;
//$lore_user_session->cookie_path = $lore_system->settings['cookie_path'];
//$lore_user_session->cookie_domain = $lore_system->settings['cookie_domain'];
$lore_user_session->start();

$lore_system->user_session =& $lore_user_session;

///////////////////////////////////////////////////////////////////////////////
// TEMPLATE ENGINE INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

define('SMARTY_DIR', '../third_party/smarty/');
$lore_system->te =& new pt_template_engine;
$lore_system->te->compiler_file		= SMARTY_DIR . 'Smarty_Compiler.class.php';
$lore_system->te->compile_dir		= '../var/templates_c';
$lore_system->te->template_dir		= './templates';
$lore_system->te->use_sub_dirs		= false;
$lore_system->te->force_compile		= false;
$lore_system->te->compile_check		= true;

$lore_system->te->register_modifier('format_date', array(&$lore_system, 'format_date'));
$lore_system->te->assign('lore_system', array(
				'settings'	=> $lore_system->settings,
				'version'	=> LORE_VERSION,
				'time'		=> time(),
				'scripts'	=> $lore_system->scripts
				));
$lore_system->te->assign(array(
				'goto'		=> $_GET['goto'],
				'image_dir'	=> 'templates/images',
				'php_version'	=> phpversion(),
				'mysql_version'	=> $lore_system->db->query_one_result('SELECT VERSION()')
			));
$lore_system->te->assign('lore_user_session', $lore_user_session->session_vars['user_info']);

$lore_system->te->register_modifier('format_date', array(&$lore_system, 'format_date'));

///////////////////////////////////////////////////////////////////////////////
// MISC
///////////////////////////////////////////////////////////////////////////////

$lore_db_interface = new lore_db_interface;
$lore_db_interface->lore_system =& $lore_system;

$lore_category_tree = new lore_category_tree;
$lore_category_tree->db =& $lore_system->db;

$lore_system->te->assign('category_tree', $lore_category_tree->get_category_tree());
register_shutdown_function(array(&$lore_system, '__shutdown'));


if( $_REQUEST['action'] == 'login' )
{
	if( !$lore_user_session->validate_login( $_POST['username'], $_POST['password'] ) )
	{
		$lore_system->te->assign('error', 'Invalid login information specified.');
		$lore_system->te->display('cp_login.tpl');
		exit;
	}
	else
	{
		$lore_user_session->start();
		$lore_system->te->assign('message', 'Logging you in, please wait.');
		$lore_system->te->assign('redirect_url', 'index.php');
		$lore_system->te->display('cp_message_redirect.tpl');
		exit;
	}

}
elseif( $_REQUEST['action'] == 'logout' )
{
	$lore_user_session->destroy();
	$lore_system->te->assign('message', 'Logging you out, please wait.');
	$lore_system->te->assign('redirect_url', '../' . $lore_system->scripts['index']);
	$lore_system->te->display('cp_message_redirect.tpl');
	exit;
}
elseif( !$lore_user_session->is_validated() )
{
	$lore_system->te->display('cp_login.tpl');
	exit;
}

$stuff = explode('/', $_SERVER['PHP_SELF']);
$filename = $stuff[ count($stuff)-1 ];
list($script, $ext) = explode('.', $filename);
if( !$lore_user_session->check_cp_permission( $script, $_REQUEST['action'] ) )
{
	$lore_system->te->display('cp_header.tpl');
	show_cp_message("You do not have permission to access this section of the control panel.");
	exit;
}
?>

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

require_once('./inc/config.inc.php');
require_once('./third_party/smarty/Smarty.class.php');
require_once('./inc/db_class.inc.php');
require_once('./inc/pt_system.inc.php');
require_once('./inc/user_session.inc.php');
require_once('./inc/category_tree.inc.php');
require_once('./inc/template_engine.inc.php');
require_once('./inc/functions.inc.php');
require_once('./inc/lib.inc.php');

///////////////////////////////////////////////////////////////////////////////
// PHP SETTINGS
///////////////////////////////////////////////////////////////////////////////

if(  !@get_magic_quotes_gpc()  )
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
// SOFTWARE SYSTEM INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

define('IN_PT_SYSTEM', 1);
$lore_system = new lore_system;
$lore_system->email_on_error = $CONFIG['email_on_error'];
$lore_system->error_email = $CONFIG['error_email'];

///////////////////////////////////////////////////////////////////////////////
// CHECK FOR INSTALL/UPGRADE DIRECTORIES
///////////////////////////////////////////////////////////////////////////////

if( !$CONFIG['development_mode'] )
{
	if( @file_exists('./install') )
	{
		$lore_system->trigger_error('The installation files still exist; this is a security hazard. If you have already installed the software, please delete the "install/" directory before proceeding.');
	}
	if( @file_exists('./upgrade') )
	{
		$lore_system->trigger_error('The upgrade files still exist; this is a security hazard. If you have already run all necessary upgrades, please delete the "upgrade/" directory before proceeding.');
	}
}

///////////////////////////////////////////////////////////////////////////////
// DATABASE INITIALIZATION
///////////////////////////////////////////////////////////////////////////////


$lore_system->db = new db_mysql($CONFIG['db_host'], 
				$CONFIG['db_username'], 
				$CONFIG['db_password'], 
				$CONFIG['db_database']);

$lore_system->db->use_persistent_connections = $CONFIG['use_persistent_connections'];
$lore_system->db->error_handler_func = array( &$lore_system, 'trigger_error' );
$lore_system->db->die_on_error = true;

if( !$lore_system->db->connect() )
{
	$lore_system->trigger_error('Unable to connect to the MySQL database at ' . $CONFIG['db_host'] . '. Please ensure that a MySQL database server is running, and check your login credentials in the configuration file.');
}
if( !$lore_system->db->select_db() )
{
	$lore_system->trigger_error('Unable to select the MySQL database "' . $CONFIG['db_database'] . '". Please ensure that the database exists and that the specified database user can access it.');
}
$lore_system->get_settings();

if( eregi("\/$", $lore_system->settings['knowledge_base_domain']) )
{
	$lore_system->settings['knowledge_base_domain'] = substr($lore_system->settings['knowledge_base_domain'], 0, -1);
}
if( eregi("\/$", $lore_system->settings['knowledge_base_path']) )
{
	$lore_system->settings['knowledge_base_path'] = substr($lore_system->settings['knowledge_base_path'], 0, -1);
}

///////////////////////////////////////////////////////////////////////////////
// OUTPUT BUFFERING/COMPRESSION
///////////////////////////////////////////////////////////////////////////////

if( $lore_system->settings['enable_gzip_compression'] )
{
	if( !function_exists('ob_start') )
	{
		$lore_system->trigger_error('You have enabled GZIP page compression in your settings, however the '
						.'output buffering function (ob_start()) could not be found. '
						.'Please ensure that you are using PHP 4.0.4 or greater and have output '
						.'buffering enabled. If you are not sure, contact your system '
						.'administrator.');
	}
	elseif( !function_exists('ob_gzhandler') )
	{		
		$lore_system->trigger_error('You have enabled GZIP page compression in your settings, however the gzip '
						.'compression function (ob_gzhandler()) could not be found. '
						.'Please ensure that you are suing 4.0.4 or greater and have the ZLIB '
						.'extension installed. If you are not sure, contact your system '
						.'administrator.');
	}
	ob_start('ob_gzhandler');
}

///////////////////////////////////////////////////////////////////////////////
// USER SESSION INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

$lore_user_session = new lore_user_session;
$lore_user_session->db =& $lore_system->db;
$lore_user_session->cookie_path = $lore_system->settings['cookie_path'];
$lore_user_session->cookie_domain = $lore_system->settings['cookie_domain'];
$lore_user_session->start();

$lore_system->user_session =& $lore_user_session;

///////////////////////////////////////////////////////////////////////////////
// TEMPLATE ENGINE INITIALIZATION
///////////////////////////////////////////////////////////////////////////////

$style = $lore_system->get_blackboard_value('STYLE');
$stylesheet = $lore_system->get_blackboard_value('STYLESHEET');

$lore_system->te =& new pt_template_engine;
define('SMARTY_DIR', './third_party/smarty/');
$lore_system->te->compiler_file		= SMARTY_DIR . 'Smarty_Compiler.class.php';
$lore_system->te->compile_dir		= './var/templates_c';
$lore_system->te->use_sub_dirs		= $CONFIG['use_sub_dirs'];
$lore_system->te->force_compile		= $CONFIG['force_compile'];
$lore_system->te->compile_check		= $CONFIG['compile_check'];

$lore_system->te->template_dir		= './styles/' . $style;

$lore_system->te->assign(array(
				'lore_system'		=> array(
							'settings'	=> $lore_system->settings,
							'version'	=> LORE_VERSION,
							'scripts'	=> $lore_system->scripts,
							'base_dir'	=> $lore_system->settings['knowledge_base_path']
							),

				'lore_user_session'	=> array(
							'username' 	=> $lore_user_session->session_vars['user_info']['username'],
							'is_validated'	=> $lore_user_session->is_validated()
							),


				'style_dir'		=> "styles/$style",
				'image_dir'		=> "styles/$style/images",
				'stylesheet'		=> "$stylesheet"
				));

$lore_system->te->register_modifier('format_date', array(&$lore_system, 'format_date'));
$lore_system->te->register_function('lore_link', ( $lore_system->settings['enable_search_engine_friendly_urls'] ) ? 'lore_search_engine_friendly_url' : 'lore_normal_url');
$lore_system->te->register_modifier('alphanumeric', 'alphanumeric');

///////////////////////////////////////////////////////////////////////////////
// MISC
///////////////////////////////////////////////////////////////////////////////

$lore_db_interface = new lore_db_interface;
$lore_db_interface->lore_system =& $lore_system;

$lore_category_tree = new lore_category_tree;
$lore_category_tree->db =& $lore_system->db;

$lore_system->te->assign('category_tree', $lore_category_tree->get_category_tree());
register_shutdown_function( array(&$lore_system, '__shutdown') );
?>

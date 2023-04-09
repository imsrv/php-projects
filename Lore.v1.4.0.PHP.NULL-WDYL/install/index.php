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

/*
+--------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ========================================
| This code is the proprietary product of Pineapple Technologies
| and is protected by international copyright and intellectual 
| property laws.
| ========================================
| Your usage of this software is bound by the agreement set forth
| in the software license that was packaged with this software as 
| LICENSE.txt. A copy of this license agreement can be located at 
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms 
| stated in the license.
| ========================================
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole
| or in part, in any way, shape, or form.
+---------------------------------------------------------------------------
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
require_once('../inc/lib.inc.php');
require_once('../inc/form.inc.php');

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

define('IN_PT_SYSTEM', 1);
$lore_system = new lore_system;
$lore_system->db = new db_mysql($CONFIG['db_host'], 
				$CONFIG['db_username'], 
				$CONFIG['db_password'], 
				$CONFIG['db_database']);
$lore_system->db->use_persistent_connections = $CONFIG['use_persistent_connections'];

define('SMARTY_DIR', '../third_party/smarty/');
$lore_system->te =& new pt_template_engine;
$lore_system->te->compiler_file		= SMARTY_DIR . 'Smarty_Compiler.class.php';
$lore_system->te->template_dir		= './';
$lore_system->te->compile_dir		= '../var/templates_c';
$lore_system->te->force_compile		= true;
$lore_system->te->compile_check		= true;
$lore_system->te->use_sub_dirs		= false;

$lore_system->te->assign('lore_version', LORE_VERSION);
$lore_system->te->assign('php_self', $_SERVER['PHP_SELF']);

///////////////////////////////////////////////////////////////////////////////

$step = ( $_REQUEST['step'] ) ? $_REQUEST['step'] : 1;
if( $_POST['back'] )
{
	$step--;
}
if( $_POST['next'] )
{
	$step++;
}
$lore_system->te->assign('step', $step);

switch( $step )
{

	//////////////////////////////////////////////////
	// Introduction
	//////////////////////////////////////////////////
	case 1:
		$lore_system->te->display('step_1.tpl');
	break;
	
	//////////////////////////////////////////////////
	// Check configuration
	//////////////////////////////////////////////////
	case 2:		
		$checks[] = array(
			'comment'	=> 'Checking for PHP version 4.1.0 or greater',
			'result'	=> ( (int)str_replace('.', '', $php_version) < 410 ),
			'error'		=> "This program requires PHP version 4.1.0 or higher, you are currently running version " . phpversion() . "."
			);
				
		$checks[] = array(
			'comment'	=> 'Checking for MySQL support in PHP',
			'result'	=> function_exists('mysql_query'),
			'error'		=> 'The MySQL extension for PHP is not installed. Please ensure that you have compiled PHP with MySQL support.'
			);

		foreach( $checks AS $check )
		{
			if( !$check['result'] )
			{
				$errors++;
			}
		}

		$lore_system->te->assign(array(
						'checks'		=> $checks,
						'errors'		=> $errors,
						'show_back_button'	=> true,
						'show_next_button'	=> ( $errors ) ? false : true,
						'show_retry_button'	=> ( $errors ) ? true : false));
		$lore_system->te->display('step_2.tpl');
	break;

	//////////////////////////////////////////////////
	// Verify database details
	//////////////////////////////////////////////////
	case 3:
		$checks[] = array(
			'comment'	=> 'Connecting to your database server',
			'result'	=> $lore_system->db->connect(),
			'error'		=> 'Unable to connect to your database server. Please ensure that there is a server located at the host you specified and that your login information is correct.'
			);
		
		if( !$lore_system->db->select_db() )
		{
			if( !$lore_system->db->query("CREATE DATABASE " . $CONFIG['db_database']) )
			{
				$result = false;
			}
			else
			{
				$result = true;
			}
		}
		else
		{
			$result = true;
		}

		$checks[] = array(
			'comment'	=> 'Selecting your database',
			'result'	=> $result,
			'error'		=> 'Unable to select the specified database. Additionally, it could not be created from this script. Please ensure that the database exists and that the specified user has access to it. You may need to contact your web host for information about creating a MySQL database for this software to use.'
			);

		foreach( $checks AS $check )
		{
			if( !$check['result'] )
			{
				$errors++;
			}
		}

		$lore_system->te->assign(array(
					'db_host'	=> $CONFIG['db_host'],
					'db_username'	=> $CONFIG['db_username'],
					'db_password'	=> $CONFIG['db_password'],
					'db_database'	=> $CONFIG['db_database']
					));
		$lore_system->te->assign(array(
						'checks'		=> $checks,
						'errors'		=> $errors,
						'show_back_button'	=> true,
						'show_next_button'	=> ( $errors ) ? false : true,
						'show_retry_button'	=> ( $errors ) ? true : false));
		$lore_system->te->display('step_3.tpl');
	break;

	//////////////////////////////////////////////////
	// Create database structure
	//////////////////////////////////////////////////
	case 4:
		$lore_system->db->connect();
		$lore_system->db->select_db();

		$queries = file('lore.sql');
		$num_queries = count($queries);
		for($i=0;$i<$num_queries-1;$i++)
		{
			if( !ereg("^[\r\n]", $queries[$i]) && !ereg("^#", $queries[$i]) )
			{
	
				$query = substr($queries[$i], 0, strlen($queries[$i]) -2);
				list( $s1, $s2, $table, $s3 ) = explode(' ', $query);
				
				// show CREATE TABLE queries
				if( strtolower($s1) == 'create' )
				{
					$checks[] = array(
					'comment'	=> "Creating table $table",
					'result'	=> $lore_system->db->query( $query ),
					'error'		=> "Unable to create table $table<br /><br />" . $lore_system->db->get_error_msg()
					);
				}
				// Other stuff, like "DROP TABLE IF EXISTS"
				else
				{
					$lore_system->db->query( $query );
				}
			}		
		}

		foreach( $checks AS $check )
		{
			if( !$check['result'] )
			{
				$errors++;
			}
		}

		$lore_system->te->assign(array(
						'checks'		=> $checks,
						'errors'		=> $errors,
						'show_back_button'	=> true,
						'show_next_button'	=> ( $errors ) ? false : true,
						'show_retry_button'	=> ( $errors ) ? true : false));
		$lore_system->te->display('step_4.tpl');
	break;
	
	//////////////////////////////////////////////////
	// Import default settings, 
	//////////////////////////////////////////////////
	case 5:
		$lore_system->db->connect();
		$lore_system->db->select_db();

		// Insert default categories
		$lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('INSTALL_TIME', '" . time() . "')");
		$lore_system->db->query("INSERT INTO lore_categories (name,published) VALUES ('Root Category', 1)");
		$lore_system->db->query("INSERT INTO lore_categories (name, description, published, parent_category_id) VALUES ('Article Component Category', 'Special category used to hold article components, which are articles that can be re-used as headers/footers for other articles.', 0, 1)");
		$article_component_category_id = $lore_system->db->query_one_result("SELECT id FROM lore_categories WHERE name = 'Article Component Category'");
		$lore_system->db->query("INSERT INTO lore_categories (name, description, published,parent_category_id) VALUES ('Trash Can', 'Special category where deleted articles and categories are placed.', 0, 1)");
		$trash_can_category_id = $lore_system->db->query_one_result("SELECT id FROM lore_categories WHERE name = 'Trash Can'");

		$checks[] = array(
			'comment'	=> 'Creating default categories',
			'result'	=> $lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('INSTALL_TIME', '" . time() . "')"),
			'error'		=> "This program requires PHP version 4.1.0 or higher, you are currently running version " . phpversion() . "."
			);
			
		$lore_category_tree = new lore_category_tree;
		$lore_category_tree->db =& $lore_system->db;
		$lore_category_tree->update_category_tree(LORE_ROOT_CATEGORY_ID, false);

		require_once('./default_settings.php');
		$settings['knowledge_base_domain']		= 'http://' . $_SERVER['HTTP_HOST'];
		$settings['knowledge_base_path']		= dirname(dirname($_SERVER['SCRIPT_NAME']));
		$settings['article_component_category_id']	= $article_component_category_id;
		$settings['trash_can_category_id']		= $trash_can_category_id;
		
		$checks[] = array(
			'comment'	=> 'Setting installation time',
			'result'	=> $lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('INSTALL_TIME', '" . time() . "')"),
			'error'		=> "This program requires PHP version 4.1.0 or higher, you are currently running version " . phpversion() . "."
			);

		$lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('DB_VERSION', '8')");
		$lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('SETTINGS', '" . addslashes(serialize($settings)) . "')");
		$lore_system->db->query("INSERT INTO lore_blackboard (name,content) VALUES ('DEFAULT_SETTINGS', '" . addslashes(serialize($settings)) . "')");
	
		$lore_system->te->assign('show_back_button', true);
		$lore_system->te->assign('show_next_button', true);
		$lore_system->te->display('step_5.tpl');
	break;
	
	//////////////////////////////////////////////////
	// Get administrator user info
	//////////////////////////////////////////////////
	case 6:
		$lore_system->te->assign('show_back_button', true);
		$lore_system->te->assign('show_next_button', true);
		$lore_system->te->display('step_6.tpl');
	break;
	
	//////////////////////////////////////////////////
	// Setup admin user, finish
	//////////////////////////////////////////////////
	case '7':
		$lore_system->db->connect();
		$lore_system->db->select_db();
		
		if( !$_POST['username'] || !$_POST['password'] || !$_POST['email'] )
		{
			$lore_system->te->assign('username', $_POST['username']);
			$lore_system->te->assign('password', $_POST['password']);
			$lore_system->te->assign('email', $_POST['email']);
			$lore_system->te->assign('error', 'Please fill in all required fields.');
			$lore_system->te->assign('show_next_button', true);
			$lore_system->te->assign('show_back_button', true);
			$lore_system->te->assign('step', 6);
			$lore_system->te->display('step_6.tpl');
		}
		else
		{
			$db_stuff = array(
					'username'	=> $_POST['username'],
					'password'	=> md5($_POST['password']),
					'email'		=> $_POST['email'],
					'level'		=> 'Administrator'
					);
			$lore_system->db->insert_from_array( $db_stuff, 'lore_users');
			
			$lore_system->te->assign('show_next_button', true);
			$lore_system->te->assign('show_back_button', true);
			$lore_system->te->assign('message', 'Administrative account created.');
			$lore_system->te->display('step_7.tpl');
			$lore_system->te->clear_compiled_templates();
		}
		
	break;

	
	//////////////////////////////////////////////////
	// Unknown step
	//////////////////////////////////////////////////	
	default:
		echo "Unknown step specified... not sure how you got here.";
	break;
}
?>

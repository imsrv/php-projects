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

require('cp_global.php');

$lore_system->te->assign('script_name', 'Users');
$lore_system->te->assign('script_description', 'Here you can configure the users that will have access to the control panel. The level of each user defines which functions he/she will have access to.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('user', $_REQUEST['action']);

$form_user = new form_db_single_table('user');
$form_user->set_properties(array(
					'form_edit_name'	=> 'Edit User',
					'form_new_name'		=> 'Add User',
					'database_table'	=> 'lore_users',
					'row_name'		=> 'user',
					'unique_field'		=> 'username',
					'template'		=> 'cp_default_form.tpl',
					'icon'			=> 'users.gif'
					));
$form_user->db =& $lore_system->db;
$form_user->te =& $lore_system->te;
$form_user->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_user->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_user->add_field('username', 'field_text', array('name' => 'Username', 'description' => 'Can be a maximum of 25 characters, spaces are allowed.', 'size' => 25));
$form_user->set_field_constraints('username', array('max_length' => 25, 'not_null' => true));
$form_user->add_field('email', 'field_text', array('name' => 'Email Address', 'description' => "User's email address.", 'size' => 50));
$form_user->set_field_constraints('email', array('max_length' => 100, 'pattern_match' => 'email'));
$form_user->add_field('password', 'field_password', array('name' => 'Password', 'description' => 'Must be between 4 and 25 characters long', 'size' => 25, 'populate_from_array' => false, 'export_if_null' => false, 'export_filter_function' => 'md5'));
$form_user->add_field('reenter_password', 'field_password', array('name' => 'Re-enter Password', 'description' => 'Re-enter your password for verification.', 'size' => 25, 'export' => false));
$form_user->set_field_constraints('password', array('min_length' => 4, 'must_match_field' => 'reenter_password'));
$form_user->add_field('level', 'field_select', array('name' => 'User Level', 'description' => 'Determines access level of user.<br /><br /><b>Administator:</b> has full access.<br /><b>Writer:</b> can write and edit own articles, and moderate comments.<br /><b>Moderator:</b>Can approve, unapprove, and delete article comments.', 'select_options' => array('Administrator' => 'Administrator', 'Writer' => 'Writer', 'Moderator' => 'Moderator')));

$form_user->get_post_input();

$users = new table_browse('Users', 'Browse Users');
$users->icon = 'users.gif';
$users->te =& $lore_system->te;
$users->db =& $lore_system->db;
$users->template = 'cp_default_table_browse.tpl';
$users->row_name = 'users';
$users->add_tables('lore_users LEFT JOIN lore_articles ON lore_users.id=lore_articles.user_id');
$users->add_fields('lore_users.id');
$users->add_group_by('lore_users.id');
$users->add_display_field('username', 'Username');
$users->add_display_field('email', 'Email');
$users->add_display_field('level', 'Level');
$users->add_display_field('COUNT(lore_articles.id) AS articles', 'Articles');
$users->add_text_search_field(array('Username' => 'username', 'Email Address' => 'email'));
$users->add_option_field('level', 'Show user level:', array('Administrator' => 'Administrator', 'Writer' => 'Writer', 'Moderator' => 'Moderator'));
$users->add_link('Edit', $_SERVER['PHP_SELF'], array('action' => 'edit', 'id' => '$row[id]'));
$users->add_link('Delete', $_SERVER['PHP_SELF'], array('action' => 'delete', 'id' => '$row[id]'));
$users->add_link('Browse Articles', $lore_system->scripts['cp_article'], array('action' => 'browse', 'user_id' => '$row[id]'));
$users->add_page_controls();
$users->add_order_by_controls();
$users->add_row_checkboxes();
$users->set_actions(array('Delete' => 'delete'));
$users->get_input();

// Only administrators can edit other users
// Limit non-administrators to their id only and disable
// username and level fields.
if( !$lore_user_session->is_administrator() )
{
	$form_user->set_field_properties('id', array('current_value' => $lore_user_session->session_vars['user_info']['id']));
	$form_user->set_field_properties('username', array('export' => false, 'readonly' => true, 'current_value' => $lore_user_session->session_vars['user_info']['username']));
	$form_user->set_field_properties('level', array('export' => false, 'readonly' => true,  'current_value' => $lore_user_session->session_vars['user_info']['level']));
}

switch( $_REQUEST['action'] )
{
	case 'new':
		$form_user->handle_new();
	break;

	case 'edit':
		$form_user->set_field_properties('password', array('name' => 'New Password'));
		$form_user->handle_edit();
	break;

	case 'browse':
		$users->display();
	break;

	case 'delete':
		$id = ( $ids = $users->get_selected_rows() ) ? $ids : $_GET['id'];
		$lore_system->db->delete_id($id, 'lore_users');	
		show_cp_message('Deleted ' . count($id) . ' user(s).');
		$users->display();
	break;

} // end switch

?>

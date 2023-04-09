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

$style_dir = '../styles';

$lore_system->te->assign('script_name', 'Glossary');
$lore_system->te->assign('script_description', 'The glossary allows you to define commonly used terms in your articles. If enabled, glossary terms are automatically highlighted in articles with a link to a pop-up window that displays the definition');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('glossary', $_REQUEST['action']);

$form_glossary_term = new form_db_single_table('glossary_term');
$form_glossary_term->set_properties(array(
					'id'			=> 'glossary_term',
					'form_edit_name'	=> 'Edit Glossary Term',
					'form_new_name'		=> 'Add Glossary Term',
					'database_table'	=> 'lore_glossary',
					'row_name'		=> 'glossary term',
					'unique_field'		=> 'term',
					'template'		=> 'cp_default_form.tpl'
					));
$form_glossary_term->db =& $lore_system->db;
$form_glossary_term->te =& $lore_system->te;

$form_glossary_term->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_glossary_term->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_glossary_term->add_field('term', 'field_text', array('name' => 'Glossary Term', 'description' => 'This term will be displayed by the definition.', 'size' => 50));
$form_glossary_term->set_field_constraints('term', array('not_null' => true, 'max_length' => 100));

$form_glossary_term->add_field('alt_term_1', 'field_text', array('name' => 'Alternate 1', 'description' => 'Alternate term which will link to this definition (ex: such as a plural version of the above term, like "apple" and "apples", or an acronym).', 'size' => 50));
$form_glossary_term->set_field_constraints('term', array('max_length' => 100));
$form_glossary_term->add_field('alt_term_2', 'field_text', array('name' => 'Alternate 2', 'size' => 50));
$form_glossary_term->set_field_constraints('term', array('max_length' => 100));
$form_glossary_term->add_field('alt_term_3', 'field_text', array('name' => 'Alternate 3', 'size' => 50));
$form_glossary_term->set_field_constraints('term', array('max_length' => 100));

$form_glossary_term->add_field('definition', 'field_text', array('name' => 'Definition', 'size' => 75));
$form_glossary_term->set_field_constraints('definition', array('max_length' => 65535, 'not_null' => true));
$form_glossary_term->get_post_input();

$glossary_terms = new table_browse('Glossary Terms');
$glossary_terms->template = 'cp_default_table_browse.tpl';
$glossary_terms->row_name = 'glossary terms';
$glossary_terms->db =& $lore_system->db;
$glossary_terms->te =& $lore_system->te;
$glossary_terms->add_tables('lore_glossary');
$glossary_terms->add_fields('id');
$glossary_terms->add_display_field('term', 'Term');
$glossary_terms->add_display_field('definition', 'Definition');
$glossary_terms->add_link('Edit', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'edit'));
$glossary_terms->add_link('Delete', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'delete'));
$glossary_terms->add_page_controls();
$glossary_terms->add_order_by_controls(array('term'));
$glossary_terms->add_row_checkboxes();
$glossary_terms->set_actions(array('Delete' => 'delete'));

$glossary_terms->get_input();

switch( $_REQUEST['action'] )
{
	case 'new':
		$form_glossary_term->handle_new();
	break;

	case 'edit':
		$form_glossary_term->handle_edit();
	break;

	case 'browse':
		$glossary_terms->display();
	break;

	case 'delete':
		$id = ( $ids = $glossary_terms->get_selected_rows() ) ? $ids : $_GET['id'];
		$lore_system->db->delete_id($id, 'lore_glossary');
		show_cp_message('Deleted ' . count($id) . ' term(s).');
		$glossary_terms->display();
	break;
}

?>

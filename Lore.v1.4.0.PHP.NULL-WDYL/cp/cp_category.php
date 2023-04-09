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

$lore_system->te->assign('script_name', 'Categories');
$lore_system->te->assign('script_description', 'Categories allow you to arrange your articles into separate sections. Each category may optionally have subcategories. Articles which are <i>not</i> in a (sub)category are to be placed in "Root Category".');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('category', $_REQUEST['action']);

$form_category = new form_db_single_table('Category');
$form_category->set_properties(array(
					'id'			=> 'category',
					'form_edit_name'	=> 'Edit Category',
					'form_new_name'		=> 'Add Category',
					'database_table'	=> 'lore_categories',
					'row_name'		=> 'category',
					'unique_field'		=> false,
					'template'		=> 'cp_default_form.tpl',
					'icon'			=> 'categories.gif',
					));
$form_category->db =& $lore_system->db;
$form_category->te =& $lore_system->te;
$form_category->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_category->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_category->add_field('parent_category_id', 'field_select', array('name' => 'Parent Category', 'select_options' => $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0) )));
$form_category->add_field('name', 'field_text', array('name' => 'Name', 'description' => 'A name for this category.', 'size' => 50));
$form_category->set_field_constraints('name', array('max_length' => 50, 'not_null' => true));
$form_category->add_field('description', 'field_text', array('name' => 'Description', 'description' => 'A short description of this category.', 'size' => 50));
$form_category->set_field_constraints('description', array('max_length' => 255));
$form_category->add_field('published', 'field_yes_no_select', array('name' => 'Publish?', 'description' => 'Whether to publish this category. Categories are only visible in the knowledge base if published.', 'default_value' => 1));
$form_category->get_post_input();

$categories = new table_browse('Categories', 'Browse Categories');
$categories->icon = 'categories.gif';
$categories->template = 'cp_category_table_browse.tpl';
$categories->row_name = 'categories';
$categories->db =& $lore_system->db;
$categories->te =& $lore_system->te;
$categories->add_tables('lore_categories LEFT JOIN lore_articles ON lore_articles.category_id=lore_categories.id');
$categories->add_fields('lore_categories.id');
$categories->add_group_by('lore_categories.id');
$categories->add_display_field('lore_categories.id AS id', 'ID');
$categories->add_display_field('lore_categories.published AS published', 'Published');
$categories->add_display_field('name', 'Name');
$categories->add_display_field('description', 'Description');
$categories->add_display_field('COUNT(lore_articles.id) AS total_articles', 'Total articles');
$categories->add_link('Edit', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'edit'));
$categories->add_link('Add Article', $lore_system->scripts['cp_article'], array('category_id' => '$row[id]', 'action' => 'new'));
$categories->add_link('Browse Articles', $lore_system->scripts['cp_article'], array('category_id' => '$row[id]', 'action' => 'browse'));
$categories->add_link('Publish', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'publish'));
$categories->add_link('Unpublish', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'unpublish'));
$categories->add_link('Delete', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'delete'));
$categories->add_text_search_field(array('name' => 'Name', 'description' => 'Description'));
$categories->add_page_controls();
$categories->add_order_by_controls(array('name', 'total_articles'));
$categories->add_row_checkboxes();
$categories->set_actions(array('Publish' => 'publish', 'Unpublish' => 'unpublish'));
$categories->get_input();
$category_id_list = ( $ids = $categories->get_selected_rows() ) ? $ids : array($_GET['id']);

switch( $_REQUEST['action'] )
{
	case 'new':
		$form_category->handle_new();
		$lore_category_tree->update_category_tree();
		$lore_category_tree->update_category_article_counts();
	break;

	case 'edit':
		if( LORE_ROOT_CATEGORY_ID == $form_category->get_field_value('id') )
		{
			show_cp_message('Cannot modify Root Category');
			$categories->display();
		}
		elseif( $form_category->submitted() )
		{
			if( $form_category->get_field_value('id') == $form_category->get_field_value('parent_category_id') )
			{
				$form_category->trigger_field_error('parent_category_id', "Category cannot be a child of itself, please choose a different parent category.");
			}
			elseif( $lore_category_tree->is_child_of( $form_category->get_field_value('parent_category_id'), $form_category->get_field_value('id') ) )
			{
				$form_category->trigger_field_error('parent_category_id', "Category cannot be a child of one of its children, please choose a different parent category.");
			}
			$form_category->handle_edit();
		}
		else
		{
			$form_category->handle_edit();
		}
		$lore_category_tree->update_category_tree();
		$lore_category_tree->update_category_article_counts();
	break;

	case 'browse':
		$categories->display();
	break;

	case 'unpublish':
	case 'publish':
		$flag = ( 'publish' == $_REQUEST['action'] ) ? 1 : 0;
		$word = ( 'publish' == $_REQUEST['action'] ) ? 'Published' : 'Unpublished';

		if( array_search( LORE_ROOT_CATEGORY_ID, $category_id_list ) !== false )
		{
			unset( $category_id_list[ array_search( LORE_ROOT_CATEGORY_ID, $category_id_list ) ] );
			show_cp_message('Cannot publish/unpublish Root Category');
		}
		if( count( $category_id_list ) )
		{
			$lore_system->db->query("UPDATE lore_categories SET published = $flag WHERE id IN (" . implode(',', $category_id_list) . ")");
			show_cp_message("$word categories.");
			$lore_category_tree->update_category_tree();
		}
		$categories->display();
	break;
	
	case 'delete':
		if( LORE_ROOT_CATEGORY_ID == $_GET['id'] )
		{
			show_cp_message("Cannot delete Root Category");
		}
		else
		{
			$lore_system->db->query("UPDATE lore_categories SET parent_category_id = '" . $lore_system->settings['trash_can_category_id'] . "' WHERE id ='" . $_GET['id'] . "'");
			show_cp_message('Moved 1 category to trash can.');
		}
		$categories->display();
		$lore_category_tree->update_category_tree();
		$lore_category_tree->update_category_article_counts();
	break;

}

?>

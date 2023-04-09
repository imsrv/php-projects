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

$lore_system->te->assign('script_name', 'Comments');
$lore_system->te->assign('script_description', 'Comments are short notes posted on articles by visitors to the site. Here you can browse and edit comments as well as approve pending comments. Comments are not visible on articles unless they are approved.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('comment', $_REQUEST['action']);

$form_comment = new form_db_single_table('comment');
$form_comment->set_properties(array(
					'form_edit_name'	=> 'Edit Comment',
					'form_new_name'		=> 'Add Comment',
					'database_table'	=> 'lore_comments',
					'row_name'		=> 'comments',
					'unique_field'		=> false,
					'template'		=> 'cp_default_form.tpl',
					'icon'			=> 'comments.gif'
					));
$form_comment->db =& $lore_system->db;
$form_comment->te =& $lore_system->te;

$form_comment->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_comment->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_comment->add_field('article_title', 'field_text', array('export' => false, 'readonly' => true, 'name' => 'Article', 'default_value' => $article_info['title']));
$form_comment->add_field('category_name', 'field_text', array('export' => false, 'readonly' => true, 'name' => 'Category', 'default_value' => $article_info['category_name']));
$form_comment->add_field('name', 'field_text', array('name' => 'Name', 'size' => 50));
$form_comment->set_field_constraints('name', array('not_null' => true));
$form_comment->add_field('email', 'field_text', array('name' => 'Email (optional)', 'size' => 50));
$form_comment->add_field('title', 'field_text', array('name' => 'Title (optional)', 'description' => 'Subject/title of the comment.', 'size' => 50));
$form_comment->set_field_constraints('title', array('max_length' => 255));
$form_comment->add_field('comment', 'field_textarea', array('name' => 'Comment', 'rows' => 10, 'cols' => 40));
$form_comment->set_field_constraints('comment', array('not_null' => true, 'max_length' => $lore_system->settings['max_comment_length']));
$form_comment->add_field('auto_br', 'field_yes_no_select', array('name' => 'Use Auto-BR?', 'description' => 'Auto-BR automatically converts line breaks to HTML &lt;br /&gt; tags.', 'export' => false, 'default_value' => 1));
$form_comment->add_field('created_time', 'field_date_time', array('name' => 'Time Posted', 'default_value' => time()));
$form_comment->add_field('approved', 'field_yes_no_select', array('name' => 'Approved?'));
$form_comment->get_post_input();

$article_info = $lore_system->db->query_one_row("SELECT lore_articles.title, lore_categories.name AS category_name FROM lore_articles, lore_categories, lore_comments WHERE lore_articles.id=lore_comments.article_id AND lore_articles.category_id=lore_categories.id");
$form_comment->set_field_properties('article_title', array('current_value' => $article_info['title']));
$form_comment->set_field_properties('category_name', array('current_value' => $article_info['category_name']));

$form_comment->set_field_properties('comment', array('current_value' => strip_tags($form_comment->get_field_value('comment'), @implode('', $lore_system->settings['comment_allowed_html_tags']))));
if( $form_comment->get_field_value('auto_br') )
{
	$form_comment->set_field_properties('comment', array('export_filter_function' => 'nl2br'));
}

$comments = new table_browse('Comments', 'Browse Comments');
$comments->icon = 'comments.gif';
$comments->template = 'cp_comment_table_browse.tpl';
$comments->row_name = 'comments';
$comments->db =& $lore_system->db;
$comments->te =& $lore_system->te;
$comments->add_tables('lore_comments', 'lore_articles', 'lore_categories');
$comments->add_fields('lore_comments.id');
$comments->add_where_clause('lore_articles.category_id = lore_categories.id');
$comments->add_where_clause('lore_comments.article_id = lore_articles.id');
$comments->add_display_field('lore_comments.title AS title', 'Comment Title');
$comments->add_display_field('lore_comments.comment AS comment', 'Comment');
$comments->add_display_field('lore_comments.name AS name', 'Name');
$comments->add_display_field('lore_comments.email AS email', 'Email');
$comments->add_display_field('lore_comments.approved AS approved','Approved');
$comments->add_display_field('lore_articles.title AS article_title', 'Article Title');
$comments->add_display_field('lore_categories.name AS article_category_name', 'Category Name');
$comments->add_display_field('lore_categories.id AS article_category_id', 'Category ID');
$comments->add_text_search_field(array('lore_comments.title' => 'Comment Title','comment' => 'Comment', 'lore_comments.name' => 'Name','email' => 'Email', 'lore_articles.id' => 'Article ID', 'lore_articles.title' => 'Article Title', 'lore_categories.name' => 'Article Category Name'));
$comments->add_option_field('category_id', 'Show comments where Category is:', $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0)) );
$comments->add_option_field('approved', 'Show', array('Approved and Unapproved' => NULL, 'Approved Only' => 1, 'Unapproved Only' => 0));
$comments->add_link('Edit', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'edit'));
$comments->add_link('Delete', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'delete'));
$comments->add_link('Approve', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'approve'));
$comments->add_link('Unapprove', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'unapprove'));
$comments->add_page_controls();
$comments->add_order_by_controls();
$comments->add_row_checkboxes();
$comments->set_actions(array('Approve' => 'approve', 'Unapprove' => 'unapprove', 'Delete' => 'delete'));
$comments->get_input();

switch( $_REQUEST['action'] )
{
	case 'edit':
		$form_comment->handle_edit();
	break;

	case 'browse':
		$comments->display();
	break;

	case 'delete':
		$id = ( $ids = $comments->get_selected_rows() ) ? $ids : $_GET['id'];
		$lore_system->db->delete_id($id, 'lore_comments');
		show_cp_message('Deleted ' . count($id) . ' comment(s).');
		$comments->display();
	break;
	case 'unapprove':
		$ids = ( $ids = $comments->get_selected_rows() ) ? $ids : array($_GET['id']);
		while( list($key, $id) = @each($ids) )
		{
			$lore_system->db->query("UPDATE lore_comments SET approved=0 WHERE id='$id'");
		}
		show_cp_message('Unapproved ' . count($ids) . ' comment(s).');
		$comments->display();
	break;
	case 'approve':
		$ids = ( $ids = $comments->get_selected_rows() ) ? $ids : array($_GET['id']);
		while( list($key, $id) = @each($ids) )
		{
			$lore_system->db->query("UPDATE lore_comments SET approved=1 WHERE id='$id'");
		}
		show_cp_message('Approved ' . count($ids) . ' comment(s).');
		$comments->display();
	break;

} // end switch

?>

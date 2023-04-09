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

//////////////////////////////////////////////////////////////
/**
 * htmlArea WYSIWYG field
 */
//////////////////////////////////////////////////////////////
class field_textarea_wysiwyg extends field
{
	/**
	* @var rows
	*/
	var $rows	= 5;

	/**
	* @var cols
	*/
	var $cols	= 30;

	function render()
	{
		return
			'<textarea name="'
			.$this->get_field_var()
			.'" id="'
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" rows="'
			.$this->rows
			.'" cols="'
			.$this->cols
			.'">'
			.$this->get_html_escaped_value()
			.'</textarea>'
			.'<script type="text/javascript">'
    			.'HTMLArea.replace("'
			.$this->get_field_var()
			.'");</script>';

		return $html;
	}
	function get_display_value()
	{
			return stripslashes($this->get_current_value());
	}
}

$lore_system->te->assign('script_name', 'Articles');
$lore_system->te->assign('script_description', 'Articles are the content of your knowledge base. They can either be answers to questions or complete articles.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('article', $_REQUEST['action']);

$form_article = new form_db_single_table('article');
$form_article->set_properties(array(
					'form_edit_name'	=> 'Edit Article',
					'form_new_name'		=> 'Add Article',
					'database_table'	=> 'lore_articles',
					'row_name'		=> 'article',
					'unique_field'		=> false,
					'template'		=> 'cp_default_form_with_groups.tpl',
					));
$form_article->te =& $lore_system->te;
$form_article->db =& $lore_system->db;
$form_article->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_article->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_article->add_field('category_id', 'field_select', array('name' => 'Category', 'description' => 'Category to place this article in.', 'default_value' => $_GET['category_id']));
$form_article->set_field_properties('category_id', array('select_options' => $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0) ) ));
$form_article->add_field('title', 'field_text', array('name' => 'Title', 'description' => 'The article title or question. Example: "How do I log in?", or "Logging into your account".', 'size' => 50));
$form_article->set_field_constraints('title', array('max_length' => 65535, 'not_null' => true));

$article_components = array_merge(array(array('array_key' => '(None)', 'array_value' => 0)), $lore_system->db->query_all_rows("SELECT title AS array_key, id AS array_value FROM lore_articles WHERE category_id = " . $lore_system->settings['article_component_category_id'] . " ORDER BY title ASC"));
$form_article->add_field('header_id', 'field_select', array('name' => 'Article Header', 'description' => 'Existing article that will be placed at the top the content you enter below.', 'select_options' => $article_components));

$field_type = ( $lore_system->settings['enable_wysiwyg_editor'] ) ? 'field_textarea_wysiwyg' : 'field_textarea';
$form_article->add_field('content', $field_type, array('name' => 'Content', 'description' => 'The content (body) of the article.', 'rows' => 15, 'cols' => 60));
$form_article->set_field_constraints('content', array('not_null' => true));

$form_article->add_field('footer_id', 'field_select', array('name' => 'Article Footer', 'description' => 'Existing article that will be placed at the bottom of the content you enter above.', 'select_options' => $article_components));

$form_article->add_field('keywords', 'field_text', array('name' => 'Keywords', 'description' => 'Keywords (each separated by a single SPACE) that will be used to determine the article\'s relevance to searches. It is recommended that you list any abbreviations, synonyms, or other keywords related to the article that are not present in the article\'s content above.', 'size' => 70));
$form_article->set_field_constraints('keywords', array('max_length' => 255));
$form_article->add_field_group('General', array('category_id', 'title', 'header_id', 'content', 'footer_id', 'keywords'));

$form_article->add_field('override_dates', 'field_yes_no_select', array('name' => 'Override Dates?', 'description' => 'Whether to override the date created/modified. If set to no, they will be set automatically.', 'export' => false));
$form_article->add_field('created_time', 'field_date_time', array('name' => 'Date Created', 'description' => 'Only set this value if you are overriding the date created.', 'default_value' => $lore_system->offset_timestamp(time()), 'import_filter_function' => array(&$lore_system, 'offset_timestamp'), 'export_filter_function' => array(&$lore_system, 'timestamp_to_gmt')));
$form_article->add_field('modified_time', 'field_date_time', array('name' => 'Date Modified', 'description' => 'Only set this value if you are overriding the date modified.', 'default_value' => $lore_system->offset_timestamp(time()), 'import_filter_function' => array(&$lore_system, 'offset_timestamp'), 'export_filter_function' => array(&$lore_system, 'timestamp_to_gmt'), 'show_on_action' => 'edit'));
$form_article->add_field_group('Date Created/Modified', array('override_dates', 'created_time', 'modified_time'));

$form_article->add_field('allow_comments', 'field_yes_no_select', array('name' => 'Allow Comments?', 'description' => 'Whether or not to allow comments to be added to this article.', 'default_value' => 1));
$form_article->add_field('published', 'field_yes_no_select', array('name' => 'Publish?', 'description' => 'Whether to publish this article. Articles are only visible in the knowledge base if published.', 'default_value' => 1));
$form_article->add_field('featured', 'field_yes_no_select', array('name' => 'Featured?', 'description' => 'Featured articles automatically appear at the top of their category.', 'default_value' => 0));
$form_article->add_field_group('Options', array('allow_comments', 'published', 'featured'));

$form_article->get_post_input();

$articles = new table_browse('Articles', 'Browse Articles');
$articles->icon = 'articles.gif';
$articles->template = 'cp_article_table_browse.tpl';
$articles->row_name = 'articles';
$articles->db =& $lore_system->db;
$articles->te =& $lore_system->te;
$articles->add_tables('lore_articles', 'lore_users', 'lore_categories');
$articles->add_where_clause('lore_articles.user_id = lore_users.id');
$articles->add_where_clause('lore_articles.category_id = lore_categories.id');
$articles->add_display_field('lore_articles.id AS id', 'ID');
$articles->add_display_field('lore_articles.published AS published', 'Published');
$articles->add_display_field('lore_articles.title AS title', 'Title');
$articles->add_display_field('lore_categories.name AS category_name', 'Category');
$articles->add_display_field('lore_users.username AS username', 'Username');
$articles->add_display_field('lore_articles.num_views AS num_views', 'Views');
$articles->add_display_field('lore_articles.total_rating/lore_articles.num_ratings AS rating', 'Rating');
$articles->add_display_field('lore_articles.num_ratings AS num_ratings', '# Ratings');
$articles->add_text_search_field(array('title' => 'Title'));
$articles->add_option_field('lore_articles.published', 'Show', array('Published and Unpublished' => NULL, 'Published Only' => 1, 'Unpublished Only' => 0));
$articles->add_option_field('user_id', 'Show articles created by:', $lore_system->db->query_one_array("SELECT username AS array_key, lore_users.id AS array_value FROM lore_users,lore_articles WHERE lore_users.id=lore_articles.user_id GROUP BY lore_users.id ORDER BY username ASC"));
$articles->add_option_field('category_id', 'Show articles in category:', $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0) ) );
$articles->add_link('Edit', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'edit'));
$articles->add_link('Publish', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'publish'));
$articles->add_link('Unpublish', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'unpublish'));
$articles->add_link('Browse Comments', $lore_system->scripts['cp_comment'], array('article_id' => '$row[id]', 'action' => 'browse'));
$articles->add_link('Attach Files', $lore_system->scripts['cp_attachment'], array('article_id' => '$row[id]', 'action' => 'new'));
$articles->add_link('Browse Attachments', $lore_system->scripts['cp_attachment'], array('title' => '$row[title]', 'action' => 'browse'));
$articles->add_link('Reset Rating', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'reset_rating'));
$articles->add_link('Reset Views', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'reset_views'));
$articles->add_link('Delete', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'delete'));
$articles->add_page_controls();
$articles->add_order_by_controls();
$articles->add_row_checkboxes();
$articles->set_actions(array('Publish' => 'publish', 'Unpublish' => 'unpublish', 'Delete' => 'delete', 'Reset Rating' => 'reset_rating', 'Reset Views' => 'reset_views'));

$articles->get_input();
$article_id_list = ( $ids = $articles->get_selected_rows() ) ? $ids : array($_GET['id']);

// Check permissions
switch( $_REQUEST['action'] )
{
	case 'edit':
		if( !$lore_user_session->has_article_write_permission( $form_article->get_field_value('id') ) )
		{
			show_cp_message('You do not have permission to manage this article.');
			exit;
		}
	break;

	case 'publish':
	case 'unpublish':
	case 'reset_views':
	case 'reset_rating':
	case 'delete':
		if( !$lore_user_session->has_article_write_permission( $article_id_list ) )
		{
			show_cp_message('You do not have permission to manage the selected articles.');
			$articles->display();
			exit;
		}
	break;
}

// Perform action
switch( $_REQUEST['action'] )
{
	case 'new':
		if( !$form_article->get_field_value('override_dates') )
		{
			$form_article->set_field_properties('created_time', array('current_value' => $lore_system->offset_timestamp(time())));
		}
			
		$user_info = $lore_user_session->session_vars['user_info'];
		$form_article->add_field('user_id', 'field_hidden', array('current_value' => $user_info['id']));			
		$form_article->handle_new();
		$lore_category_tree->update_category_article_counts();
	break;

	case 'edit':
		if( !$form_article->get_field_value('override_dates') )
		{
			$form_article->set_field_properties('modified_time', array('current_value' => $lore_system->offset_timestamp(time())));
		}
		

		$form_article->handle_edit();
		$lore_category_tree->update_category_article_counts();
	break;

	case 'browse':
		$articles->display();
	break;

	case 'publish':
		while( @list($d, $id) = @each($article_id_list) )
		{
			$lore_system->db->query("UPDATE lore_articles SET published = 1 WHERE id='$id'");
		}
		show_cp_message('Published article(s).');
		$lore_category_tree->update_category_article_counts();
		$articles->display();
	break;
	
	case 'unpublish':
		while( @list($d, $id) = @each($article_id_list) )
		{
			$lore_system->db->query("UPDATE lore_articles SET published = 0 WHERE id='$id'");
		}
		show_cp_message('Unpublished article(s).');
		$lore_category_tree->update_category_article_counts();
		$articles->display();
	break;
	
	case 'reset_rating':
		while( @list($d, $id) = @each($article_id_list) )
		{
			$lore_system->db->query("UPDATE lore_articles SET total_rating=0,num_ratings=0 WHERE id='$id'");
		}
		show_cp_message('Reset rating(s).');
		$articles->display();
	break;

	case 'reset_views':
		while( @list($d, $id) = @each($article_id_list) )
		{
			$lore_system->db->query("UPDATE lore_articles SET num_views=0 WHERE id='$id'");
		}
		show_cp_message('Reset article view(s).');
		$articles->display();
	break;


	case 'delete':
		while( @list($d, $id) = @each($article_id_list) )
		{
			// delete if the article is already in trash can
			if( $lore_system->settings['trash_can_category_id'] == $lore_system->db->query_one_result("SELECT category_id FROM lore_articles WHERE id = '$id'") )
			{
				$lore_system->db->query("DELETE FROM lore_articles WHERE id = '$id'");
				$deleted_articles++;
			}
			// otherwise move it to the trash can
			else
			{
				$moved_articles++;
				$lore_system->db->query("UPDATE lore_articles SET category_id = '" . $lore_system->settings['trash_can_category_id'] . "' WHERE id = '$id'");
			}
		}
		
		if( $deleted_articles )
		{
			show_cp_message('Deleted ' . count($deleted_articles) . ' article(s).');
		}
		if( $moved_articles )
		{
			show_cp_message('Moved ' . count($moved_articles) . ' article(s) to trash can.');
		}

		$articles->display();
		$lore_category_tree->update_category_article_counts();
	break;
}
?>

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

require_once('cp_global.php');

$lore_system->te->assign('script_name', 'Maintenance');
$lore_system->te->assign('script_description', 'This script allows you to perform various maintenance operations on your knowledge base and database.');
$lore_system->te->display('cp_header.tpl');
$lore_user_session->check_cp_permission('maintenance', $_REQUEST['action']);

$form_article_search_replace = new form_smarty('search_replace');
$form_article_search_replace->set_properties(array(
					'id'			=> 'search_replace',
					'name'			=> 'Article Search & Replace',
					'template'		=> 'cp_default_form.tpl'
					));
$form_article_search_replace->db =& $lore_system->db;
$form_article_search_replace->te =& $lore_system->te;
$form_article_search_replace->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_article_search_replace->add_field('category_id', 'field_select', array('name' => 'Article Category', 'description' => 'Which category of articles to perform search & replace on.'));
$form_article_search_replace->set_field_properties('category_id', array('select_options' => array(array('array_key' => 'All Categories', 'array_value' => 0)) + $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0)) ));
$form_article_search_replace->add_field('search_for', 'field_text', array('name' => 'Search For?', 'description' => 'Text to find.', 'size' => 50));
$form_article_search_replace->set_field_constraints('search_for', array('not_null' => true, max_length => 255));
$form_article_search_replace->add_field('replace_with', 'field_text', array('name' => 'Replace With?', 'description' => 'Replacement text.', 'size' => 50));
$form_article_search_replace->set_field_constraints('replace_with', array('not_null' => true, max_length => 255));
$form_article_search_replace->get_post_input();

switch( $_REQUEST['action'] )
{
	case 'search_replace':
		if( $form_article_search_replace->submitted() )
		{
			$form_article_search_replace->validate();
			if( $form_article_search_replace->has_errors() )
			{
				$form_article_search_replace->display();
			}
			else
			{
				extract( $form_article_search_replace->get_field_values() );

				if( $category_id )
				{
					$lore_system->db->query("UPDATE lore_articles SET content = REPLACE(content, '$search_for', '$replace_with') WHERE category_id='$category_id'");
				}
				else
				{
					$lore_system->db->query("UPDATE lore_articles SET content = REPLACE(content, '$search_for', '$replace_with')");
				}
				$num_articles = $lore_system->db->affected_rows();
				show_cp_message("Replaced \"<b>$search_for</b>\" with \"<b>$replace_with</b>\" in the $num_articles article(s).");
				$form_article_search_replace->display_as_readonly();
			}
		}
		else
		{
			$form_article_search_replace->display();
		}
	break;

	case 'phpinfo':
		phpinfo();
	break;
}

?>

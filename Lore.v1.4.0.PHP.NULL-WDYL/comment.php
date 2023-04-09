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
require_once('global.php');
require_once('inc/form.inc.php');

$form_comment = new form_smarty('comment');
$form_comment->set_property('template', 'comment.tpl');
$form_comment->te =& $lore_system->te;
$form_comment->db =& $lore_system->db;

$form_comment->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_comment->add_field('article_id', 'field_hidden', array('default_value' => $_GET['article_id']));
$form_comment->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));

$form_comment->set_field_type_defaults('field_text', array('export_filter_function' => 'strip_tags'));
$form_comment->add_field('name', 'field_text', array('name' => 'Name'));
$form_comment->set_field_constraints('name', array('not_null' => true));
$form_comment->add_field('email', 'field_text', array('name' => 'Email'));
$form_comment->add_field('title', 'field_text', array('name' => 'Title'));
$form_comment->set_field_constraints('title', array('max_length' => 255, 'export_if_null' => false));
$form_comment->add_field('comment', 'field_textarea', array('name' => 'Comment', 'rows' => 10, 'cols' => 40));
$form_comment->set_field_constraints('comment', array('not_null' => true, 'max_length' => $lore_system->settings['max_comment_length']));
$form_comment->get_post_input();

$form_comment->set_field_properties('comment', array('current_value' => strip_tags($form_comment->get_field_value('comment'), @implode('', $lore_system->settings['comment_allowed_html_tags']))));


$article_id = $form_comment->get_field_value('article_id');
$article = $lore_db_interface->get_article_info( $article_id );
$article['comments'] = $lore_db_interface->get_article_comments($article_id);
$lore_system->te->assign('category_path', $lore_db_interface->get_category_path( $article['category_id'] ));
$lore_system->te->assign('category_path_ids', $lore_db_interface->get_category_path( $article['category_id'], true ));
$lore_system->te->assign('article', $article);
$lore_system->te->assign('category', array('id' => $article['category_id'], 'name' => $article['category_name']));
		

if( !$lore_system->db->id_exists( $form_comment->get_field_value('article_id'), 'lore_articles') )
{
	$lore_system->te->assign('error_message', 'invalid_article');
	$lore_system->te->display('error_message.tpl');
	exit;
}

if( !$lore_db_interface->can_comment_on_article( $form_comment->get_field_value('article_id') ) )
{
	$lore_system->te->assign('error_message', 'cannot_post_comment');
	$lore_system->te->display('error_message.tpl');
	exit;
}

switch( $_REQUEST['action'] )
{
	case 'new':
		if( $form_comment->submitted() )
		{
			$form_comment->validate();
			if( $form_comment->has_errors() )
			{
				$form_comment->display();
			}
			else
			{
				$require_comment_approval = ( $lore_system->settings['require_comment_approval'] && !$lore_user_session->is_validated() ) ? true : false;
				$approved = ( $require_comment_approval ) ? 0 : 1;

				$db_values = $form_comment->get_field_values() + array('created_time' => time(), 'approved' => $approved);
				$lore_system->db->insert_from_array( $db_values, 'lore_comments' );

				$lore_system->te->assign('require_comment_approval', $require_comment_approval);
				$lore_system->te->assign('redirect_url', $lore_system->scripts['article'] . "?id=$article_id");
				$lore_system->te->assign('message', 'comment_added');
				$lore_system->te->display('message_redirect.tpl');
			}
		}
		else
		{
			$form_comment->display();
		}
	break;
}
?>

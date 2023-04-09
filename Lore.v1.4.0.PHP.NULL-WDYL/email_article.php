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

$form_email = new form_smarty('email_article');
$form_email->set_property('template', 'email_article.tpl');
$form_email->te =& $lore_system->te;
$form_email->db =& $lore_system->db;

$form_email->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_email->add_field('article_id', 'field_hidden', array('default_value' => $_GET['article_id']));
$form_email->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));

$form_email->add_field('from_name', 'field_text', array('name' => 'Name'));
$form_email->set_field_constraints('from_name', array('not_null' => true));
$form_email->add_field('from_email', 'field_text', array('name' => 'From Email'));
$form_email->set_field_constraints('from_email', array('pattern_match' => 'email'));
$form_email->add_field('to_email', 'field_text', array('name' => 'To Email'));
$form_email->set_field_constraints('to_email', array('pattern_match' => 'email'));
$form_email->add_field('comment', 'field_textarea', array('name' => 'Comment', 'rows' => 10, 'cols' => 40));
$form_email->set_field_constraints('comment', array('not_null' => true, 'max_length' => 65535));
$form_email->get_post_input();

if( !$lore_system->db->id_exists( $form_email->get_field_value('article_id'), 'lore_articles') )
{
	$lore_system->te->assign('error_message', 'invalid_article');
	$lore_system->te->display('error_message.tpl');
	exit;
}

$article_id = $form_email->get_field_value('article_id');
$article = $lore_db_interface->get_article_info( $article_id );
$lore_system->te->assign('category_path', $lore_db_interface->get_category_path( $article['category_id'] ));
$lore_system->te->assign('category_path_ids', $lore_db_interface->get_category_path( $article['category_id'], true ));
$lore_system->te->assign('article', $article);
$lore_system->te->assign('category', array('id' => $article['category_id'], 'name' => $article['category_name']));


$form_email->get_post_input();

if( $form_email->submitted() )
{
	$form_email->validate();
	if( $form_email->has_errors() )
	{
		$form_email->display();
	}
	elseif( $lore_user_session->session_vars['email_article'] && @in_array( $article_id, $lore_user_session->session_vars['viewed_articles'] ) )
	{
		$form_data = $form_email->get_field_values('stripslashes');
	
		$lore_system->te->assign( $form_data );
		$subject = $lore_system->te->fetch('email_article_subject.tpl');
		$body = $lore_system->te->fetch('email_article_body.tpl');
		
		$lore_system->mail( $form_data['to_email'], $form_data['from_name'] . ' <' . $form_data['from_email'] . '>', $subject, $body );
		
		$lore_system->te->assign('redirect_url', $lore_system->scripts['article'] . "?id=$article_id");
		$lore_system->te->assign('message', 'email_sent');
		$lore_system->te->display('message_redirect.tpl');
	}
	else
	{
		$lore_system->te->assign('error_message', 'cannot_email_article');
		$lore_system->te->display('error_message.tpl');
		exit;
	}
}
else
{
	$lore_user_session->session_vars['email_article'] = true;
	$form_email->display();
}

?>

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

$form_contact = new form_smarty('contact_form');
$form_contact->set_property('name', 'Email Us');
$form_contact->te =& $lore_system->te;
$form_contact->template = 'contact.tpl';
$form_contact->set_field_type_defaults('field_text', array('size' => 50));
$form_contact->add_field('name', 'field_text', array('name' => 'Name', 'description' => 'Your full name.'));
$form_contact->set_field_constraints('name', array('not_null' => true, 'max_length' => 50));
$form_contact->add_field('email', 'field_text', array('name' => 'Email Address', 'description' => 'Your email address (so that we may contact you).'));
$form_contact->set_field_constraints('email', array('not_null' => true, 'max_length' => 100, 'pattern_match' => 'email'));
$form_contact->add_field('email_reenter', 'field_text', array('name' => 'Email Address (re-enter)', 'description' => 'Enter your email address again.'));
$form_contact->set_field_constraints('email_reenter', array('must_match_field' => 'email'));
$form_contact->add_field('subject', 'field_text', array('name' => 'Subject'));
$form_contact->set_field_constraints('subject', array('not_null' => true, 'max_length' => 100));
$form_contact->add_field('body', 'field_textarea', array('name' => 'Body', 'description' => 'Enter the body to send to us.', 'rows' => 10, 'cols' => 60));
$form_contact->set_field_constraints('body', array('not_null' => true, 'max_length' => 10000));
$form_contact->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_contact->get_post_input();

if( $form_contact->submitted() )
{
	$form_contact->validate();
	if( $form_contact->has_errors() )
	{
		$form_contact->display();
	}
	else
	{
		extract( $form_contact->get_field_values() );
		
		// search for articles relevant to their inquiry
		if( $lore_system->settings['enable_automated_reply_system'] && !$_REQUEST['already_viewed_relevant_articles'] && $articles = $lore_db_interface->search_articles( $subject . ' ' . $body, false, $lore_system->settings['automated_reply_system_num_articles'] ) )
		{
			$lore_system->te->assign('articles', $articles);
			$form_contact->display();
		}
		else
		{
			extract( $form_contact->get_field_values('stripslashes') );

			$lore_system->mail( $lore_system->settings['contact_email'], "$name <$email>", $subject, $body );
		
			$lore_system->te->assign('redirect_url', $lore_system->scripts['index']);
			$lore_system->te->assign('message', 'inquiry_sent');
			$lore_system->te->display('message_redirect.tpl');

		}
	}
}
else
{
	$form_contact->display();
}


?>

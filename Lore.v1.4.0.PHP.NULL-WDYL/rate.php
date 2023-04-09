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

if( !$lore_system->db->id_exists( $_POST['article_id'], 'lore_articles') )
{
	$lore_system->te->assign('error_message', 'invalid_article');
	$lore_system->te->display('error_message.tpl');
	exit;
}
if( @in_array( $_POST['article_id'], $lore_user_session->session_vars['rated_articles'] ) )
{
	$lore_system->te->assign('error_message', 'already_rated_article');
	$lore_system->te->display('error_message.tpl');
	exit;
}
if( $_POST['rating'] < 1 || $_POST['rating'] > 5 )
{
	$lore_system->te->assign('error_message', 'invalid_rating');
	$lore_system->te->display('error_message.tpl');
	exit;
}

$lore_db_interface->add_article_rating( $_POST['article_id'], $_POST['rating'] );
$lore_user_session->session_vars['rated_articles'][] = $_POST['article_id'];

$lore_system->te->assign('message', 'rating_added');
$lore_system->te->assign('redirect_url', $lore_system->scripts['article'] . '?id=' . $_POST['article_id']);
$lore_system->te->display('message_redirect.tpl');
?>

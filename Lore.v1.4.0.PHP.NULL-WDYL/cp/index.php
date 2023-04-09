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

$lore_user_session->check_cp_permission('index');

switch( $_REQUEST['action'] )
{
	case 'index':
		$lore_db_interface = new lore_db_interface;
		$lore_db_interface->lore_system =& $lore_system;

		$lore_system->te->assign('script_name', 'Control Panel');
		$lore_system->te->assign('script_description', 'The control panel allows you to setup and manage all aspects of your knowledge base.');
		$lore_system->te->display('cp_header.tpl');

		$lore_system->te->assign('articles_latest', $lore_db_interface->get_latest_articles(10) );
		$lore_system->te->assign('articles_highest_rated', $lore_db_interface->get_highest_rated_articles(10) );
		$lore_system->te->assign('articles_most_viewed', $lore_db_interface->get_most_viewed_articles(10) );

		$lore_system->te->assign('system_info', array(
							'unapproved_comments'	=> $lore_system->db->query_one_result("SELECT COUNT(*) FROM lore_comments WHERE approved=0"),
							'install_time'		=> $lore_system->db->query_one_result("SELECT content FROM lore_blackboard WHERE name='INSTALL_TIME'"),
							
							'articles_total'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_articles'),
							'articles_published'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_articles WHERE published = 1'),
							'articles_unpublished'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_articles WHERE published = 0'),
							
							'categories_total'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_categories'),
							'categories_published'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_categories WHERE published = 1'),
							'categories_unpublished'=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_categories WHERE published = 0'),
							
							'comments_total'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_comments'),
							'comments_approved'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_comments WHERE approved = 1'),
							'comments_unapproved'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_comments WHERE approved = 0'),
							
							'users_total'		=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_users'),
							
							'attachments_total'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_attachments'),
							'attachments_downloads'	=> $lore_system->db->query_one_result('SELECT SUM(num_downloads) FROM lore_attachments'),
							
							'glossary_terms_total'	=> $lore_system->db->query_one_result('SELECT COUNT(*) FROM lore_glossary'),
							
							'article_stats_views'	=> $lore_system->db->query_one_result('SELECT SUM(num_views) FROM lore_articles'),
							'article_stats_ratings'	=> $lore_system->db->query_one_result('SELECT SUM(num_ratings) FROM lore_articles')
							
							));
		$lore_system->te->display('cp_index.tpl');	
		$lore_system->te->display('cp_footer.tpl');
	break;

	case 'nav':
		require_once('cp_modules.php');
		$lore_system->te->assign('module_groups', $module_groups);
		$lore_system->te->display('cp_nav.tpl');
	break;

	default:
		$lore_system->te->display('cp_frames.tpl');
}
?>

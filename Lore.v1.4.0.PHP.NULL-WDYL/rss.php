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

if( !$lore_system->settings['enable_rss_syndication'] )
{
	$lore_system->te->assign('error_message', 'rss_disabled');
	$lore_system->te->display('error_message.tpl');
	exit;
}
if( !$_GET['version'] )
{
	exit;
}

switch( $_GET['action'] )
{
	case 'articles':
		$lore_system->te->assign('articles', $lore_db_interface->get_category_article_list( $_GET['category_id']));
	break;
	
	case 'latest_articles':
		$lore_system->te->assign('articles', $lore_db_interface->get_latest_articles() );
	break;
	
	case 'highest_rated_articles':
		$lore_system->te->assign('articles', $lore_db_interface->get_highest_rated_articles() );
	break;
	
	case 'most_viewed_articles':
		$lore_system->te->assign('articles', $lore_db_interface->get_most_viewed_articles() );
	break;
	
	default:
		exit;
	break;
}
$lore_system->te->display('rss_' . $_GET['version'] . '.tpl');
?>

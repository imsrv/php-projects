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

switch( $_REQUEST['action'] )
{
	case 'glossary':
		$glossary_terms = $lore_db_interface->get_glossary_terms();
		$lore_system->te->assign('glossary_terms', $glossary_terms);
		$lore_system->te->assign('num_glossary_terms', count($glossary_terms));
		$lore_system->te->display('glossary.tpl');
	break;
			
	default:
		$lore_system->te->assign('articles', $lore_db_interface->get_category_article_list( LORE_ROOT_CATEGORY_ID ) );
		$lore_system->te->assign('categories', $lore_db_interface->get_subcategories( LORE_ROOT_CATEGORY_ID ) );
		
		if( $lore_system->settings['show_latest_articles'] )
		{
			$lore_system->te->assign('articles_latest', $lore_db_interface->get_latest_articles() );
		}
		if( $lore_system->settings['show_highest_rated_articles'] )
		{
			$lore_system->te->assign('articles_highest_rated', $lore_db_interface->get_highest_rated_articles() );
		}
		if( $lore_system->settings['show_most_viewed_articles'] )
		{
			$lore_system->te->assign('articles_most_viewed', $lore_db_interface->get_most_viewed_articles() );
		}

		$lore_system->te->display('index.tpl');
	break;
}

?>

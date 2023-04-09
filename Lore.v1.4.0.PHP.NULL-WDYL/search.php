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

$articles = $lore_db_interface->search_articles( $_GET['query'] );
$categories = $lore_db_interface->search_categories( $_GET['query'] );
$lore_db_interface->log_search( $_GET['query'] );

$lore_system->te->assign(array(
			'num_articles'		=> count($articles),
			'num_categories'	=> count($categories),
			'articles'		=> $articles,
			'categories'		=> $categories,
			'search_query'		=> stripslashes($_GET['query'])
			));

$lore_system->te->display('search_results.tpl');

?>

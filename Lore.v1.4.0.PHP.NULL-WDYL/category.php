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

$id = $_GET['id'];
if( !$lore_system->db->id_exists( $id, 'lore_categories') )
{
	$lore_system->te->assign('error_message', 'invalid_category');
	$lore_system->te->display('error_message.tpl');
	exit;
}
if( !$lore_db_interface->category_is_published( $id ) )
{
	$lore_system->te->assign('error_message', 'category_not_published');
	$lore_system->te->display('error_message.tpl');
	exit;
}	

$lore_system->te->assign('category_path', $lore_db_interface->get_category_path( $id ));
$lore_system->te->assign('category_path_ids', $lore_db_interface->get_category_path( $id, true ));
$lore_system->te->assign('category', $lore_db_interface->get_category_info( $id ) );
$lore_system->te->assign('categories', $lore_db_interface->get_subcategories( $id ) );
$lore_system->te->assign('articles', $lore_db_interface->get_category_article_list( $id ) );

$lore_system->te->display('category.tpl');
?>

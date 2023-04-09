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

require_once('./upgrade_global.php');

if( !$db_version = $lore_system->db->query_one_result("SELECT content FROM lore_blackboard WHERE name='DB_VERSION'") )
{
	$lore_system->db->query("INSERT INTO lore_blackboard (name, content) VALUES ('DB_VERSION', 3)");
}
if( $db_version == 3 )
{
	$messages[] = "Updating categories table.";
	$lore_system->db->query("ALTER TABLE lore_categories ADD published TINYINT(1) UNSIGNED");
	$lore_system->db->query("UPDATE lore_categories SET published = 1");
	
	$messages[] = "Updating articles table.";
	$lore_system->db->query("ALTER TABLE lore_articles ADD published TINYINT(1) UNSIGNED");
	$lore_system->db->query("ALTER TABLE lore_articles ADD featured TINYINT(1) UNSIGNED");
	$lore_system->db->query("ALTER TABLE lore_articles ADD header_id INT UNSIGNED");
	$lore_system->db->query("ALTER TABLE lore_articles ADD footer_id INT UNSIGNED");
	$lore_system->db->query("UPDATE lore_articles SET published = 1");
	
	$messages[] = "Adding article component category";
	$lore_system->db->query("INSERT INTO lore_categories (name, description, published,parent_category_id) VALUES ('Article Component Category', 'Special category used to hold article components, which are articles that can be re-used as headers/footers for other articles.', 0, 1)");
	$article_component_category_id = $lore_system->db->query_one_result("SELECT id FROM lore_categories WHERE name = 'Article Component Category'");
	$messages[] = "Updating category article counts.";
	$lore_category_tree->update_category_article_counts();

	$messages[] = "Updating category tree.";
	$lore_category_tree->update_category_tree();

	$messages[] = "Clearing compiled templates.";
	$lore_system->te->clear_compiled_templates();

	$new_setting_values = array(
				'category_select_depth'			=> 9999,
				'automated_reply_system_num_articles'	=> 3,
				'article_index_order'			=> 'title',
				'article_index_order_asc_or_desc'	=> 'ASC',
				'category_index_order'			=> 'name',
				'category_index_order_asc_or_desc'	=> 'ASC',
				'article_component_category_id'		=> $article_component_category_id
				);

	$messages[] = "Updating settings.";
	$lore_system->edit_settings( $new_setting_values, $lore_system->db );

	$messages[] = "Updating database version.";
	$lore_system->db->query("UPDATE lore_blackboard SET content='4' WHERE name='DB_VERSION'");

	$messages[] = "<strong>Upgrade completed.</strong>";
}
elseif( $db_version < 4 )
{
	$messages[] = 'Please run <a href="upgrade2.php">upgrade2.php</a> before running this script.';
}
else
{
	$messages[] = "Your database is already up to date, there is no need to run this script.";
}
$lore_system->te->assign('messages', $messages);
$lore_system->te->display('upgrade.tpl');

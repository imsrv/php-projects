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

$db_version = $lore_system->db->query_one_result("SELECT content FROM lore_blackboard WHERE name='DB_VERSION'");

if( $db_version == 4 )
{
	$messages[] = "Adding search log table.";
	$lore_system->db->query("CREATE TABLE lore_search_log (id int(10) unsigned NOT NULL auto_increment,search varchar(255) NOT NULL default '',the_time int(10) unsigned NOT NULL default '0',PRIMARY KEY  (id),KEY search (search,the_time))");

	$messages[] = "Adding trash can category.";
	$lore_system->db->query("INSERT INTO lore_categories (name, description, published,parent_category_id) VALUES ('Trash Can', 'Special category where deleted articles and categories are placed.', 0, 1)");
	$trash_can_category_id = $lore_system->db->query_one_result("SELECT id FROM lore_categories WHERE name = 'Trash Can'");

	$messages[] = "Updating category article counts.";
	$lore_category_tree->update_category_article_counts();

	$messages[] = "Updating category tree.";
	$lore_category_tree->update_category_tree();

	$messages[] = "Clearing compiled templates.";
	$lore_system->te->clear_compiled_templates();

	$new_setting_values = array(
				'trash_can_category_id'		=> $trash_can_category_id
				);

	$messages[] = "Updating settings.";
	$lore_system->edit_settings( $new_setting_values, $lore_system->db );

	$messages[] = "Updating database version.";
	$lore_system->db->query("UPDATE lore_blackboard SET content='5' WHERE name='DB_VERSION'");

	$messages[] = "<strong>Upgrade completed.</strong>";
}
elseif( $db_version < 4 )
{
	$messages[] = 'Please run <a href="upgrade3.php">upgrade3.php</a> before running this script.';
}
else
{
	$messages[] = "Your database is already up to date, there is no need to run this script.";
}
$lore_system->te->assign('messages', $messages);
$lore_system->te->display('upgrade.tpl');

?>

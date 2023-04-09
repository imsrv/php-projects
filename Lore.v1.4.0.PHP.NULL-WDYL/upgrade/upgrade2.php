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
if( $db_version == 2 )
{
	$messages[] = "Updating categories table.";
	$lore_system->db->query("ALTER TABLE lore_categories ADD total_articles INT UNSIGNED");

	$messages[] = "Updating category article counts.";
	$lore_category_tree->update_category_article_counts();

	$messages[] = "Updating category tree.";
	$lore_category_tree->update_category_tree();

	$messages[] = "Clearing compiled templates.";
	$lore_system->te->clear_compiled_templates();

	$new_setting_values = array(
				'cookie_path'		=> dirname($_SERVER['SCRIPT_NAME']),
				'knowledge_base_path'	=> dirname($_SERVER['SCRIPT_NAME']),
				'knowledge_base_domain'	=> 'http://' . $_SERVER['HTTP_HOST']
				);

	$messages[] = "Updating settings.";
	$lore_system->edit_settings( $new_setting_values, $lore_system->db );

	$messages[] = "Updating database version.";
	$lore_system->db->query("UPDATE lore_blackboard SET content='3' WHERE name='DB_VERSION'");

	$messages[] = "<strong>Upgrade completed.</strong>";
}
elseif( $db_version < 3 )
{
	$messages[] = 'Please run <a href="upgrade1.php">upgrade1.php</a> before running this script.';
}
else
{
	$messages[] = "Your database is already up to date, there is no need to run this script.";
}
$lore_system->te->assign('messages', $messages);
$lore_system->te->display('upgrade.tpl');

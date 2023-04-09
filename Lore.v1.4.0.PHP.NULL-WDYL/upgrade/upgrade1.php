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

if( $db_version < 2 )
{
	$lore_system->db->query("ALTER TABLE lore_articles DROP INDEX title_content");
	$lore_system->db->query("ALTER TABLE lore_articles ADD keywords VARCHAR(255)");
	$lore_system->db->query("ALTER TABLE lore_articles ADD FULLTEXT title_content_keywords (title,content,keywords)");
	$lore_system->db->query("ALTER TABLE lore_articles ADD FULLTEXT title_keywords (title,keywords)");
	
	$new_setting_values = array(
				'enable_gzip_compression'		=> true,
				'enable_search_engine_friendly_urls'	=> false,
				'enable_article_title_urls'		=> true,
				'enable_category_name_urls'		=> true,
				'enable_category_name_in_article_urls'	=> false
				);
	$lore_system->edit_settings( $new_setting_values, $lore_system->db );

	$lore_system->db->query("INSERT INTO lore_blackboard (content, name) VALUES ('2', 'DB_VERSION')");
	$messages[] = "Upgrade completed.";
}
else
{
	$messages[] = "Your database is already up to date, there is no need to run this script.";
}
$lore_system->te->assign('messages', $messages);
$lore_system->te->display('upgrade.tpl');

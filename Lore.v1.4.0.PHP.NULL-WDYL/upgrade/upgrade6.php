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

if( $db_version == 6 )
{
	$new_setting_values = array(
				'enable_rss_syndication'	=> 1,
				'enable_glossary'		=> 1,
				'enable_glossary_popups'	=> 1
				);

	$messages[] = "Updating settings.";
	$lore_system->edit_settings( $new_setting_values, $lore_system->db );
	
	$messages[] = "Clearing compiled templates.";
	$lore_system->te->clear_compiled_templates();

	$messages[] = "Updating database version.";
	$lore_system->db->query("UPDATE lore_blackboard SET content='7' WHERE name='DB_VERSION'");

	$messages[] = "<strong>Upgrade completed.</strong>";
}
elseif( $db_version < 6 )
{
	$messages[] = 'Please run <a href="upgrade5.php">upgrade5.php</a> before running this script.';
}
else
{
	$messages[] = "Your database is already up to date, there is no need to run this script.";
}
$lore_system->te->assign('messages', $messages);
$lore_system->te->display('upgrade.tpl');

?>

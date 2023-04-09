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

$lore_system->te->assign('script_name', 'Search Log');
$lore_system->te->assign('script_description', 'A log of searches that have been performed on your knowledge base.');
$lore_system->te->display('cp_header.tpl');

$search_log = new table_browse('Search Logs', '');
$search_log->template = 'cp_default_table_browse.tpl';
$search_log->row_name = 'records';
$search_log->db =& $lore_system->db;
$search_log->te =& $lore_system->te;
$search_log->add_tables('lore_search_log');
$search_log->add_display_field('search', 'Search Query');
$search_log->add_display_field('COUNT(*) AS num_searches', '# Searches');
$search_log->add_text_search_field(array('search' => 'Search Query'));
$search_log->add_group_by('search');
$search_log->add_page_controls();
$search_log->add_order_by_controls();
$search_log->get_input();

switch( $_REQUEST['action'] )
{
	case 'browse':
		$search_log->display();
	break;
}

?>

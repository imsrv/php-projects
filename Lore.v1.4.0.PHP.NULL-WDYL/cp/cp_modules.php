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

$module_groups = array(
		array(
		'name' => 'General',
		'modules' =>
			array(
			'Index'			=> $lore_system->scripts['cp_index'] . '?action=index',
			'Edit Settings'		=> $lore_system->scripts['cp_settings'],
			'Styles/Templates'	=> $lore_system->scripts['cp_style']
			),
		),

		array(
		'name' => 'Categories',
		'modules' =>
			array(
			'Add'			=> $lore_system->scripts['cp_category'] . '?action=new',
			'Browse'		=> $lore_system->scripts['cp_category'] . '?action=browse',
			),
		),

		array(
		'name' => 'Articles',
		'modules' =>
			array(
			'Add'			=> $lore_system->scripts['cp_article'] . '?action=new',
			'Browse'		=> $lore_system->scripts['cp_article'] . '?action=browse',
			'Trash Can'		=> $lore_system->scripts['cp_article'] . '?action=browse&category_id=' . $lore_system->settings['trash_can_category_id']
			),
		),

		array(
		'name' => 'Comments',
		'modules' =>
			array(
			'Browse All'		=> $lore_system->scripts['cp_comment'] . '?action=browse',
			'Browse Approved'	=> $lore_system->scripts['cp_comment'] . '?action=browse&approved=1',
			'Browse Unapproved'	=> $lore_system->scripts['cp_comment'] . '?action=browse&approved=0'
			),
		),

		array(
		'name' => 'Attachments',
		'modules' =>
			array(
			'Add'		=> $lore_system->scripts['cp_attachment'] . '?action=new',
			'Browse'	=> $lore_system->scripts['cp_attachment'] . '?action=browse'
			),
		),

		array(
		'name' => 'Glossary',
		'modules' =>
			array(
			'Add Term'	=> $lore_system->scripts['cp_glossary'] . '?action=new',
			'Browse'	=> $lore_system->scripts['cp_glossary'] . '?action=browse'
			),
		),

		array(
		'name' => 'Users',
		'modules' =>
			array(
			'Add'		=> $lore_system->scripts['cp_user'] . '?action=new',
			'Browse'	=> $lore_system->scripts['cp_user'] . '?action=browse',
			'Edit User Info'=> $lore_system->scripts['cp_user'] . '?action=edit&id=' . $lore_user_session->session_vars['user_info']['id']
			)
		),

		array(
		'name' => 'Search Log',
		'modules' =>
			array(
			'Browse Search Log'			=> $lore_system->scripts['cp_search_log'] . '?action=browse',
			)
		),
		
		array(
		'name' => 'Maintenance',
		'modules' =>
			array(
			'PHP Info'			=> $lore_system->scripts['cp_maintenance'] . '?action=phpinfo',
			'Article Search/Replace'	=> $lore_system->scripts['cp_maintenance'] . '?action=search_replace'
			)
		)
);

?>

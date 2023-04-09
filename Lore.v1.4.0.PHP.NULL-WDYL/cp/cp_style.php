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

$styles_dir = '../styles';

$lore_system->te->assign('script_name', 'Styles');
$lore_system->te->assign('script_description', 'The styles system controls the look of the user interface.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('style', $_REQUEST['action']);

$form = new form_smarty('style');
$form->te =& $lore_system->te;
$form->name = "Style";
$form->template = 'cp_default_form.tpl';
$form->add_field('submit', 'field_submit_button', array('name' => 'Submit'));
$form->add_field('style', 'field_select', array('name' => 'Style', 'description' => 'Select the style to use for the user interface. Each style is located in the /styles directory and consists of templates, images, and CSS stylesheets.', 'submit_on_change' => true));
$form->set_field_properties('style', array('select_options' => list_dirs( $styles_dir )));
$form->set_field_constraints('style', array('not_null' => true));
$form->add_field('stylesheet', 'field_select', array('name' => 'CSS Stylesheet', 'description' => 'Select the CSS stylesheet to use. The stylesheet controls the basic look and feel, including the colors and fonts.'));
$form->set_field_constraints('stylesheet', array('not_null' => true));

$form->get_post_input();
if( $form->submitted() )
{
	if( !$form->validate() )
	{
		$style_dir = $styles_dir . DIRECTORY_SEPARATOR . $form->get_field_value('style');
		$form->set_field_properties('style', array('select_options' => list_files( $style_dir, '.css' )));

		$form->display();
	}
	else
	{
		extract($form->get_field_values());
		$lore_system->set_blackboard_value('STYLE', $style);
		$lore_system->set_blackboard_value('STYLESHEET', $stylesheet);
		$lore_system->te->clear_compiled_templates();
		$form->readonly = true;
		show_cp_message('Style settings were saved.');
	}
}
elseif( !$form->posted() )
{
	// Get current style
	$style = $lore_system->get_blackboard_value('STYLE');
	$form->set_field_value('style', $style);
	
	// Get current stylesheet
	$stylesheet = $lore_system->get_blackboard_value('STYLESHEET');
	$form->set_field_value('stylesheet', $stylesheet);
}

$style_dir = "$styles_dir/" . $form->get_field_value('style') . '/stylesheets';
$form->set_field_properties('stylesheet', array('select_options' => list_files( $style_dir, '.css' )));
$form->display();
?>

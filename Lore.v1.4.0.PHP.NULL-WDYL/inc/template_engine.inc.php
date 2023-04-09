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

//////////////////////////////////////////////////////////////
/**
* Template engine object
* Just an extension of Smarty - adds in a few basic
* filters and some other configurations
*
* @package pt_common_lib
*/
//////////////////////////////////////////////////////////////
class pt_template_engine extends Smarty
{
	var $db;

	function pt_template_engine()
	{
		$this->register_block('nocache', 'te_block_nocache', false);
		$this->register_prefilter('te_prefilter_remove_html_comments');
		$this->register_postfilter('te_postfilter_header_check');
	}

	//////////////////////////////////////////////////////////////
	/**
	* Clear compiled templates
	*/
	//////////////////////////////////////////////////////////////
	function clear_compiled_templates()
	{
		$this->clear_compiled_tpl();
	}
	
	function display_nocache( $template )
	{
		$old_cache_setting = $this->caching;
		$this->caching = false;
		$this->display( $template );
		$this->caching = $old_cache_setting;
	}
}

function te_block_nocache( $params, $content, &$smarty )
{
	return $content;
}

function te_prefilter_remove_html_comments( $tpl_source, &$smarty )
{
	return preg_replace("/<!--.*-->/U", "", $tpl_source);
}

function te_postfilter_header_check( $tpl_source, &$smarty )
{
	return "<?php if( !defined('IN_PT_SYSTEM') ) die('Program run out of context. Quitting...'); ?>" . $tpl_source;
}
?>

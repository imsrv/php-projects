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

if( !$lore_system->db->id_exists( $_GET['id'], 'lore_attachments') )
{
	$lore_system->te->assign('error_message', 'invalid_attachment');
	$lore_system->te->display('error_message.tpl');
	exit;
}

$attachment = $lore_db_interface->get_attachment( $_GET['id'] );
$lore_db_interface->increment_attachment_downloads( $_GET['id'] );

$content_disp = ( eregi('IE', $_SERVER['HTTP_USER_AGENT']) ) ? 'inline' : 'attachment';
header('Content-Disposition:  ' . $content_disp . '; filename="' . $attachment['filename'] . '"');
header('Content-type: ' . $attachment['filetype']);
echo $attachment['file'];
?>

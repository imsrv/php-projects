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

$lore_system->te->assign('script_name', 'Attachments');
$lore_system->te->assign('script_description', 'Attachments are files that can be added to articles. Attachments are listed on the article\'s page and will be available for download by any user.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('attachment', $_REQUEST['action']);

$form_attachments = new form_db_single_table('attachments');
$form_attachments->template = 'cp_default_form.tpl';
$form_attachments->te =& $lore_system->te;
$form_attachments->db =& $lore_system->db;
$form_attachments->name = 'Add Attachments';

$form_attachments->add_field('id', 'field_hidden', array('export' => false, 'default_value' => $_GET['id']));
$form_attachments->add_field('submit', 'field_submit_button', array('name' => 'Submit', 'submits_form' => true));
$form_attachments->add_field('article_id', 'field_hidden', array('default_value' => $_GET['article_id']));
$form_attachments->add_field('article_title', 'field_text', array('name' => 'Article', 'description' => 'Article to attach files to.', 'readonly' => true, 'export' => false));
$form_attachments->add_field('attachments', 'field_file_upload_multiple', array('export' => false, 'name' => 'Attachments', 'num_files' => 5, 'allow_add_files' => true, 'max_file_size' => 10240000));
$form_attachments->set_field_constraints('attachments', array('min_file_uploads' => 1));

$form_attachments->get_post_input();
$form_attachments->set_field_properties('article_title', array('current_value' => $lore_system->db->query_one_result("SELECT title FROM lore_articles WHERE id='" . $form_attachments->get_field_value('article_id') . "'")));

$attachments = new table_browse('Attachments', 'Browse Attachments');
$attachments->template = 'cp_default_table_browse.tpl';
$attachments->row_name = 'attachments';
$attachments->db =& $lore_system->db;
$attachments->te =& $lore_system->te;
$attachments->add_tables('lore_attachments', 'lore_articles');
$attachments->add_fields('lore_attachments.id');
$attachments->add_where_clause('lore_attachments.article_id = lore_articles.id');
$attachments->add_display_field('filename', 'Filename');
$attachments->add_display_field('filetype', 'Filetype');
$attachments->add_display_field('filesize', 'Size');
$attachments->add_display_field('title', 'Article');
$attachments->add_text_search_field(array('title' => 'Article Title','filename' => 'File name','filetype' => 'File type'));
$attachments->add_link('Delete', $_SERVER['PHP_SELF'], array('id' => '$row[id]', 'action' => 'delete'));
$attachments->add_link('Download', '../' . $lore_system->scripts['attachment'], array('id' => '$row[id]'));
$attachments->add_page_controls();
$attachments->add_order_by_controls();
$attachments->add_row_checkboxes();
$attachments->set_actions(array('Delete' => 'delete'));
$attachments->get_input();
$attachment_id_list = ( $ids = $attachments->get_selected_rows() ) ? $ids : $_GET['id'];

// check permissions
switch( $_REQUEST['action'] )
{
	case 'new':
		if( $article_id = $form_attachments->get_field_value('article_id') )
		{
			if( !$lore_user_session->has_article_write_permission( $article_id ) )
			{
				show_cp_message('You do not have permission to manage attachments on this article.');
				exit;
			}
		}
	break;

	case 'delete':
		$attachment_ids = ( is_array($attachment_id_list) ) ? implode(',', $attachment_id_list) : $attachment_id_list;
		if( $attachment_ids )
		{
			$article_id_list = $lore_system->db->query_all_results("SELECT lore_articles.id FROM lore_articles,lore_attachments WHERE lore_articles.id=lore_attachments.article_id AND lore_attachments.id IN ($attachment_ids)");
			if( !$lore_user_session->has_article_write_permission( $article_id_list ) )
			{
				show_cp_message('You do not have permission to manage the selected attachment(s).');
				$attachments->display();
				exit;
			}
		}
	break;
}

// perform action
switch( $_REQUEST['action'] )
{
	case 'new':
		if( !$form_attachments->get_field_value('article_id') )
		{
			show_cp_message('Please use the <a href="'
					.$lore_system->scripts['cp_article']
					."?action=browse&sid=$sid\">article browser</a> "
					.'and click "Attach Files" next to the '
					.'article you want to add attachments to.');
			exit;
		}
					
		if( $form_attachments->submitted() )
		{
			$form_attachments->validate();
			if( $form_attachments->has_errors() )
			{
				$form_attachments->display();
			}
			else
			{
				extract( $form_attachments->get_field_values() );
				$attachments = $form_attachments->get_field_value('attachments');
				foreach( $attachments AS $attachment )
				{
					extract($attachment);
					
					move_uploaded_file( $tmp_name, $lore_system->te->compile_dir . '/attachment_tmp');
					$lore_system->db->query("INSERT INTO lore_attachments "
								."(article_id,filename,filetype,filesize,file) VALUES "
								."('$article_id','$name','$type','$size', '"
								.mysql_escape_string(file_get_contents($lore_system->te->compile_dir . '/attachment_tmp')) . "')");
					unlink( $lore_system->te->compile_dir . '/attachment_tmp' );
				}
				show_cp_message('Attached <b>' . count($attachments) . '</b> file(s).');
				$form_attachments->display_as_readonly();
			}
		}
		else
		{
			$form_attachments->display();
		}
	break;

	case 'browse':
		$attachments->display();
	break;

	case 'delete':
		$lore_system->db->delete_id($attachment_id_list, 'lore_attachments');
		show_cp_message('Deleted ' . count($attachment_id_list) . ' attachment(s).');
		$attachments->display();
	break;

}
?>

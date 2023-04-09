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

$lore_system->te->assign('script_name', 'Program Settings');
$lore_system->te->assign('script_description', 'These global settings control the basic software options.');
$lore_system->te->display('cp_header.tpl');

$lore_user_session->check_cp_permission('settings', $_REQUEST['action']);

$style_dir = '../styles';

$form_settings = new form_smarty('form_settings');
$form_settings->set_properties(array('name' => 'Edit Program Settings', 'template' => 'cp_default_form_with_groups.tpl', 'icon' => 'settings.gif'));
$form_settigns->db =& $lore_system->db;
$form_settings->te =& $lore_system->te;

$form_settings->add_field('save_settings', 'field_submit_button', array('name' => 'Save Settings', 'submits_form' => true));
$form_settings->add_field('restore_defaults', 'field_submit_button', array('name' => 'Restore Defaults', 'submits_form' => false));
$form_settings->add_field('knowledge_base_name', 'field_text', array('name' => 'Knowledge Base Name', 'description' => 'The name of your knowledge base.', 'size' => 50));
$form_settings->set_field_constraints('knowledge_base_name', array('max_length' => 255, 'not_null' => true));
$form_settings->add_field('knowledge_base_description', 'field_text', array('name' => 'Knowledge Base Description', 'description' => 'A short description of your knowledge base.', 'size' => 50));
$form_settings->add_field('knowledge_base_domain', 'field_text', array('name' => 'Knowledge Base Domain', 'description' => 'The primary domain name that your knowledge base is installed on. Do not include the path or a trailing space (ex: "http://example.com")', 'size' => 50));
$form_settings->set_field_constraints('knowledge_base_domain', array('max_length' => 255, 'not_null' => true));
$form_settings->add_field('knowledge_base_path', 'field_text', array('name' => 'Knowledge Base Path', 'description' => 'The URL path to your knowledge base, without the domain name or a trailing slash (i.e. "/lore" or "/example/kb")', 'size' => 50));
$form_settings->set_field_constraints('knowledge_base_path', array('max_length' => 255));
$form_settings->add_field('copyright_notice', 'field_textarea', array('name' => 'Copyright Notice', 'description' => 'Your copyright notice, placed at the bottom of the site.', 'rows' => 5, 'cols' => 30));
$form_settings->set_field_constraints('copyright_notice', array('max_length' => 255));
$form_settings->add_field('default_time_offset', 'field_timezone_select', array('name' => 'Default Time Offset', 'description' => 'the default timezone for the times displayed on the site.'));
$form_settings->add_field('show_admin_login_link', 'field_yes_no_select', array('name' => 'Show Admin Login Link?', 'description' => 'If enabled, a link to login to the control panel will be shown on the footer of every page of the knowledge base.'));
$form_settings->add_field('category_select_depth', 'field_select', array('name' => 'Category Select Depth', 'description' => 'The depth of the category tree that is used in the "browse by category" select menu. For example, entering 1 would only show root-level categories.', 'select_options' => array('Unlimited' => 9999) + range(1,25)));
$form_settings->set_field_constraints('category_select_depth', array('pattern_match' => 'number', 'validate_if_null' => false));
$form_settings->add_field_group('General', array('knowledge_base_name', 'knowledge_base_description', 'knowledge_base_domain', 'knowledge_base_path', 'copyright_notice', 'default_time_offset', 'show_admin_login_link', 'category_select_depth'));

$form_settings->add_field('show_contact_link', 'field_yes_no_select', array('name' => 'Show Contact Link?', 'description' => 'If enabled, a link to an email contact form will be displayed.'));
$form_settings->add_field('enable_automated_reply_system', 'field_yes_no_select', array('name' => 'Enable Automated Reply System?', 'description' => 'If enabled, the system will automatically perform a full text search after the contact form is submitted and display any articles relevant to the inquiry BEFORE emailing it to you.'));
$form_settings->add_field('automated_reply_system_num_articles', 'field_text', array('name' => 'Number of Articles to Show?', 'description' => 'Maximum number of articles to show for the automated reply system.', 'size' => 2));
$form_settings->set_field_constraints('automated_reply_system_num_articles', array('pattern_match' => 'number'));
$form_settings->add_field('contact_email', 'field_text', array('name' => 'Contact Email', 'description' => 'The email address to send inquiries to.', 'size' => 50));
$form_settings->set_field_constraints('contact_email', array('max_length' => 255, 'pattern_match' => 'email'));
$form_settings->add_field_group('Contact Form/Automated Reply System', array('show_contact_link', 'enable_automated_reply_system', 'automated_reply_system_num_articles', 'contact_email'));

$form_settings->add_field('show_latest_articles', 'field_yes_no_select', array('name' => 'Show Latest Articles?'));
$form_settings->add_field('show_most_viewed_articles', 'field_yes_no_select', array('name' => 'Show Most Viewed?'));
$form_settings->add_field('show_highest_rated_articles', 'field_yes_no_select', array('name' => 'Show Highest Rated?'));
$form_settings->add_field('num_top_articles', 'field_text', array('name' => 'Number of Articles to Show?', 'description' => 'The number of articles to display in the above lists.', 'size' => 3));
$form_settings->set_field_constraints('num_top_articles', array('pattern_match' => 'number', 'max_num' => 255, 'min_num' => 0));
$form_settings->add_field_group('Top/Latest Articles', array('show_latest_articles', 'show_most_viewed_articles', 'show_highest_rated_articles', 'num_top_articles'));

$form_settings->add_field('show_article_previews', 'field_yes_no_select', array('name' => 'Show Article Preview?', 'description' => 'If enabled, each article listed will have a short preview under it.'));
$form_settings->add_field('show_article_details', 'field_yes_no_select', array('name' => 'Show Article Details?', 'description' => 'If enabled, each article listed will have its rating, creation date, number of views, and number of comments listed under it.'));
$form_settings->add_field('article_short_preview_length', 'field_text', array('name' => 'Article Short Preview Length', 'description' => 'Number of characters to show in the short preview under each article listed.', 'size' => 3));
$form_settings->set_field_constraints('article_short_preview_length', array('min_num' => 0, 'pattern_match' => 'number'));
$form_settings->add_field('article_index_order', 'field_select', array('name' => 'Article Index Display Order', 'Field to order articles by', 'select_options' => array('Alphabetical' => 'title', 'ID' => 'id', 'Date Added' => 'created_time', 'Date Modified' => 'modified_time', 'Number of Views' => 'num_views', 'Rating' => 'rating')));
$form_settings->add_field('article_index_order_asc_or_desc', 'field_select', array('name' => 'Ascending or Descending?', 'description' => 'Order of above selection. Ascending is least to greatest, descending is greatest to least.', 'select_options' => array('Ascending' => 'ASC', 'Descending' => 'DESC')));
$form_settings->add_field_group('Article Index', array('show_article_previews', 'show_article_details', 'article_short_preview_length', 'article_index_order', 'article_index_order_asc_or_desc'));

$form_settings->add_field('show_article_info', 'field_yes_no_select', array('name' => 'Show Article Information?', 'description' => 'Determines whether detailed information (article id, author, rating, etc.) is displayed on the article page.'));
$form_settings->add_field('show_related_articles', 'field_yes_no_select', array('name' => 'Show Related Articles?', 'description' => 'Determines whether related articles are listed on the article page.'));
$form_settings->add_field('num_related_articles', 'field_text', array('name' => 'Number of Related Articles', 'description' => 'Number of related articles to show.', 'size' => 2));
$form_settings->set_field_constraints('num_related_articles', array('not_null' => true, 'pattern_match' => 'number'));
$form_settings->add_field('allow_article_ratings', 'field_yes_no_select', array('name' => 'Allow Ratings?', 'description' => 'Whether to allow users to rate articles.'));
$form_settings->add_field('show_article_ratings', 'field_yes_no_select', array('name' => 'Show Rating?', 'description' => 'Whether to show the article rating on the article page (otherwise it will only be available from the control panel).'));
$form_settings->add_field_group('Article Page', array('show_article_info', 'show_related_articles','num_related_articles', 'allow_article_ratings','show_article_ratings'));

$form_settings->add_field('category_index_order', 'field_select', array('name' => 'Category Index Display Order', 'description' => 'Field to order categories by', 'select_options' => array('Alphabetical' => name, 'Total articles' => 'total_articles')));
$form_settings->add_field('category_index_order_asc_or_desc', 'field_select', array('name' => 'Ascending or Descending?', 'description' => 'Order of above selection. Ascending is least to greatest, descending is greatest to least.', 'select_options' => array('Ascending' => 'ASC', 'Descending' => 'DESC')));
$form_settings->add_field_group('Category Index', array('category_index_order', 'category_index_order_asc_or_desc'));

$form_settings->add_field('show_comments', 'field_yes_no_select', array('name' => 'Show Comments?', 'description' => 'Determines whether or not comments are displayed on articles. Note: below option must be set to "Yes" to allow comments to be posted.'));
$form_settings->add_field('allow_comments', 'field_yes_no_select', array('name' => 'Allow Comments to be Posted?', 'description' => 'Whether or not to allow comments to be posted on articles.'));
$form_settings->add_field('require_comment_approval', 'field_yes_no_select', array('name' => 'Require Comment Approval?', 'description' => 'Whether or not to require comments to first be approved by an administrator before they are posted.'));
$form_settings->add_field('comment_allowed_html_tags', 'field_list', array('name' => 'Allowed HTML Tags (Comments)', 'description' => 'List of HTML tags that are allowed in comments. All others will be stripped.', 'cols' => 20, 'rows' => 10));
$form_settings->add_field('comment_order', 'field_select', array('name' => 'Comment Order', 'description' => 'Order the comments will be listed in.', 'select_options' => array('Ascending (earliest comment first)' => 'ASC', 'Descending (latest comment first)' => 'DESC')));
$form_settings->add_field('max_comment_length', 'field_text', array('name' => 'Maximum Comment Length?', 'description' => 'Maximum length (in # of characters) that a comment can be.', 'size' => 6));
$form_settings->set_field_constraints('max_comment_length', array('min_num' => 1, 'pattern_match' => number, 'not_null' => true));
$form_settings->add_field_group('Comments', array('show_comments', 'allow_comments', 'require_comment_approval', 'max_comment_length', 'comment_order', 'comment_allowed_html_tags'));

$form_settings->add_field('enable_glossary', 'field_yes_no_select', array('name' => 'Enable Glossary?', 'description' => 'Whether to show a link to the full glossary, which lists all terms.'));
$form_settings->add_field('enable_glossary_popups', 'field_yes_no_select', array('name' => 'Enable Glossary Popups?', 'description' => 'This option automatically highlights glossary terms in articles and links them to their definition.'));
$form_settings->add_field_group('Glossary', array('enable_glossary', 'enable_glossary_popups'));

$form_settings->add_field('date_format', 'field_text', array('name' => 'Date Format', 'description' => 'The format of a full date (day/month/year).<br><br>The format comes from the <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date() function</a>', 'size' => 30));
$form_settings->set_field_constraints('date_format', array('max_length' => 255, 'not_null' => true));
$form_settings->add_field('time_format', 'field_text', array('name' => 'Time Format', 'description' => 'The format of the time.<br><br>The format comes from the <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date() function</a>', 'size' => 30));
$form_settings->set_field_constraints('time_format', array('max_length' => 255, 'not_null' => true));
$form_settings->add_field_group('Date/Time Format', array('date_format', 'time_format'));

$form_settings->add_field('use_comment_censor', 'field_yes_no_select', array('name' => 'Use Comment Censor?', 'description' => 'This will automatically censor the words listed below in all comments.'));
$form_settings->add_field('censor_word_list', 'field_list', array('name' => 'Words to Censor', 'description' => 'Enter the words to censor. Words will be censored partially and in the order listed. For example, if "pine" is listed first, the word "pineapple" will be converted to "****apple", but if "pineapple" is listed first, it will be converted to "*********".', 'cols' => 15, 'rows' => 10));
$form_settings->add_field_group('Censorship Options', array('use_comment_censor', 'censor_word_list'));

$form_settings->add_field('enable_search_engine_friendly_urls', 'field_yes_no_select', array('name' => 'Enable "Search Engine Friendly" URLs?', 'description' => 'If set to yes, the URL\'s for articles and categories will look similar to: http://.../article/001/'));
$form_settings->add_field('enable_article_title_urls', 'field_yes_no_select', array('name' => 'Enable Article Titles in URLs?', 'description' => 'If set to yes, URL\'s for articles will include the title of the article. Example: http://.../my_article.html'));
$form_settings->add_field('enable_category_name_urls', 'field_yes_no_select', array('name' => 'Enable Category Names in URLs?', 'description' => 'If set to yes, URL\'s for categories will include the name of the category. Example: http://.../my_category.html'));
$form_settings->add_field('enable_category_name_in_article_urls', 'field_yes_no_select', array('name' => 'Enable Category Name in Article URLs?', 'description' => 'If set to yes, URL\'s for articles will include the name of the category they belong to.'));
$form_settings->add_field_group('Search Engine Friendly URLs', array('enable_search_engine_friendly_urls', 'enable_article_title_urls', 'enable_category_name_urls', 'enable_category_name_in_article_urls'));

$form_settings->add_field('cookie_path', 'field_text', array('name' => 'Cookie Path', 'description' => 'Path to use when setting cookies.', 'size' => 50));
$form_settings->add_field('cookie_domain', 'field_text', array('name' => 'Cookie Domain', 'description' => 'Domain to use when setting cookies. Use <b>.example.com</b> to match <b>www.example.com</b> <b>example.com</b>, etc.', 'size' => 50));
$form_settings->add_field_group('Cookies', array('cookie_path', 'cookie_domain'));

$form_settings->add_field('enable_rss_syndication', 'field_yes_no_select', array('name' => 'Enable RSS Syndication?', 'description' => 'Whether to allow articles/categories to be syndicated via RSS through the included RSS generating script.'));
$form_settings->add_field_group('RSS Syndication', array('enable_rss_syndication'));

$form_settings->add_field('enable_gzip_compression', 'field_yes_no_select', array('name' => 'Enable GZIP Compression?', 'description' => 'If set to yes, all output will automatically be GZIP compressed (which nearly all modern browsers support). This can cut HTML page size dramatically, save bandwidth, and speed up loading times.'));
$form_settings->add_field('enable_wysiwyg_editor', 'field_yes_no_select', array('name' => 'Enable WYSIWYG Editor?', 'description' => 'If set to yes, the WYSIWYG editor will be enabled when adding/editing articles. If no, a regular text area field will be displayed.'));
$form_settings->add_field('article_component_category_id', 'field_select', array('name' => 'Article Component Category', 'description' => 'Select a category to use for article components (articles that can be re-used as headers or footers for other articles).', 'select_options' => $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0) )));
$form_settings->add_field('trash_can_category_id', 'field_select', array('name' => 'Trash Can Category', 'description' => 'Select a category to move deleted articles and categories to.', 'select_options' => $lore_category_tree->get_category_options( $lore_category_tree->generate_category_tree(0) )));
$form_settings->add_field_group('Misc', array('enable_gzip_compression', 'enable_wysiwyg_editor','article_component_category_id','trash_can_category_id'));


$form_settings->get_post_input();
$form_settings->set_submit_action_from_button();
switch( $_REQUEST['action'] )
{
	case 'save_settings':
		$form_settings->get_post_input();
		$form_settings->validate();
		if( !$form_settings->has_errors() )
		{
			$content = addslashes(serialize($form_settings->get_field_values()));
			$lore_system->db->query("UPDATE lore_blackboard SET content='$content' WHERE name='SETTINGS'");
			$lore_system->te->clear_compiled_templates();
			show_cp_message('Program Settings were saved.');
			$form_settings->display_as_readonly();
		}
		else
		{
			$form_settings->display();
		}
	break;

	case 'restore_defaults':
		$default_settings = $lore_system->db->query_one_result("SELECT content FROM lore_blackboard WHERE name='DEFAULT_SETTINGS'");
		$lore_system->db->query("UPDATE lore_blackboard SET content='$default_settings' WHERE name='SETTINGS'");
		$lore_system->get_settings();
		$form_settings->populate_from_array($lore_system->settings);
		$lore_system->te->clear_compiled_templates();

		show_cp_message('Default program settings were restored.');
		$form_settings->display_as_readonly();
	break;

	default:
		$form_settings->populate_from_array($lore_system->settings);
		$form_settings->display();
	break;
}
?>

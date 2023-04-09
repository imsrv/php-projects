<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");

define('ALLOW_HTML_MAIL', 'yes');

$jsfile = "admin_mail.js";
if ($HTTP_POST_VARS['todo'] != "test_mail" && $HTTP_GET_VARS['todo']!="preview" && $HTTP_POST_VARS['todo']!="preview") {
	include (DIR_SERVER_ADMIN."admin_header.php");
}
include(DIR_SERVER_ADMIN. 'admin_mail_lng.php');
include(DIR_SERVER_ADMIN."admin_edit_mail_form.php");
if ($HTTP_POST_VARS['todo'] != "test_mail" && $HTTP_GET_VARS['todo']!="preview" && $HTTP_POST_VARS['todo']!="preview") {
	include (DIR_SERVER_ADMIN."admin_footer.php");
}
?>
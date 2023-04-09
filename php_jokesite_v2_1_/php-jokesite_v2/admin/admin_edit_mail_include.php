<?
if ($HTTP_POST_VARS['todo']=="preview") {
	include ("../config_file.php");
	include (DIR_SERVER_ADMIN."admin_setting.php");
	echo $HTTP_POST_VARS['test_html_file'];
	exit;
}
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include(DIR_SERVER_ADMIN. 'admin_mail_lng.php');
$jsfile = "admin_mail.js";
if ($HTTP_POST_VARS['todo'] != "test_mail") {
    include (DIR_SERVER_ADMIN."admin_header.php");
}
include(DIR_SERVER_ADMIN."admin_edit_mail_include_form.php");
if ($HTTP_POST_VARS['todo'] != "test_mail") {
    include (DIR_SERVER_ADMIN."admin_footer.php");
}
?>
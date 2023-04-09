<?
include ('../config_file.php');
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

if ($todo =="editoptions")
{
    include(DIR_LANGUAGES.$folders.'.php');
}
$jsfile = "admin_lng.js";

include(DIR_SERVER_ADMIN."admin_language_edit_lng_form.php");
include(DIR_SERVER_ADMIN."admin_footer.php");
?>
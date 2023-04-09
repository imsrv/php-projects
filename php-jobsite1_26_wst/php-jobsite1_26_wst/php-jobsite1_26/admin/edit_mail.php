<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);
$jsfile = "admin_mail.js";
if ($HTTP_POST_VARS['todo'] != "test_mail") {
    include("header.php");
}
include(DIR_ADMIN.FILENAME_ADMIN_EDIT_MAIL_FORM);
if ($HTTP_POST_VARS['todo'] != "test_mail") {
    include("footer.php");
}
else {
    bx_exit();
}
?>
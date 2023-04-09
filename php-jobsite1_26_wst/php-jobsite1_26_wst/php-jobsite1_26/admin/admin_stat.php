<?php
include('admin_design.php');
include('../application_config_file.php');
include('admin_auth.php');
include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);
$jsfile = "admin_lng.js";
include("header.php");
include(DIR_ADMIN."admin_stat_form.php");
include("footer.php");
?>
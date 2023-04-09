<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);
if ($HTTP_GET_VARS["compid"] && $HTTP_GET_VARS['logo_name']) {
        $image_location = DIR_LOGO. $HTTP_GET_VARS['logo_name'];
        if (file_exists($image_location)) {
                @unlink($image_location);
                bx_db_query("update ".$bx_table_prefix."_companies set logo = '' where compid = '".$HTTP_GET_VARS['compid']."'");
        }//end if (file_exists($image_location))
        header("Location: ".HTTP_SERVER_ADMIN.FILENAME_ADMIN."?action=details");
        bx_exit();
}
?>
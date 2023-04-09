<?php
include ('application_config_file.php');
if ($HTTP_GET_VARS['login'] == "jobseeker" && $HTTP_SESSION_VARS['userid']) {
    header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$HTTP_GET_VARS['job_id'], "auth_sess", $bx_session));
    bx_exit();
}
if ($HTTP_GET_VARS['login'] == "employer" && $HTTP_SESSION_VARS['employerid']) {
    if ($HTTP_GET_VARS['resume_id']) {
        if ($HTTP_GET_VARS['from']=="download") {
               $sess_resume_id = $HTTP_GET_VARS['resume_id'];
               bx_session_unregister("sess_resume_id");
               bx_session_register("sess_resume_id");
               header("location: ".bx_make_url(HTTP_SERVER."download_resume.php?resume_id=".$HTTP_GET_VARS['resume_id'], "auth_sess", $bx_session));
               bx_exit();
        }
        else {
            header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?resume_id=".$HTTP_GET_VARS['resume_id'], "auth_sess", $bx_session));
            bx_exit();
        }    
    }
    if ($HTTP_GET_VARS['job_id']) {
        header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$HTTP_GET_VARS['job_id']."&employer=yes", "auth_sess", $bx_session));
        bx_exit();
    }
}
include(DIR_SERVER_ROOT."header.php");
include(DIR_FORMS.FILENAME_LOGIN_FORM);    
include(DIR_SERVER_ROOT."footer.php");
?>
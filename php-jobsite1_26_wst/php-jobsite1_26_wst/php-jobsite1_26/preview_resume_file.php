<?php
include('application_config_file.php');
if ($HTTP_SESSION_VARS['userid']) {
                    $resume_query = bx_db_query("select * from  ".$bx_table_prefix."_resumes where ".$bx_table_prefix."_resumes.persid = '".$HTTP_SESSION_VARS['userid']."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    $resume_result=bx_db_fetch_array($resume_query);
                    if ($resume_result['resume_cv']) {
                            header("Content-disposition: attachment; filename=".eregi_replace($resume_result['persid']."-","",$resume_result['resume_cv']));    
                            header("Content-type: application/octetstream");
                            header("Pragma: no-cache");
                            header("Expires: 0");
                            $fp = @fread(@fopen(DIR_RESUME.$resume_result['resume_cv'],"r"),@filesize(DIR_RESUME.$resume_result['resume_cv']));
                            echo $fp;
                    }
}
else {
                            $error_message=TEXT_UNAUTHORIZED_ACCESS;
                            $close_button = true;
                            $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                            include(DIR_FORMS.FILENAME_ERROR_FORM);
}
include('application_parse_time_log.php');
?>
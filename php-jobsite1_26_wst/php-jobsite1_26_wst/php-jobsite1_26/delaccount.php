<?php
define('LEFT_NAVIGATION_WIDTH','20%');
define('RIGHT_NAVIGATION_WIDTH','20%');
define('MAIN_NAVIGATION_WIDTH','60%');
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_DELACCOUNT);
       if ($HTTP_POST_VARS['action']=="delaccount") {
          if ($HTTP_POST_VARS['type']=="jobseeker") {
             if (!$HTTP_SESSION_VARS['userid']) {
                  $error_message=TEXT_UNAUTHORIZED_ACCESS;
                  $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                  include(DIR_SERVER_ROOT."header.php");
                  include(DIR_FORMS.FILENAME_ERROR_FORM);
                  include(DIR_SERVER_ROOT."footer.php");      
             }
             else {
                  if ($HTTP_POST_VARS['yes']) {
                        $jobseeker_query = bx_db_query("select * from ".$bx_table_prefix."_persons where persid='".$HTTP_SESSION_VARS['userid']."'");
                        $jobseeker_result = bx_db_fetch_array($jobseeker_query);
                        $mailfile = $language."/mail/jobseeker_unregistration.txt";
                        include(DIR_LANGUAGES.$mailfile.".cfg.php");
                        $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                        reset($fields);
                        while (list($h, $v) = each($fields)) {
                             $mail_message = eregi_replace($v[0],$jobseeker_result[$h],$mail_message);
                             $file_mail_subject = eregi_replace($v[0],$jobseeker_result[$h],$file_mail_subject);
                        }
                        if ($add_mail_signature == "on") {
                             $mail_message .= "\n".SITE_SIGNATURE;
                        }
                        bx_mail(SITE_NAME,SITE_MAIL,$jobseeker_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                        $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_SESSION_VARS['userid']."'");
                        if(bx_db_num_rows($resume_query)!=0)
                           {
                             $resume_result=bx_db_fetch_array($resume_query);
                             $cv_file_location = DIR_RESUME.$resume_result['resume_cv'];
                             if (file_exists($cv_file_location)) {
                                  @unlink($cv_file_location);
                             }//end if (file_exists($cv_file_location))
                        }     
                        bx_db_query("insert into del".$bx_table_prefix."_resumes select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_SESSION_VARS['userid']."'");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("delete from ".$bx_table_prefix."_resumes where persid=\"".$HTTP_SESSION_VARS['userid']."\"");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("insert into del".$bx_table_prefix."_persons select * from ".$bx_table_prefix."_persons where persid=\"".$HTTP_SESSION_VARS['userid']."\"");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("delete from ".$bx_table_prefix."_persons where persid=\"".$HTTP_SESSION_VARS['userid']."\"");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("delete from ".$bx_table_prefix."_jobmail where persid=\"".$HTTP_SESSION_VARS['userid']."\"");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_session_destroy();
                        $HTTP_SESSION_VARS['userid'] = '';
                        $HTTP_SESSION_VARS['userid'] = '';
                        include(DIR_SERVER_ROOT."header.php");
                        $success_message=TEXT_DELETE_ACCOUNT_SUCCESSFULLY;
                        $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX."?language=".$language, "auth_sess", $bx_session);
                        include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                        include(DIR_SERVER_ROOT."footer.php");      
                  }
                  else {
                      header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session));
                      bx_exit();
                  }
             }
          }
          elseif ($HTTP_POST_VARS['type']=="employer") {
                   if (!$HTTP_SESSION_VARS['employerid']) {
                          $error_message=TEXT_UNAUTHORIZED_ACCESS;
                          $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                          include(DIR_SERVER_ROOT."header.php");
                          include(DIR_FORMS.FILENAME_ERROR_FORM);
                          include(DIR_SERVER_ROOT."footer.php");      
                   }
                   else {
                        if ($HTTP_POST_VARS['yes']) {
                            $employer_query = bx_db_query("select * from ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            $employer_result = bx_db_fetch_array($employer_query);
                            $mailfile = $language."/mail/employer_unregistration.txt";
                            include(DIR_LANGUAGES.$mailfile.".cfg.php");
                            $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                            reset($fields);
                            while (list($h, $v) = each($fields)) {
                                 $mail_message = eregi_replace($v[0],$employer_result[$h],$mail_message);
                                 $file_mail_subject = eregi_replace($v[0],$employer_result[$h],$file_mail_subject);
                            }
                            if ($add_mail_signature == "on") {
                                 $mail_message .= "\n".SITE_SIGNATURE;
                            }
                            bx_mail(SITE_NAME,SITE_MAIL,$employer_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                            bx_db_query("insert into del".$bx_table_prefix."_companies select * from ".$bx_table_prefix."_companies where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_companies where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_companycredits where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("insert into del".$bx_table_prefix."_jobs select * from ".$bx_table_prefix."_jobs where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            $job_query = bx_db_query("select jobid from ".$bx_table_prefix."_jobs where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            while ($job_result = bx_db_fetch_array($job_query)) {
                                bx_db_query("delete from ".$bx_table_prefix."_jobview where jobid=\"".$job_result['jobid']."\"");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            }
                            bx_db_query("delete from ".$bx_table_prefix."_jobs where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("insert into del".$bx_table_prefix."_invoices select * from ".$bx_table_prefix."_invoices where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_invoices where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("insert into del".$bx_table_prefix."_membership select * from ".$bx_table_prefix."_membership where compid='".$HTTP_SESSION_VARS['employerid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_membership where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_resumemail where compid=\"".$HTTP_SESSION_VARS['employerid']."\"");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            if ($employer_result['logo'] && file_exists(DIR_LOGO.$employer_result['logo'])) {
                                @unlink(DIR_LOGO.$employer_result['logo']);
                            }
                            bx_session_destroy();
                            $HTTP_SESSION_VARS['employerid'] = '';
                            $HTTP_SESSION_VARS['employerid'] = '';
                            include(DIR_SERVER_ROOT."header.php");
                            $success_message=TEXT_DELETE_ACCOUNT_SUCCESSFULLY;
                            $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX."?language=".$language, "auth_sess", $bx_session);
                            include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                            include(DIR_SERVER_ROOT."footer.php");      
                        }
                        else {
                            header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session));
                            bx_exit();
                        }
                  }
        }
}
else {
     include(DIR_SERVER_ROOT."header.php");
     if ($HTTP_SESSION_VARS['employerid'] || $HTTP_SESSION_VARS['userid']) {
          include(DIR_FORMS.FILENAME_DELACCOUNT_FORM);    
     }
     else {
          $error_message=TEXT_UNAUTHORIZED_ACCESS;
          $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
          include(DIR_FORMS.FILENAME_ERROR_FORM);
     }
     include(DIR_SERVER_ROOT."footer.php");      
}
bx_exit();       
?>
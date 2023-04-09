<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_FORGOT_PASSWORDS);
$jsfile="forgot_passwords.js";
include(DIR_SERVER_ROOT."header.php");
       if ($HTTP_POST_VARS['action']=="forgot_password") {
          if ($HTTP_POST_VARS['type']=="jobseeker") {
             if ((!$HTTP_POST_VARS['pers_email']) || (!eregi("(@)(.*)",$HTTP_POST_VARS['pers_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['pers_email'],$regs))) {
                  $error_message=NO_EMAIL_ADDRESS;
                  $back_url=bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true", "auth_sess", $bx_session);
                  include(DIR_FORMS.FILENAME_ERROR_FORM);
               }
             else {
                  $forget_query=bx_db_query("select * from ".$bx_table_prefix."_persons where email='".$HTTP_POST_VARS['pers_email']."'");
                  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                  if (bx_db_num_rows($forget_query)!=0) {
                      $forget_result=bx_db_fetch_array($forget_query);
                      $mailfile = $language."/mail/jobseeker_forgottpassword.txt";
                      include(DIR_LANGUAGES.$mailfile.".cfg.php");
                      $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                      reset($fields);
                      while (list($h, $v) = each($fields)) {
                           $mail_message = eregi_replace($v[0],$forget_result[$h],$mail_message);
                           $file_mail_subject = eregi_replace($v[0],$forget_result[$h],$file_mail_subject);
                      }
                      if ($add_mail_signature == "on") {
                           $mail_message .= "\n".SITE_SIGNATURE;
                      }
                      bx_mail(SITE_NAME,SITE_MAIL,$forget_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                      $success_message=TEXT_PASSWORD_IN_MAIL_SENT_SUCCESSFULLY;
                      $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                      include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                  }
                  else {
                       //Email address not found in database
                       $error_message=EMAIL_ADDRESS_NOT_FOUND;
                       $back_url=bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true", "auth_sess", $bx_session);
                       include(DIR_FORMS.FILENAME_ERROR_FORM);
                  }
             }
          }
          elseif ($HTTP_POST_VARS['type']=="employer") {
                   if ((!$HTTP_POST_VARS['comp_email']) || (!eregi("(@)(.*)",$HTTP_POST_VARS['comp_email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['comp_email'],$regs))) {
                          $error_message=NO_EMAIL_ADDRESS;
                          $back_url=bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true", "auth_sess", $bx_session);
                          include(DIR_FORMS.FILENAME_ERROR_FORM);
                   }
                   else {
                         $forget_query=bx_db_query("select * from ".$bx_table_prefix."_companies where email='".$HTTP_POST_VARS['comp_email']."'");
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         if (bx_db_num_rows($forget_query)!=0) {
                             $forget_result=bx_db_fetch_array($forget_query);
                             $mailfile = $language."/mail/employer_forgottpassword.txt";
                             include(DIR_LANGUAGES.$mailfile.".cfg.php");
                             $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                             reset($fields);
                             while (list($h, $v) = each($fields)) {
                                  $mail_message = eregi_replace($v[0],$forget_result[$h],$mail_message);
                                  $file_mail_subject = eregi_replace($v[0],$forget_result[$h],$file_mail_subject);
                             }
                             if ($add_mail_signature == "on") {
                                  $mail_message .= "\n".SITE_SIGNATURE;
                             }
                             bx_mail(SITE_NAME,SITE_MAIL,$forget_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                             $success_message=TEXT_PASSWORD_IN_MAIL_SENT_SUCCESSFULLY;
                             $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                             include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                         }
                         else {
                               //Email address not found in database
                               $error_message=EMAIL_ADDRESS_NOT_FOUND;
                               $back_url=bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true", "auth_sess", $bx_session);
                               include(DIR_FORMS.FILENAME_ERROR_FORM);
                         }
                   }
             }
       }
       else {
             include(DIR_FORMS.FILENAME_FORGOT_PASSWORDS_FORM);
       }
include(DIR_SERVER_ROOT."footer.php");      
?>
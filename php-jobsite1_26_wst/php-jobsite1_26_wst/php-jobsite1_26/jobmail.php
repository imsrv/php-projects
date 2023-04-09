<?php
include ('application_config_file.php');
include(DIR_SERVER_ROOT."header.php");
       if ($HTTP_SESSION_VARS['userid'])
        {
           $jobmail_query=bx_db_query("select * from ".$bx_table_prefix."_jobmail where persid='".$HTTP_SESSION_VARS['userid']."'");
           if(bx_db_num_rows($jobmail_query)!=0) {
                   $jobmail_exist="true";
                   $jobmail_result=bx_db_fetch_array($jobmail_query);
           }//end if(bx_db_num_rows($jobmail_query)!=0)
           else {
                   $jobmail_exist="false";
           }//end else if(bx_db_num_rows($jobmail_query)!=0)
           if ($HTTP_POST_VARS['action']=="jobmail_subscribe") {
                  if (($jobmail_exist=="false") && ($HTTP_POST_VARS['jobmail_type']!=1)) {
                      bx_db_insert($bx_table_prefix."_jobmail","persid,jobmail_type,jmail_lang,jobmail_lastdate","\"".$HTTP_SESSION_VARS['userid']."\",\"".$HTTP_POST_VARS['jobmail_type']."\",'".$HTTP_POST_VARS['jmail_lang']."','".date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')))."'");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      $done="subscribe";
                  }//end if ($jobmail_exist=="false")
                  if (($jobmail_exist=="true") && (($HTTP_POST_VARS['jobmail_type']!=$jobmail_result['jobmail_type']) || ($HTTP_POST_VARS['jmail_lang']!=$jobmail_result['jmail_lang']))) {
                      bx_db_query("update ".$bx_table_prefix."_jobmail set jobmail_type=\"".$HTTP_POST_VARS['jobmail_type']."\",jmail_lang = '".$HTTP_POST_VARS['jmail_lang']."',jobmail_lastdate='' where persid=\"".$HTTP_SESSION_VARS['userid']."\"");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      $done="subscribe_update";
                  }
            }//end if ($action="jobmail_subscribe")
            if ($HTTP_POST_VARS['action']=="jobmail_unsubscribe") {
                bx_db_query("delete from ".$bx_table_prefix."_jobmail where persid='".$HTTP_SESSION_VARS['userid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                $done="unsubscribe";
            }
            include(DIR_FORMS.FILENAME_JOBMAIL_FORM);
        }//end if ($HTTP_SESSION_VARS['userid'])
        else  {
            $login='jobseeker';
            include(DIR_FORMS.FILENAME_LOGIN_FORM);
        }//end else if ($HTTP_SESSION_VARS['userid'])
include(DIR_SERVER_ROOT."footer.php");        
?>
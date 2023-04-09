<?php
include ('application_config_file.php');
if($HTTP_GET_VARS['login']=='jobseeker')
{
   $db_query="SELECT persid from ".$bx_table_prefix."_persons where email='".$HTTP_POST_VARS['users_seek']."' and password='".bx_addslashes($HTTP_POST_VARS['passw_seek'])."'";
   $result_userid=bx_db_query($db_query);
   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
   $reactivate = 0;
   if(bx_db_num_rows($result_userid)!=0) {
          $user=bx_db_fetch_array($result_userid);
          $userid=$user['persid'];
          bx_session_register("userid");
	      $sessiontime = time();
          bx_session_register("sessiontime");
          if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){
                  $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
          }
          else {
                  $IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
          }
          bx_db_query("UPDATE ".$bx_table_prefix."_persons set lastlogin = NOW(), lastip = '".$IP."' where persid = '".$userid."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $resume_query = bx_db_query("select resumeid, TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire) - TO_DAYS(NOW()) as resexp from ".$bx_table_prefix."_resumes where persid='".$userid."'");
          if(bx_db_num_rows($resume_query)>0) {
              $resume_result = bx_db_fetch_array($resume_query);
              $post_resumeid = $resume_result['resumeid'];
              bx_session_register("post_resumeid");
              if(RESUME_EXPIRE == "yes") {
                  if($resume_result['resexp'] <= NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY) {
                      $reactivate = 1;
                  }
              }    
          }
          if($HTTP_POST_VARS['from']) {
              $from = $HTTP_POST_VARS['from'];
          }
          elseif($HTTP_GET_VARS['from']) {
              $from = $HTTP_GET_VARS['from'];
          }
          else {
              $from = '';
          }
          if($reactivate == 1) {
              header("location: ".bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session));
              bx_exit();
          }
          else if ($from) {
                if ($from=="view") {
                      header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".(($HTTP_GET_VARS['job_id'])?$HTTP_GET_VARS['job_id']:$HTTP_POST_VARS['job_id']), "auth_sess", $bx_session));
                      bx_exit();
                }
                else {
                      header("location: ".$from);
                      bx_exit();
                }
          }//end if ($from)
          else {
                header("location: ".bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session));
                bx_exit();
          }//end else if ($from)
   }
   else {
           header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_ERROR_LOGIN, "auth_sess", $bx_session));
           bx_exit();
   }
}
else if($HTTP_GET_VARS['login']=='employer')
{
     $db_query="SELECT compid from ".$bx_table_prefix."_companies where email='".$HTTP_POST_VARS['users_empl']."' and password='".bx_addslashes($HTTP_POST_VARS['passw_empl'])."'";
     $result_userid=bx_db_query($db_query);
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     if(bx_db_num_rows($result_userid)!=0) {
          $user=bx_db_fetch_array($result_userid);
          $employerid=$user['compid'];
          bx_session_register("employerid");
		  $sessiontime = time();
          bx_session_register("sessiontime");
          if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){
                  $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
                  $proxy = $HTTP_SERVER_VARS["REMOTE_ADDR"];
                  $host = @gethostbyaddr($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]);
          }
          else {
                  $IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
                  $host = @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
          }
          bx_db_query("UPDATE ".$bx_table_prefix."_companies set lastlogin = NOW(), lastip = '".$IP."' where compid = '".$employerid."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          if($HTTP_POST_VARS['redirect']) {
              $redirect = $HTTP_POST_VARS['redirect'];
          }
          elseif($HTTP_GET_VARS['redirect']) {
              $redirect = $HTTP_GET_VARS['redirect'];
          }
          else {
              $redirect = '';
          }
          if($HTTP_POST_VARS['from']) {
              $from = $HTTP_POST_VARS['from'];
          }
          elseif($HTTP_GET_VARS['from']) {
              $from = $HTTP_GET_VARS['from'];
          }
          else {
              $from = '';
          }
          if ($redirect) {
              if ($redirect=="details") {
                   header("location: ".bx_make_url(HTTP_SERVER.FILENAME_DETAILS."?resume_id=".(($HTTP_GET_VARS['resume_id'])?$HTTP_GET_VARS['resume_id']:$HTTP_POST_VARS['resume_id']), "auth_sess", $bx_session));
                   bx_exit();
              }
              else {
                   header("location: ".$redirect);
                   bx_exit();
              }
          }//end if ($from)
          elseif ($from) {
                if ($from=="view") {
                      if ($HTTP_GET_VARS['resume_id']) {
                                header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?resume_id=".(($HTTP_GET_VARS['resume_id'])?$HTTP_GET_VARS['resume_id']:$HTTP_POST_VARS['resume_id']), "auth_sess", $bx_session));
                                bx_exit();
                      }
                      if ($HTTP_GET_VARS['job_id']) {
                                header("location: ".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".(($HTTP_GET_VARS['job_id'])?$HTTP_GET_VARS['job_id']:$HTTP_POST_VARS['job_id'])."&employer=yes", "auth_sess", $bx_session));
                                bx_exit();
                      }
                }
                elseif ($from=="download") {
                      if ($HTTP_GET_VARS['resume_id']) {
                               $sess_resume_id = $HTTP_GET_VARS['resume_id'];
                               bx_session_unregister("sess_resume_id");
                               bx_session_register("sess_resume_id");
                               header("location: ".bx_make_url(HTTP_SERVER."download_resume.php?resume_id=".$HTTP_GET_VARS['resume_id'], "auth_sess", $bx_session));
                               bx_exit();
                      }
                }
                else {
                      header("location: ".$from);
                      bx_exit();
                }
          }//end if ($from)
          else  {
               header("location: ".bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session));
               bx_exit();
          }//end else if ($redirect)
     }
     else {
           header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_ERROR_LOGIN, "auth_sess", $bx_session));
           bx_exit();
    }
}
else {
    header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session));
	bx_exit();
}
?>
<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_EMAIL_JOB);
           if (($HTTP_POST_VARS['action']=="sendjobinemail") && ($HTTP_POST_VARS['job_id'])) {
                  //Error validation
                  $error=0;
                  if (($HTTP_POST_VARS['jname']=="")) {
                        $error=1;
                        $jname_error=1;
                  }
                  else {
                        $jname_error=0;
                  }
                  if (($HTTP_POST_VARS['jemail']=="") || (!eregi("(@)(.*)",$HTTP_POST_VARS['jemail'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['jemail'],$regs))) {
                        $error=1;
                        $jemail_error=1;
                  }
                  else {
                        $jemail_error=0;
                  }
                  if (($HTTP_POST_VARS['fname']=="")) {
                        $error=1;
                        $fname_error=1;
                  }
                  else {
                        $fname_error=0;
                  }
                  if (($HTTP_POST_VARS['femail']=="") || (!eregi("(@)(.*)",$HTTP_POST_VARS['femail'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['femail'],$regs))) {
                        $error=1;
                        $femail_error=1;
                  }
                  else {
                        $femail_error=0;
                  }
                  if (($HTTP_POST_VARS['jmessage']=="")) {
                        $error=1;
                        $jmessage_error=1;
                  }
                  else {
                        $jmessage_error=0;
                  }
                  if ($error==1) //we have errors
                  {
                        include(DIR_FORMS.FILENAME_EMAIL_JOB_FORM);
                  } //end if error=1
                  else //no errors
                  {
                        $job_query = bx_db_query("select * from  ".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobs.jobid = '".$HTTP_POST_VARS['job_id']."'");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        if (bx_db_num_rows($job_query)>0) {
                                $job_result = bx_db_fetch_array($job_query);
                                $location_names = array();
                                $location_query = bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($location_result = bx_db_fetch_array($location_query)) {
                                $location_names[$location_result['locationid']] = $location_result['location'];
                                }
                                $type_names = array();
                                $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($type_result = bx_db_fetch_array($type_query)) {
                                $type_names[$type_result['jobtypeid']] = $type_result['jobtype'];
                                }
                                $jobcategory_names = array();
                                $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng."");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
                                $jobcategory_names[$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
                                }
                                $job_result['visitor_name'] = bx_dirty_words($HTTP_POST_VARS['jname']);
                                $job_result['visitor_email'] = bx_dirty_words($HTTP_POST_VARS['jemail']);
                                $job_result['friend_email'] = bx_dirty_words($HTTP_POST_VARS['femail']);
                                $job_result['friend_name'] = bx_dirty_words($HTTP_POST_VARS['fname']);
                                $job_result['visitor_message'] = bx_dirty_words($HTTP_POST_VARS['jmessage']);
                                $job_result['location'] = $location_names[$job_result['locationid']];
                                $job_result['jobcategory'] = $jobcategory_names[$job_result['jobcategoryid']];
                                $w=$job_result['jobtypeids'];
                                while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                                        $job_result['jobtype'] .= $type_names[$regs[1]]." - ";
                                        $w=$regs[2];
                                }
                                $job_result['jobtype'] = eregi_replace(" - $","",$job_result['jobtype']);
                                $job_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                                $job_result['jobdate'] = bx_format_date($job_result['jobdate'], DATE_FORMAT);
                                $job_result['lastdate'] = bx_format_date($job_result['lastdate'], DATE_FORMAT);
                                if ($job_result['salary']) {
                                        $job_result['salary'] = bx_format_price($job_result['salary'],PRICE_CURENCY,0);
                                }
                                else {
                                        $job_result['salary'] = TEXT_UNSPECIFIED;
                                }
                                $job_result['joblink'] = HTTP_SERVER.FILENAME_VIEW."?job_id=".$job_result['jobid'];
                                //send mail to registered company
                                $mailfile = $language."/mail/email_job_to_friend.txt";
                                include(DIR_LANGUAGES.$mailfile.".cfg.php");
                                $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                                reset($fields);
                                while (list($h, $v) = each($fields)) {
                                        $mail_message = eregi_replace($v[0],$job_result[$h],$mail_message);
                                        $file_mail_subject = eregi_replace($v[0],$job_result[$h],$file_mail_subject);
                                }
                                if ($add_mail_signature == "on") {
                                        $mail_message .= "\n".SITE_SIGNATURE;
                                }
                                bx_mail(SITE_NAME,SITE_MAIL,$HTTP_POST_VARS['femail'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                                if ($HTTP_POST_VARS['sendcopy'] == "yes") {
                                        bx_mail(SITE_NAME,SITE_MAIL,$HTTP_POST_VARS['jemail'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                                }
                                $action = "sent";
                                include(DIR_FORMS.FILENAME_EMAIL_JOB_FORM);
                        }
                        else {
                                $error_message=TEXT_UNAUTHORIZED_ACCESS;
                                $close_button = true;
                                $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                                include(DIR_FORMS.FILENAME_ERROR_FORM);
                        }
                  }
            }//end if (($HTTP_POST_VARS['action']=="sendjobinemail") && ($HTTP_POST_VARS['job_id']))
            else {
                include(DIR_FORMS.FILENAME_EMAIL_JOB_FORM);
            }
?>
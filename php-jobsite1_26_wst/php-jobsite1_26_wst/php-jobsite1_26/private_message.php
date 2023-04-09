<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_PRIVATE);
if ($HTTP_SESSION_VARS['employerid']) {
           if (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['apply_id'])) {
                  //Error validation
                  $error=0;
                  if (($HTTP_POST_VARS['private_message']=="")) {
                        $error=1;
                        $message_error=1;
                  }
                  else {
                        $message_error=0;
                  }
                  if ($error==1) //we have errors
                  {
                        include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                  } //end if error=1
                  else //no errors
                  {
                        $job_query = bx_db_query("select *,".$bx_table_prefix."_companies.email as cemail from ".$bx_table_prefix."_jobapply,".$bx_table_prefix."_persons,".$bx_table_prefix."_companies,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobapply.applyid='".$HTTP_POST_VARS['apply_id']."' and ".$bx_table_prefix."_jobs.jobid=".$bx_table_prefix."_jobapply.jobid and ".$bx_table_prefix."_companies.compid =".$bx_table_prefix."_jobapply.compid and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_jobapply.persid");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        if(bx_db_num_rows($job_query)!=0) {
                              $job_result=bx_db_fetch_array($job_query);
                              if ($job_result['compid'] == $HTTP_SESSION_VARS['employerid']) {
                                    $location_names = array();
                                    $location_query = bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
                                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                    while ($location_result = bx_db_fetch_array($location_query)) {
                                    $location_names[$location_result['locationid']] = $location_result['location'];
                                    }
                                    $type_names = array();
                                    $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng."");
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
                                    $job_result['private_message'] = bx_dirty_words($HTTP_POST_VARS['private_message']);
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
                                    $mailfile = $language."/mail/private_message.txt";
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
                                    bx_mail(SITE_NAME,SITE_MAIL,$job_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                                    $action = "sent";
                                    include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                              }
                              else {
                                  $error_message=TEXT_UNAUTHORIZED_ACCESS;
                                  $close_button="yes";
                                  $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
                                  include(DIR_FORMS.FILENAME_ERROR_FORM);
                              }
                      }
                  }
            }//end if (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['apply_id']))
            elseif (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['person_id'])) {
                              //Error validation
                              $error=0;
                              if (($HTTP_POST_VARS['private_message']=="")) {
                                    $error=1;
                                    $message_error=1;
                              }
                              else {
                                    $message_error=0;
                              }
                              if ($error==1) //we have errors
                              {
                                    include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                              } //end if error=1
                              else //no errors
                              {
                                        $company_query=bx_db_query("select ".$bx_table_prefix."_companies.email as cemail, ".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_companies.compid from ".$bx_table_prefix."_companies where ".$bx_table_prefix."_companies.compid='".$HTTP_SESSION_VARS['employerid']."'");
                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                        $company_result=bx_db_fetch_array($company_query);
                                        $contact_query=bx_db_query("select * from ".$bx_table_prefix."_persons where ".$bx_table_prefix."_persons.persid='".$HTTP_POST_VARS['person_id']."'");
                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                        $contact_result=bx_db_fetch_array($contact_query);
                                        $company_result['company_link'] = HTTP_SERVER.FILENAME_VIEW."?company_id=".$company_result['compid'];
                                        if ($contact_result['salary']) {
                                                $contact_result['salary'] = bx_format_price($contact_result['salary'],PRICE_CURENCY);
                                        }
                                        else {
                                                $contact_result['salary'] = TEXT_UNSPECIFIED;
                                        }
                                        $mailfile = $language."/mail/jobseeker_private_message.txt";
                                        include(DIR_LANGUAGES.$mailfile.".cfg.php");
                                        $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                                        reset($fields);
                                        while (list($h, $v) = each($fields)) {
                                                if ($company_result[$h]) {
                                                    $mail_message = eregi_replace($v[0],$company_result[$h],$mail_message);
                                                    $file_mail_subject = eregi_replace($v[0],$company_result[$h],$file_mail_subject);
                                                }
                                                else if ($contact_result[$h]) {
                                                    $mail_message = eregi_replace($v[0],$contact_result[$h],$mail_message);
                                                    $file_mail_subject = eregi_replace($v[0],$contact_result[$h],$file_mail_subject);
                                                }
                                                else if ($HTTP_POST_VARS[$h]) {
                                                    $mail_message = eregi_replace($v[0],bx_dirty_words($HTTP_POST_VARS[$h]),$mail_message);
                                                    $file_mail_subject = eregi_replace($v[0],bx_dirty_words($HTTP_POST_VARS[$h]),$file_mail_subject);
                                                }
                                                else {
                                                    $mail_message = eregi_replace($v[0],"",$mail_message);
                                                    $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                                                }
                                          }
                                          if ($add_mail_signature == "on") {
                                             $mail_message .= "\n".SITE_SIGNATURE;
                                          }
                                          bx_mail(SITE_NAME,SITE_MAIL,($contact_result['email']), stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                                          $action = "sent";
                                          include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                              }
            }//end if (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['person_id'])) {
            else {
                include(DIR_FORMS.FILENAME_PRIVATE_FORM);
            }
}
elseif($HTTP_GET_VARS['company_id'] || $HTTP_POST_VARS['company_id']) {
    if (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['company_id'])) {
        //Error validation
                  $error=0;
                  if (($HTTP_POST_VARS['private_message']=="")) {
                        $error=1;
                        $message_error=1;
                  }
                  else {
                        $message_error=0;
                  }
                  if(!$HTTP_SESSION_VARS['userid']) {
                      if ($HTTP_POST_VARS['user']=="") {
                           $error=1;
                           $email_error = 1;
                      }
                      else {
                          $email_error = 0;
                      }
                      if ($HTTP_POST_VARS['passw']=="") {
                           $error=1;
                           $password_error = 1;
                      }
                      else {
                          $password_error = 0;
                      }
                  }    
                  if ($error==1) //we have errors
                  {
                        include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                  } //end if error=1
                  else //no errors
                  {
                        if(!$HTTP_SESSION_VARS['userid']) {
                            $contact_query=bx_db_query("select *,".$bx_table_prefix."_persons.email as jemail,".$bx_table_prefix."_persons.address as jaddress,".$bx_table_prefix."_persons.city as jcity,".$bx_table_prefix."_persons.province as jprovince,".$bx_table_prefix."_persons.postalcode as jpostalcode,".$bx_table_prefix."_persons.phone as jphone,".$bx_table_prefix."_persons.locationid as jlocation from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_persons.email='".$HTTP_POST_VARS['user']."' and ".$bx_table_prefix."_persons.password='".$HTTP_POST_VARS['passw']."' and ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_persons.persid");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        }
                        else {
                            $contact_query=bx_db_query("select *,".$bx_table_prefix."_persons.email as jemail,".$bx_table_prefix."_persons.address as jaddress,".$bx_table_prefix."_persons.city as jcity,".$bx_table_prefix."_persons.province as jprovince, ".$bx_table_prefix."_persons.postalcode as jpostalcode,".$bx_table_prefix."_persons.phone as jphone,".$bx_table_prefix."_persons.locationid as jlocation from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid='".$HTTP_SESSION_VARS['userid']."' and ".$bx_table_prefix."_persons.persid='".$HTTP_SESSION_VARS['userid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        }
                        if (bx_db_num_rows($contact_query)==0) {
                           //no resumes found
                           $error_message=NO_RESUMES_FOUND;
                           $close_button="yes";
                           include(DIR_FORMS.FILENAME_ERROR_FORM);
                        }
                        else {
                                $contact_result=bx_db_fetch_array($contact_query);
                                $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies where ".$bx_table_prefix."_companies.compid='".$HTTP_POST_VARS['company_id']."'");
                                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                 $company_result=bx_db_fetch_array($company_query);
                                 $w=$contact_result['jobcategoryids'];
                                 while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                                       $where.=$regs[1].',';
                                       $w="-".$regs[2];
                                  }
                                  $where=substr($where,0,strlen($where)-1);
                                  if($where != "") {
                                          $category_query=bx_db_query("select jobcategory from ".$bx_table_prefix."_jobcategories_".$bx_table_lng." where jobcategoryid in ($where) group by jobcategory");
                                          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                          while ($category_result=bx_db_fetch_array($category_query)){
                                               $local_result['resume_jobcategory'].=$category_result['jobcategory']." - ";
                                          }
                                          $local_result['resume_jobcategory'] = eregi_replace(" - $","",$local_result['resume_jobcategory']);
                                  }
                                  else {
                                      $local_result['resume_jobcategory'] = "";
                                  }
                                  $w=$contact_result['jobtypeids'];
                                  $where="";
                                  while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                                       $where.=$regs[1].',';
                                       $w=$regs[2];
                                  }
                                  $where=substr($where,0,strlen($where)-1);
                                  $type_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
                                  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                  while ($type_result=bx_db_fetch_array($type_query)){
                                        $local_result['resume_jobtype'].=$type_result['jobtype']." - ";
                                  }
                                  $local_result['resume_jobtype'] = eregi_replace(" - $","",$local_result['resume_jobtype']);
                                  $local_result['resume_degree'] = ${TEXT_DEGREE_OPT.$contact_result['degreeid']};
                                  $local_result['private_message'] = bx_dirty_words($HTTP_POST_VARS['private_message']);
                                  if($contact_result['jlocation']!="") {
                                          $location_query=bx_db_query("select location from ".$bx_table_prefix."_locations_".$bx_table_lng." where locationid='".$contact_result['jlocation']."'");
                                          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                          $location_result=bx_db_fetch_array($location_query);
                                          $contact_result['jlocation'] = $location_result['location'];
                                  }
                                  if($contact_result['hide_name']=="yes") {
                                      $contact_result['name'] = TEXT_HIDDEN_INFORMATION;
                                  }
                                  if($contact_result['hide_address']=="yes") {
                                      $contact_result['jaddress'] = TEXT_HIDDEN_INFORMATION;
                                  }
                                  if($contact_result['hide_email']=="yes") {
                                      $contact_result['jemail'] = TEXT_HIDDEN_INFORMATION;
                                  }
                                  if($contact_result['hide_phone']=="yes") {
                                      $contact_result['jphone'] = TEXT_HIDDEN_INFORMATION;
                                  }
                                  if($contact_result['hide_location']=="yes") {
                                      $contact_result['jprovince'] = TEXT_HIDDEN_INFORMATION;
                                      $contact_result['jcity'] = TEXT_HIDDEN_INFORMATION;
                                      $contact_result['jlocation'] = TEXT_HIDDEN_INFORMATION;
                                      $contact_result['jpostalcode'] = TEXT_HIDDEN_INFORMATION;
                                  }
                                  $w=$contact_result['locationids'];
                                  $where="";
                                  while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                                       $where.=$regs[1].',';
                                       $w="-".$regs[2];
                                  }
                                  $where=substr($where,0,strlen($where)-1);
                                  if ($where != "") {
                                                $location_query=bx_db_query("select location from ".$bx_table_prefix."_locations_".$bx_table_lng." where locationid in ($where) group by location");
                                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                                while ($location_result=bx_db_fetch_array($location_query)){
                                                        $local_result['resume_location'] .= $location_result['location']." - ";
                                                }
                                                $local_result['resume_location'] = eregi_replace(" - $","",$local_result['resume_location']);
                                  }
                                  else {
                                          $local_result['resume_location'] = "";
                                  }
                                  $local_result['resume_link'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&resume_id=".$contact_result['resumeid'];
                                  if ($contact_result['salary']) {
                                        $contact_result['salary'] = bx_format_price($contact_result['salary'],PRICE_CURENCY);
                                  }
                                  else {
                                        $contact_result['salary'] = TEXT_UNSPECIFIED;
                                  }
                                  $mailfile = $language."/mail/employer_private_message.txt";
                                  include(DIR_LANGUAGES.$mailfile.".cfg.php");
                                  $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                                  reset($fields);
                                  while (list($h, $v) = each($fields)) {
                                        if ($company_result[$h]) {
                                            $mail_message = eregi_replace($v[0],$company_result[$h],$mail_message);
                                            $file_mail_subject = eregi_replace($v[0],$company_result[$h],$file_mail_subject);
                                        }
                                        else if ($contact_result[$h]) {
                                            $mail_message = eregi_replace($v[0],$contact_result[$h],$mail_message);
                                            $file_mail_subject = eregi_replace($v[0],$contact_result[$h],$file_mail_subject);
                                        }
                                        else if ($local_result[$h]) {
                                            $mail_message = eregi_replace($v[0],$local_result[$h],$mail_message);
                                            $file_mail_subject = eregi_replace($v[0],$local_result[$h],$file_mail_subject);
                                        }
                                        else if ($HTTP_POST_VARS[$h]) {
                                            $mail_message = eregi_replace($v[0],bx_dirty_words($HTTP_POST_VARS[$h]),$mail_message);
                                            $file_mail_subject = eregi_replace($v[0],bx_dirty_words($HTTP_POST_VARS[$h]),$file_mail_subject);
                                        }
                                        else {
                                            $mail_message = eregi_replace($v[0],"",$mail_message);
                                            $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                                        }
                                  }
                                  if ($add_mail_signature == "on") {
                                         $mail_message .= "\n".SITE_SIGNATURE;
                                  }
                                  bx_mail(SITE_NAME,SITE_MAIL,($company_result['email']), stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                                  $action = "sent";
                                  include(DIR_FORMS.FILENAME_PRIVATE_FORM);
                      }
                  }
    }//end if (($HTTP_POST_VARS['action']=="sendprivate") && ($HTTP_POST_VARS['company_id'])) {
    else {
        include(DIR_FORMS.FILENAME_PRIVATE_FORM);
    }
}
else {
    $login='employer';
    include(DIR_FORMS.FILENAME_LOGIN_FORM);
}
?>
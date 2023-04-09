<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_JOBSEEKER);
$jsfile="jobseeker.js";
if($HTTP_POST_VARS['action']) {
    $action = $HTTP_POST_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
if ($HTTP_SESSION_VARS['userid'])
       {
         if($action=="del_resume")
           {
           if ($HTTP_POST_VARS['confirmed']=="yes")
           {
             $resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_SESSION_VARS['userid']."'");
             if(bx_db_num_rows($resume_query)!=0)
               {
                 $resume_result=bx_db_fetch_array($resume_query);
                 $cv_file_location = DIR_RESUME.$resume_result['resume_cv'];
                 if (file_exists($cv_file_location)) {
                      @unlink($cv_file_location);
                 }//end if (file_exists($cv_file_location))
                 bx_db_query("insert into del".$bx_table_prefix."_resumes select * from ".$bx_table_prefix."_resumes where resumeid='".$resume_result['resumeid']."'");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 bx_db_query("delete from ".$bx_table_prefix."_resumes where resumeid='".$resume_result['resumeid']."'");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 bx_db_query("delete from ".$bx_table_prefix."_jobmail where persid='".$HTTP_SESSION_VARS['userid']."'");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 bx_session_unregister("post_resumeid");
                 $success_message=DELETE_SUCCESS;
                 $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                 include(DIR_SERVER_ROOT."header.php");
                 include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                 include(DIR_SERVER_ROOT."footer.php");
               }
           }
           else {
               include(DIR_SERVER_ROOT."header.php");
               include(DIR_FORMS.FILENAME_CONFIRM_RESUME_DELETE_FORM);
               include(DIR_SERVER_ROOT."footer.php");
           }
         }
         elseif ($action=="pers_form") {
               include(DIR_SERVER_ROOT."header.php");
               include(DIR_FORMS.FILENAME_PERSONAL_FORM);
               include(DIR_SERVER_ROOT."footer.php");
         }
         elseif ($action=="resume") {
          //looking for errors
                   $error=0;
                  //summary validation
                  if ($HTTP_POST_VARS['summary']=="") {
                     $error=1;
                     $summary_error=1;
                  }
                  else {
                     $summary_error=0;
                  }
                  if (sizeof($HTTP_POST_VARS['jobtypeids'])==0) {
                     $error=1;
                     $emplyment_type_error=1;
                  }
                  else {
                     $emplyment_type_error=0;
                  }
                  if (sizeof($HTTP_POST_VARS['jobcategoryids'])==0) {
                      $error=1;
                      $jobcategory_error=1;
                  }
                  else {
                      $jobcategory_error=0;
                  }
                  if(verify($HTTP_POST_VARS['salary'],"int")==1) {
                       $error=1;
                       $salary_error=1;
                  }
                  else {
                        $salary_error=0;
                  }
                  if(verify($HTTP_POST_VARS['experience'],"int")==1) {
                       $error=1;
                       $expyears_error=1;
                  }
                  else {
                       $expyears_error=0;
                  }
                  if ((!empty($HTTP_POST_FILES['resume_cv']['tmp_name'])) && ($HTTP_POST_FILES['resume_cv']['tmp_name']!="none") ) {
                             if(strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".php" || strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".php3" || strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".php4" || strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".phtml" || strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".phps" || strstr($HTTP_POST_FILES['resume_cv']['name'],'.') == ".shtml") 	{
                                    $error=1;
                                    $upload_error=1;
                             }
                             else {
                                 $upload_error=0;
                             }
                  }                       
                  else {
                      $upload_error=0;
                  }
                 $test_resume_query=bx_db_query("select * from ".$bx_table_prefix."_resumes where persid='".$HTTP_SESSION_VARS['userid']."'");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 if (bx_db_num_rows($test_resume_query)!=0) {
                      if ($error=="0") {
                          // echo "update";
                          //calculating jobcategoryids
                          for ($i=0;$i<sizeof($HTTP_POST_VARS['jobcategoryids']);$i++) {
                               $calc_jobcategoryids.=$HTTP_POST_VARS['jobcategoryids'][$i]."-";
                          }
                          //calculating locationids
                          for ($i=0;$i<sizeof($HTTP_POST_VARS['locationids']);$i++) {
                               $calc_locationids.=$HTTP_POST_VARS['locationids'][$i]."-";
                          }
                          //caculating jobtypeids
                          for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
                               $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                          }
                          //calculating lang
                          $i=1;
                          while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                                if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]) {
                                    $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                                }
                                else {
                                    $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                                }
                                $i++;
                          }
                          bx_db_query("update ".$bx_table_prefix."_resumes set summary='".bx_dirty_words($HTTP_POST_VARS['summary'])."',resume='".bx_dirty_words($HTTP_POST_VARS['resume'])."',education='".bx_dirty_words($HTTP_POST_VARS['education'])."',workexperience='".bx_dirty_words($HTTP_POST_VARS['workexperience'])."',degreeid='".$HTTP_POST_VARS['degreeid']."',confidential='".$HTTP_POST_VARS['confidential']."',jobtypeids='".$calc_jobtypeids."',locationids='-".$calc_locationids."',jobcategoryids='-".$calc_jobcategoryids."',salary='".bx_dirty_words($HTTP_POST_VARS['salary'])."',skills='".bx_dirty_words($HTTP_POST_VARS['skills'])."',jobmail='".$HTTP_POST_VARS['jobmail']."',languageids='".$calc_lang."',postlanguage='".$HTTP_POST_VARS['languageid']."',experience='".bx_dirty_words($HTTP_POST_VARS['experience'])."',resume_city='".bx_dirty_words($HTTP_POST_VARS['resume_city'])."',resume_province='".bx_dirty_words($HTTP_POST_VARS['resume_province'])."' where persid='".$HTTP_SESSION_VARS['userid']."'");
					      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                          if ((!empty($HTTP_POST_FILES['resume_cv']['tmp_name'])) && ($HTTP_POST_FILES['resume_cv']['tmp_name']!="none") ) {
                                         $cv_file_location = DIR_RESUME.$HTTP_SESSION_VARS['userid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name']);
                                         $test_resume_result=bx_db_fetch_array($test_resume_query);
                                         if ($test_resume_result['resume_cv']!="") {
                                             $old_cv_location=DIR_RESUME.$test_resume_result['resume_cv'];
                                             if (file_exists($old_cv_location)) {
                                                  @unlink($old_cv_location);
                                             }//end if (file_exists($image_location))
                                         }
                                         if (file_exists($cv_file_location)) {
                                              @unlink($cv_file_location);
                                          }//end if (file_exists($image_location))
                                          move_uploaded_file($HTTP_POST_FILES['resume_cv']['tmp_name'], $cv_file_location);
                                          @chmod($cv_file_location, 0777);    
                                          bx_db_query("update ".$bx_table_prefix."_resumes set resume_cv = '" .$HTTP_SESSION_VARS['userid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name']). "' where persid = '".$HTTP_SESSION_VARS['userid']."'"); 
                                          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                          }//end if ((!empty($resume_cv)) && ($resume_cv!="none") )
                          if(RESUME_EXPIRE == "yes") {
                                  if($HTTP_POST_VARS['reactivate'] == "yes") {
                                      $resume_expire = date("Y-m-d",mktime(0,0,0,date("m")+RESUME_EXPIRE_MONTH,  date("d")+RESUME_EXPIRE_DAY,  date("Y")+RESUME_EXPIRE_YEAR));
                                      bx_db_query("update ".$bx_table_prefix."_resumes set resumeexpire = '".$resume_expire."' where persid='".$HTTP_SESSION_VARS['userid']."'");
                                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                      $success_message=REACTIVATE_SUCCESS;
                                      $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);
                                      include(DIR_SERVER_ROOT."header.php");
                                      include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                                      include(DIR_SERVER_ROOT."footer.php");
                                  }
                                  else {
                                      header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session));    
                                      bx_exit();
                                  }
                          }    
                          else {
                              header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session));    
                              bx_exit();
                          }
                   }
                   else {
                          include(DIR_SERVER_ROOT."header.php");
                          include(DIR_FORMS.FILENAME_JOBSEEKER_FORM);
                          include(DIR_SERVER_ROOT."footer.php");
                   }
               }
               else //new resume
               {
                   if ($error==0) {
                        // echo "save";
                        //calculating jobcategoryids
                        for ($i=0;$i<sizeof($HTTP_POST_VARS['jobcategoryids']);$i++) {
                            $calc_jobcategoryids.=$HTTP_POST_VARS['jobcategoryids'][$i]."-";
                        }
                        //calculating locationids
                        for ($i=0;$i<sizeof($HTTP_POST_VARS['locationids']);$i++) {
                            $calc_locationids.=$HTTP_POST_VARS['locationids'][$i]."-";
                        }
                        //caculating jobtypeids
                        for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
                            $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                        }
                        //calculating lang
                        $i=1;
                        while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                              if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]) {
                                  $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                              }
                              else {
                                  $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                              }
                              $i++;
                         }
                         if (RESUME_EXPIRE == "yes") {
                              $resume_expire = date("Y-m-d",mktime(0,0,0,date("m")+RESUME_EXPIRE_MONTH,  date("d")+RESUME_EXPIRE_DAY,  date("Y")+RESUME_EXPIRE_YEAR));
                         }
                         else {
                              $resume_expire = '0000-00-00';
                         }
                         bx_db_insert($bx_table_prefix."_resumes","persid,summary,resume,education,workexperience,degreeid,confidential,jobtypeids,locationids,jobcategoryids,salary,skills,jobmail,languageids,postlanguage,experience,resume_city, resume_province,lastmaildate,resumedate,resumeexpire","'".$HTTP_SESSION_VARS['userid']."','".bx_dirty_words($HTTP_POST_VARS['summary'])."','".bx_dirty_words($HTTP_POST_VARS['resume'])."','".bx_dirty_words($HTTP_POST_VARS['education'])."','".bx_dirty_words($HTTP_POST_VARS['workexperience'])."','".$HTTP_POST_VARS['degreeid']."','".$HTTP_POST_VARS['confidential']."','".$calc_jobtypeids."','-".$calc_locationids."','-".$calc_jobcategoryids."','".bx_dirty_words($HTTP_POST_VARS['salary'])."','".bx_dirty_words($HTTP_POST_VARS['skills'])."','".$HTTP_POST_VARS['jobmail']."','".$calc_lang."','".$HTTP_POST_VARS['languageid']."','".bx_dirty_words($HTTP_POST_VARS['experience'])."','".bx_dirty_words($HTTP_POST_VARS['resume_city'])."','".bx_dirty_words($HTTP_POST_VARS['resume_province'])."','".date("Y-m-d")."','".date("Y-m-d")."','".$resume_expire."'");
                         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         $post_resumeid = bx_db_insert_id();
                         if ((!empty($HTTP_POST_FILES['resume_cv']['tmp_name'])) && ($HTTP_POST_FILES['resume_cv']['tmp_name']!="none") ) {
                                         $cv_file_location = DIR_RESUME.$HTTP_SESSION_VARS['userid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name']);
                                         if (file_exists($cv_file_location)) {
                                              @unlink($cv_file_location);
                                          }//end if (file_exists($image_location))
                                          move_uploaded_file($HTTP_POST_FILES['resume_cv']['tmp_name'], $cv_file_location);
                                          @chmod($cv_file_location,0777);
                                          bx_db_query("update ".$bx_table_prefix."_resumes set resume_cv = '" .$HTTP_SESSION_VARS['userid']."-".eregi_replace(" ","_",$HTTP_POST_FILES['resume_cv']['name'])."' where persid = '" . $HTTP_SESSION_VARS['userid'] . "'"); 
                                          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         }//end if ((!empty($resume_doc)) && ($resume_doc!="none") )
                         if(JOBMAIL_AUTO == "yes") {
                             bx_db_insert($bx_table_prefix."_jobmail","persid,jobmail_type,jmail_lang,jobmail_lastdate","'".$HTTP_SESSION_VARS['userid']."','2','".$language."','".date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')))."'");
                             SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                         }
                         bx_session_register("post_resumeid");
                         $HTTP_SESSION_VARS['post_resumeid'] = $post_resumeid;
                         if (RESUME_EXPIRE == "yes") {
                                $email_query = bx_db_query("select email, name, UNIX_TIMESTAMP('".$resume_expire."') - UNIX_TIMESTAMP(NOW()) as remaining from ".$bx_table_prefix."_persons where persid = '".$HTTP_SESSION_VARS['userid']."'");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                $email_result = bx_db_fetch_array($email_query);
                                $mailfile = $language."/mail/jobseeker_postresume.txt";
                                include(DIR_LANGUAGES.$mailfile.".cfg.php");
                                $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                                $HTTP_POST_VARS['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                                $HTTP_POST_VARS['resumedate'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                                $HTTP_POST_VARS['resumeexpire'] = bx_format_date($resume_expire, DATE_FORMAT);
                                if ($email_result['remaining']>=86400) {
                                       $HTTP_POST_VARS['resume_remaining']="".(floor($email_result['remaining']/(3600*24)));    
                                }
                                else {
                                       $HTTP_POST_VARS['resume_remaining']="0";
                                }
                                $HTTP_POST_VARS['name'] = $email_result['name'];
                                reset($fields);
                                while (list($h, $v) = each($fields)) {
                                                $mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
                                                $file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
                                }
                                if ($add_mail_signature == "on") {
                                        $mail_message .= "\n".SITE_SIGNATURE;
                                }
                                bx_mail(SITE_NAME,SITE_MAIL,$email_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                         }
                         $success_message=RESUME_UPDATED;
                         $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBSEEKER, "auth_sess", $bx_session);
                         include(DIR_SERVER_ROOT."header.php");
                         include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                         include(DIR_SERVER_ROOT."footer.php");
		           }
                   else {
                         include(DIR_SERVER_ROOT."header.php");
                         include(DIR_FORMS.FILENAME_JOBSEEKER_FORM);
                         include(DIR_SERVER_ROOT."footer.php");
                  }
             }
          }
          elseif ($action=="contact") {
          //check for errors
                 $contact_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid='".$HTTP_SESSION_VARS['userid']."' and ".$bx_table_prefix."_persons.persid='".$HTTP_SESSION_VARS['userid']."'");
                 SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                 if (bx_db_num_rows($contact_query)==0) {
                     //no resumes found
                     $error_message=NO_RESUMES_FOUND;
                     $back_url=bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$HTTP_POST_VARS['jobid'], "auth_sess", $bx_session);
                     include(DIR_SERVER_ROOT."header.php");
                     include(DIR_FORMS.FILENAME_ERROR_FORM);
                     include(DIR_SERVER_ROOT."footer.php");
                 }
                 else {
                       //resume found and now we are sending the email to the employer about the apply
                       $contact_result=bx_db_fetch_array($contact_query);
                       $company_query=bx_db_query("select ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.jobid, ".$bx_table_prefix."_jobs.contact_email, ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.company from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.jobid='".$HTTP_POST_VARS['jobid']."' and (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0)");
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
                       if($where != "") {
                           $type_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
                           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                           while ($type_result=bx_db_fetch_array($type_query)){
                                 $local_result['resume_jobtype'].=$type_result['jobtype']." - ";
                           }
                       }    
                       $local_result['resume_jobtype'] = eregi_replace(" - $","",$local_result['resume_jobtype']);      
                       $local_result['resume_degree'] = ${TEXT_DEGREE_OPT.$contact_result['degreeid']};
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
                       if ($contact_result['resume_cv']) {
                           $local_result['resume_download'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=download&resume_id=".$contact_result['resumeid'];
                       }
                       else {
                           $local_result['resume_download'] = "";
                       }
                       if($contact_result['hide_name']=="yes") {
                                      $contact_result['name'] = "****";
                       }
                       if ($contact_result['salary']) {
                                $contact_result['salary'] = bx_format_price($contact_result['salary'],PRICE_CURENCY,0);
                       }
                       else {
                                $contact_result['salary'] = TEXT_UNSPECIFIED;
                       }
                       $mailfile = $language."/mail/online_job_apply.txt";
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
                       if ($company_result['compid']==0) {
                              $company_result['email']=SITE_MAIL;
                       }
                       bx_mail(SITE_NAME,SITE_MAIL,($company_result['contact_email'])?$company_result['contact_email']:$company_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                       $success_message=TEXT_RESUME_SENT." ".$company_result['company']." ".TEXT_SUCCESSFULLY.".";
                       if ($HTTP_POST_VARS['back_search']) {
                              $back_url=$HTTP_POST_VARS['back_search'];
                       }
                       else {
                              $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                       }
                       include(DIR_SERVER_ROOT."header.php");
                       include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                       include(DIR_SERVER_ROOT."footer.php");
                  }
          }
          else {
              include(DIR_SERVER_ROOT."header.php");
              include(DIR_FORMS.FILENAME_JOBSEEKER_FORM);
              include(DIR_SERVER_ROOT."footer.php");
          }
}
else {
          if ($action=="pers_form") {
              include(DIR_SERVER_ROOT."header.php");
              include(DIR_FORMS.FILENAME_PERSONAL_FORM);
              include(DIR_SERVER_ROOT."footer.php");
          }
          elseif ($action=="contact") {
           //check for errors
                $error=0;
                if ($HTTP_POST_VARS['login']=="") {
                   $error=1;
                   $error_message.=LOGIN_NAME_ERROR."<br>";
                }
                if ($HTTP_POST_VARS['password']=="") {
                   $error=1;
                   $error_message.=PASSWORD_NAME_ERROR."<br>";
                }
                if ($error==1) {
                   $error_message=$error_message;
                   if ($HTTP_POST_VARS['back_search']) {
                       $back_url=$HTTP_POST_VARS['back_search'];
                   }
                   else {
                       $back_url=bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$HTTP_POST_VARS['jobid'], "auth_sess", $bx_session);
                   }
                   include(DIR_SERVER_ROOT."header.php");
                   include(DIR_FORMS.FILENAME_ERROR_FORM);
                   include(DIR_SERVER_ROOT."footer.php");
                }//end if ($error==1)
                else {
                   $contact_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_persons.email='".$HTTP_POST_VARS['login']."' and ".$bx_table_prefix."_persons.password='".$HTTP_POST_VARS['password']."' and ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_persons.persid");
                   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                   if (bx_db_num_rows($contact_query)==0) {
                   //no resumes found
                       $error_message=NO_RESUMES_FOUND;
                       if ($HTTP_POST_VARS['back_search']) {
                               $back_url=$HTTP_POST_VARS['back_search'];
                       }
                       else {
                               $back_url=bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$HTTP_POST_VARS['jobid'], "auth_sess", $bx_session);
                       }                  
                       include(DIR_SERVER_ROOT."header.php");
                       include(DIR_FORMS.FILENAME_ERROR_FORM);
                       include(DIR_SERVER_ROOT."footer.php");
                    }
                    else {
                    //resume found and now we are sending the email to the employer about the apply
                         $contact_result=bx_db_fetch_array($contact_query);
                         $company_query=bx_db_query("select ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.jobid, ".$bx_table_prefix."_jobs.contact_email, ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.company from ".$bx_table_prefix."_jobs,".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.jobid='".$HTTP_POST_VARS['jobid']."' and (".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_jobs.compid or ".$bx_table_prefix."_jobs.compid=0)");
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
                          if($where != "") {
                              $type_query=bx_db_query("select jobtype from ".$bx_table_prefix."_jobtypes_".$bx_table_lng." where jobtypeid in ($where) group by jobtype");
                              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                              while ($type_result=bx_db_fetch_array($type_query)){
                                    $local_result['resume_jobtype'].=$type_result['jobtype']." - ";
                              }
                          }    
                          $local_result['resume_jobtype'] = eregi_replace(" - $","",$local_result['resume_jobtype']);
                          $local_result['resume_degree'] = ${TEXT_DEGREE_OPT.$contact_result['degreeid']};
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
                          if($contact_result['hide_name']=="yes") {
                                      $contact_result['name'] = "****";
                          }
                          $local_result['resume_link'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&resume_id=".$contact_result['resumeid'];
                          if ($contact_result['resume_cv']) {
                               $local_result['resume_download'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=download&resume_id=".$contact_result['resumeid'];
                          }
                          else {
                               $local_result['resume_download'] = "";
                          }
                          if ($contact_result['salary']) {
                                $contact_result['salary'] = bx_format_price($contact_result['salary'],PRICE_CURENCY,0);
                          }
                          else {
                                $contact_result['salary'] = TEXT_UNSPECIFIED;
                          }
                          $mailfile = $language."/mail/online_job_apply.txt";
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
                          if ($company_result['compid']==0) {
                              $company_result['email']=SITE_MAIL;
                          }
                          bx_mail(SITE_NAME,SITE_MAIL,($company_result['contact_email'])?$company_result['contact_email']:$company_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail); 
                          $success_message=TEXT_RESUME_SENT." ".$company_result['company']." ".TEXT_SUCCESSFULLY.".";
                          if ($HTTP_POST_VARS['back_search']) {
                              $back_url=$HTTP_POST_VARS['back_search'];
                          }
                          else {
                              $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                          }
                          include(DIR_SERVER_ROOT."header.php");
                          include(DIR_FORMS.FILENAME_MESSAGE_FORM);
                          include(DIR_SERVER_ROOT."footer.php");
                    }
                }//end else if ($error==1)
       }//end elseif
       else
       {
         $login='jobseeker';
         include(DIR_SERVER_ROOT."header.php");
         include(DIR_FORMS.FILENAME_LOGIN_FORM);
         include(DIR_SERVER_ROOT."footer.php");
       }
}
?>
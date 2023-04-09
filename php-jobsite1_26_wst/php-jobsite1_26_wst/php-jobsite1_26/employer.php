<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_EMPLOYER);
$jsfile="employer.js";
if($HTTP_POST_VARS['action']) {
    $action = $HTTP_POST_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
if ($HTTP_SESSION_VARS['employerid'])
       {
        if ($action=="job_form"){
            if (!$HTTP_POST_VARS['jobid']) {
                $company_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where compid='".$HTTP_SESSION_VARS['employerid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                $company_result=bx_db_fetch_array($company_query);
                if ($company_result['featuredjobs']==0 && $company_result['jobs']==0) {
                     $post_error=1;
                }
                else {
                     $post_error=0;
                }
            }
            else {
                $post_error=0;
            }
            if ($post_error==1) {
                $error_message=NO_MORE_JOBS;
                $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
                include(DIR_SERVER_ROOT."header.php");
                include(DIR_FORMS.FILENAME_ERROR_FORM);
                include(DIR_SERVER_ROOT."footer.php");
            }
            else {
                include(DIR_SERVER_ROOT."header.php");
                include(DIR_FORMS.FILENAME_JOB_FORM);
                include(DIR_SERVER_ROOT."footer.php");
            }
        }
        elseif($action=="del_job")
        {
        if ($HTTP_POST_VARS['confirmed']=="yes")
           {
           $job_query=bx_db_query("select * from ".$bx_table_prefix."_jobs where jobid='".$HTTP_POST_VARS['jobid']."'");
           SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
           if(bx_db_num_rows($job_query)!=0) {
              $job_result=bx_db_fetch_array($job_query);
              if ($job_result['compid'] == $HTTP_SESSION_VARS['employerid']) {
                        bx_db_query("insert into del".$bx_table_prefix."_jobs select * from ".$bx_table_prefix."_jobs where jobid='".$job_result['jobid']."'");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("delete from ".$bx_table_prefix."_jobs where jobid='".$job_result['jobid']."'");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        bx_db_query("delete from ".$bx_table_prefix."_jobview where jobid='".$job_result['jobid']."'");
                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                        include(DIR_SERVER_ROOT."header.php");
                        include(DIR_FORMS.FILENAME_EMPLOYER_FORM);
                        include(DIR_SERVER_ROOT."footer.php");
              }
              else {
                        $error_message=TEXT_UNAUTHORIZED_ACCESS;
                        $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
                        include(DIR_SERVER_ROOT."header.php");
                        include(DIR_FORMS.FILENAME_ERROR_FORM);
                        include(DIR_SERVER_ROOT."footer.php");
              }
            }
         }//end if ($confirmed="yes")
         else  {
               include(DIR_SERVER_ROOT."header.php");
               include(DIR_FORMS.FILENAME_CONFIRM_JOB_DELETE_FORM);
               include(DIR_SERVER_ROOT."footer.php");
         }//end else if ($confirmed="yes")
       }
       elseif ($HTTP_POST_VARS['action']=="job") {         //looking for errors
               $error=0;
               //summary validation
               if ($HTTP_POST_VARS['jobtitle']=="") {
                  $error=1;
                  $jobtitle_error=1;
               }
               else {
                  $jobtitle_error=0;
               }
               if ($HTTP_POST_VARS['description']=="") {
                  $error=1;
                  $description_error=1;
               }
               else {
                  $description_error=0;
               }
               if (sizeof($HTTP_POST_VARS['jobtypeids'])==0) {
                  $error=1;
                  $emplyment_type_error=1;
               }
               else {
                  $emplyment_type_error=0;
               }
               if(verify($HTTP_POST_VARS['salary'],"int")==1) {
                    $error=1;
                    $salary_error=1;
               } 
			   else {
                    $salary_error=0;
               }
               if (verify($HTTP_POST_VARS['experience'],"int")==1) {
                    $error=1;
                    $expyears_error=1;
               }
			   else {
                    $expyears_error=0;
               }
              $test_job_query=bx_db_query("select compid,featuredjob from ".$bx_table_prefix."_jobs where jobid='".$HTTP_POST_VARS['jobid']."'");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
              if (bx_db_num_rows($test_job_query)!=0) {
                if ($error=="0") {
                      $test_job_result = bx_db_fetch_array($test_job_query);
                      if ($test_job_result['compid'] == $HTTP_SESSION_VARS['employerid']) {
                                // echo "update";
                                //calculating categoryids
                                //caculating titleids
                                for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
                                        $calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                                }
                                //calculating lang
                                $i=1;
                                while (${TEXT_LANGUAGE_KNOWN_OPT.$i})
                                {
                                        if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]) {
                                                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                                        }
                                        else {
                                                $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                                        }
                                        $i++;
                                }
                                bx_db_query("update ".$bx_table_prefix."_jobs set description='".bx_dirty_words($HTTP_POST_VARS['description'])."',jobtitle='".bx_dirty_words($HTTP_POST_VARS['jobtitle'])."',jobcategoryid='".$HTTP_POST_VARS['jobcategoryid']."',locationid='".$HTTP_POST_VARS['location']."',province='".bx_dirty_words($HTTP_POST_VARS['province'])."',skills='".bx_dirty_words($HTTP_POST_VARS['skills'])."',jobtypeids='".$calc_jobtypeids."',salary='".bx_dirty_words($HTTP_POST_VARS['salary'])."',degreeid='".$HTTP_POST_VARS['degreeid']."',experience='".bx_dirty_words($HTTP_POST_VARS['experience'])."',city='".bx_dirty_words($HTTP_POST_VARS['city'])."',languageids='".$calc_lang."',postlanguage='".$HTTP_POST_VARS['languageid']."', hide_compname='".$HTTP_POST_VARS['hide_compname']."', contact_name='".bx_dirty_words($HTTP_POST_VARS['contact_name'])."', hide_contactname='".$HTTP_POST_VARS['hide_contactname']."', contact_email='".$HTTP_POST_VARS['contact_email']."', hide_contactemail='".$HTTP_POST_VARS['hide_contactemail']."', contact_phone='".$HTTP_POST_VARS['contact_phone']."', hide_contactphone='".$HTTP_POST_VARS['hide_contactphone']."', contact_fax='".$HTTP_POST_VARS['contact_fax']."', hide_contactfax='".$HTTP_POST_VARS['hide_contactfax']."' where jobid='".$HTTP_POST_VARS['jobid']."'");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                if($HTTP_POST_VARS['featuredjob']=='Y' && $test_job_result['featuredjob']!='Y') {
                                        $company_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where compid='".$HTTP_SESSION_VARS['employerid']."'");
                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                        $company_result=bx_db_fetch_array($company_query);
                                        if ($company_result['featuredjobs']==0) {
                                                $featured = 'N';
                                                $err_featured=1;
                                        }
                                        else {
                                                $featured = 'Y';
                                                $err_featured=0;
                                        }
                                        if ($err_featured==1)	{
                                                        $error_message=NO_MORE_FEATURED_JOBS;
                                                        $back_url=bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session);
                                                        include(DIR_SERVER_ROOT."header.php");
                                                        include(DIR_FORMS.FILENAME_ERROR_FORM);
                                                        include(DIR_SERVER_ROOT."footer.php");
                                        }
                                        else {
                                                        bx_db_query("update ".$bx_table_prefix."_companycredits set featuredjobs=(featuredjobs-1) where compid='".$HTTP_SESSION_VARS['employerid']."'");
                                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                                        bx_db_query("update ".$bx_table_prefix."_jobs set featuredjob='".$featured."' where jobid='".$HTTP_POST_VARS['jobid']."'");
                                                        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                                        header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session));
                                                        bx_exit();
                                        }
                                  }
                                  else {
                                           header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session));
                                           bx_exit();
                                  }
                           }//end if $test_job_result['compid'] = $HTTP_SESSION_VARS['employerid']
                           else {
                                        $error_message=TEXT_UNAUTHORIZED_ACCESS;
                                        $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
                                        include(DIR_SERVER_ROOT."header.php");
                                        include(DIR_FORMS.FILENAME_ERROR_FORM);
                                        include(DIR_SERVER_ROOT."footer.php");
                           }
                   }
                   else
                   {
                        include(DIR_SERVER_ROOT."header.php");
                        include(DIR_FORMS.FILENAME_JOB_FORM);
                        include(DIR_SERVER_ROOT."footer.php");
                   }
               }
               else //new job
                {
                   if ($error==0)
                   {
                  // echo "save";
                  //caculating jobcatypeids
                   for ($i=0;$i<sizeof($HTTP_POST_VARS['jobtypeids']);$i++) {
						$calc_jobtypeids.=$HTTP_POST_VARS['jobtypeids'][$i]."-";
                   }
                   //calculating lang
                   $i=1;
                   while (${TEXT_LANGUAGE_KNOWN_OPT.$i}) {
                        if ($HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)])
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3).$HTTP_POST_VARS[substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)]."-";
                        }
                        else
                        {
                        $calc_lang.=substr(${TEXT_LANGUAGE_KNOWN_OPT.$i},0,3)."0"."-";
                        }
                     $i++;
                    }
                    $company_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where compid='".$HTTP_SESSION_VARS['employerid']."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    $company_result=bx_db_fetch_array($company_query);
                    if($HTTP_POST_VARS['featuredjob']=='N') {
                          $featured="N";
						  $err_featured=0;
						  if ($company_result['jobs']==0) {
                                 $err_jobs=1;
                          }
                          else {
                                  $err_jobs=0;
                          }
                    }
					else {
                         $featured="Y";
						 if ($company_result['featuredjobs']==0)
                              {
                                 $err_featured=1;
                              }
                          else
                               {
                                  $err_featured=0;
                               }

					}
                    if (($err_jobs==0) && ($err_featured==0))
                    {
                      bx_db_insert($bx_table_prefix."_jobs","compid,jobtitle,jobcategoryid,description,locationid,province,skills,jobtypeids,salary,degreeid,experience,city,jobdate,languageids,postlanguage,featuredjob,hide_compname,contact_name,hide_contactname,contact_email,hide_contactemail,contact_phone,hide_contactphone,contact_fax,hide_contactfax,jobexpire","'".$HTTP_SESSION_VARS['employerid']."','".bx_dirty_words($HTTP_POST_VARS['jobtitle'])."','".$HTTP_POST_VARS['jobcategoryid']."','".bx_dirty_words($HTTP_POST_VARS['description'])."','".$HTTP_POST_VARS['location']."','".bx_dirty_words($HTTP_POST_VARS['province'])."','".bx_dirty_words($HTTP_POST_VARS['skills'])."','".$calc_jobtypeids."','".bx_dirty_words($HTTP_POST_VARS['salary'])."','".$HTTP_POST_VARS['degreeid']."','".bx_dirty_words($HTTP_POST_VARS['experience'])."','".bx_dirty_words($HTTP_POST_VARS['city'])."','".date('Y-m-d')."','".$calc_lang."','".$HTTP_POST_VARS['languageid']."','".$featured."','".$HTTP_POST_VARS['hide_compname']."','".bx_dirty_words($HTTP_POST_VARS['contact_name'])."','".$HTTP_POST_VARS['hide_contactname']."','".$HTTP_POST_VARS['contact_email']."','".$HTTP_POST_VARS['hide_contactemail']."','".$HTTP_POST_VARS['contact_phone']."','".$HTTP_POST_VARS['hide_contactphone']."','".$HTTP_POST_VARS['contact_fax']."','".$HTTP_POST_VARS['hide_contactfax']."','".date("Y-m-d",mktime(0,0,0,date("m")+JOB_EXPIRE_MONTH,  date("d")+JOB_EXPIRE_DAY,  date("Y")+JOB_EXPIRE_YEAR))."'");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      $new_jobid = bx_db_insert_id();
                      if(RESUMEMAIL_AUTO == "yes") {
                              $resumemail_query=bx_db_query("select * from ".$bx_table_prefix."_resumemail where compid='".$HTTP_SESSION_VARS['employerid']."'");
                              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                              if(bx_db_num_rows($resumemail_query)==0) {
                                    bx_db_insert($bx_table_prefix."_resumemail","compid,resumemail_type,rmail_lang,resumemail_lastdate","'".$HTTP_SESSION_VARS['employerid']."','2','".$language."','".date('Y-m-d',mktime(0,0,0,date('m'),date('d')-1,date('Y')))."'");
                                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                              }//end if(bx_db_num_rows($resumemail_query)!=0)
                      }
                      bx_db_insert($bx_table_prefix."_jobview","jobid,viewed,lastdate",$new_jobid.",0,NOW()");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      if($featured=='Y')
                        {
                          bx_db_query("update ".$bx_table_prefix."_companycredits set  featuredjobs=(featuredjobs-1) where compid='".$HTTP_SESSION_VARS['employerid']."'");
	                   }
                       else {
                 		   if ($company_result['jobs']!=999) {
                                    bx_db_query("update ".$bx_table_prefix."_companycredits set jobs=(jobs-1)  where compid='".$HTTP_SESSION_VARS['employerid']."'");
                           }
                      }
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      $email_query = bx_db_query("select email, company, UNIX_TIMESTAMP('".date("Y-m-d",mktime(0,0,0,date("m")+JOB_EXPIRE_MONTH,  date("d")+JOB_EXPIRE_DAY,  date("Y")+JOB_EXPIRE_YEAR))."') - UNIX_TIMESTAMP(NOW()) as remaining from ".$bx_table_prefix."_companies where compid = '".$HTTP_SESSION_VARS['employerid']."'");
                      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                      $email_result = bx_db_fetch_array($email_query);
                      $mailfile = $language."/mail/employer_postjob.txt";
                      include(DIR_LANGUAGES.$mailfile.".cfg.php");
                      $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                      $HTTP_POST_VARS['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                      $HTTP_POST_VARS['jobdate'] = bx_format_date($HTTP_POST_VARS['jobdate'], DATE_FORMAT);
                      $HTTP_POST_VARS['jobexpire'] = bx_format_date(date("Y-m-d",mktime(0,0,0,date("m")+JOB_EXPIRE_MONTH,  date("d")+JOB_EXPIRE_DAY,  date("Y")+JOB_EXPIRE_YEAR)), DATE_FORMAT);
                      if ($email_result['remaining']>=86400) {
                           $HTTP_POST_VARS['remaining']="".(floor($email_result['remaining']/(3600*24)));    
                      }
                      else {
                           $HTTP_POST_VARS['remaining']="0";
                      }
                      $HTTP_POST_VARS['company'] = $email_result['company'];
                      if ($HTTP_POST_VARS['salary']) {
                                $HTTP_POST_VARS['salary'] = bx_format_price($HTTP_POST_VARS['salary'],PRICE_CURENCY,0);
                      }
                      else {
                                $HTTP_POST_VARS['salary'] = TEXT_UNSPECIFIED;
                      }
                      $HTTP_POST_VARS['joblink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&job_id=".$new_jobid;
                      reset($fields);
                      while (list($h, $v) = each($fields)) {
                                 $mail_message = eregi_replace($v[0],$HTTP_POST_VARS[$h],$mail_message);
                                 $file_mail_subject = eregi_replace($v[0],$HTTP_POST_VARS[$h],$file_mail_subject);
                      }
                      if ($add_mail_signature == "on") {
                             $mail_message .= "\n".SITE_SIGNATURE;
                      }
                      bx_mail(SITE_NAME,SITE_MAIL,$email_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                      header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, "auth_sess", $bx_session));
                      bx_exit();
                    }
                    elseif ($err_featured==1)
                    {
                        $error_message=NO_MORE_FEATURED_JOBS;
                        $back_url=bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER."?action=job_form", "auth_sess", $bx_session);
                        include(DIR_SERVER_ROOT."header.php");
                        include(DIR_FORMS.FILENAME_ERROR_FORM);
                        include(DIR_SERVER_ROOT."footer.php");
                    }
                    else {
                       $error_message=NO_MORE_JOBS;
                       $back_url=bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER."?action=job_form", "auth_sess", $bx_session);
                       include(DIR_SERVER_ROOT."header.php");
                       include(DIR_FORMS.FILENAME_ERROR_FORM);
                       include(DIR_SERVER_ROOT."footer.php");
                    }
                  }
                   else {
                       include(DIR_SERVER_ROOT."header.php");
                       include(DIR_FORMS.FILENAME_JOB_FORM);
                       include(DIR_SERVER_ROOT."footer.php");
                  }
              }
          }
          else {
            include(DIR_SERVER_ROOT."header.php");
            include(DIR_FORMS.FILENAME_EMPLOYER_FORM);
            include(DIR_SERVER_ROOT."footer.php");
          }
}
else {
    $login='employer';
    include(DIR_SERVER_ROOT."header.php");
    include(DIR_FORMS.FILENAME_LOGIN_FORM);
    include(DIR_SERVER_ROOT."footer.php");
}
?>
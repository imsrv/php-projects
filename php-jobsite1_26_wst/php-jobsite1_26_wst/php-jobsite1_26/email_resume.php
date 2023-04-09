<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/email_resume_form.php");
           if (($HTTP_POST_VARS['action']=="sendresumeinemail") && ($HTTP_SESSION_VARS['sess_resume_id'])) {
                    $resume_query = bx_db_query("select * from  ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.resumeid = '".$HTTP_SESSION_VARS['sess_resume_id']."' and ".$bx_table_prefix."_persons.persid = ".$bx_table_prefix."_resumes.persid");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    $company_query = bx_db_query("select * from  ".$bx_table_prefix."_companies where ".$bx_table_prefix."_companies.compid = '".$HTTP_SESSION_VARS['employerid']."'");
                    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    if (bx_db_num_rows($resume_query)>0 && bx_db_num_rows($company_query)>0) {
                            $resume_result = bx_db_fetch_array($resume_query);
                            $company_result = bx_db_fetch_array($company_query);
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
                            $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
                                $jobcategory_names[$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
                            }
                            $resume_result['subject'] = bx_dirty_words($HTTP_POST_VARS['rsubject']);
                            $resume_result['company'] = $company_result['company'];
                            $resume_result['resume_comment'] = bx_dirty_words($HTTP_POST_VARS['jmessage']);
                            $resume_result['location'] = $location_names[$resume_result['locationid']];
                            $w=$resume_result['jobcategoryids'];
                            while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                                    $resume_result['resume_jobcategory'] .= $jobcategory_names[$regs[1]]." - ";
                                    $w="-".$regs[2];
                            }
                            $resume_result['resume_jobcategory'] = eregi_replace(" - $","",$resume_result['resume_jobcategory']);
                            $w=$resume_result['locationids'];
                            while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                                    $resume_result['resume_location'] .= $location_names[$regs[1]]." - ";
                                    $w="-".$regs[2];
                            }
                            $resume_result['resume_location'] = eregi_replace(" - $","",$resume_result['resume_location']);
                            $w=$resume_result['jobtypeids'];
                            while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                                    $resume_result['resume_jobtype'] .= $type_names[$regs[1]]." - ";
                                    $w=$regs[2];
                            }
                            if($resume_result['hide_name']=="yes") {
                                      $resume_result['name'] = TEXT_HIDDEN_INFORMATION;
                            }
                            if($resume_result['hide_address']=="yes") {
                                      $resume_result['address'] = TEXT_HIDDEN_INFORMATION;
                            }
                            if($resume_result['hide_email']=="yes") {
                                      $resume_result['email'] = TEXT_HIDDEN_INFORMATION;
                            }
                            if($resume_result['hide_phone']=="yes") {
                                      $resume_result['phone'] = TEXT_HIDDEN_INFORMATION;
                            }
                            if($resume_result['hide_location']=="yes") {
                                  $resume_result['city'] = TEXT_HIDDEN_INFORMATION;
                                  $resume_result['location'] = TEXT_HIDDEN_INFORMATION;
                                  $resume_result['postalcode'] = TEXT_HIDDEN_INFORMATION;
                            }
                            $resume_result['resume_jobtype'] = eregi_replace(" - $","",$resume_result['resume_jobtype']);
                            $resume_result['degree'] = ${TEXT_DEGREE_OPT.$resume_result['degreeid']};
                            $resume_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                            $resume_result['jobdate'] = bx_format_date($resume_result['resumedate'], DATE_FORMAT);
                            $resume_result['lastdate'] = bx_format_date($resume_result['lastdate'], DATE_FORMAT);
                            if ($resume_result['salary']) {
                                    $resume_result['salary'] = bx_format_price($resume_result['salary'],PRICE_CURENCY,0);
                            }
                            else {
                                    $resume_result['salary'] = TEXT_UNSPECIFIED;
                            }
                            $resume_result['resumelink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&resume_id=".$resume_result['resumeid'];
                            //send mail to registered company
                            $mailfile = $language."/mail/email_resume.txt";
                            include(DIR_LANGUAGES.$mailfile.".cfg.php");
                            $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                            reset($fields);
                            while (list($h, $v) = each($fields)) {
                                    $mail_message = eregi_replace($v[0],$resume_result[$h],$mail_message);
                                    $file_mail_subject= eregi_replace($v[0],$resume_result[$h],$file_mail_subject);
                            }
                            if ($add_mail_signature == "on") {
                                    $mail_message .= "\n".SITE_SIGNATURE;
                            }
                            bx_mail(SITE_NAME,SITE_MAIL,$company_result['email'], stripslashes($resume_result['subject']), stripslashes($mail_message), $html_mail);
                            $action = "sent";
                            include(DIR_FORMS."email_resume_form.php");
                    }
                    else {
                            $error_message=TEXT_UNAUTHORIZED_ACCESS;
                            $close_button = true;
                            $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
                            include(DIR_FORMS.FILENAME_ERROR_FORM);
                    }
            }//end if (($HTTP_POST_VARS['action']=="sendresumeinemail") && ($HTTP_SESSION_VARS['sess_resume_id'])) 
            else {
                include(DIR_FORMS."email_resume_form.php");
            }
?>
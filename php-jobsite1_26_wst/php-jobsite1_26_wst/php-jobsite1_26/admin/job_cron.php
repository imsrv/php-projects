<?php
@set_time_limit(0);
define('CRON_JOB','yes');
if (!defined("INTERNAL_CRON")) {
    include_once('admin_design.php');
    if(!@include_once('../application_config_file.php')){
        include_once(eregi_replace("/([^\/])*$","/application_config_file.php",dirname(__FILE__)));
    }
}

//include ('admin_auth.php');
$testmode = TEST_MODE;
if ($HTTP_SERVER_VARS['QUERY_STRING'] == "test") {
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "Sending mail to ".SITE_TITLE." - ADMIN -".SITE_MAIL;
    }   
    bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Testing job_cron.php","\n             Test succcess!!!\nDate: ".date('l, F d Y H:i:s a')."\n","no"); 
    bx_exit();
}
if ($argv[1] == "test") {
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "\nTesting success\n";
    }    
    bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Testing job_cron.php","\n             Test succcess!!!\nDate: ".date('l, F d Y H:i:s a')."\n","no"); 
    bx_exit();
}
if ($testmode == "yes") {
    if(ADMIN_SAFE_MODE == "yes") {
        if ($HTTP_GET_VARS['type']=="admin") {
            echo "<center><font color=red><h1>TEST MODE</h1></font></center><font color=red>All email messsages will not be sent, just displayed. No update to the database</font><br>";
        }    
    }
    else {
        if ($HTTP_GET_VARS['type']=="admin") {
            echo "<center><font color=red><h1>TEST MODE</h1></font></center><font color=red>All email messsages will not be sent, just displayed. No update to the database</font><br>To switch back to live mode goto Script Settings and set <b><a href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS."#TEST_MODE\" style=\"color: #FF0000; font-size: 14px;\">TEST MODE</a></b> to \"no\"<br>";
        }    
    }
    if ($HTTP_GET_VARS['type']=="admin") {
    ?>
    <script language="Javascript">
    <!--
    function new_wind(title,content) {
    	mywindow = open('','error_popup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=300,left=0,top=0,screenX=0,screenY=0');
        mywindow.document.write('<html><style type="text/css" title=""><!--');
        mywindow.document.write('A:LINK, A:VISITED {	color : #0000FF; font-family : arial; text-decoration : none; font-weight : normal; font-size : 12px;}');
        mywindow.document.write('A:HOVER {	color : #FF0000; font-family : arial; text-decoration : underline; font-weight : normal;	font-size : 12px;}');
        mywindow.document.write('//-->');
        mywindow.document.write('</style><body bgcolor="#EFEFEF">');
        mywindow.document.write('<table width="100%" cellpadding="0" cellspacing="0" border="0">');
        mywindow.document.write('<tr><td><hr></td></tr>');
        mywindow.document.write('<tr><td>&nbsp;&nbsp;<b>'+title+'</b></td></tr>');
        mywindow.document.write('<tr><td><hr></td></tr>');
        mywindow.document.write('<tr><td>&nbsp;</td></tr>');
        mywindow.document.write('<tr><td><font style="font-size:12px;" nowrap>'+content+'</font></td></tr>');
        mywindow.document.write('<tr><td>&nbsp;</td></tr>');
         mywindow.document.write('<tr><td align="right" valign="middle"><a href="javascript: ;" onClick="window.close();" style="color: #FF0000; text-decoration:none; font-weight: bold; font-size:12px; background: #FFFFFF; border: 1px solid #000000;">&nbsp;x&nbsp;</a>&nbsp;<a href="javascript: window.close();">Close Window</a></td></tr>');
        mywindow.document.write('<tr><td>&nbsp;</td></tr>');
        mywindow.document.write('</table>');
        mywindow.document.write('</body></html>');
    }
    //-->
    </script>
    <?php 
    $key="Cron Job";
    $value="<font color=red><b>This file should be runned once in a day by a cron job!</b></font><br><br>Many hosting companies have in their Control Panel a link to where you can input your Cron jobs!<br><b>How does that should look like?</b><br>Something like this: <br>[minute 0-59] [hour 0-23] [day of month 0-31] [month 1-12] [day of week 0-7] /path/to/php [script_path]/admin/job_cron.php >/dev/null<br><br>In this server case we suggest this one:<br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/job_cron.php >/dev/null <br>This means the job_cron.php will run at 23:55 min everyday, everymonth, everyweek day.<br>Also if you want to make a test to this cron job, what you have to do is replace &#034;job_cron.php&#034; with &#034;job_cron.php test&#034; like below: <br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/job_cron.php test >/dev/null<br>This will send the admin an email that the cron job is running, else if the admin doesn't get this email the admin will know that the cron job is not set properly! (Note: don't forgot to remove the test argument if the mail was sent, to go live with this cron job)<br><b>Note:</b> <font color=red><b>php</b></font> can be changed to <b>/usr/bin/php</b> or <b>/usr/local/bin/php</b>.<br>If there is no php available (case in which the php is installed as a module inside the webserver, no command line available) you can use <b>lynx</b> as in this example:<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."job_cron.php >/dev/null<br>or for the test::<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."job_cron.php?test >/dev/null<br><br>More information: <a href='http://www.bluereef.net/support/extensions/admin/cron/crontab.html' target='_blank'>http://www.bluereef.net/support/extensions/admin/cron/crontab.html</a><br>or a search on <b>google.com</b> with '<b>crontab documentation examples</b>' could help you!";
    ?>
    <p><font color="#FF0000" size="4"><b>Note</b>: this file should be runned by a cron job once/day! More help...<a href="javascript: ;" onClick="new_wind('<?php echo $key;?>','<?php echo eregi_replace("'","\'",$value);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></p></font><br><br>
    <?php
    }
}
$location_names = array();
$location_query = bx_db_query("SELECt * from ".$bx_table_prefix."_locations_".$bx_table_lng);
while ($location_result = bx_db_fetch_array($location_query)) {
    $location_names[$location_result['locationid']] = $location_result['location'];
}
$type_names = array();
$type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng."");
while ($type_result = bx_db_fetch_array($type_query)) {
    $type_names[$type_result['jobtypeid']] = $type_result['jobtype'];
}
$jobcategory_names = array();
$jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng."");
while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
    $jobcategory_names[$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
}
$admin_mail_message = '';
$admin_send_mail = false;
$deljob_query=bx_db_query("select count(*) as noofjobstodelete from ".$bx_table_prefix."_jobs where TO_DAYS(jobexpire)<=TO_DAYS('".date('Y-m-d')."')");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$deljob_result=bx_db_fetch_array($deljob_query);
if ($HTTP_GET_VARS['type']=="admin") {
    echo "Number of jobs deleted is: ".$deljob_result['noofjobstodelete'];
}    
if (JOB_EXPIRE_NOTIFY_ADMIN == "yes") {
    $admin_send_mail = true;
    $admin_mail_message .= "Number of jobs deleted is: ".$deljob_result['noofjobstodelete']."\n";
}//end if (JOB_EXPIRE_NOTIFY_ADMIN == "yes")
if ($deljob_result['noofjobstodelete'] != 0) {
    $deljobsemail_query = bx_db_query("select ".$bx_table_prefix."_jobview.viewed, ".$bx_table_prefix."_jobview.lastdate, ".$bx_table_prefix."_jobs.*, ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_companies.compid from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_jobs, ".$bx_table_prefix."_jobview where TO_DAYS(".$bx_table_prefix."_jobs.jobexpire)<=TO_DAYS('".date('Y-m-d')."') and ".$bx_table_prefix."_companies.compid = ".$bx_table_prefix."_jobs.compid and ".$bx_table_prefix."_jobview.jobid = ".$bx_table_prefix."_jobs.jobid");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    while ($deljobsemail_result = bx_db_fetch_array($deljobsemail_query)) {
            if (NOTIFY_EMPLOYER_JOB_EXPIRE == "yes") {
                if ($HTTP_GET_VARS['type']=="admin") {
                    echo "<br>Sending mail to: \"".$deljobsemail_result['company']." - ".$deljobsemail_result['email']."\" - DELETE JOB: \"".$deljobsemail_result['jobtitle']."\" ID:".$deljobsemail_result['jobid'];
                }   
                $deljobsemail_result['location'] = $location_names[$deljobsemail_result['locationid']];
                $deljobsemail_result['jobcategory'] = $jobcategory_names[$deljobsemail_result['jobcategoryid']];
                $w=$deljobsemail_result['jobtypeids'];
                while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                     $deljobsemail_result['jobtype'] .= $type_names[$regs[1]]." - ";      
                     $w=$regs[2];
                }
                $deljobsemail_result['jobtype'] = eregi_replace(" - $","",$deljobsemail_result['jobtype']);      
                $deljobsemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                $deljobsemail_result['jobdate'] = bx_format_date($deljobsemail_result['jobdate'], DATE_FORMAT);
                $deljobsemail_result['lastdate'] = bx_format_date($deljobsemail_result['lastdate'], DATE_FORMAT);
                if ($deljobsemail_result['salary']) {
                        $deljobsemail_result['salary'] = bx_format_price($deljobsemail_result['salary'],PRICE_CURENCY,0);
                }
                else {
                        $deljobsemail_result['salary'] = TEXT_UNSPECIFIED;
                }
                $mailfile = $language."/mail/notify_jobexpire.txt";
                include(DIR_LANGUAGES.$mailfile.".cfg.php");
                $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                reset($fields);
                while (list($h, $v) = each($fields)) {
                        if ($deljobsemail_result[$h] || $deljobsemail_result[$h]==0) {
                            $mail_message = eregi_replace($v[0],$deljobsemail_result[$h],$mail_message);
                            $file_mail_subject = eregi_replace($v[0],$deljobsemail_result[$h],$file_mail_subject);
                        }
                        else {
                            $mail_message = eregi_replace($v[0],"",$mail_message);
                            $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                        }
                 }
                 if ($add_mail_signature == "on") {
                        $mail_message .= "\n".SITE_SIGNATURE;
                 }
                 if ($testmode != "yes") {
                     bx_mail(SITE_NAME,SITE_MAIL,$deljobsemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                 }    
                 else {
                     if ($HTTP_GET_VARS['type']=="admin") {
                         echo "<br>".nl2br($mail_message)."<br>";
                     }    
                 }
            }//end if (NOTIFY_EMPLOYER_JOB_EXPIRE == "yes")
            if (JOB_EXPIRE_NOTIFY_ADMIN == "yes") {
                $admin_mail_message .= "-----------------Deleted Job Details--[id:".$deljobsemail_result['jobid']."]----------\n";
                $admin_mail_message .= "JOB ID: ".$deljobsemail_result['jobid']."\n";
                $admin_mail_message .= "Company: ".$deljobsemail_result['company']." - ".HTTP_SERVER.FILENAME_VIEW."?company_id=".$deljobsemail_result['compid']."\n";
                $admin_mail_message .="              Posted: ".$deljobsemail_result['jobdate']."\n";
                $admin_mail_message .="              Viewed: ".$deljobsemail_result['viewed']."\n";
                $admin_mail_message .="    Last viewed date: ".$deljobsemail_result['lastdate']."\n";
                $admin_mail_message .= "-----------------End Deleted Job Details------------\n\n";
            }//end if (JOB_EXPIRE_NOTIFY_ADMIN == "yes")
            if ($testmode != "yes") {
                bx_db_query("insert into del".$bx_table_prefix."_jobs select * from ".$bx_table_prefix."_jobs where jobid='".$deljobsemail_result['jobid']."' and compid = '".$deljobsemail_result['compid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("delete from ".$bx_table_prefix."_jobs where jobid='".$deljobsemail_result['jobid']."' and compid = '".$deljobsemail_result['compid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                bx_db_query("delete from ".$bx_table_prefix."_jobview where jobid='".$deljobsemail_result['jobid']."'");
                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            }
    }//end while
    
}//if ($deljob_result['noofjobstodelete'] != 0) {

if (NOTIFY_EMPLOYER_JOB_EXPIRE_DAY>0) {
    $jobnotify_query=bx_db_query("select count(*) as noofjobstonotify from ".$bx_table_prefix."_jobs where TO_DAYS(jobexpire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_EMPLOYER_JOB_EXPIRE_DAY,date('Y')))."')");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $jobnotify_result=bx_db_fetch_array($jobnotify_query);
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "<br>Number of jobs expiring in about ".NOTIFY_EMPLOYER_JOB_EXPIRE_DAY." days is: ".$jobnotify_result['noofjobstonotify'];
    }    
    if ($jobnotify_result['noofjobstonotify'] != 0) {
        $jobsnotifyemail_query = bx_db_query("select ".$bx_table_prefix."_jobview.viewed, ".$bx_table_prefix."_jobview.lastdate, ".$bx_table_prefix."_jobs.*, (UNIX_TIMESTAMP(".$bx_table_prefix."_jobs.jobexpire)-UNIX_TIMESTAMP(NOW())) as remaining, ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_companies.compid from ".$bx_table_prefix."_companies, ".$bx_table_prefix."_jobs, ".$bx_table_prefix."_jobview where TO_DAYS(".$bx_table_prefix."_jobs.jobexpire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_EMPLOYER_JOB_EXPIRE_DAY,date('Y')))."') and ".$bx_table_prefix."_companies.compid = ".$bx_table_prefix."_jobs.compid and ".$bx_table_prefix."_jobview.jobid = ".$bx_table_prefix."_jobs.jobid");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($jobsnotifyemail_result = bx_db_fetch_array($jobsnotifyemail_query)) {
                if (NOTIFY_EMPLOYER_JOB_EXPIRE == "yes") {
                    if ($HTTP_GET_VARS['type']=="admin") {
                        echo "<br>Sending mail to: \"".$jobsnotifyemail_result['company']." - ".$jobsnotifyemail_result['email']."\" - Notify JOB Expiration: \"".$jobsnotifyemail_result['jobtitle']."\" ID:".$jobsnotifyemail_result['jobid'];
                    }    
                    $jobsnotifyemail_result['location'] = $location_names[$jobsnotifyemail_result['locationid']];
                    $jobsnotifyemail_result['jobcategory'] = $jobcategory_names[$jobsnotifyemail_result['jobcategoryid']];
                    $w=$jobsnotifyemail_result['jobtypeids'];
                    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                         $jobsnotifyemail_result['jobtype'] .= $type_names[$regs[1]]." - ";      
                         $w=$regs[2];
                    }
                    $jobsnotifyemail_result['jobtype'] = eregi_replace(" - $","",$jobsnotifyemail_result['jobtype']);      
                    $jobsnotifyemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                    $jobsnotifyemail_result['jobdate'] = bx_format_date($jobsnotifyemail_result['jobdate'], DATE_FORMAT);
                    $jobsnotifyemail_result['lastdate'] = bx_format_date($jobsnotifyemail_result['lastdate'], DATE_FORMAT);
                    $jobsnotifyemail_result['jobexpire'] = bx_format_date($jobsnotifyemail_result['jobexpire'], DATE_FORMAT);
                    if ($jobsnotifyemail_result['salary']) {
                        $jobsnotifyemail_result['salary'] = bx_format_price($jobsnotifyemail_result['salary'],PRICE_CURENCY,0);
                    }
                    else {
                        $jobsnotifyemail_result['salary'] = TEXT_UNSPECIFIED;
                    }
                    $jobsnotifyemail_result['joblink'] =  HTTP_SERVER.FILENAME_VIEW."?job_id=".$jobsnotifyemail_result['jobid'];
                    if ($jobsnotifyemail_result['remaining']>=86400) {
                           $jobsnotifyemail_result['remaining']="".(floor($jobsnotifyemail_result['remaining']/(3600*24)));    
                    }
                    else {
                           $jobsnotifyemail_result['remaining']="0";
                    }
                    $mailfile = $language."/mail/notifybefore_jobexpire.txt";
                    include(DIR_LANGUAGES.$mailfile.".cfg.php");
                    $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                    reset($fields);
                    while (list($h, $v) = each($fields)) {
                            if ($jobsnotifyemail_result[$h] || $jobsnotifyemail_result[$h]==0) {
                                 $mail_message = eregi_replace($v[0],$jobsnotifyemail_result[$h],$mail_message);
                                 $file_mail_subject = eregi_replace($v[0],$jobsnotifyemail_result[$h],$file_mail_subject);
                            }
                            else {
                                 $mail_message = eregi_replace($v[0],"",$mail_message);
                                 $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                            }
                    }
                    if ($add_mail_signature == "on") {
                            $mail_message .= "\n".SITE_SIGNATURE;
                    }
                    if ($testmode != "yes") {
                        bx_mail(SITE_NAME,SITE_MAIL,$jobsnotifyemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                    }    
                    else {
                         if ($HTTP_GET_VARS['type']=="admin") {
                             echo "<br>".nl2br($mail_message)."<br>";
                         }    
                    }
                }//end if (NOTIFY_EMPLOYER_JOB_EXPIRE == "yes")
        }//end while
    }//end if ($jobnotify_result['noofjobstonotify'] != 0)
}//end if (NOTIFY_EMPLOYER_JOB_EXPIRE_DAY>0)
if (RESUME_EXPIRE == "yes") {
    if(RESUME_REACTIVATE == "no") {
        $delresume_query=bx_db_query("select count(*) as noofresumestodelete from ".$bx_table_prefix."_resumes where resumeexpire != '0000-00-00' and TO_DAYS(resumeexpire)<=TO_DAYS('".date('Y-m-d')."')");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $delresume_result=bx_db_fetch_array($delresume_query);
        if ($HTTP_GET_VARS['type']=="admin") {
            echo "<br>Number of resumes deleted is: ".$delresume_result['noofresumestodelete'];
        }    
        if (RESUME_EXPIRE_NOTIFY_ADMIN == "yes") {
            $admin_send_mail = true;
            $admin_mail_message .= "Number of resumes deleted is: ".$delresume_result['noofresumestodelete']."\n";
        }
        if ($delresume_result['noofresumestodelete'] != 0) {
            $delresumesemail_query = bx_db_query("select ".$bx_table_prefix."_resumes.resumeid, ".$bx_table_prefix."_resumes.resumedate, ".$bx_table_prefix."_resumes.summary, ".$bx_table_prefix."_persons.email, ".$bx_table_prefix."_persons.name, ".$bx_table_prefix."_persons.persid from ".$bx_table_prefix."_persons, ".$bx_table_prefix."_resumes where ".$bx_table_prefix."_resumes.resumeexpire != '0000-00-00' and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)<=TO_DAYS('".date('Y-m-d')."') and ".$bx_table_prefix."_persons.persid = ".$bx_table_prefix."_resumes.persid");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            while ($delresumesemail_result = bx_db_fetch_array($delresumesemail_query)) {
                    if (NOTIFY_JOBSEEKER_RESUME_EXPIRE == "yes") {
                        if ($HTTP_GET_VARS['type']=="admin") {
                            echo "<br>Sending mail to: \"".$delresumesemail_result['name']." - ".$delresumesemail_result['email']."\" - DELETE RESUME: \"".$delresumesemail_result['summary']."\" ID:".$delresumesemail_result['resumeid'];
                        }
                        $w=$delresumesemail_result['jobcategoryids'];
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $delresumesemail_result['resume_jobcategory'] .= $jobcategory_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $delresumesemail_result['resume_jobcategory'] = eregi_replace(" - $","",$delresumesemail_result['resume_jobcategory']);
                        $w=$delresumesemail_result['jobtypeids'];
                        while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                             $delresumesemail_result['resume_jobtype'] .= $type_names[$regs[1]]." - ";
                             $w=$regs[2];
                        }
                        $delresumesemail_result['resume_jobtype'] = eregi_replace(" - $","",$delresumesemail_result['resume_jobtype']);
                        $delresumesemail_result['resume_degree'] = ${TEXT_DEGREE_OPT.$delresumesemail_result['degreeid']};
                        $w=$delresumesemail_result['locationids'];
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $delresumesemail_result['resume_location'] .= $location_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $delresumesemail_result['resume_location'] = eregi_replace(" - $","",$delresumesemail_result['resume_location']);
                        $delresumesemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                        $delresumesemail_result['resumedate'] = bx_format_date($delresumesemail_result['resumedate'], DATE_FORMAT);
                        $delresumesemail_result['resumeexpire'] = bx_format_date($delresumesemail_result['resumeexpire'], DATE_FORMAT);
                        if ($delresumesemail_result['salary']) {
                            $delresumesemail_result['salary'] = bx_format_price($delresumesemail_result['salary'],PRICE_CURENCY,0);
                        }
                        else {
                            $delresumesemail_result['salary'] = TEXT_UNSPECIFIED;
                        }
                        $mailfile = $language."/mail/notify_resumeexpire.txt";
                        include(DIR_LANGUAGES.$mailfile.".cfg.php");
                        $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                        reset($fields);
                        while (list($h, $v) = each($fields)) {
                                if ($delresumesemail_result[$h] || $delresumesemail_result[$h]==0) {
                                     $mail_message = eregi_replace($v[0],$delresumesemail_result[$h],$mail_message);
                                     $file_mail_subject = eregi_replace($v[0],$delresumesemail_result[$h],$file_mail_subject);
                                }
                                else {
                                     $mail_message = eregi_replace($v[0],"",$mail_message);
                                     $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                                }
                        }
                        if ($add_mail_signature == "on") {
                                $mail_message .= "\n".SITE_SIGNATURE;
                        }
                        if ($testmode != "yes") {
                            bx_mail(SITE_NAME,SITE_MAIL,$delresumesemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                        }    
                        else {
                            if ($HTTP_GET_VARS['type']=="admin") {
                                echo "<br>".nl2br($mail_message)."<br>";
                            }    
                        }
                    }
                    if (RESUME_EXPIRE_NOTIFY_ADMIN == "yes") {
                        $admin_mail_message .= "-----------------Deleted Resume Details--[id:".$delresumesemail_result['resumeid']."]----------\n";
                        $admin_mail_message .= "RESUME ID: ".$delresumesemail_result['resumeid']."\n";
                        $admin_mail_message .= "Jobseeker: ".$delresumesemail_result['name']." - ".$delresumesemail_result['email']."\n";
                        $admin_mail_message .= "Resume Posted: ".$delresumesemail_result['resumedate']."\n";
                        $admin_mail_message .= "-----------------End Deleted Resume Details------------\n\n";
                    }
                    if ($testmode != "yes") {
                            bx_db_query("insert into del".$bx_table_prefix."_resumes select * from ".$bx_table_prefix."_resumes where resumeid='".$delresumesemail_result['resumeid']."' and persid = '".$delresumesemail_result['persid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                            bx_db_query("delete from ".$bx_table_prefix."_resumes where resumeid='".$delresumesemail_result['resumeid']."' and persid = '".$delresumesemail_result['persid']."'");
                            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                    }
            }
        }
    }//end if ($delresume_result['noofresumestodelete'] != 0) {
    if (NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY>0) {
        $resumenotify_query=bx_db_query("select count(*) as noofresumestonotify from ".$bx_table_prefix."_resumes where resumeexpire != '0000-00-00' and TO_DAYS(resumeexpire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY,date('Y')))."')");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $resumenotify_result=bx_db_fetch_array($resumenotify_query);
        if ($HTTP_GET_VARS['type']=="admin") {
            echo "<br>Number of resumes expiring in about ".NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY." days is: ".$resumenotify_result['noofresumestonotify'];
        }    
        if ($resumenotify_result['noofresumestonotify'] != 0) {
            $resumenotifysemail_query = bx_db_query("select ".$bx_table_prefix."_resumes.*, (UNIX_TIMESTAMP(".$bx_table_prefix."_resumes.resumeexpire)-UNIX_TIMESTAMP(NOW())) as remaining, ".$bx_table_prefix."_persons.email, ".$bx_table_prefix."_persons.name, ".$bx_table_prefix."_persons.persid from ".$bx_table_prefix."_persons, ".$bx_table_prefix."_resumes where ".$bx_table_prefix."_resumes.resumeexpire != '0000-00-00' and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY,date('Y')))."') and ".$bx_table_prefix."_persons.persid = ".$bx_table_prefix."_resumes.persid");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            while ($resumenotifysemail_result = bx_db_fetch_array($resumenotifysemail_query)) {
                  if (NOTIFY_JOBSEEKER_RESUME_EXPIRE == "yes") {
                        if ($HTTP_GET_VARS['type']=="admin") {
                            echo "<br>Sending mail to: \"".$resumenotifysemail_result['name']." - ".$resumenotifysemail_result['email']."\" - Notify RESUME expiration: \"".$resumenotifysemail_result['summary']."\" ID:".$resumenotifysemail_result['resumeid'];
                        }   
                        $w=$resumenotifysemail_result['jobcategoryids'];
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $resumenotifysemail_result['resume_jobcategory'] .= $jobcategory_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $resumenotifysemail_result['resume_jobcategory'] = eregi_replace(" - $","",$resumenotifysemail_result['resume_jobcategory']);
                        $w=$resumenotifysemail_result['jobtypeids'];
                        while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                             $resumenotifysemail_result['resume_jobtype'] .= $type_names[$regs[1]]." - ";
                             $w=$regs[2];
                        }
                        $resumenotifysemail_result['resume_jobtype'] = eregi_replace(" - $","",$resumenotifysemail_result['resume_jobtype']);
                        $resumenotifysemail_result['resume_degree'] = ${TEXT_DEGREE_OPT.$resumenotifysemail_result['degreeid']};
                        $w=$resumenotifysemail_result['locationids'];
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $resumenotifysemail_result['resume_location'] .= $location_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $resumenotifysemail_result['resume_location'] = eregi_replace(" - $","",$resumenotifysemail_result['resume_location']);
                        $resumenotifysemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                        $resumenotifysemail_result['resumedate'] = bx_format_date($resumenotifysemail_result['resumedate'], DATE_FORMAT);
                        $resumenotifysemail_result['resumeexpire'] = bx_format_date($resumenotifysemail_result['resumeexpire'], DATE_FORMAT);
                        if ($resumenotifysemail_result['salary']) {
                                $resumenotifysemail_result['salary'] = bx_format_price($resumenotifysemail_result['salary'],PRICE_CURENCY,0);
                        }
                        else {
                                $resumenotifysemail_result['salary'] = TEXT_UNSPECIFIED;
                        }
                        if ($resumenotifysemail_result['remaining']>=86400) {
                               $resumenotifysemail_result['remaining']="".(floor($resumenotifysemail_result['remaining']/(3600*24)));    
                        }
                        else {
                               $resumenotifysemail_result['remaining']="0";
                        }
                        $mailfile = $language."/mail/notifybefore_resumeexpire.txt";
                        include(DIR_LANGUAGES.$mailfile.".cfg.php");
                        $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                        reset($fields);
                        while (list($h, $v) = each($fields)) {
                                if ($resumenotifysemail_result[$h] || $resumenotifysemail_result[$h]==0) {
                                     $mail_message = eregi_replace($v[0],$resumenotifysemail_result[$h],$mail_message);
                                     $file_mail_subject = eregi_replace($v[0],$resumenotifysemail_result[$h],$file_mail_subject);
                                }
                                else {
                                     $mail_message = eregi_replace($v[0],"",$mail_message);
                                     $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                                }
                        }
                        if ($add_mail_signature == "on") {
                                $mail_message .= "\n".SITE_SIGNATURE;
                        }
                        if ($testmode != "yes") {
                            bx_mail(SITE_NAME,SITE_MAIL,$resumenotifysemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                        }   
                        else {
                            if ($HTTP_GET_VARS['type']=="admin") {
                                echo "<br>".nl2br($mail_message)."<br>";
                            }    
                        }
                  }//end if (NOTIFY_JOBSEEKER_RESUME_EXPIRE == "yes")
            }//end while
        }//end if ($resumenotify_result['noofresumestonotify'] != 0)
    }//end if (NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY>0) {
}//if (RESUME_EXPIRE == "yes")
$delplanning_query=bx_db_query("select count(*) as noofexpiredplanning from ".$bx_table_prefix."_companies where expire != '0000-00-00' and TO_DAYS(expire)<=TO_DAYS('".date('Y-m-d')."')");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$delplanning_result=bx_db_fetch_array($delplanning_query);
if ($HTTP_GET_VARS['type']=="admin") {
    echo "<br>Number of expired planning is: ".$delplanning_result['noofexpiredplanning'];
}    
if (PLANNING_EXPIRE_NOTIFY_ADMIN == "yes") {
    $admin_send_mail = true;
    $admin_mail_message .= "\nNumber of expired planning is: ".$delplanning_result['noofexpiredplanning']."\n";
}
if ($delplanning_result['noofexpiredplanning'] != 0) {
    $delplanningemail_query=bx_db_query("select ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_companies.compid, ".$bx_table_prefix."_pricing_".$bx_table_lng.".* from ".$bx_table_prefix."_companies,".$bx_table_prefix."_membership,".$bx_table_prefix."_pricing_".$bx_table_lng." where expire != '0000-00-00' and TO_DAYS(expire)<=TO_DAYS('".date('Y-m-d')."') and ".$bx_table_prefix."_membership.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id = ".$bx_table_prefix."_membership.pricing_id");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    while ($delplanningemail_result=bx_db_fetch_array($delplanningemail_query)) {
        if (PLANNING_EXPIRE_NOTIFY_EMPLOYER == "yes") {
            if ($HTTP_GET_VARS['type']=="admin") {
                echo "<br>Sending mail to: ".$delplanningemail_result['company']." - ".$delplanningemail_result['email']." - DELETE Planning: \"".$delplanningemail_result['pricing_title']."\"";
            }   
            $delplanningemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
            $delplanningemail_result['pricing_price'] = bx_format_price($delplanningemail_result['pricing_price'],$delplanningemail_result['pricing_currency']);
            $mailfile = $language."/mail/notify_planningexpire.txt";
            include(DIR_LANGUAGES.$mailfile.".cfg.php");
            $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
            reset($fields);
            while (list($h, $v) = each($fields)) {
                    if ($delplanningemail_result[$h] || $delplanningemail_result[$h]==0) {
                         $mail_message = eregi_replace($v[0],$delplanningemail_result[$h],$mail_message);
                         $file_mail_subject = eregi_replace($v[0],$delplanningemail_result[$h],$file_mail_subject);
                    }
                    else {
                         $mail_message = eregi_replace($v[0],"",$mail_message);
                         $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                    }
            }
            if ($add_mail_signature == "on") {
                    $mail_message .= "\n".SITE_SIGNATURE;
            }
            if ($testmode != "yes") {
                bx_mail(SITE_NAME,SITE_MAIL,$delplanningemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
            }    
            else {
                if ($HTTP_GET_VARS['type']=="admin") {
                    echo "<br>".nl2br($mail_message)."<br>";
                }    
            }
        }
        if (PLANNING_EXPIRE_NOTIFY_ADMIN == "yes") {
            $admin_mail_message .= "-----------------Deleted Planning Details------------\n";
            $admin_mail_message .= "Company: ".$delplanningemail_result['company']." - ".HTTP_SERVER.FILENAME_VIEW."?company_id=".$delplanningemail_result['compid']."\n";
            $admin_mail_message .= "Email: ".$delplanningemail_result['email']."\n";
            $admin_mail_message .= "Expired Planning: ".$delplanningemail_result['pricing_title']."\n";
            $admin_mail_message .= "-----------------End Deleted Planning Details------------\n\n";
        }
        if ($testmode != "yes") {
            bx_db_query("insert into del".$bx_table_prefix."_membership select * from ".$bx_table_prefix."_membership where compid = '".$delplanningemail_result['compid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            bx_db_query("delete from ".$bx_table_prefix."_membership where compid = '".$delplanningemail_result['compid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            bx_db_query("UPDATE ".$bx_table_prefix."_companies set expire = '0000-00-00', featured = '0' where compid = '".$delplanningemail_result['compid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
            bx_db_query("UPDATE ".$bx_table_prefix."_companycredits set jobs = '0', featuredjobs = '0', contacts = '0' where compid = '".$delplanningemail_result['compid']."'");
            SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        }
    }
} //end if $delplanning_result['noofexpiredplanning']!=0
if (NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY>0) {
    $notifyplanning_query=bx_db_query("select count(*) as noofexpiredplanning from ".$bx_table_prefix."_companies where expire != '0000-00-00' and TO_DAYS(expire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY,date('Y')))."')");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $notifyplanning_result=bx_db_fetch_array($notifyplanning_query);
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "<br>Number of planning expiring in about ".NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY." days is: ".$notifyplanning_result['noofexpiredplanning'];
    }    
    if ($notifyplanning_result['noofexpiredplanning'] != 0) {
        $notifyplanningemail_query=bx_db_query("select ".$bx_table_prefix."_companies.email, ".$bx_table_prefix."_companies.expire, (UNIX_TIMESTAMP(".$bx_table_prefix."_companies.expire)-UNIX_TIMESTAMP(NOW())) as remaining, ".$bx_table_prefix."_companies.company, ".$bx_table_prefix."_companies.compid, ".$bx_table_prefix."_companycredits.*, ".$bx_table_prefix."_pricing_".$bx_table_lng.".* from ".$bx_table_prefix."_companies,".$bx_table_prefix."_membership,".$bx_table_prefix."_companycredits,".$bx_table_prefix."_pricing_".$bx_table_lng." where expire != '0000-00-00' and TO_DAYS(expire)=TO_DAYS('".date('Y-m-d', mktime(0,0,0,date('m'),date('d')+NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY,date('Y')))."') and ".$bx_table_prefix."_companycredits.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_membership.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id = ".$bx_table_prefix."_membership.pricing_id");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($notifyplanningemail_result=bx_db_fetch_array($notifyplanningemail_query)) {
            if (PLANNING_EXPIRE_NOTIFY_EMPLOYER == "yes") {
                if ($HTTP_GET_VARS['type']=="admin") {
                    echo "<br>Sending mail to: ".$notifyplanningemail_result['company']." - ".$notifyplanningemail_result['email']." reminding about planning expiration.";
                }    
                $notifyplanningemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
                $notifyplanningemail_result['expire'] = bx_format_date($notifyplanningemail_result['expire'], DATE_FORMAT);
                $notifyplanningemail_result['pricing_price'] = bx_format_price($notifyplanningemail_result['pricing_price'],$notifyplanningemail_result['pricing_currency']);
                if ($notifyplanningemail_result['jobs'] == "999") {
                    $notifyplanningemail_result['jobs'] = TEXT_UNLIMITED." ".TEXT_JOBS;
                }
                if ($notifyplanningemail_result['contacts'] == "999") {
                    $notifyplanningemail_result['contacts'] = TEXT_UNLIMITED." ".TEXT_RESUMES;
                }
                if ($notifyplanningemail_result['remaining']>=86400) {
                       $notifyplanningemail_result['remaining']="".(floor($notifyplanningemail_result['remaining']/(3600*24)));    
                }
                else {
                       $notifyplanningemail_result['remaining']="0";
                }
                $mailfile = $language."/mail/notifybefore_planningexpire.txt";
                include(DIR_LANGUAGES.$mailfile.".cfg.php");
                $mail_message = fread(fopen(DIR_LANGUAGES.$mailfile,"r"),filesize(DIR_LANGUAGES.$mailfile));
                reset($fields);
                while (list($h, $v) = each($fields)) {
                        if ($notifyplanningemail_result[$h] || $notifyplanningemail_result[$h]==0) {
                             $mail_message = eregi_replace($v[0],$notifyplanningemail_result[$h],$mail_message);
                             $file_mail_subject = eregi_replace($v[0],$notifyplanningemail_result[$h],$file_mail_subject);
                        }
                        else {
                             $mail_message = eregi_replace($v[0],"",$mail_message);
                             $file_mail_subject = eregi_replace($v[0],"",$file_mail_subject);
                        }
                }
                if ($add_mail_signature == "on") {
                        $mail_message .= "\n".SITE_SIGNATURE;
                }
                if ($testmode != "yes") {
                    bx_mail(SITE_NAME,SITE_MAIL,$notifyplanningemail_result['email'], stripslashes($file_mail_subject), stripslashes($mail_message), $html_mail);
                }    
                else {
                   if ($HTTP_GET_VARS['type']=="admin") {
                       echo "<br>".nl2br($mail_message)."<br>";
                   }    
                }
            }
        }//end while
    } //end if $notifyplanning_result['noofexpiredplanning']!=0
}
if ($admin_send_mail) {
     $admin_mail_message .= "-----------------Today Statistics(".date('l, d F Y').")------------\n";
     $tot_jobseeker_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_persons.persid) from ".$bx_table_prefix."_persons where ".$bx_table_prefix."_persons.signupdate='".date('Y-m-d')."'");
     $tot_jobseeker_result=bx_db_fetch_array($tot_jobseeker_query);
     $admin_mail_message .= "New Registered Jobseekers: ".$tot_jobseeker_result[0]."\n";
     $tot_resumes_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_resumes.resumeid) from ".$bx_table_prefix."_resumes where 1=1 ".((HIDE_RESUME=="yes")?" and ".$bx_table_prefix."_resumes.confidential!='1'":"")." and ".$bx_table_prefix."_resumes.resumedate='".date('Y-m-d')."'");
     $tot_resumes_result=bx_db_fetch_array($tot_resumes_query);
     $admin_mail_message .= "New Posted Resumes: ".$tot_resumes_result[0]."\n";
     $tot_employers_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_companies.compid) from ".$bx_table_prefix."_companies where ".$bx_table_prefix."_companies.signupdate='".date('Y-m-d')."'");
     $tot_employers_result=bx_db_fetch_array($tot_employers_query);
     $admin_mail_message .= "New Registered Employers: ".$tot_employers_result[0]."\n";
     $tot_jobs_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_jobs.jobid) from ".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobs.jobdate='".date('Y-m-d')."'");
     $tot_jobs_result=bx_db_fetch_array($tot_jobs_query);
     $admin_mail_message .= "New Posted Jobs: ".$tot_jobs_result[0]."\n";
     $admin_mail_message .= "-----------------End Today Statistics------------\n\n";
     $admin_mail_message .= "-----------------Site Statistics------------\n";
     $tot_jobseeker_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_persons.persid) from ".$bx_table_prefix."_persons");
     $tot_jobseeker_result=bx_db_fetch_array($tot_jobseeker_query);
     $admin_mail_message .= "Total number of jobseekers: ".$tot_jobseeker_result[0]."\n";
     $tot_resumes_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_resumes.resumeid) from ".$bx_table_prefix."_resumes where 1=1 ".((HIDE_RESUME=="yes")?" and ".$bx_table_prefix."_resumes.confidential!='1'":"").((RESUME_EXPIRE == "yes")?" and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)>= TO_DAYS(NOW())":""));
     $tot_resumes_result=bx_db_fetch_array($tot_resumes_query);
     $admin_mail_message .= "Total number of resumes: ".$tot_resumes_result[0]."\n";
     $tot_employers_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_companies.compid) from ".$bx_table_prefix."_companies");
     $tot_employers_result=bx_db_fetch_array($tot_employers_query);
     $admin_mail_message .= "Total number of employers: ".$tot_employers_result[0]."\n";
     $tot_jobs_query=bx_db_query("SELECT COUNT(".$bx_table_prefix."_jobs.jobid) from ".$bx_table_prefix."_jobs");
     $tot_jobs_result=bx_db_fetch_array($tot_jobs_query);
     $admin_mail_message .= "Total number of jobs: ".$tot_jobs_result[0]."\n";
     $admin_mail_message.="Log file size is: ".number_format(filesize(DIR_SERVER_ROOT.'logs/parse_time_log')/1024,1,'.',',')." kbytes\n";
     $admin_mail_message .= "-----------------End Site Statistics------------\n\n";
    if(filesize(DIR_SERVER_ROOT.'logs/parse_time_log')>1024*1024*5){
       $admin_mail_message.="Log file is bigger then 5MB...Maybe is time to download and empty it... Go to Log File Statistics: ".HTTP_SERVER_ADMIN."timestat.php\n\n";
    }
    if ($testmode != "yes" || defined("INTERNAL_CRON")) {
        bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Today cron files messages - ".date('l, d F Y'),$admin_mail_message,"no"); 
    }    
    else {
        if ($HTTP_GET_VARS['type']=="admin") {
            echo "<br><br><b>Sending mail to: ".SITE_MAIL." - Today Cron jobs notification.</b>";
            echo "<br>".nl2br($admin_mail_message)."<br>";
        }    
    }
}
if (defined("CRON_TYPE") && CRON_TYPE=='internal') {
    $cron_status=true;
}
else {
    bx_exit();
}
?>
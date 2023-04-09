<?php
@set_time_limit(0);
define('CRON_JOB','yes');
if (!defined("INTERNAL_CRON")) {
    include_once ('admin_design.php');
    if(!@include_once('../application_config_file.php')){
        include_once(eregi_replace("/([^\/])*$","/application_config_file.php",dirname(__FILE__)));
    }
}    
//include ('admin_auth.php');
$testmode = TEST_MODE;
if ($HTTP_SERVER_VARS['QUERY_STRING'] == "test") {
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "Sending test mail to ".SITE_TITLE." - ADMIN -".SITE_MAIL;
    }    
    bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Testing resumemail_cron.php","\n             Test succcess!!!\nDate: ".date('l, F d Y H:i:s a')."\n","no");
    bx_exit();
}
if ($argv[1] == "test") {
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "\nTesting success\n";
    }    
    bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,"Testing resumemail_cron.php","\n             Test succcess!!!\nDate: ".date('l, F d Y H:i:s a')."\n","no");
    bx_exit();
}
if ($testmode == "yes") {
    if ($HTTP_GET_VARS['type']=="admin") {     
        if(ADMIN_SAFE_MODE == "yes") {
             echo "<center><font color=red><h1>TEST MODE</h1></font></center><font color=red>All email messsages will not be sent, just displayed. No update to the database</font><br>";
        }//end if ADMIN_SAFE_MODE == yes
        else {
              echo "<center><font color=red><h1>TEST MODE</h1></font></center><font color=red>All email messsages will not be sent, just displayed. No update to the database</font><br>To switch back to live mode goto Script Settings and set <b><a href=\"".HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS."#TEST_MODE\" style=\"color: #FF0000; font-size: 14px;\">TEST MODE</a></b> to \"no\"<br>";
        }
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
        $value="<font color=red><b>This file should be runned once in a day by a cron job!</b></font><br><br>Many hosting companies have in their Control Panel a link to where you can input your Cron jobs!<br><b>How does that should look like?</b><br>Something like this: <br>[minute 0-59] [hour 0-23] [day of month 0-31] [month 1-12] [day of week 0-7] /path/to/php [script_path]/admin/resumemail_cron.php >/dev/null<br><br>In this server case we suggest this one:<br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/resumemail_cron.php >/dev/null <br>This means the resumemail_cron.php will run at 23:55 min everyday, everymonth, everyweek day.<br>Also if you want to make a test to this cron job, what you have to do is replace &#034;resumemail_cron.php&#034; with &#034;resumemail_cron.php test&#034; like below: <br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/resumemail_cron.php test >/dev/null<br>This will send the admin an email that the cron job is running, else if the admin doesn't get this email the admin will know that the cron job is not set properly! (Note: don't forgot to remove the test argument if the mail was sent, to go live with this cron job)<br><b>Note:</b> <font color=red><b>php</b></font> can be changed to <b>/usr/bin/php</b> or <b>/usr/local/bin/php</b>.<br>If there is no php available (case in which the php is installed as a module inside the webserver, no command line available) you can use <b>lynx</b> as in this example:<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."resumemail_cron.php >/dev/null<br>or for the test:<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."resumemail_cron.php?test >/dev/null<br><br>More information: <a href='http://www.bluereef.net/support/extensions/admin/cron/crontab.html' target='_blank'>http://www.bluereef.net/support/extensions/admin/cron/crontab.html</a><br>or a search on <b>google.com</b> with '<b>crontab documentation examples</b>' could help you!";
        ?>
        <p><font color="#FF0000" size="4"><b>Note</b>: this file should be runned by a cron job once/day! More help...<a href="javascript: ;" onClick="new_wind('<?php echo $key;?>','<?php echo eregi_replace("'","\'",$value);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></p></font><br><br>
        <?php
    } 
}
$mail_header = array();
$mail_footer = array();
$mail_subject = array();
$mailfile=array();
$mail_messages=array();
if (MULTILANGUAGE_SUPPORT == "on") {
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                                $location_names[$dirs[$i]] = array();
                                $location_query = bx_db_query("select * from ".$bx_table_prefix."_locations_".substr($dirs[$i],0,2)."");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($location_result = bx_db_fetch_array($location_query)) {
                                    $location_names[$dirs[$i]][$location_result['locationid']] = $location_result['location'];
                                }
                                $type_names[$dirs[$i]] = array();
                                $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".substr($dirs[$i],0,2)."");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($type_result = bx_db_fetch_array($type_query)) {
                                    $type_names[$dirs[$i]][$type_result['jobtypeid']] = $type_result['jobtype'];
                                }
                                $jobcategory_names[$dirs[$i]] = array();
                                $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".substr($dirs[$i],0,2)."");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
                                    $jobcategory_names[$dirs[$i]][$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
                                }
    
                    }
              }
}
else {
        $location_names[$language] = array();
        $location_query = bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($location_result = bx_db_fetch_array($location_query)) {
            $location_names[$language][$location_result['locationid']] = $location_result['location'];
        }
        $type_names[$language] = array();
        $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng."");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($type_result = bx_db_fetch_array($type_query)) {
            $type_names[$language][$type_result['jobtypeid']] = $type_result['jobtype'];
        }
        $jobcategory_names[$language] = array();
        $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng."");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
            $jobcategory_names[$language][$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
        }
}

bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'resumemail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

//daily resume mail
if ($HTTP_GET_VARS['type']=="admin") {
    echo "<h1>Daily resumes</h1>";
}    
$resumemail_query=bx_db_query("select *, (UNIX_TIMESTAMP(".$bx_table_prefix."_jobs.jobexpire)-UNIX_TIMESTAMP(NOW())) as job_remaining, (UNIX_TIMESTAMP(".$bx_table_prefix."_resumes.resumeexpire)-UNIX_TIMESTAMP(NOW())) as resume_remaining, ".$bx_table_prefix."_jobs.skills as job_skills, ".$bx_table_prefix."_jobs.jobtypeids as job_jobtypeids, ".$bx_table_prefix."_resumes.jobtypeids as resume_jobtypeids , ".$bx_table_prefix."_jobs.salary as job_salary, ".$bx_table_prefix."_resumes.salary as resume_salary, ".$bx_table_prefix."_resumes.skills as resume_skills from ".$bx_table_prefix."_resumemail,".$bx_table_prefix."_resumes,".$bx_table_prefix."_companies,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_resumemail.resumemail_type='2' and ".$bx_table_prefix."_jobs.compid=".$bx_table_prefix."_resumemail.compid and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_resumemail.compid and ".$bx_table_prefix."_resumemail.resumemail_lastdate<='".date('Y-m-d')."' and ".$bx_table_prefix."_resumes.resumedate>".$bx_table_prefix."_resumemail.resumemail_lastdate and POSITION(CONCAT('-',".$bx_table_prefix."_jobs.jobcategoryid,'-') IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0 and (POSITION(CONCAT('-',".$bx_table_prefix."_jobs.locationid,'-') IN ".$bx_table_prefix."_resumes.locationids)!=0 or ".$bx_table_prefix."_resumes.locationids = '' or ".$bx_table_prefix."_resumes.locationids = '-')".((HIDE_RESUME=="yes")?" and ".$bx_table_prefix."_resumes.confidential!='1'":"").((RESUME_EXPIRE=="yes")?" and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)>= TO_DAYS(NOW())":""));
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (MULTILANGUAGE_SUPPORT == "on") {
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                            $mailfile[$dirs[$i]] = $dirs[$i]."/mail/daily_resumemail.txt";
                            include(DIR_LANGUAGES.$mailfile[$dirs[$i]].".cfg.php");
                            $mail_message[$dirs[$i]] = fread(fopen(DIR_LANGUAGES.$mailfile[$dirs[$i]],"r"),filesize(DIR_LANGUAGES.$mailfile[$dirs[$i]]));
                            if ($repeat_code) {
                                $ee = eregi("(.*)<BEGIN REPEAT>(.*)<END REPEAT>(.*)",$mail_message[$dirs[$i]], $regs);
                                $mail_header[$dirs[$i]] = $regs[1];
                                $mail_message[$dirs[$i]] = $regs[2];
                                $mail_footer[$dirs[$i]] = $regs[3];
                            }
                           $mail_file_mail_subject[$dirs[$i]] = $file_mail_subject; 
                    }
              }
}
else {
        $mailfile[$language] = $language."/mail/daily_resumemail.txt";
        include(DIR_LANGUAGES.$mailfile[$language].".cfg.php");
        $mail_message[$language] = fread(fopen(DIR_LANGUAGES.$mailfile[$language],"r"),filesize(DIR_LANGUAGES.$mailfile[$language]));
        if ($repeat_code) {
            $ee = eregi("(.*)<BEGIN REPEAT>(.*)<END REPEAT>(.*)",$mail_message[$language], $regs);
            $mail_header[$language] = $regs[1];
            $mail_message[$language] = $regs[2];
            $mail_footer[$language] = $regs[3];
        }
        $mail_file_mail_subject[$language] = $file_mail_subject; 
}
while ($resumemail_result=bx_db_fetch_array($resumemail_query)) {
    if (MULTILANGUAGE_SUPPORT == "on") {
        if ($resumemail_result['rmail_lang']) {
            $jmail_lang = $resumemail_result['rmail_lang'];
        }
        else {
            $jmail_lang = DEFAULT_LANGUAGE;
        }
    }
    else {
        $jmail_lang = $language;
    }
    $mail_message_temp = $mail_message[$jmail_lang];
    $mail_header_temp = $mail_header[$jmail_lang];
    $mail_footer_temp = $mail_footer[$jmail_lang];
    $mail_subject_temp = $mail_file_mail_subject[$jmail_lang];
    $resumemail_result['location'] = $location_names[$jmail_lang][$resumemail_result['locationid']];
    $resumemail_result['jobcategory'] = $jobcategory_names[$jmail_lang][$resumemail_result['jobcategoryid']];
    $w=$resumemail_result['job_jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $resumemail_result['jobtype'] = eregi_replace(" - $","",$resumemail_result['jobtype']);
    $w=$resumemail_result['jobcategoryids'];
    while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_jobcategory'] .= $jobcategory_names[$jmail_lang][$regs[1]]." - ";
         $w="-".$regs[2];
    }
    $resumemail_result['resume_jobcategory'] = eregi_replace(" - $","",$resumemail_result['resume_jobcategory']);
    $w=$resumemail_result['locationids'];
    while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_location'] .= $location_names[$jmail_lang][$regs[1]]." - ";
         $w="-".$regs[2];
    }
    $resumemail_result['resume_location'] = eregi_replace(" - $","",$resumemail_result['resume_location']);
    $w=$resumemail_result['resume_jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $resumemail_result['resume_jobtype'] = eregi_replace(" - $","",$resumemail_result['resume_jobtype']);
    $resumemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
    $resumemail_result['jobdate'] = bx_format_date($resumemail_result['jobdate'], DATE_FORMAT);
    if ($resumemail_result['job_salary']) {
                $resumemail_result['job_salary'] = bx_format_price($resumemail_result['job_salary'],PRICE_CURENCY,0);
    }
    else {
                 $resumemail_result['job_salary'] = TEXT_UNSPECIFIED;
    }
    if ($resumemail_result['resume_salary']) {
                $resumemail_result['resume_salary'] = bx_format_price($resumemail_result['resume_salary'],PRICE_CURENCY,0);
    }
    else {
                 $resumemail_result['resume_salary'] = TEXT_UNSPECIFIED;
    }
    $resumemail_result['joblink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&job_id=".$resumemail_result['jobid'];
    $resumemail_result['resumelink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&resume_id=".$resumemail_result['resumeid'];
    if ($resumemail_result['resume_cv']) {
       $resumemail_result['resume_download'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=download&resume_id=".$resumemail_result['resumeid'];
    }
    else {
       $resumemail_result['resume_download'] = "";
    }
    if ($resumemail_result['job_remaining']>=86400) {
           $resumemail_result['job_remaining']="".(floor($resumemail_result['job_remaining']/(3600*24)));    
    }
    else {
           $resumemail_result['job_remaining']="0";
    }
    if ($resumemail_result['resume_remaining']>=86400) {
           $resumemail_result['resume_remaining']="".(floor($resumemail_result['resume_remaining']/(3600*24)));    
    }
    else {
           $resumemail_result['resume_remaining']="0";
    }
    reset($fields);
    while (list($h, $v) = each($fields)) {
            if ($resumemail_result[$h]) {
                $mail_message_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_footer_temp);
            }
            else {
                $mail_message_temp = eregi_replace($v[0],"",$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],"",$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],"",$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],"",$mail_footer_temp);
            }
    }
    $sendmail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where persid='".$resumemail_result['compid']."' and sendmail_type = 'resumemail'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    if(bx_db_num_rows($sendmail_query)!=0) {
          bx_db_query("update ".$bx_table_prefix."_sendmail set sendmail_message=CONCAT(sendmail_message,'".addslashes($mail_message_temp)."') where persid='".$resumemail_result['compid']."' and sendmail_type = 'resumemail'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    }//end if(bx_db_num_rows($sendmail_query)!=0)
    else {
          bx_db_insert($bx_table_prefix."_sendmail","persid,sendmail_type,sendmail_email,sendmail_message,sendmail_header,sendmail_footer,sendmail_subject","'".$resumemail_result['compid']."','resumemail','".addslashes($resumemail_result['name']." <".$resumemail_result['email']).">"."','".addslashes($mail_message_temp)."','".addslashes($mail_header_temp)."','".addslashes($mail_footer_temp)."','".addslashes($mail_subject_temp)."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    }//end else if(bx_db_num_rows($sendmail_query)!=0)
}
$sent_mail = 0;
$sendmail_mail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where sendmail_type = 'resumemail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query)) {
    $sent_mail++;
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "<br><b><font color=\"#FF0000\">Sending mail to: ".htmlspecialchars($sendmail_mail_result['sendmail_email'])."</font></b><br>";
        echo "<b><font color=\"#FF0000\">Subject:</font></b> ".$sendmail_mail_result['sendmail_subject']."<br>";
    }    
    $themessage = $sendmail_mail_result['sendmail_header'];
    $themessage .= $sendmail_mail_result['sendmail_message']."\n";
    $themessage .= $sendmail_mail_result['sendmail_footer'];
    if ($add_mail_signature == "on") {
            $themessage .= "\n".SITE_SIGNATURE;
    }
    if ($testmode != "yes") {
          bx_mail(SITE_NAME,SITE_MAIL,stripslashes($sendmail_mail_result['sendmail_email']), stripslashes($sendmail_mail_result['sendmail_subject']), stripslashes($themessage), $html_mail);
          bx_db_query("update ".$bx_table_prefix."_resumemail set resumemail_lastdate='".date('Y-m-d')."' where compid='".$sendmail_mail_result['persid']."'");
    }
    else {
       if ($HTTP_GET_VARS['type']=="admin") {
           echo nl2br($themessage);
       }    
    }
}//end while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query))
if ($HTTP_GET_VARS['type']=="admin") {
    if ($sent_mail == 0) {
            print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>No daily resumemail to send...</b></font></p><br>";
    }
    else {
            if ($testmode != "yes") {
                    print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." daily resumemails was sent.</b></font></p><br>";
            }
            else {
                    print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." daily resumemails to send.</b></font></p><br>";
            }
    }
}    
bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'resumemail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

//Weekly mail
$mail_header = array();
$mail_footer = array();
$mail_subject = array();
$mailfile=array();
$mail_messages=array();
if ($HTTP_GET_VARS['type']=="admin") {
    echo "<h1>Weekly mail</h1><br>";
}    
$resumemail_query=bx_db_query("select *, (UNIX_TIMESTAMP(".$bx_table_prefix."_jobs.jobexpire)-UNIX_TIMESTAMP(NOW())) as job_remaining, (UNIX_TIMESTAMP(".$bx_table_prefix."_resumes.resumeexpire)-UNIX_TIMESTAMP(NOW())) as resume_remaining, ".$bx_table_prefix."_jobs.skills as job_skills, ".$bx_table_prefix."_jobs.jobtypeids as job_jobtypeids, ".$bx_table_prefix."_resumes.jobtypeids as resume_jobtypeids , ".$bx_table_prefix."_jobs.salary as job_salary, ".$bx_table_prefix."_resumes.salary as resume_salary, ".$bx_table_prefix."_resumes.skills as resume_skills from ".$bx_table_prefix."_resumemail,".$bx_table_prefix."_resumes,".$bx_table_prefix."_companies,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_resumemail.resumemail_type='3' and ".$bx_table_prefix."_jobs.compid=".$bx_table_prefix."_resumemail.compid and ".$bx_table_prefix."_companies.compid=".$bx_table_prefix."_resumemail.compid and ".$bx_table_prefix."_resumemail.resumemail_lastdate<='".date('Y-m-d', mktime(0,0,0,date('m'), date('d')-7,date('Y')))."' and ".$bx_table_prefix."_resumes.resumedate>".$bx_table_prefix."_resumemail.resumemail_lastdate and POSITION(CONCAT('-',".$bx_table_prefix."_jobs.jobcategoryid,'-') IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0 and (POSITION(CONCAT('-',".$bx_table_prefix."_jobs.locationid,'-') IN ".$bx_table_prefix."_resumes.locationids)!=0 or ".$bx_table_prefix."_resumes.locationids = ''  or ".$bx_table_prefix."_resumes.locationids = '-')".((HIDE_RESUME=="yes")?" and ".$bx_table_prefix."_resumes.confidential!='1'":"").((RESUME_EXPIRE=="yes")?" and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)>= TO_DAYS(NOW())":""));
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (MULTILANGUAGE_SUPPORT == "on") {
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                            $mailfile[$dirs[$i]] = $dirs[$i]."/mail/weekly_resumemail.txt";
                            include(DIR_LANGUAGES.$mailfile[$dirs[$i]].".cfg.php");
                            $mail_message[$dirs[$i]] = fread(fopen(DIR_LANGUAGES.$mailfile[$dirs[$i]],"r"),filesize(DIR_LANGUAGES.$mailfile[$dirs[$i]]));
                            if ($repeat_code) {
                                $ee = eregi("(.*)<BEGIN REPEAT>(.*)<END REPEAT>(.*)",$mail_message[$dirs[$i]], $regs);
                                $mail_header[$dirs[$i]] = $regs[1];
                                $mail_message[$dirs[$i]] = $regs[2];
                                $mail_footer[$dirs[$i]] = $regs[3];
                            }
                           $mail_file_mail_subject[$dirs[$i]] = $file_mail_subject; 
                    }
              }
}
else {
        $mailfile[$language] = $language."/mail/weekly_resumemail.txt";
        include(DIR_LANGUAGES.$mailfile[$language].".cfg.php");
        $mail_message[$language] = fread(fopen(DIR_LANGUAGES.$mailfile[$language],"r"),filesize(DIR_LANGUAGES.$mailfile[$language]));
        if ($repeat_code) {
            $ee = eregi("(.*)<BEGIN REPEAT>(.*)<END REPEAT>(.*)",$mail_message[$language], $regs);
            $mail_header[$language] = $regs[1];
            $mail_message[$language] = $regs[2];
            $mail_footer[$language] = $regs[3];
        }
        $mail_file_mail_subject[$language] = $file_mail_subject; 
}
while ($resumemail_result=bx_db_fetch_array($resumemail_query)) {
    if (MULTILANGUAGE_SUPPORT == "on") {
        if ($resumemail_result['rmail_lang']) {
            $jmail_lang = $resumemail_result['rmail_lang'];
        }
        else {
            $jmail_lang = DEFAULT_LANGUAGE;
        }
    }
    else {
        $jmail_lang = $language;
    }
    $mail_message_temp = $mail_message[$jmail_lang];
    $mail_header_temp = $mail_header[$jmail_lang];
    $mail_footer_temp = $mail_footer[$jmail_lang];
    $mail_subject_temp = $mail_file_mail_subject[$jmail_lang];
    $resumemail_result['location'] = $location_names[$jmail_lang][$resumemail_result['locationid']];
    $resumemail_result['jobcategory'] = $jobcategory_names[$jmail_lang][$resumemail_result['jobcategoryid']];
    $w=$resumemail_result['job_jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $resumemail_result['jobtype'] = eregi_replace(" - $","",$resumemail_result['jobtype']);
    $w=$resumemail_result['jobcategoryids'];
    while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_jobcategory'] .= $jobcategory_names[$jmail_lang][$regs[1]]." - ";
         $w="-".$regs[2];
    }
    $resumemail_result['resume_jobcategory'] = eregi_replace(" - $","",$resumemail_result['resume_jobcategory']);
    $w=$resumemail_result['locationids'];
    while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_location'] .= $location_names[$jmail_lang][$regs[1]]." - ";
         $w="-".$regs[2];
    }
    $resumemail_result['resume_location'] = eregi_replace(" - $","",$resumemail_result['resume_location']);
    $w=$resumemail_result['resume_jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $resumemail_result['resume_jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $resumemail_result['resume_jobtype'] = eregi_replace(" - $","",$resumemail_result['resume_jobtype']);
    $resumemail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
    $resumemail_result['jobdate'] = bx_format_date($resumemail_result['jobdate'], DATE_FORMAT);
    if ($resumemail_result['job_salary']) {
                $resumemail_result['job_salary'] = bx_format_price($resumemail_result['job_salary'],PRICE_CURENCY,0);
    }
    else {
                 $resumemail_result['job_salary'] = TEXT_UNSPECIFIED;
    }
    if ($resumemail_result['resume_salary']) {
                $resumemail_result['resume_salary'] = bx_format_price($resumemail_result['resume_salary'],PRICE_CURENCY,0);
    }
    else {
                 $resumemail_result['resume_salary'] = TEXT_UNSPECIFIED;
    }
    $resumemail_result['joblink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&job_id=".$resumemail_result['jobid'];
    $resumemail_result['resumelink'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=view&resume_id=".$resumemail_result['resumeid'];
    if ($resumemail_result['resume_cv']) {
       $resumemail_result['resume_download'] = HTTP_SERVER.FILENAME_LOGIN."?login=employer&from=download&resume_id=".$resumemail_result['resumeid'];
    }
    else {
       $resumemail_result['resume_download'] = "";
    }
    if ($resumemail_result['job_remaining']>=86400) {
           $resumemail_result['job_remaining']="".(floor($resumemail_result['job_remaining']/(3600*24)));    
    }
    else {
           $resumemail_result['job_remaining']="0";
    }
    if ($resumemail_result['resume_remaining']>=86400) {
           $resumemail_result['resume_remaining']="".(floor($resumemail_result['resume_remaining']/(3600*24)));    
    }
    else {
           $resumemail_result['resume_remaining']="0";
    }
    reset($fields);
    while (list($h, $v) = each($fields)) {
            if ($resumemail_result[$h]) {
                $mail_message_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],$resumemail_result[$h],$mail_footer_temp);
            }
            else {
                $mail_message_temp = eregi_replace($v[0],"",$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],"",$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],"",$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],"",$mail_footer_temp);
            }
    }
    $sendmail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where persid='".$resumemail_result['compid']."' and sendmail_type = 'resumemail'");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    if(bx_db_num_rows($sendmail_query)!=0) {
          bx_db_query("update ".$bx_table_prefix."_sendmail set sendmail_message=CONCAT(sendmail_message,'".addslashes($mail_message_temp)."') where persid='".$resumemail_result['compid']."' and sendmail_type = 'resumemail'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    }//end if(bx_db_num_rows($sendmail_query)!=0)
    else {
          bx_db_insert($bx_table_prefix."_sendmail","persid,sendmail_type,sendmail_email,sendmail_message,sendmail_header,sendmail_footer,sendmail_subject","'".$resumemail_result['compid']."','resumemail','".addslashes($resumemail_result['name']." <".$resumemail_result['email']).">"."','".addslashes($mail_message_temp)."','".addslashes($mail_header_temp)."','".addslashes($mail_footer_temp)."','".addslashes($mail_subject_temp)."'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    }//end else if(bx_db_num_rows($sendmail_query)!=0)
}
$sendmail_mail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where sendmail_type = 'resumemail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$sent_mail = 0;
while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query)) {
    $sent_mail++;
    if ($HTTP_GET_VARS['type']=="admin") {
        echo "<br><b><font color=\"#FF0000\">Sending mail to: ".htmlspecialchars($sendmail_mail_result['sendmail_email'])."</font></b><br>";
        echo "<b><font color=\"#FF0000\">Subject:</font></b> ".$sendmail_mail_result['sendmail_subject']."<br>";
    }    
    $themessage = $sendmail_mail_result['sendmail_header'];
    $themessage .= $sendmail_mail_result['sendmail_message']."\n";
    $themessage .= $sendmail_mail_result['sendmail_footer'];
    if ($add_mail_signature == "on") {
            $themessage .= "\n".SITE_SIGNATURE;
    }
    if ($testmode != "yes") {
          bx_mail(SITE_NAME,SITE_MAIL,stripslashes($sendmail_mail_result['sendmail_email']), stripslashes($sendmail_mail_result['sendmail_subject']), stripslashes($themessage), $html_mail);
          bx_db_query("update ".$bx_table_prefix."_resumemail set resumemail_lastdate='".date('Y-m-d')."' where compid='".$sendmail_mail_result['persid']."'");
    }
    else {
       if ($HTTP_GET_VARS['type']=="admin") {
           echo nl2br($themessage);
       }    
    }
}//end while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query))
if ($HTTP_GET_VARS['type']=="admin") {
    if ($sent_mail == 0) {
            print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>No weekly resumemail to send...</b></font></p><br>";
    }
    else {
            if ($testmode != "yes") {
                    print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." weekly resumemail(s) was sent.</b></font></p><br>";
            }
            else {
                    print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." weekly resumemail(s) to send.</b></font></p><br>";
            }
    }
}    
bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'resumemail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (defined("CRON_TYPE") && CRON_TYPE=='internal') {
    $cron_status=true;
}
else {
    bx_exit();
}
?>
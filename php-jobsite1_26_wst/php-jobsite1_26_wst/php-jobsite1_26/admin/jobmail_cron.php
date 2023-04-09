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
//daily mail
if ($testmode == "yes") {
    if ($HTTP_GET_VARS['type']=="admin") {
        if(ADMIN_SAFE_MODE == "yes") {
            echo "<center><font color=red><h1>TEST MODE</h1></font></center><font color=red>All email messsages will not be sent, just displayed. No update to the database</font><br>";
        }    
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
        $value="<font color=red><b>This file should be runned once in a day by a cron job!</b></font><br><br>Many hosting companies have in their Control Panel a link to where you can input your Cron jobs!<br><b>How does that should look like?</b><br>Something like this: <br>[minute 0-59] [hour 0-23] [day of month 0-31] [month 1-12] [day of week 0-7] /path/to/php [script_path]/admin/jobmail_cron.php >/dev/null<br><br>In this server case we suggest this one:<br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/jobmail_cron.php >/dev/null <br>This means the jobmail_cron.php will run at 23:55 min everyday, everymonth, everyweek day.<br>Also if you want to make a test to this cron job, what you have to do is replace &#034;jobmail_cron.php&#034; with &#034;jobmail_cron.php test&#034; like below: <br> 55 23 * * * <font color=red><b>php</b></font> ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"/path/to/the/script/":DIR_SERVER_ROOT)."admin/jobmail_cron.php test >/dev/null<br>This will send the admin an email that the cron job is running, else if the admin doesn't get this email the admin will know that the cron job is not set properly! (Note: don't forgot to remove the test argument if the mail was sent, to go live with this cron job)<br><b>Note:</b> <font color=red><b>php</b></font> can be changed to <b>/usr/bin/php</b> or <b>/usr/local/bin/php</b>.<br>If there is no php available (case in which the php is installed as a module inside the webserver, no command line available) you can use <b>lynx</b> as in this example:<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."jobmail_cron.php >/dev/null<br>or for the test:<br> 55 23 * * * /usr/local/bin/lynx -auth username:password -accept-all-cookies -dump ".((ADMIN_SAFE_MODE=="yes" || ADMIN_BX_DEMO=="yes")?"http://www.yourjobsite.com/admin/":HTTP_SERVER_ADMIN)."jobmail_cron.php?test >/dev/null<br><br>More information: <a href='http://www.bluereef.net/support/extensions/admin/cron/crontab.html' target='_blank'>http://www.bluereef.net/support/extensions/admin/cron/crontab.html</a><br>or a search on <b>google.com</b> with '<b>crontab documentation examples</b>' could help you!";
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
        $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($type_result = bx_db_fetch_array($type_query)) {
            $type_names[$language][$type_result['jobtypeid']] = $type_result['jobtype'];
        }
        $jobcategory_names[$language] = array();
        $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
            $jobcategory_names[$language][$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
        }
}
bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'jobmail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if ($HTTP_GET_VARS['type']=="admin") {
    echo "<h1>Daily mail</h1>";
}    
$jobmail_query=bx_db_query("select *, (UNIX_TIMESTAMP(".$bx_table_prefix."_jobs.jobexpire)-UNIX_TIMESTAMP(NOW())) as remaining from ".$bx_table_prefix."_jobmail,".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobmail.jobmail_type='2' and ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_jobmail.persid and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_jobmail.persid and ".$bx_table_prefix."_jobmail.jobmail_lastdate<='".date('Y-m-d')."' and TO_DAYS(".$bx_table_prefix."_jobs.jobexpire)>TO_DAYS('".date('Y-m-d')."') and ".$bx_table_prefix."_jobs.jobdate>".$bx_table_prefix."_jobmail.jobmail_lastdate and POSITION(CONCAT('-',".$bx_table_prefix."_jobs.jobcategoryid,'-') IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0 and (POSITION(CONCAT('-',".$bx_table_prefix."_jobs.locationid,'-') IN ".$bx_table_prefix."_resumes.locationids)!=0 or ".$bx_table_prefix."_resumes.locationids ='' or ".$bx_table_prefix."_resumes.locationids ='-')");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

if (MULTILANGUAGE_SUPPORT == "on") {
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                            $mailfile[$dirs[$i]] = $dirs[$i]."/mail/daily_jobmail.txt";
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
        $mailfile[$language] = $language."/mail/daily_jobmail.txt";
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
while ($jobmail_result=bx_db_fetch_array($jobmail_query)) {
    if (MULTILANGUAGE_SUPPORT == "on") {
        if ($jobmail_result['jmail_lang']) {
            $jmail_lang = $jobmail_result['jmail_lang'];
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
    $jobmail_result['location'] = $location_names[$jmail_lang][$jobmail_result['locationid']];
    $jobmail_result['jobcategory'] = $jobcategory_names[$jmail_lang][$jobmail_result['jobcategoryid']];
    $w=$jobmail_result['jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $jobmail_result['jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $jobmail_result['jobtype'] = eregi_replace(" - $","",$jobmail_result['jobtype']);
    $jobmail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
    $jobmail_result['jobdate'] = bx_format_date($jobmail_result['jobdate'], DATE_FORMAT);
    $jobmail_result['lastdate'] = bx_format_date($jobmail_result['lastdate'], DATE_FORMAT);
    $jobmail_result['jobexpire'] = bx_format_date($jobmail_result['jobexpire'], DATE_FORMAT);
    if ($jobmail_result['remaining']>=86400) {
           $jobmail_result['remaining']="".(floor($jobmail_result['remaining']/(3600*24)));    
    }
    else {
           $jobmail_result['remaining']="0";
    }
    if ($jobmail_result['salary']) {
        $jobmail_result['salary'] = bx_format_price($jobmail_result['salary'],PRICE_CURENCY,0);
    }
    else {
                $jobmail_result['salary'] = TEXT_UNSPECIFIED;
    }
    $jobmail_result['joblink'] = HTTP_SERVER.FILENAME_LOGIN."?login=jobseeker&from=view&job_id=".$jobmail_result['jobid'];
    reset($fields);
    while (list($h, $v) = each($fields)) {
            if ($jobmail_result[$h]) {
                $mail_message_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_footer_temp);
            }
            else {
                $mail_message_temp = eregi_replace($v[0],"",$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],"",$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],"",$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],"",$mail_footer_temp);
            }
     }
     $sendmail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where persid='".$jobmail_result['persid']."' and sendmail_type = 'jobmail'");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     if(bx_db_num_rows($sendmail_query)!=0) {
          bx_db_query("update ".$bx_table_prefix."_sendmail set sendmail_message=CONCAT(sendmail_message,'".addslashes($mail_message_temp)."') where persid='".$jobmail_result['persid']."' and sendmail_type = 'jobmail'");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     }//end if(bx_db_num_rows($sendmail_query)!=0)
     else {
         bx_db_insert($bx_table_prefix."_sendmail","persid,sendmail_type,sendmail_email,sendmail_message,sendmail_header,sendmail_footer,sendmail_subject","'".$jobmail_result['persid']."','jobmail','".addslashes($jobmail_result['name']." <".$jobmail_result['email']).">"."','".addslashes($mail_message_temp)."','".addslashes($mail_header_temp)."','".addslashes($mail_footer_temp)."','".addslashes($mail_subject_temp)."'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     }//end else if(bx_db_num_rows($sendmail_query)!=0)
}//end while
$sent_mail = 0;
$sendmail_mail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where sendmail_type = 'jobmail'");
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
    if ($testmode!="yes") {
        bx_mail(SITE_NAME,SITE_MAIL,stripslashes($sendmail_mail_result['sendmail_email']), stripslashes($sendmail_mail_result['sendmail_subject']), stripslashes($themessage), $html_mail);
        bx_db_query("update ".$bx_table_prefix."_jobmail set jobmail_lastdate='".date('Y-m-d')."' where persid='".$sendmail_mail_result['persid']."'");
    }
    else {
       if ($HTTP_GET_VARS['type']=="admin") {
           echo nl2br($themessage);
       }    
    }
}//end while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query))
if ($HTTP_GET_VARS['type']=="admin") {
    if ($sent_mail == 0) {
                print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>No daily jobmail to send...</b></font></p><br>";
    }
    else {
            if ($testmode != "yes") {
                        print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." daily jobmails was sent.</b></font></p><br>";
            }
            else {
                        print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." daily jobmails to send.</b></font></p><br>";
            }
    }
}
bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'jobmail'");
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
$jobmail_query=bx_db_query("select *, (UNIX_TIMESTAMP(".$bx_table_prefix."_jobs.jobexpire)-UNIX_TIMESTAMP(NOW())) as remaining from ".$bx_table_prefix."_jobmail,".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons,".$bx_table_prefix."_jobs where ".$bx_table_prefix."_jobmail.jobmail_type='3' and ".$bx_table_prefix."_resumes.persid=".$bx_table_prefix."_jobmail.persid and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_jobmail.persid and  ".$bx_table_prefix."_jobmail.jobmail_lastdate <= '".date('Y-m-d', mktime(0,0,0,date('m'), date('d')-7,date('Y')))."' and TO_DAYS(".$bx_table_prefix."_jobs.jobexpire)>TO_DAYS('".date('Y-m-d')."') and ".$bx_table_prefix."_jobs.jobdate>".$bx_table_prefix."_jobmail.jobmail_lastdate and POSITION(CONCAT('-',".$bx_table_prefix."_jobs.jobcategoryid,'-') IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0 and (POSITION(CONCAT('-',".$bx_table_prefix."_jobs.locationid,'-') IN ".$bx_table_prefix."_resumes.locationids)!=0 or ".$bx_table_prefix."_resumes.locationids ='' or ".$bx_table_prefix."_resumes.locationids ='-')");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (MULTILANGUAGE_SUPPORT == "on") {
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                            $mailfile[$dirs[$i]] = $dirs[$i]."/mail/weekly_jobmail.txt";
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
        $mailfile[$language] = $language."/mail/weekly_jobmail.txt";
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
while ($jobmail_result=bx_db_fetch_array($jobmail_query)) {
    if (MULTILANGUAGE_SUPPORT == "on") {
        if ($jobmail_result['jmail_lang']) {
            $jmail_lang = $jobmail_result['jmail_lang'];
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
    $jobmail_result['location'] = $location_names[$jmail_lang][$jobmail_result['locationid']];
    $jobmail_result['jobcategory'] = $jobcategory_names[$jmail_lang][$jobmail_result['jobcategoryid']];
    $w=$jobmail_result['jobtypeids'];
    while (eregi("([0-9]*)-(.*)",$w,$regs)) {
         $jobmail_result['jobtype'] .= $type_names[$jmail_lang][$regs[1]]." - ";
         $w=$regs[2];
    }
    $jobmail_result['jobtype'] = eregi_replace(" - $","",$jobmail_result['jobtype']);
    $jobmail_result['today'] = bx_format_date(date('Y-m-d'), DATE_FORMAT);
    $jobmail_result['jobdate'] = bx_format_date($jobmail_result['jobdate'], DATE_FORMAT);
    $jobmail_result['lastdate'] = bx_format_date($jobmail_result['lastdate'], DATE_FORMAT);
    $jobmail_result['jobexpire'] = bx_format_date($jobmail_result['jobexpire'], DATE_FORMAT);
    if ($jobmail_result['remaining']>=86400) {
           $jobmail_result['remaining']="".(floor($jobmail_result['remaining']/(3600*24)));    
    }
    else {
           $jobmail_result['remaining']="0";
    }
    if ($jobmail_result['salary']) {
        $jobmail_result['salary'] = bx_format_price($jobmail_result['salary'],PRICE_CURENCY,0);
    }
    else {
                $jobmail_result['salary'] = TEXT_UNSPECIFIED;
    }
    $jobmail_result['joblink'] = HTTP_SERVER.FILENAME_LOGIN."?login=jobseeker&from=view&job_id=".$jobmail_result['jobid'];
    reset($fields);
    while (list($h, $v) = each($fields)) {
            if ($jobmail_result[$h]) {
                $mail_message_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],$jobmail_result[$h],$mail_footer_temp);
            }
            else {
                $mail_message_temp = eregi_replace($v[0],"",$mail_message_temp);
                $mail_header_temp = eregi_replace($v[0],"",$mail_header_temp);
                $mail_subject_temp = eregi_replace($v[0],"",$mail_subject_temp);
                $mail_footer_temp = eregi_replace($v[0],"",$mail_footer_temp);
            }

     }
     $sendmail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where persid='".$jobmail_result['persid']."' and sendmail_type = 'jobmail'");
     SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     if(bx_db_num_rows($sendmail_query)!=0) {
         bx_db_query("update ".$bx_table_prefix."_sendmail set sendmail_message=CONCAT(sendmail_message,'".addslashes($mail_message_temp)."') where persid='".$jobmail_result['persid']."' and sendmail_type = 'jobmail'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     }//end if(bx_db_num_rows($sendmail_query)!=0)
     else {
         bx_db_insert($bx_table_prefix."_sendmail","persid,sendmail_type,sendmail_email,sendmail_message,sendmail_header,sendmail_footer,sendmail_subject","'".$jobmail_result['persid']."','jobmail','".addslashes($jobmail_result['name']." <".$jobmail_result['email']).">"."','".addslashes($mail_message_temp)."','".addslashes($mail_header_temp)."','".addslashes($mail_footer_temp)."','".addslashes($mail_subject_temp)."'");
         SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
     }//end else if(bx_db_num_rows($sendmail_query)!=0)
}
$sendmail_mail_query=bx_db_query("select * from ".$bx_table_prefix."_sendmail where sendmail_type = 'jobmail'");
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
    if ($testmode!="yes") {
        bx_mail(SITE_NAME,SITE_MAIL,stripslashes($sendmail_mail_result['sendmail_email']), stripslashes($sendmail_mail_result['sendmail_subject']), stripslashes($themessage), $html_mail);
        bx_db_query("update ".$bx_table_prefix."_jobmail set jobmail_lastdate='".date('Y-m-d')."' where persid='".$sendmail_mail_result['persid']."'");
    }
    else {
       if ($HTTP_GET_VARS['type']=="admin") {
           echo nl2br($themessage);
       }    
    }
}//end while ($sendmail_mail_result=bx_db_fetch_array($sendmail_mail_query))
if ($HTTP_GET_VARS['type']=="admin") {
    if ($sent_mail == 0) {
                print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>No weekly jobmail to send...</b></font></p><br>";
    }
    else {
            if ($testmode != "yes") {
                        print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." weekly jobmail(s) was sent.</b></font></p><br>";
            }
            else {
                        print "<br><p style=\"background-color: #E0E0E0;\"><font color=\"#FF0000\"><b>".$sent_mail." weekly jobmail(s) to send.</b></font></p><br>";
            }
    }
}    
bx_db_query("delete from ".$bx_table_prefix."_sendmail where sendmail_type = 'jobmail'");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
if (defined("CRON_TYPE") && CRON_TYPE=='internal') {
    $cron_status=true;
}
else {
    bx_exit();
}
?>
<?php
############################################################
# php-Jobsite(TM)                                          #
# Copyright © 2002-2003 BitmixSoft. All rights reserved.   #
#                                                          #
# http://www.scriptdemo.com/php-jobsite/                   #
# File: application_config_file.php                        #
# Last update: 08/04/2003                                  #
############################################################
define('HTTP_SERVER','http://localhost/php-jobsite1_26/');
define('HTTPS_SERVER','https://localhost/php-jobsite1_26/');
define('HTTP_SERVER_ADMIN','http://localhost/php-jobsite1_26/admin/');
define('DIR_SERVER_ROOT','W:\\www\\php-jobsite1_26/');

define('DB_SERVER_TYPE', 'mysql');
define('DB_SERVER','localhost');
define('DB_SERVER_USERNAME','root');
define('DB_SERVER_PASSWORD','');
define('DB_DATABASE','job');

  #######################################################
#                  !!!!!!!!!!!                            #
#  Do not edit below only if you know what are you doing  #
#                  !!!!!!!!!!!                            #
  #######################################################

define('DIR_FUNCTIONS',DIR_SERVER_ROOT.'functions/');
define('DIR_LANGUAGES', DIR_SERVER_ROOT.'languages/');
define('DIR_FORMS',DIR_SERVER_ROOT.'forms/');
define('DIR_ADMIN',DIR_SERVER_ROOT.'admin/');
define('DIR_JS',DIR_SERVER_ROOT.'js/');
define('DIR_LOGO',DIR_SERVER_ROOT.'logo/');
define('HTTP_LOGO',HTTP_SERVER.'logo/');
define('HTTP_IMAGES',HTTP_SERVER.'other/');
define('DIR_IMAGES',DIR_SERVER_ROOT.'other/');
define('HTTP_FLAG',HTTP_SERVER.'other/flags/');
define('DIR_FLAG',DIR_SERVER_ROOT.'other/flags/');
define('DIR_RESUME',DIR_SERVER_ROOT.'resumes/');
define('HTTP_RESUME',HTTP_SERVER.'resumes/');

include(DIR_SERVER_ROOT."application_settings.php");

define('FILENAME_INDEX','index.php');
define('FILENAME_LEFT_NAVIGATION','left_navigation.php');
define('FILENAME_LOGIN','login.php');
define('FILENAME_LOGOUT','logout.php');
define('FILENAME_LOGIN_PROCESS','login_process.php');
define('FILENAME_JOB_SEEKER','jobseeker.php');
define('FILENAME_JOB_FIND','jobfind.php');
define('FILENAME_RESUMES_FIND','resumesfind.php');
define('FILENAME_EMPLOYER','employer.php');
define('FILENAME_SEARCH','search.php');
define('FILENAME_SEARCH_JOB_FORM','search_job_form.php');
define('FILENAME_SEARCH_RESUME_FORM','search_resume_form.php');
define('FILENAME_JOBFIND_FORM','job_find_form.php');
define('FILENAME_RESUMESFIND_FORM','resumes_find_form.php');
define('FILENAME_JOBSEEKER','jobseeker.php');
define('FILENAME_JOBSEEKER_FORM','jobseeker_form.php');
define('FILENAME_PERSONAL','personal.php');
define('FILENAME_PERSONAL_FORM','personal_form.php');
define('FILENAME_DELACCOUNT','delaccount.php');
define('FILENAME_DELACCOUNT_FORM','delaccount_form.php');
define('FILENAME_EMPLOYER_FORM','employer_form.php');
define('FILENAME_COMPANY','company.php');
define('FILENAME_COMPANY_FORM','company_form.php');
define('FILENAME_JOB_FORM','job_form.php');
define('FILENAME_VIEW','view.php');
define('FILENAME_VIEW_FORM','view_form.php');
define('FILENAME_LOGIN_FORM','login_form.php');
define('FILENAME_RIGHT_NAVIGATION','right_navigation.php');
define('FILENAME_ERROR_LOGIN','error_login.php');
define('FILENAME_MEMBERSHIP','planning.php');
define('FILENAME_MEMBERSHIP_FORM','planning_form.php');
define('FILENAME_INVOICES','invoices.php');
define('FILENAME_INVOICES_FORM','invoices_form.php');
define('FILENAME_SEARCH_RESUMES','search_resumes.php');
define('FILENAME_PAYMENT','payment.php');
define('FILENAME_PAYMENT_FORM','payment_form.php');
define('FILENAME_PROCESSING','processing.php');
define('FILENAME_PROCESSING_FORM','processing_form.php');
define('FILENAME_JOBMAIL','jobmail.php');
define('FILENAME_JOBMAIL_FORM','jobmail_form.php');
define('FILENAME_STATISTICS','statistics.php');
define('FILENAME_STATISTICS_FORM','statistics_form.php');
define('FILENAME_CONFIRM_JOB_DELETE_FORM','confirm_job_delete_form.php');
define('FILENAME_CONFIRM_RESUME_DELETE_FORM','confirm_resume_delete_form.php');
define('FILENAME_MYCOMPANY','mycompany.php');
define('FILENAME_MYCOMPANY_FORM','mycompany_form.php');
define('FILENAME_MYINVOICES','myinvoices.php');
define('FILENAME_MYINVOICES_FORM','myinvoices_form.php');
define('FILENAME_ERROR_FORM','error_form.php');
define('FILENAME_MESSAGE_FORM','message_form.php');
define('FILENAME_FORGOT_PASSWORDS','forgot_passwords.php');
define('FILENAME_FORGOT_PASSWORDS_FORM','forgot_passwords_form.php');
define('FILENAME_SUPPORT','support.php');
define('FILENAME_SUPPORT_FORM','support_form.php');
define('FILENAME_EMAIL_JOB','email_job.php');
define('FILENAME_EMAIL_JOB_FORM','email_job_form.php');
define('FILENAME_CC_BILLING_FORM','cc_billing_form.php');
define('FILENAME_HELP','help.php');
define('FILENAME_PRIVATE','private_message.php');
define('FILENAME_PRIVATE_FORM','private_message_form.php');

if(USE_FEATURED_COMPANIES == "yes") {
    $index_page_includes="include('".DIR_FORMS."featured_companies_form.php');";
}
if(USE_FEATURED_JOBS == "yes") {
    $index_page_includes.="include('".DIR_FORMS."featured_jobs_form.php');";
}
$index_page_includes.="include('".DIR_FORMS."quick_search_form.php');";
// customization for the design layout

include(DIR_SERVER_ROOT."design_configuration.php");
$bx_table_prefix.='phpjob';
$check_email=true;

include(DIR_FUNCTIONS . 'database.php');
include(DIR_FUNCTIONS . 'general.php');
include(DIR_FUNCTIONS . 'sessions.php');

// make a connection to the database... now
if (DB_CONNECT=="no") {
   
}
else {
    bx_db_connect() or die('Unable to connect to database server!');
}
//start the session management
if ($employerid) {
  $employerid='';
}
if ($userid) {
  $userid='';
}
session_cache_limiter("none");
if(CRON_JOB!="yes") {
    bx_session_start();    
}

if ($HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $HTTP_POST_VARS['compid'])) {
define('LEFT_NAVIGATION_WIDTH','0%');
define('RIGHT_NAVIGATION_WIDTH',RIGHT_NAV_WIDTH);
define('MAIN_NAVIGATION_WIDTH',MAIN_LNAV_WIDTH);
define('TABLE_HEADING_BGCOLOR', TABLE_EMPLOYER);
}
else if ($HTTP_SESSION_VARS['userid']){
define('LEFT_NAVIGATION_WIDTH',LEFT_NAV_WIDTH);
define('RIGHT_NAVIGATION_WIDTH','0%');
define('MAIN_NAVIGATION_WIDTH',MAIN_LNAV_WIDTH);
define('TABLE_HEADING_BGCOLOR', TABLE_JOBSEEKER);
  }
else {
define('LEFT_NAVIGATION_WIDTH',LEFT_NAV_WIDTH);
define('RIGHT_NAVIGATION_WIDTH',RIGHT_NAV_WIDTH);
define('MAIN_NAVIGATION_WIDTH',MAIN_NAV_WIDTH);
define('TABLE_HEADING_BGCOLOR', TABLE_JOBSEEKER);
}

//parse time log creation
define('STORE_PAGE_PARSE_TIME_LOG', DIR_SERVER_ROOT . 'logs/parse_time_log');
define('STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S');
define('PHP_JOBSITE_VERSION','1.26');
define('INSTALLATION_DATE','2003-08-01');
if (STORE_PAGE_PARSE_TIME == 'on') {
  $parse_start_time = microtime();
  $sql_query_time= 0;
}
//language support
if(CRON_JOB!="yes") {
        if(MULTILANGUAGE_SUPPORT == "on" && CRON_JOB!="yes") {
                if ($HTTP_GET_VARS['language'] && file_exists(DIR_LANGUAGES.$HTTP_GET_VARS['language'].".php")) {
                          $language=strtolower(urldecode($HTTP_GET_VARS['language']));
                          bx_session_unregister('language');
                          bx_session_register('language');
                          setcookie("phpjob_lng", $language, mktime(0,0,0,date('m')+3,date('d'),date('Y')));
                }
                else {
                        if (!bx_session_is_registered('language') && $HTTP_COOKIE_VARS['phpjob_lng'] && file_exists(DIR_LANGUAGES.$HTTP_COOKIE_VARS['phpjob_lng'].".php")) {
                              $language = strtolower($HTTP_COOKIE_VARS['phpjob_lng']);
                              bx_session_register('language');
                              setcookie("phpjob_lng", $language, mktime(0,0,0,date('m')+3,date('d'),date('Y')));
                        }
                        elseif (!bx_session_is_registered('language')) {
                              $language = strtolower(DEFAULT_LANGUAGE);
                              bx_session_register('language');
                              setcookie("phpjob_lng", $language, mktime(0,0,0,date('m')+3,date('d'),date('Y')));
                        }
                        elseif($HTTP_SESSION_VARS['language']){
                             $language = $HTTP_SESSION_VARS['language'];
                        }
                        else {
                            $language = DEFAULT_LANGUAGE;
                        }
                }
        }
        else {
                $language = DEFAULT_LANGUAGE;
		}
        if ($HTTP_SESSION_VARS['sessiontime']) {
            if (time()>$HTTP_SESSION_VARS['sessiontime']+(60*SESSION_EXPIRES)) {
                if ($HTTP_SESSION_VARS['userid']) {
                     $login="jobseeker";
                     bx_session_destroy();
                     header("Location: login.php?log=".$login);
                     bx_exit();
                }
                else if ($HTTP_SESSION_VARS['employerid']) {
                     $login="employer";
                     bx_session_destroy();
                     header("Location: login.php?log=".$login);
                     bx_exit();
                }
                else {
                    $sessiontime = time();
                    bx_session_register("sessiontime");
               }
            }
            else {
                $sessiontime = time();
                bx_session_register("sessiontime");
            }
        }
        $bx_session = bx_session_id();
}
else {
    $language = DEFAULT_LANGUAGE;
}
if (DEBUG_MODE == "yes") {
    set_time_limit(5);
}
$bx_table_lng = substr($language,0,2);
include(DIR_LANGUAGES.$language.'.php');
if ($DATE_FORMAT) {define('DATE_FORMAT', $DATE_FORMAT);}else{define('DATE_FORMAT', 'mm/dd/YYYY');}
if ($PRICE_FORMAT) {define('PRICE_FORMAT', $PRICE_FORMAT);}else{define('PRICE_FORMAT', '1,234.56');}
if(USE_IP_FILTER=="yes") {
     include(DIR_SERVER_ROOT."ip_banned.php");           
}
?>
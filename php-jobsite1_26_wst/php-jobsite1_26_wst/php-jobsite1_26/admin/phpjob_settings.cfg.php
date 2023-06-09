<?php
$fields[1]["name"]="Site name (will appear in email message as sender name)";
$fields[1]["define"]="SITE_NAME";
$fields[1]["default"]="Php-Jobsite 1.26";
$fields[2]["name"]="Site Title ( the site title will appear in the browser as the page title)";
$fields[2]["define"]="SITE_TITLE";
$fields[2]["default"]="Php-Jobsite 1.26";
$fields[3]["name"]="Encryption Phrase";
$fields[3]["define"]="CRYPT_PHRASE";
$fields[3]["default"]="This is a long phrase used to encrypt sensitive data here";
$fields[4]["name"]="Admin Email Address ( were email regarding payment, will be sent)";
$fields[4]["define"]="SITE_MAIL";
$fields[4]["default"]="zsoly@bitmixsoft.com";
$fields[5]["name"]="number of displayed items in a search/list";
$fields[5]["define"]="NR_DISPLAY";
$fields[5]["default"]="1";
$fields[6]["name"]="session expires after specified number of minutes/then the user have to login again";
$fields[6]["define"]="SESSION_EXPIRES";
$fields[6]["default"]="300";
$fields[7]["comment"][]="Only set the Debug Mode to yes when you want to see the database error messages";
$fields[7]["name"]="(radio yes,no)Debug Mode";
$fields[7]["define"]="DEBUG_MODE";
$fields[7]["default"]="yes";
$fields[8]["comment"][]="Employers Logo Image Settings";
$fields[8]["name"]="logo image max width";
$fields[8]["define"]="LOGO_MAX_WIDTH";
$fields[8]["default"]="120";
$fields[9]["name"]="logo image max height";
$fields[9]["define"]="LOGO_MAX_HEIGHT";
$fields[9]["default"]="60";
$fields[10]["name"]="logo image max size (bytes)";
$fields[10]["define"]="LOGO_MAX_SIZE";
$fields[10]["default"]="10000";
$fields[11]["comment"][]="Show Statistics on the top of the page (# of employers, jobseekers, jobs, resumes)";
$fields[11]["name"]="(radio yes,no)Show statistics?";
$fields[11]["define"]="SHOW_STATISTICS_BAR";
$fields[11]["default"]="yes";
$fields[12]["comment"][]="Show Statistics on the top of the admin page (# of employers, jobseekers, jobs, resumes)";
$fields[12]["name"]="(radio yes,no)Show statistics for admin?";
$fields[12]["define"]="SHOW_STATISTICS_ADMIN_BAR";
$fields[12]["default"]="yes";
$fields[13]["comment"][]="Writing information to the log file (date, IP address, Host, Browser type, compilation time etc.)";
$fields[13]["comment"][]="For more details on how is this look like please visit [Script Management]->[Log file Statistics]";
$fields[13]["name"]="(radio on,off)write log file";
$fields[13]["define"]="STORE_PAGE_PARSE_TIME";
$fields[13]["default"]="on";
$fields[14]["comment"][]="";
$fields[14]["name"]="(radio yes,no)Use IP Filter";
$fields[14]["define"]="USE_IP_FILTER";
$fields[14]["default"]="no";
$fields[15]["comment"][]="Comma (,) separated list with all the IP Address which are not allowed to access your site";
$fields[15]["name"]="Ip Address Filter List";
$fields[15]["define"]="IP_FILTER_LIST";
$fields[15]["default"]="";
$fields[16]["comment"][]="The default language used by the script, the language have to exist (created in this Admin Area), or use the original english language, which comes with the script";
$fields[16]["name"]=$def_lang_select."default language";
$fields[16]["define"]="DEFAULT_LANGUAGE";
$fields[16]["default"]="english";
$fields[17]["comment"][]="Multilanguage support option, possible values are on - off";
$fields[17]["comment"][]="If you set it to off the default language will be used as the only language available.";
$fields[17]["name"]="(radio on,off)multilanguage support";
$fields[17]["define"]="MULTILANGUAGE_SUPPORT";
$fields[17]["default"]="on";
$fields[18]["comment"][]="Posting language option, possible values are on - off";
$fields[18]["comment"][]="If you set it to off the default language will be used as the default posting language.";
$fields[18]["name"]="(radio on,off)posting language";
$fields[18]["define"]="POSTING_LANGUAGE";
$fields[18]["default"]="on";
$fields[19]["comment"][]="Required languages option, possible values are on - off";
$fields[19]["comment"][]="If you set it to off the default language will be used as the default required language.";
$fields[19]["name"]="(radio on,off)required languages";
$fields[19]["define"]="REQUIRED_LANGUAGE";
$fields[19]["default"]="on";
$fields[20]["comment"][]="If you set the this option to yes, all information posted either by jobseeker or employer will be searched/replaced for words from the list above";
$fields[20]["name"]="(radio yes,no)Use Dirty words filter?";
$fields[20]["define"]="USE_DIRTY_WORDS";
$fields[20]["default"]="yes";
$fields[21]["comment"][]="Use a comma to separate the words in the Dirty words list";
$fields[21]["name"]="Dirty words list";
$fields[21]["define"]="DIRTY_WORDS";
$fields[21]["default"]="fuck, cunt, shit, asshole, ";
$fields[22]["name"]="Dirty words will be replaced by";
$fields[22]["define"]="DIRTY_WORDS_REPLACEMENT";
$fields[22]["default"]="****";
$fields[23]["comment"][]="Notify admin in email about planning(membership) expiration and deletion, possible values are \"yes\" - \"no\"";
$fields[23]["name"]="(radio yes,no)Notify admin in email about planning expirations?";
$fields[23]["define"]="PLANNING_EXPIRE_NOTIFY_ADMIN";
$fields[23]["default"]="yes";
$fields[24]["name"]="(radio yes,no)Notify employer in email about his/her planning expiration?";
$fields[24]["define"]="PLANNING_EXPIRE_NOTIFY_EMPLOYER";
$fields[24]["default"]="yes";
$fields[25]["comment"][]="Set the number of days to notify the employer before his/her planning is about to expire";
$fields[25]["comment"][]="Set this to 0 and employer will not be notified about planning expiration only when is deleted";
$fields[25]["name"]="notify employer with specified number of days about planning expiration";
$fields[25]["define"]="NOTIFY_EMPLOYER_PLANNING_EXPIRE_DAY";
$fields[25]["default"]="5";
$fields[26]["comment"][]="Allow jobseekers to hide their resumes from employers when searching";
$fields[26]["comment"][]="But allow to apply for jobs";
$fields[26]["name"]="(radio yes,no)Jobseekers can hide his/her resume?";
$fields[26]["define"]="HIDE_RESUME";
$fields[26]["default"]="yes";
$fields[27]["comment"][]="Automatically subscribe Jobseekers to Daily Jobmail Agent when his/her resume is posted";
$fields[27]["name"]="(radio yes,no)Jobmail Auto Subscribe";
$fields[27]["define"]="JOBMAIL_AUTO";
$fields[27]["default"]="yes";
$fields[28]["comment"][]="Posted resume expire option, possible values are \"yes\" - \"no\"";
$fields[28]["comment"][]="If you set it to \"no\" the resume posted by the jobseeker will stay in the system until the jobseeker account is not deleted.";
$fields[28]["name"]="(radio yes,no)Should posted resume expire?";
$fields[28]["define"]="RESUME_EXPIRE";
$fields[28]["default"]="yes";
$fields[29]["comment"][]="Reactivate Option - resumes after expiration will not be deleted and jobseekers can reactivate it when they login.";
$fields[29]["name"]="(radio yes,no)Reactivate Resume Option after Expiration?";
$fields[29]["define"]="RESUME_REACTIVATE";
$fields[29]["default"]="yes";
$fields[30]["name"]="(radio yes,no)Notify jobseeker about his/her resume expiration and deletion/reactivation option?";
$fields[30]["define"]="NOTIFY_JOBSEEKER_RESUME_EXPIRE";
$fields[30]["default"]="yes";
$fields[31]["comment"][]="Set the number of days to notify the jobseeker before his/her resume is about to expire";
$fields[31]["comment"][]="Set this to 0 and jobseeker will not be notified about resume expiration only when is deleted/expired";
$fields[31]["name"]="notify jobseeker with specified number of days about resume expiration";
$fields[31]["define"]="NOTIFY_JOBSEEKER_RESUME_EXPIRE_DAY";
$fields[31]["default"]="5";
$fields[32]["comment"][]="Posted resume expires after specified number of days,months,years,";
$fields[32]["comment"][]="Attention, please modify only one (or day,or month, or year) and make the rest 0";
$fields[32]["comment"][]="Has effect if \"Should posted resume expire?\" is set to \"yes\"";
$fields[32]["name"]="posted resume expire after specified number of days";
$fields[32]["define"]="RESUME_EXPIRE_DAY";
$fields[32]["default"]="0";
$fields[33]["name"]="posted resume expire after specified number of months";
$fields[33]["define"]="RESUME_EXPIRE_MONTH";
$fields[33]["default"]="3";
$fields[34]["name"]="posted resume expire after specified number of years";
$fields[34]["define"]="RESUME_EXPIRE_YEAR";
$fields[34]["default"]="0";
$fields[35]["comment"][]="Notify admin in email about resume expiration and deletion, possible values are \"yes\" - \"no\"";
$fields[35]["name"]="(radio yes,no)Notify admin in email about resume expiration?";
$fields[35]["define"]="RESUME_EXPIRE_NOTIFY_ADMIN";
$fields[35]["default"]="yes";
$fields[36]["name"]="(radio yes,no)Notify employer about his/her job expiration and deletion?";
$fields[36]["define"]="NOTIFY_EMPLOYER_JOB_EXPIRE";
$fields[36]["default"]="yes";
$fields[37]["comment"][]="Set the number of days to notify the employer before his/her job is about to expire";
$fields[37]["comment"][]="Set this to 0 and employer will not be notified about job expiration only when is deleted";
$fields[37]["name"]="notify employer with specified number of days about job expiration";
$fields[37]["define"]="NOTIFY_EMPLOYER_JOB_EXPIRE_DAY";
$fields[37]["default"]="5";
$fields[38]["comment"][]="Job expires after specified number of days,months,years,";
$fields[38]["comment"][]="Attention, please modify only one (or day,or month, or year) and make the rest 0";
$fields[38]["name"]="job expire after specified number of days";
$fields[38]["define"]="JOB_EXPIRE_DAY";
$fields[38]["default"]="0";
$fields[39]["name"]="jobs expire after specified number of months";
$fields[39]["define"]="JOB_EXPIRE_MONTH";
$fields[39]["default"]="3";
$fields[40]["name"]="jobs expire after specified number of years";
$fields[40]["define"]="JOB_EXPIRE_YEAR";
$fields[40]["default"]="0";
$fields[41]["comment"][]="Notify admin in email about job expiration and deletion, possible values are \"yes\" - \"no\"";
$fields[41]["name"]="(radio yes,no)Notify admin in email about job expiration?";
$fields[41]["define"]="JOB_EXPIRE_NOTIFY_ADMIN";
$fields[41]["default"]="yes";
$fields[42]["name"]="1 job's price on extra job purchase";
$fields[42]["define"]="JOBS_PRICE";
$fields[42]["default"]="5";
$fields[43]["name"]="1 featured job's price on extra job purchase";
$fields[43]["define"]="FEATURED_JOBS_PRICE";
$fields[43]["default"]="10";
$fields[44]["name"]="1 resume consult price on extra purchase";
$fields[44]["define"]="RESUMES_PRICE";
$fields[44]["default"]="2";
$fields[45]["comment"][]="Automatically subscribe Employer's to Daily Resumemail Agent when a job is posted";
$fields[45]["name"]="(radio yes,no)Resumemail Auto Subscribe";
$fields[45]["define"]="RESUMEMAIL_AUTO";
$fields[45]["default"]="yes";
$fields[46]["name"]="(radio yes,no)Use Featured Jobs";
$fields[46]["define"]="USE_FEATURED_JOBS";
$fields[46]["default"]="yes";
$fields[47]["comment"][]="Featured Jobs should be displayed:";
$fields[47]["comment"][]="1 - Random Selected - Without Order";
$fields[47]["comment"][]="2 - Random Selected - Ordered by Post Date Descending";
$fields[47]["comment"][]="3 - Not Random Selected - Ordered by Post Date Descending";
$fields[47]["name"]="(select 1,2,3)Featured Jobs Order";
$fields[47]["define"]="FEATURED_ORDER";
$fields[47]["default"]="2";
$fields[48]["comment"][]="Featured Companies should be displayed:";
$fields[48]["comment"][]="1 - Random Selected - Without Order";
$fields[48]["comment"][]="2 - Random Selected - Ordered by Registration Date Descending";
$fields[48]["comment"][]="3 - Not Random Selected - Ordered by Registration Date Descending";
$fields[48]["name"]="(select 1,2,3)Featured Companies Order";
$fields[48]["define"]="FEATURED_COMPANY_ORDER";
$fields[48]["default"]="1";
$fields[49]["name"]="(radio yes,no)Use Featured Companies";
$fields[49]["define"]="USE_FEATURED_COMPANIES";
$fields[49]["default"]="yes";
$fields[50]["name"]="currency sign for job/resume purchase";
$fields[50]["define"]="PRICE_CURENCY";
$fields[50]["default"]="USD";
$fields[51]["name"]="(radio right,left)currency sign position";
$fields[51]["define"]="CURRENCY_POSITION";
$fields[51]["default"]="right";
$fields[52]["name"]="number of featured companies to list on homepage";
$fields[52]["define"]="FEATURED_COMPANIES_NUMBER";
$fields[52]["default"]="3";
$fields[53]["name"]="number of featured jobs to list on homepage";
$fields[53]["define"]="FEATURED_JOBS_NUMBER";
$fields[53]["default"]="3";
$fields[54]["comment"][]="Should we use discounts?";
$fields[54]["name"]="(radio yes,no)Use Discounts";
$fields[54]["define"]="USE_DISCOUNT";
$fields[54]["default"]="yes";
$fields[55]["name"]="your discount percent to upgrade (until isn't changed)";
$fields[55]["define"]="DISCOUNT_PROCENT";
$fields[55]["default"]="5";
$fields[56]["name"]="discount percent for additional job/resume purchase";
$fields[56]["define"]="DISCOUNT_PROCENT_JOBS";
$fields[56]["default"]="2";
$fields[57]["name"]="(radio yes,no)Use VAT  - Value Added Tax?";
$fields[57]["define"]="USE_VAT";
$fields[57]["default"]="yes";
$fields[58]["name"]="VAT percent";
$fields[58]["define"]="VAT_PROCENT";
$fields[58]["default"]="11.11";
$fields[59]["comment"][]=" some fields required size (to be accepted as valid)";
$fields[59]["name"]="name size";
$fields[59]["define"]="ENTRY_NAME_MIN_LENGTH";
$fields[59]["default"]="3";
$fields[60]["name"]="company name size";
$fields[60]["define"]="ENTRY_COMPANY_MIN_LENGTH";
$fields[60]["default"]="3";
$fields[61]["name"]="job title size";
$fields[61]["define"]="ENTRY_TITLE_MIN_LENGTH";
$fields[61]["default"]="3";
$fields[62]["name"]="address size";
$fields[62]["define"]="ENTRY_ADDRESS_MIN_LENGTH";
$fields[62]["default"]="3";
$fields[63]["name"]="city size";
$fields[63]["define"]="ENTRY_CITY_MIN_LENGTH";
$fields[63]["default"]="3";
$fields[64]["name"]="postalcode size";
$fields[64]["define"]="ENTRY_POSTALCODE_MIN_LENGTH";
$fields[64]["default"]="3";
$fields[65]["name"]="phone size";
$fields[65]["define"]="ENTRY_PHONE_MIN_LENGTH";
$fields[65]["default"]="3";
$fields[66]["comment"][]="Set size to 0 if you don't want the jobseekers to enter their Birth Year";
$fields[66]["name"]="birthyear size";
$fields[66]["define"]="ENTRY_BIRTHYEAR_LENGTH";
$fields[66]["default"]="4";
$fields[67]["name"]="email size";
$fields[67]["define"]="ENTRY_EMAIL_MIN_LENGTH";
$fields[67]["default"]="3";
$fields[68]["name"]="password size";
$fields[68]["define"]="ENTRY_PASSWORD_MIN_LENGTH";
$fields[68]["default"]="6";
$fields[69]["name"]="description size";
$fields[69]["define"]="ENTRY_DESCRIPTION_MIN_LENGTH";
$fields[69]["default"]="3";
$fields[70]["name"]="resume summary size";
$fields[70]["define"]="ENTRY_SUMMARY_MIN_LENGTH";
$fields[70]["default"]="3";
$fields[71]["comment"][]="";
$fields[71]["name"]="(radio yes,no)Ask Gender Information from Jobseekers";
$fields[71]["define"]="ASK_GENDER_INFO";
$fields[71]["default"]="yes";
$fields[72]["name"]="Meta Keywords";
$fields[72]["define"]="META";
$fields[72]["default"]="<meta name=\"copyright\" content=\"Copyright � 2002 - BitmixSoft. All rights reserved.\">'.\"\"\"\"\"\"\"\"\"\"\"\n\"\"\"\"\"\"\"\"\"\"\".'<meta name=\"keywords\" content=\"phjobsite, jobsite, recruitment, job posting\">'.\"\"\"\n\"\"\".'<meta name=\"description\" content=\"A site for international recruitment...\">";
$fields[73]["name"]="(radio yes,no)Jobmail/Resumemail TEST MODE";
$fields[73]["define"]="TEST_MODE";
$fields[73]["default"]="yes";
$fields[74]["comment"][]="Cron Jobs options:";
$fields[74]["comment"][]="crontab - Runned By Crontab - More info on the Cron Jobs Section";
$fields[74]["comment"][]="internal - No Crontab - runned internally by the script";
$fields[74]["name"]="(select crontab,internal)Cron Type";
$fields[74]["define"]="CRON_TYPE";
$fields[74]["default"]="crontab";
?>
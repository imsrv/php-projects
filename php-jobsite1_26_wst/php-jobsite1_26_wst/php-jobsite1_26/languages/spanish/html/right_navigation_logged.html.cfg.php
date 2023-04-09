<?php
include(DIR_LANGUAGES.$language."/".FILENAME_RIGHT_NAVIGATION);
$fields = array (
       "match1" => array("%%NAV_BG_COLOR%%","Navigation Bgcolor - Customizable from Admin - Layout Manager",LEFT_NAV_BG_COLOR,"<?php echo LEFT_NAV_BG_COLOR;?>"),
       "match2" => array("%%EMPLOYER_COLOR%%","Employer Color - Customizable from Admin - Layout Manager",TABLE_EMPLOYER,"<?php echo TABLE_EMPLOYER;?>"),
       "match3" => array("%%TEXT_EMPLOYER%%","\"Employer\" - Language Text",TEXT_RIGHT_EMPLOYER,"<?php echo TEXT_RIGHT_EMPLOYER;?>"),
       "match4" => array("%%IMG_PIXEL%%","Pixel Image with width and height",bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,""),"<?php echo bx_image_width(HTTP_IMAGES.\$language.\"/pix-t.gif\",1,1,0,\"\");;?>"),
       "match5" => array("%%HOME_LINK%%","Link to Employer Home",HTTP_SERVER.FILENAME_EMPLOYER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, \"auth_sess\", \$bx_session);?>"),
       "match6" => array("%%TEXT_HOME%%","\"Home\" - Language Text",TEXT_HOME,"<?php echo TEXT_HOME;?>"),
       "match7" => array("%%LOGOUT_LINK%%","Link to Employer Logout",HTTP_SERVER.FILENAME_LOGOUT."?employer=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGOUT.\"?employer=true\", \"auth_sess\", \$bx_session);?>"),
       "match8" => array("%%TEXT_LOGOUT%%","\"Logout\" - Language text",TEXT_LOGOUT,"<?php echo TEXT_LOGOUT;?>"),
       "match9" => array("%%MYCOMPANY_LINK%%","Link to Employer Company Information",HTTP_SERVER.FILENAME_MYCOMPANY,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, \"auth_sess\", \$bx_session);?>"),
       "match10" => array("%%TEXT_MYCOMPANY%%","\"My Company\" - Language text",TEXT_MYCOMPANY,"<?php echo TEXT_MYCOMPANY;?>"),
       "match11" => array("%%PROFILE_LINK%%","Link to Employer Profile",HTTP_SERVER.FILENAME_COMPANY."?action=comp_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY.\"?action=comp_form\", \"auth_sess\", \$bx_session);?>"),
       "match12" => array("%%TEXT_MODIFY_PROFILE%%","\"Modify Profile\" - Language text",TEXT_MODIFY_PROFILE,"<?php echo TEXT_MODIFY_PROFILE;?>"),
       "match13" => array("%%PLANNING_LINK%%","Link to Employer Planning",HTTP_SERVER.FILENAME_MEMBERSHIP,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, \"auth_sess\", \$bx_session);?>"),
       "match14" => array("%%TEXT_PLANNING%%","\"Planning\" - Language text",TEXT_PLANNING,"<?php echo TEXT_PLANNING;?>"),
       "match15" => array("%%INVOICES_LINK%%","Link to Employer Invoices",HTTP_SERVER.FILENAME_MYINVOICES,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, \"auth_sess\", \$bx_session);?>"),
       "match16" => array("%%TEXT_INVOICING%%","\"Invoices\" - Language text",TEXT_INVOICING,"<?php echo TEXT_INVOICING;?>"),
       "match17" => array("%%MYJOBS_LINK%%","Link to Employer Jobs",HTTP_SERVER.FILENAME_EMPLOYER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, \"auth_sess\", \$bx_session);?>"),
       "match18" => array("%%TEXT_MYJOBS%%","\"My Jobs\"  - Language text",TEXT_POST_JOB,"<?php echo TEXT_POST_JOB;?>"),
       "match19" => array("%%ADDJOB_LINK%%","Link to Employer Add Job",HTTP_SERVER.FILENAME_EMPLOYER."?action=job_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER.\"?action=job_form\", \"auth_sess\", \$bx_session);?>"),
       "match20" => array("%%TEXT_ADD_JOB%%","\"Add Job\" - Language text",TEXT_ADD_JOB,"<?php echo TEXT_ADD_JOB;?>"),
       "match21" => array("%%SEARCH_RESUMES_LINK%%","Link to Employer Search Resumes",HTTP_SERVER.FILENAME_SEARCH."?search=resumes","<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH.\"?search=resumes\", \"auth_sess\", \$bx_session);?>"),
       "match22" => array("%%TEXT_SEARCH_RESUMES%%","\"Search Resumes\" - Language text",TEXT_SEARCH_RESUMES,"<?php echo TEXT_SEARCH_RESUMES;?>"),
       "match23" => array("%%SUPPORT_LINK%%","Link to Employer Support",HTTP_SERVER.FILENAME_SUPPORT,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, \"auth_sess\", \$bx_session);?>"),
       "match24" => array("%%TEXT_SUPPORT%%","\"Employer Support\" - Language text",TEXT_ESUPPORT,"<?php echo TEXT_ESUPPORT;?>"),
       "match25" => array("%%DELACCOUNT_LINK%%","Link to Employer DelAccount",HTTP_SERVER.FILENAME_DELACCOUNT."?employer=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_DELACCOUNT.\"?employer=true\", \"auth_sess\", \$bx_session);?>"),
       "match26" => array("%%TEXT_DELETE_ACCOUNT%%","\"Delete Account\" - Language text",TEXT_DELETE_ACCOUNT,"<?php echo TEXT_DELETE_ACCOUNT;?>"),
       "match27" => array("%%EMPLOYER_JOBSTAT_BOX%%","Employer Box with Job Statistics, numebr of viewed jobs","","<?php include(DIR_FORMS.\"jobview_form.php\");?>"),
       "match28" => array("%%ACCOUNT_STAT_BOX%%","Employer Account Statistics - numebr of jobs to post, featured jobs to post...etc","","<?php include(DIR_FORMS.\"account_statistics_form.php\");?>")
);
?>
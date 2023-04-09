<?php
include(DIR_LANGUAGES.$language."/".FILENAME_RIGHT_NAVIGATION);
$fields = array (
       "match1" => array("%%NAV_BG_COLOR%%","Navigation Bgcolor - Customizable from Admin - Layout Manager",LEFT_NAV_BG_COLOR,"<?php echo LEFT_NAV_BG_COLOR;?>"),
       "match2" => array("%%EMPLOYER_COLOR%%","Employer Color - Customizable from Admin - Layout Manager",TABLE_EMPLOYER,"<?php echo TABLE_EMPLOYER;?>"),
       "match3" => array("%%TEXT_EMPLOYER%%","\"Employer\" - Language Text",TEXT_RIGHT_EMPLOYER,"<?php echo TEXT_RIGHT_EMPLOYER;?>"),
       "match4" => array("%%IMG_PIXEL%%","Pixel Image with width and height",bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,""),"<?php echo bx_image_width(HTTP_IMAGES.\$language.\"/pix-t.gif\",1,1,0,\"\");;?>"),
       "match5" => array("%%EMPLOYER_LOGIN_BOX%%","Employer Login Box - with email, password and forgott password link","","<?php \$tolog=\"employer\"; include(DIR_FORMS.\"nav_login_form.php\");?>"),
       "match6" => array("%%HOME_LINK%%","Link to Employer Home",HTTP_SERVER.FILENAME_EMPLOYER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, \"auth_sess\", \$bx_session);?>"),
       "match7" => array("%%TEXT_HOME%%","\"Home\" - Language Text",TEXT_HOME,"<?php echo TEXT_HOME;?>"),
       "match8" => array("%%REGISTER_LINK%%","Link to Employer Registration",HTTP_SERVER.FILENAME_COMPANY."?action=new","<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY.\"?action=new\", \"auth_sess\", \$bx_session);?>"),
       "match9" => array("%%TEXT_REGISTRATION%%","\"Free Registration\" - Language text",TEXT_REGISTRATION,"<?php echo TEXT_REGISTRATION;?>"),
       "match10" => array("%%FORGOT_LINK%%","Link to Employer Forgot Password",HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS.\"?employer=true\", \"auth_sess\", \$bx_session);?>"),
       "match11" => array("%%TEXT_FORGOT_PASSWORD%%","\"Forgot Password\" - Language text",TEXT_FORGOT_PASSWORD,"<?php echo TEXT_FORGOT_PASSWORD;?>"),
       "match12" => array("%%MYCOMPANY_LINK%%","Link to Employer Company Information",HTTP_SERVER.FILENAME_MYCOMPANY,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYCOMPANY, \"auth_sess\", \$bx_session);?>"),
       "match13" => array("%%TEXT_MYCOMPANY%%","\"My Company\" - Language text",TEXT_MYCOMPANY,"<?php echo TEXT_MYCOMPANY;?>"),
       "match14" => array("%%PROFILE_LINK%%","Link to Employer Profile",HTTP_SERVER.FILENAME_COMPANY."?action=comp_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY.\"?action=comp_form\", \"auth_sess\", \$bx_session);?>"),
       "match15" => array("%%TEXT_MODIFY_PROFILE%%","\"Modify Profile\" - Language text",TEXT_MODIFY_PROFILE,"<?php echo TEXT_MODIFY_PROFILE;?>"),
       "match16" => array("%%PLANNING_LINK%%","Link to Employer Planning",HTTP_SERVER.FILENAME_MEMBERSHIP,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, \"auth_sess\", \$bx_session);?>"),
       "match17" => array("%%TEXT_PLANNING%%","\"Planning\" - Language text",TEXT_PLANNING,"<?php echo TEXT_PLANNING;?>"),
       "match18" => array("%%INVOICES_LINK%%","Link to Employer Invoices",HTTP_SERVER.FILENAME_MYINVOICES,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, \"auth_sess\", \$bx_session);?>"),
       "match19" => array("%%TEXT_INVOICING%%","\"Invoices\" - Language text",TEXT_INVOICING,"<?php echo TEXT_INVOICING;?>"),
       "match20" => array("%%MYJOBS_LINK%%","Link to Employer Jobs",HTTP_SERVER.FILENAME_EMPLOYER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER, \"auth_sess\", \$bx_session);?>"),
       "match21" => array("%%TEXT_MYJOBS%%","\"My Jobs\"  - Language text",TEXT_POST_JOB,"<?php echo TEXT_POST_JOB;?>"),
       "match22" => array("%%ADDJOB_LINK%%","Link to Employer Add Job",HTTP_SERVER.FILENAME_EMPLOYER."?action=job_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMPLOYER.\"?action=job_form\", \"auth_sess\", \$bx_session);?>"),
       "match23" => array("%%TEXT_ADD_JOB%%","\"Add Job\" - Language text",TEXT_ADD_JOB,"<?php echo TEXT_ADD_JOB;?>"),
       "match24" => array("%%SEARCH_RESUMES_LINK%%","Link to Employer Search Resumes",HTTP_SERVER.FILENAME_SEARCH."?search=resumes","<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH.\"?search=resumes\", \"auth_sess\", \$bx_session);?>"),
       "match25" => array("%%TEXT_SEARCH_RESUMES%%","\"Search Resumes\" - Language text",TEXT_SEARCH_RESUMES,"<?php echo TEXT_SEARCH_RESUMES;?>"),
       "match26" => array("%%SUPPORT_LINK%%","Link to Employer Support",HTTP_SERVER.FILENAME_SUPPORT,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, \"auth_sess\", \$bx_session);?>"),
       "match27" => array("%%TEXT_SUPPORT%%","\"Employer Support\" - Language text",TEXT_ESUPPORT,"<?php echo TEXT_ESUPPORT;?>")
);
?>
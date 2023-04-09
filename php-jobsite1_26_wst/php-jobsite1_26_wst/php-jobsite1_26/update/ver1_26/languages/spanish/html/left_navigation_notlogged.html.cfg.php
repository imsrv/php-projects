<?php
include(DIR_LANGUAGES.$lng."/".FILENAME_LEFT_NAVIGATION);
$fields = array (
       "match1" => array("%%NAV_BG_COLOR%%","Left Navigation Bgcolor - Customizable from Admin - Layout Manager","#FFFFFF","<?php echo LEFT_NAV_BG_COLOR;?>"),
       "match2" => array("%%JOBSEEKER_COLOR%%","Jobseeker Color - Customizable from Admin - Layout Manager","#70CCFF","<?php echo TABLE_JOBSEEKER;?>"),
       "match3" => array("%%TEXT_JOBSEEKER%%","\"Jobseeker\" - Language Text","Jobseeker","<?php echo TEXT_LEFT_JOBSEEKER;?>"),
       "match4" => array("%%IMG_PIXEL%%","Pixel Image with width and height",bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,""),"<?php echo bx_image_width(HTTP_IMAGES.\$language.\"/pix-t.gif\",1,1,0,\"\");?>"),
       "match5" => array("%%JOBSEEKER_LOGIN_BOX%%","Jobseeker Login Box - with email, password and forgott password link","","<?php \$tolog=\"jobseeker\"; include(DIR_FORMS.\"nav_login_form.php\");?>"),
       "match6" => array("%%HOME_LINK%%","Link to Jobseeker Home",HTTP_SERVER.FILENAME_INDEX,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_INDEX, \"auth_sess\", \$bx_session);?>"),
       "match7" => array("%%TEXT_HOME%%","\"Home\" - Language Text",TEXT_HOME,"<?php echo TEXT_HOME;?>"),
       "match8" => array("%%REGISTER_LINK%%","Link to Jobseeker Registration",HTTP_SERVER.FILENAME_PERSONAL."?action=new","<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL.\"?action=new\", \"auth_sess\", \$bx_session);?>"),
       "match9" => array("%%TEXT_REGISTRATION%%","\"Free Registration\" - Language text",TEXT_REGISTRATION,"<?php echo TEXT_REGISTRATION;?>"),
       "match10" => array("%%FORGOT_LINK%%","Link to Jobseeker Forgot Password",HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS.\"?jobseeker=true\", \"auth_sess\", \$bx_session);?>"),
       "match11" => array("%%TEXT_FORGOT_PASSWORD%%","\"Forgot Password\" - Language text",TEXT_FORGOT_PASSWORD,"<?php echo TEXT_FORGOT_PASSWORD;?>"),
       "match12" => array("%%JOBMAIL_LINK%%","Link to Jobseeker JobMail",HTTP_SERVER.FILENAME_JOBMAIL,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, \"auth_sess\", \$bx_session);?>"),
       "match13" => array("%%TEXT_JOBMAIL%%","\"Jobmail\" - Language text",TEXT_JOBMAIL,"<?php echo TEXT_JOBMAIL;?>"),
       "match14" => array("%%MYACCOUNT_LINK%%","Link to Jobseeker Account",HTTP_SERVER.FILENAME_PERSONAL."?action=pers_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL.\"?action=pers_form\", \"auth_sess\", \$bx_session);?>"),
       "match15" => array("%%TEXT_MYACCOUNT%%","\"My Account\" - Language text",TEXT_MYACCOUNT,"<?php echo TEXT_MYACCOUNT;?>"),
       "match16" => array("%%MYRESUME_LINK%%","Link to Jobseeker Resume (Post - Edit)",HTTP_SERVER.FILENAME_JOB_SEEKER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_SEEKER, \"auth_sess\", \$bx_session);?>"),
       "match17" => array("%%TEXT_MYRESUME%%","\"My Resume\" - Language text",TEXT_POST_RESUME,"<?php echo (\$HTTP_SESSION_VARS['post_resumeid'])?TEXT_MODIFY_RESUME:TEXT_POST_RESUME;?>"),
       "match18" => array("%%SEARCH_LINK%%","Link to Jobseeker Search Jobs - Advanced",HTTP_SERVER.FILENAME_SEARCH."?search=job","<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH.\"?search=job\", \"auth_sess\", \$bx_session);?>"),
       "match19" => array("%%TEXT_SEARCH_JOB%%","\"Search Job\" Language text",TEXT_SEARCH_JOB,"<?php echo TEXT_SEARCH_JOB;?>"),
       "match20" => array("%%SUPPORT_LINK%%","Link to Jobseeker Support Link",HTTP_SERVER.FILENAME_SUPPORT,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, \"auth_sess\", \$bx_session);?>"),
       "match21" => array("%%TEXT_SUPPORT%%","\"Jobseeker Support\" Language text",TEXT_JSUPPORT,"<?php echo TEXT_JSUPPORT;?>"),
       "match22" => array("%%QUICK_JOB_SEARCH_BOX%%","Quick Job Search Box - Categories and locations","","<?php include(DIR_FORMS.\"quick_job_search_form.php\");?>"),
       "match23" => array("%%FEATURED_COMPANIES_JOBS_BOX%%","Featured Companies Jobs Listing Box","","<?php include(DIR_FORMS.\"featured_companies_jobs_form.php\");?>")
);
?>
<?php
include(DIR_LANGUAGES.$lng."/".FILENAME_LEFT_NAVIGATION);
$fields = array (
       "match1" => array("%%NAV_BG_COLOR%%","Left Navigation Bgcolor - Customizable from Admin - Layout Manager","#FFFFFF","<?php echo LEFT_NAV_BG_COLOR;?>"),
       "match2" => array("%%JOBSEEKER_COLOR%%","Jobseeker Color - Customizable from Admin - Layout Manager","#70CCFF","<?php echo TABLE_JOBSEEKER;?>"),
       "match3" => array("%%TEXT_JOBSEEKER%%","\"Jobseeker\" - Language Text","Jobseeker","<?php echo TEXT_LEFT_JOBSEEKER;?>"),
       "match4" => array("%%IMG_PIXEL%%","Pixel Image with width and height",bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,""),"<?php echo bx_image_width(HTTP_IMAGES.\$language.\"/pix-t.gif\",1,1,0,\"\");?>"),
       "match5" => array("%%HOME_LINK%%","Link to Jobseeker Home",HTTP_SERVER.FILENAME_INDEX,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_INDEX, \"auth_sess\", \$bx_session);?>"),
       "match6" => array("%%TEXT_HOME%%","\"Home\" - Language Text",TEXT_HOME,"<?php echo TEXT_HOME;?>"),
       "match7" => array("%%LOGOUT_LINK%%","Link to Jobseeker Logout",HTTP_SERVER.FILENAME_LOGOUT."?user=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGOUT.\"?user=true\", \"auth_sess\", \$bx_session);?>"),
       "match8" => array("%%TEXT_LOGOUT%%","\"Logout\" - Language text",TEXT_LOGOUT,"<?php echo TEXT_LOGOUT;?>"),
       "match9" => array("%%JOBMAIL_LINK%%","Link to Jobseeker JobMail",HTTP_SERVER.FILENAME_JOBMAIL,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, \"auth_sess\", \$bx_session);?>"),
       "match10" => array("%%TEXT_JOBMAIL%%","\"Jobmail\" - Language text",TEXT_JOBMAIL,"<?php echo TEXT_JOBMAIL;?>"),
       "match11" => array("%%MYACCOUNT_LINK%%","Link to Jobseeker Account",HTTP_SERVER.FILENAME_PERSONAL."?action=pers_form","<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL.\"?action=pers_form\", \"auth_sess\", \$bx_session);?>"),
       "match12" => array("%%TEXT_MYACCOUNT%%","\"My Account\" - Language text",TEXT_MYACCOUNT,"<?php echo TEXT_MYACCOUNT;?>"),
       "match13" => array("%%MYRESUME_LINK%%","Link to Jobseeker Resume (Post - Edit)",HTTP_SERVER.FILENAME_JOB_SEEKER,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_SEEKER, \"auth_sess\", \$bx_session);?>"),
       "match14" => array("%%TEXT_MYRESUME%%","\"My Resume\" - Language text",TEXT_POST_RESUME,"<?php echo (\$HTTP_SESSION_VARS['post_resumeid'])?TEXT_MODIFY_RESUME:TEXT_POST_RESUME;?>"),
       "match15" => array("%%SEARCH_LINK%%","Link to Jobseeker Search Jobs - Advanced",HTTP_SERVER.FILENAME_SEARCH."?search=job","<?php echo bx_make_url(HTTP_SERVER.FILENAME_SEARCH.\"?search=job\", \"auth_sess\", \$bx_session);?>"),
       "match16" => array("%%TEXT_SEARCH_JOB%%","\"Search Job\" Language text",TEXT_SEARCH_JOB,"<?php echo TEXT_SEARCH_JOB;?>"),
       "match17" => array("%%SUPPORT_LINK%%","Link to Jobseeker Support Link",HTTP_SERVER.FILENAME_SUPPORT,"<?php echo bx_make_url(HTTP_SERVER.FILENAME_SUPPORT, \"auth_sess\", \$bx_session);?>"),
       "match18" => array("%%TEXT_SUPPORT%%","\"Jobseeker Support\" Language text",TEXT_JSUPPORT,"<?php echo TEXT_JSUPPORT;?>"),
       "match19" => array("%%DELACCOUNT_LINK%%","Link to Jobseeker Delete Account",HTTP_SERVER.FILENAME_DELACCOUNT."?jobseeker=true","<?php echo bx_make_url(HTTP_SERVER.FILENAME_DELACCOUNT.\"?jobseeker=true\", \"auth_sess\", \$bx_session);?>"),
       "match20" => array("%%TEXT_DELETE_ACCOUNT%%","\"Delete Account\" - Language Text",TEXT_DELETE_ACCOUNT,"<?php echo TEXT_DELETE_ACCOUNT;?>"),
       "match21" => array("%%QUICK_JOB_SEARCH_BOX%%","Quick Job Search Box - Categories and locations","","<?php include(DIR_FORMS.\"quick_job_search_form.php\");?>"),
       "match22" => array("%%FEATURED_COMPANIES_JOBS_BOX%%","Featured Companies Jobs Listing Box","","<?php include(DIR_FORMS.\"featured_companies_jobs_form.php\");?>")
);
?>
<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_RESUMES);
$jsfile="search.js";
include(DIR_SERVER_ROOT."header.php");
if ($HTTP_GET_VARS['search']=='job') {
       include(DIR_FORMS.FILENAME_SEARCH_JOB_FORM);
} //end if search job
if ($HTTP_GET_VARS['search']=='resumes') {
       if ($HTTP_SESSION_VARS['employerid']) //if the user is logged in
       {
            include(DIR_FORMS.FILENAME_SEARCH_RESUME_FORM);
       }
       else
       {  //the user is not logged in
            $login='employer';
            include(DIR_FORMS.FILENAME_LOGIN_FORM);
       }  //end else the user is not logged in
} //end if search resumes
include(DIR_SERVER_ROOT."footer.php");          
?>
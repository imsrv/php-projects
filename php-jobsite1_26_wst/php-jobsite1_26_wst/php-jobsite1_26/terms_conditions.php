<?php
include ('application_config_file.php');
if($HTTP_GET_VARS['type']) {
    include(DIR_LANGUAGES.$language.'/html/terms_conditions_'.$HTTP_GET_VARS['type'].'.html');    
}
else {
    include(DIR_LANGUAGES.$language.'/html/terms_conditions_jobseeker.html');
    include(DIR_LANGUAGES.$language.'/html/terms_conditions_employer.html');
}
?>
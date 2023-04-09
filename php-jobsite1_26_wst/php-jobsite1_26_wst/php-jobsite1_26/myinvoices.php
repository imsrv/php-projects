<?php
include ('application_config_file.php');
include(DIR_SERVER_ROOT."header.php");
if ($HTTP_SESSION_VARS['employerid']) {
             include(DIR_FORMS.FILENAME_MYINVOICES_FORM);
}
else
{
  $login='employer';
  include(DIR_FORMS.FILENAME_LOGIN_FORM);
}
include(DIR_SERVER_ROOT."footer.php");
?>
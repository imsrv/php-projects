<?php
include ('application_config_file.php');
include(DIR_SERVER_ROOT."header.php");
      // error_login form
      $error_message=LOGIN_ERROR;
      $back_url=bx_make_url(HTTP_SERVER.FILENAME_INDEX, "auth_sess", $bx_session);
      include(DIR_FORMS.FILENAME_ERROR_FORM);
include(DIR_SERVER_ROOT."footer.php");
?>
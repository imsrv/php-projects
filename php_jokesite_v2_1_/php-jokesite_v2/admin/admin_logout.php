<?php
include ('../config_file.php');
session_start();
session_unregister("adm_user");
session_unregister("adm_pass");
header("Location: ".HTTP_SERVER_ADMIN);
?>
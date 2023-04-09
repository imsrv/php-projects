<?php
session_start();
if (isset($_SESSION[eggblog])) {
  setcookie("eggblog_u","",time()-60*60*24,"/","$eggblog_domain",0);
  setcookie("eggblog_p","",time()-60*60*24,"/","$eggblog_domain",0);
  session_start();
  session_destroy();
  $ref = $_SERVER["HTTP_REFERER"];
  header("Location: $ref");
}
else {
  require_once("../_etc/header.php");
  echo "		<p><b>You are not currently logged in.</b></p>\n		<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
  require_once("../_etc/footer.php");
}
?>
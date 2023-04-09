<?php
if (isset($_POST[username])) {
  $username=strtolower($_POST[username]);
  $password=strtolower($_POST[password]);
  require_once("../_etc/config.inc.php");
  require_once("../_etc/mysql.php");
  $count=mysql_result(mysql_query("SELECT count(*) FROM eggblog_members WHERE username='$username' AND password='$password'"),0);
  if ($count == 1) {
    if ($cookie == 1) {
      $md5_u=md5($username);
      $md5_p=md5($password);
      setcookie("eggblog_u",$md5_u,time()+60*60*24*31,"/","$eggblog_domain",0);
      setcookie("eggblog_p",$md5_p,time()+60*60*24*31,"/","$eggblog_domain",0);
    }
    session_start();
    $_SESSION[eggblog] = $username;
    $ref = $_SERVER["HTTP_REFERER"];
    header("Location: $ref");
  }
  else {
    require_once("../_etc/header.php");
    echo "		<p><br /></p>\n		<p><b>The username and password supplied do not match.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
    require_once("../_etc/footer.php");
  }
}
?>
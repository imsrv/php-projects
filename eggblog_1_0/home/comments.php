<?php
if (isset($comments)) {
  session_start();
  $username=strtolower($_SESSION[eggblog]);
  require_once("../_etc/config.inc.php");
  require_once("../_etc/mysql.php");
  $date=time();
  $sql="INSERT INTO eggblog_comments SET date='$date', article_id='$_POST[id]', author='$username', comments='$_POST[comments]'";
  if (mysql_query($sql)) {
    $ref = $_SERVER["HTTP_REFERER"];
    header("Location: blog.php?id=$_POST[id]#comments");
  }
  else {
    require_once("../_etc/header.php");
    echo "		<p><br /></p>\n		<p><b>There has been an error submitting your comments.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
    require_once("../_etc/footer.php");
  }
}
?>
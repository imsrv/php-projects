<?php
session_start();
if (isset($_SESSION[eggblog])) {
  require_once("../_etc/header.php");
  echo "		<p><b>You are already logged in.</b></p>\n		<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
  require_once("../_etc/footer.php");
}
else {
  if (isset($_POST[submit])) {
    require_once("../_etc/config.inc.php");
    require_once("../_etc/mysql.php");
    $username = strtolower($_POST[username]);
    $password = strtolower($_POST[password]);
    $sql = "INSERT INTO eggblog_members SET username='$username', password='$password', email='$_POST[email]'";
    if (mysql_query($sql)) {
      $_SESSION[eggblog] = $username;
      header("Location: $ref");
    }
    else {
      require_once("../_etc/header.php");
      require_once("../_etc/footer.php");
    }
  }
  else {
    require_once("../_etc/header.php");
    echo "		<p>Register your username - its free, quick and simple:</p>
		<form action=\"register.php\" method=\"post\">
			<p><label for=\"username\">Username:</label><br /><input type=\"text\" size=\"20\" id=\"username\" name=\"username\" /></p>
			<p><label for=\"password\">Password:</label><br /><input type=\"password\" size=\"20\" id=\"password\" name=\"password\" /></p>
			<p><label for=\"email\">Email:</label><br /><input type=\"text\" size=\"40\" id=\"email\" name=\"email\" /></p>
			<p><input type=\"hidden\" name=\"ref\" value=\"$_SERVER[HTTP_REFERER]\" /><input class=\"no\" type=\"submit\" size=\"20\" name=\"submit\" value=\"Register\" /></p>
		</form>\n";
    require_once("../_etc/footer.php");
  }
}
?>
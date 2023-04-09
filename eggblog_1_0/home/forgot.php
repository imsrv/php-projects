<?php
require_once("../_etc/header.php");
if (isset($q)) {
  $sql="SELECT COUNT(*) FROM eggblog_members WHERE username='$_POST[q]' OR email='$_POST[q]'";
  $count = mysql_result(mysql_query($sql),0);
  if (strlen($count == 1)) {
    $sql="SELECT username, password, email FROM eggblog_members WHERE username='$_POST[q]' OR email='$_POST[q]'";
    $result=mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
      echo "		<p>A password reminder has been sent to you by email to <b>$row[email]</b>.</p>\n<p>If you continue to receive problems, please feel free to email me at <a href=\"mailto:$eggblog_email\">$eggblog_email</a>.</p>\n";
      $to = $row[email];
      $subject = "Your Password Reminder";
      $headers = "From: $eggblog_title <$eggblog_email>";
      $message = "Someone has requested that a password reminder be sent to you for your account with $eggblog_url.\n\nPlease find confirmation of your log in details as follows:\nUsername: $row[username]\nPassword: $row[password]\n\nIf you continue to receive problems, please email $eggblog_email.\n\nRegards\n\n$eggblog_title | $eggblog_subtitle\n$eggblog_url";
      mail($to, $subject, $message, $headers);
    }
  }
  else {
    echo "		<p>The query <b>$q</b> could not be matched as a username nor email address.</p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
  }
}
else {
  echo "		<p>Please enter the username or email address you registered with:</p>
		<form action=\"forgot.php\" method=\"post\">
			<p>
				<input type=\"text\" size=\"20\" name=\"q\" value=\"$q\"/><br />
				<input type=\"submit\" class=\"no\" name=\"submit\" value=\"Submit\" />
			</p>
		</form>\n";
}
require("../_etc/footer.php");
?>
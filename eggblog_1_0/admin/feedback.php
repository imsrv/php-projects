<?php
require_once("header.php");
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (isset($_POST[submit])) {
      $comments = str_replace("\r","",$_POST[comments]);
      $comments = str_replace("\\","",$comments);
      $message = "Name: $_POST[name]\nEmail: $_POST[email]\nurl: $eggblog_url\nRelease: $eggblog_release\nComments:\n$_POST[comments]";
      $to = "eggblog@epicdesigns.co.uk";
      $headers = "From: $eggblog_email\n";
      $subject = "Feedback re: $eggblog_release";
      mail($to, $subject, $message, $headers);
      echo "		<p><b>Thank you for your comments.</b></p>\n		<p>We at <b>eggblog</b> will endeavour to contact you as soon as possible.</p>\n";
    }
    else {
      print
<<<END
		<p><b>We would very much like to hear from you regarding <a href="http://www.epicdesigns.co.uk/projects/eggblog" target="_blank">eggblog</a>.</b></p>
		<p>Feel free to contact us if you have any ideas or to report any bugs.</p>
		<form action="feedback.php" method="post">
			<p><label for="name">Name</label><br /><input type="text" size="30" name="name" id="name" /></p>
			<p><label for="email">E-mail</label><br /><input type="text" size="30" name="email" id="email" /></p>
			<p><label for="comments">Comments</label><br /><textarea name="comments" id="comments" cols="53" rows="8"></textarea></p>
			<p><input type="submit" name="submit" value="Send" class="no" /></p>
		</form>\n
END;
    }
  }
  else {
    echo "		<p><b>You are not authorised to view the administration area of the blog.</b></p>\n";
  }
}
else {
  require_once("../_etc/login_form.php");
}

require_once("footer.php");
?>
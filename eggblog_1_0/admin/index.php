<?php
require_once("header.php");
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    echo "		<p><b>Welcome to the administration area $_SESSION[eggblog].</b></p>
		<p>Select one of the following items:</p>
		<ul>
			<li><a href=\"index.php\">Home</a></li>
			<li><a href=\"blogs.php\">Blogs</a></li>
			<li><a href=\"forums.php\">Forum Topics</a></li>
			<li><a href=\"photos.php\">Photos</a></li>
			<li><a href=\"feedback.php\">Feedback</a></li>
		</ul>\n";
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
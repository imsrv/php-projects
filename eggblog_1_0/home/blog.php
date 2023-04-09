<?php
require_once("../_etc/header.php");

$sql_blog = "SELECT * FROM eggblog_articles WHERE id='$_GET[id]'";
$result_blog = mysql_query($sql_blog);
while ($row_blog = mysql_fetch_array($result_blog)) {
  $date = date("D j F Y",$row_blog[date]);
  $details = str_replace("\r","",$row_blog[details]);
  $details = str_replace("\n\n","</p>\n		<p>",$details);
  echo "		<p class=\"date\">$date</p>
		<h2>$row_blog[title]</h2>
		<p><b>$row_blog[intro]</b></p>
		<p>$details</p>\n";
  $show = $row_blog[comments];
}

if ($show == '1') {
  $comments = mysql_result(mysql_query("SELECT count(*) FROM eggblog_comments WHERE article_id='$_GET[id]'"),0);
  echo "		<a name=\"comments\"></a>
		<p class=\"head\">comments</p>\n";
  $sql_comments = "SELECT * FROM eggblog_comments WHERE article_id='$_GET[id]' ORDER BY date";
  $result_comments = mysql_query($sql_comments);
  while ($row_comments = mysql_fetch_array($result_comments)) {
    $date = date("g:ia | D j F Y",$row_comments[date]);
    $comments = str_replace("\r","",$row_comments[comments]);
    $comments = str_replace("\n","<br />",$comments);
    echo "		<p><span class=\"date\">$date | $row_comments[author]</span><br />$comments</p>\n";
  }
  if (isset($_SESSION[eggblog])) {
    echo "		<p><hr /></p>\n";
    require_once("../_etc/comments_form.php");
  }
  else {
    echo "		<p><br /></p>
		<p class=\"head\">Log in or regsiter below to submit a comment</p>\n";
    require_once("../_etc/login_form.php");
  }
}
else {
  echo "		<a name=\"comments\"></a>
		<p class=\"head\">comments</p>
		<p>No comments are allowed for this article.</p>\n";
}
require_once("../_etc/footer.php");
?>
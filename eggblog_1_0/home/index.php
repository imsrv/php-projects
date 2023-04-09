<?php
require_once("../_etc/header.php");
//echo "		<img src=\"../_images/valid_rss.png\" alt=\"XML RSS Feed\" width=\"85\" height=\"15\" align=\"right\" />\n";
$sql = "SELECT * FROM eggblog_articles ORDER BY date DESC LIMIT $eggblog_home";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
  $date = date("D j F Y",$row[date]);
  $details = str_replace("\r","",$row[details]);
  $details = str_replace("\n\n","</p>\n		<p>",$details);
  echo "		<p class=\"date\">$date</p>
		<h2>$row[title]</h2>
		<p><b>$row[intro]</b></p>
		<p>$details</p>\n";
  $comments = mysql_result(mysql_query("SELECT count(*) FROM eggblog_comments WHERE article_id='$row[id]'"),0);
  echo "		<p class=\"blogfoot\"><a href=\"blog.php?id=$row[id]\">full blog</a>";

  if ($row[comments] == "1") {
    echo " | <a href=\"blog.php?id=$row[id]#comments\">comments ($comments)</a></p>\n		<hr />\n";
  }
  else {
    echo "\n		<hr />\n";
  }
}
require_once("../_etc/footer.php");
?>

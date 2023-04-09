<?php
header('Content-type: text/xml');
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
if (!isset($eggblog_rss)) {
  $eggblog_rss = 10;
}
$date = date("r");
$data = "<?xml version=\"1.0\"  encoding=\"ISO-8859-1\" ?>\n<rss version=\"2.0\"><channel>\n";
$data .= "<title>$eggblog_title | $eggblog_subtitle | Blogs</title>\n";
$data .= "<copyright>(c) copyright 2005 | epicdesigns.co.uk/projects/eggblog.php | some rights reserved</copyright>\n";
$data .= "<link>$eggblog_url</link>\n";
$data .= "<description>A list of the $blog_rss most recent articles from $eggblog_title</description>\n";
$data .= "<language>en</language>\n";
$data .= "<generator>epicdesigns.co.uk xml rss compiler v0.1</generator>\n";
$data .= "<pubDate>$date</pubDate>\n";
$data .= "<ttl>1</ttl>\n\n";
$sql = "SELECT id, date, title, intro FROM eggblog_articles ORDER BY date DESC LIMIT $eggblog_rss";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result))
{
  $data .= "<item>\n";

  $title = htmlentities(strip_tags($row[title]));
  $comments = htmlentities(strip_tags($row[intro]));
  $date = date("r",$row[date]);

  $data .= "<title>$title</title>\n";
  $data .= "<description>$comments</description>\n";
  $data .= "<link>http://egg.epicdesigns.co.uk/home/blog.php?id=$row[id]</link>\n";
  $data .= "<pubDate>$date</pubDate>\n";
  $data .= "</item>\n\n";
}
$data .= "</channel>\n</rss>";
mysql_close($mysql);
print $data;
?>
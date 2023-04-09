<?php
header('Content-type: text/xml');
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
if (!isset($eggblog_rss)) {
  $eggblog_rss = 10;
}
$date = date("r");
$data = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n<rss version=\"2.0\"><channel>\n";
$data .= "<title>$eggblog_title | forum | posts</title>\n";
$data .= "<copyright>(c) copyright 1999-2005 | http://epicdesigns.co.uk/projects/eggblog | some rights reserved</copyright>\n";
$data .= "<link>".$eggblog_url."/forum/topic.php?id=$id</link>\n";
$data .= "<description>The latest topics from the $eggblog_title forum</description>\n";
$data .= "<language>en</language>\n";
$data .= "<generator>eggblog XML RSS feed</generator>\n";
$data .= "<pubDate>$date</pubDate>\n";
$data .= "<ttl>1</ttl>\n\n";
$sql="SELECT date, author, text FROM eggblog_forum_posts WHERE topicid='$id' ORDER BY date";
$result=mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
  $author=$row[author];
  $time=date("H:i.s",$row[date]);
  $date=date("D jS M Y",$row[date]);
  $postdate=date("r",$row[date]);
  $text=strip_tags($row[text]);
  $text=str_replace("\r","",$text);
  $text=str_replace("\n","",$text);
  $aspace=" ";
  if(strlen($text) > $eggblog_forum_chars) {
    $text = substr(trim($text),0,$eggblog_forum_chars); 
    $text = substr($text,0,strlen($text)-strpos(strrev($text),$aspace));
    $text = $text.'...';
  }
  $data .= "<item>\n";
  $data .= "<title>$author ($time on $date)</title>\n";
  $data .= "<description>$text</description>\n";
  $data .= "<link>".$eggblog_url."/forum/topic.php?id=$id</link>\n";
  $data .= "<pubDate>$postdate</pubDate>\n";
  $data .= "</item>\n\n";
}
$data .= "</channel>\n</rss>";
mysql_close($mysql);
print $data;
?>
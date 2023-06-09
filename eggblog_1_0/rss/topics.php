<?php
header('Content-type: text/xml');
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
if (!isset($limit)) { 
  $limit = 10;
}
$date = date("r");
$data = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n<rss version=\"2.0\"><channel>\n";
$data .= "<title>$tinybb_title | forum | topics</title>\n";
$data .= "<copyright>(c) copyright 1999-2005 | epicdesigns.co.uk/projects/eggblog | some rights reserved</copyright>\n";
$data .= "<link>".$eggblog_url."/forum/index.php</link>\n";
$data .= "<description>The latest topics from the $eggblog_title forum</description>\n";
$data .= "<language>en</language>\n";
$data .= "<generator>eggblog XML RSS feed</generator>\n";
$data .= "<pubDate>$date</pubDate>\n";
$data .= "<ttl>1</ttl>\n\n";
$sql_topics="SELECT id, name, lastpostid FROM eggblog_forum_topics ORDER BY lastpost DESC LIMIT 10";
$result_topics=mysql_query($sql_topics);
while ($row_topics = mysql_fetch_array($result_topics)) {
  $topic=$row_topics[name];
  $topicid=$row_topics[id];
  $postid=$row_topics[lastpostid];
  $sql_post="SELECT date, author, text FROM eggblog_forum_posts WHERE id='$postid'";
  $result_post=mysql_query($sql_post);
  while ($row_post = mysql_fetch_array($result_post)) {
    $author=$row_post[author];
    $time=date("H:i.s",$row_post[date]);
    $date=date("D jS M Y",$row_post[date]);
    $postdate=date("r",$row_post[date]);
    $text=strip_tags($row_post[text]);
    $text=str_replace("\r","",$text);
    $text=str_replace("\n","",$text);
    $aspace=" ";
    if(strlen($text) > $eggblog_forum_chars) {
      $text = substr(trim($text),0,$eggblog_forum_chars); 
      $text = substr($text,0,strlen($text)-strpos(strrev($text),$aspace));
      $text = $text.'...';
    }
    $data .= "<item>\n";
    $data .= "<title>$topic (last post by $author)</title>\n";
    $data .= "<description><b>Last post at $time on $date by $author</b><br />$text</description>\n";
    $data .= "<link>".$eggblog_url."/forum/topic.php?id=$topicid</link>\n";
    $data .= "<pubDate>$postdate</pubDate>\n";
    $data .= "</item>\n\n";
  }
}
$data .= "</channel>\n</rss>";
mysql_close($mysql);
print $data;
?>
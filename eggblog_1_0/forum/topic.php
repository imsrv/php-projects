<?php
if (isset($_POST['comments'])) {
  require_once("../_etc/config.inc.php");
  require_once("../_etc/mysql.php");
  $eggblog_forum_tags_array=array($eggblog_forum_tags);
  $comments=strip_tags($comments,$eggblog_forum_tags);
  foreach ($eggblog_forum_censors as $word) {
    $count=strlen($word);
    $i=0;
    while ($i < $count) {
      $replace .= "*";
      $i++;
    }
    $comments=str_replace($word,$replace,$comments);
    unset($replace,$count);
  }
  $date=time();
  session_start();
  $username=$_SESSION[eggblog];
  $sql="INSERT INTO eggblog_forum_posts SET topicid='$_POST[id]', author='$username', date='$date', text='$_POST[comments]'";
  mysql_query($sql);
  $postid=mysql_insert_id();
  $sql_topic="UPDATE eggblog_forum_topics SET lastpost='$date', lastpostid='$postid' WHERE id='$_POST[id]'";
  mysql_query($sql_topic);
  header("Location: topic.php?id=$_POST[id]");
}
require_once("header.php");
if (isset($_GET[id])) {
  $count=mysql_result(mysql_query("SELECT count(*) FROM eggblog_forum_topics WHERE id='$_GET[id]'"),0);
  if ($count == 1) {
    $topicname=mysql_result(mysql_query("SELECT name FROM eggblog_forum_topics WHERE id='$_GET[id]'"),0);
    echo "		<a href=\"../rss/posts.php?id=$id\" target=\"_blank\"><img src=\"../_images/valid_rss.png\" width=\"85\" height=\"15\" align=\"right\" alt=\"XML RSS Feed\" /></a>\n		<h2>$topicname</h2>\n";
    $sql="SELECT * FROM eggblog_forum_posts WHERE topicid='$id' ORDER BY date";
    $result=mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
      $time=date("H:i.s",$row[date]);
      $date=date("D jS M Y",$row[date]);
      $author=$row[author];
      $text=str_replace("\r","",$row[text]);
      $text=str_replace("\n","<br />",$text);
      $lasthour = time()-3601;
      foreach ($eggblog_forum_smilies as $emote) {
         $text = str_replace(" [$emote] "," <img src=\"../_images/smilies/$emote.gif\" alt=\"$emote\" width=\"16px\" height=\"16px\" /> ",$text);
      }
      echo "		<p class=\"forum\"><span class=\"date\"><b>$author</b> | $time | $date";
      if (($_SESSION[eggblog] == $author) AND ($row[date] > $lasthour)) {
        echo " | <a href=\"edit.php?id=$row[id]\">edit</a>";
      }
      echo "</span><br />$text</p>\n";
    }

    if (isset($_SESSION[eggblog])) {
      echo "		<a name=\"post\"></a>
		<form name=\"reply\" action=\"topic.php\" method=\"post\">
			<p class=\"head\"><label for=\"comments\">Post a message:</label></p>
			<p>
				The only allowed html tags are ".htmlentities($eggblog_forum_tags)."
				<br /><br /><b>Add smilies:</b><br />\n";
      foreach ($eggblog_forum_smilies as $emote) {
        echo "				<a href=\"#post\" onclick=\"smilie(' [$emote] '); return false;\"><img src=\"../_images/smilies/$emote.gif\" alt=\"$emote\" /></a>&nbsp; \n";
      }
      echo "			</p>
			<textarea name=\"comments\" id=\"comments\" cols=\"82\" rows=\"8\">$comments</textarea><br /><br />
			<input type=\"hidden\" name=\"id\" value=\"$id\" />
			<input type=\"submit\" class=\"no\" name=\"submit\" value=\"Post\" />
			<p>You can edit this post for up to 1 hour after it has been submitted.</p>
		</form>\n";
    }
    else {
      echo "		<p><br /></p>
		<p class=\"head\">Log in or register below to post a message:</b></p>\n";
      require_once("../_etc/login_form.php");
    }
  }
}

require_once("../_etc/footer.php");
?>

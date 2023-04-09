<?php
session_start();
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
if (isset($_POST['comments'])) {
  $topic=strip_tags($_POST['topic']);
  $comments=strip_tags($_POST['comments'],$eggblog_forum_tags);
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
  foreach ($eggblog_forum_censors as $word) {
    $count=strlen($word);
    $i=0;
    while ($i < $count) {
      $replace .= "*";
      $i++;
    }
    $topic=str_replace($word,$replace,$topic);
    unset($replace,$count);
  }
  $date=time();
  $username=$_SESSION[eggblog];
  $sql="INSERT INTO eggblog_forum_topics SET author='$username', name='$topic'";
  if (mysql_query($sql)) {
    $topicid=mysql_insert_id();
    $sql_post="INSERT INTO eggblog_forum_posts SET topicid='$topicid', date='$date', author='$username', text='$comments'";
    if (mysql_query($sql_post)) {
      $postid=mysql_insert_id();
      $sql_last="UPDATE eggblog_forum_topics SET lastpost='$date', lastpostid='$postid' WHERE id='$topicid'";
      mysql_query($sql_last);
      header("Location: topic.php?id=$topicid");
    }
    else {
      echo "<p><b>There has been a problem processing your request.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
    }
  }
  else {
    echo "<p><b>There has been a problem processing your request.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
  }
}
else {
  require_once("header.php");
  if (isset($_SESSION[eggblog])) {
    echo "		<form name=\"reply\" action=\"newtopic.php\" method=\"post\">
			<p><b><label for=\"topic\">Topic:</label></b><br /><input type=\"text\" size=\"50\" name=\"topic\" id=\"topic\" maxlength=\"30\" /></p>
			<p>
				<b><label for=\"comments\">Post a message:</label></b><br />
				The only allowed html tags are ".htmlentities($eggblog_forum_tags)."
				<br /><br /><b>Add smilies:</b><br />\n";
    foreach ($eggblog_forum_smilies as $emote) {
      echo "				<a href=\"#post\" onclick=\"smilie(' [$emote] '); return false;\"><img src=\"../_images/smilies/$emote.gif\" width=\"16\" height=\"16\" alt=\"$emote\" /></a>&nbsp; \n";
    }
    echo "			</p>
			<textarea name=\"comments\" id=\"comments\" cols=\"82\" rows=\"8\">$comments</textarea><br /><br />
			<input type=\"submit\" class=\"no\" name=\"sumit\" value=\"Post\" />
		</form>\n";
  }
  else {
    echo "		<p class=\"head\">Log in or regsiter below to start a new topic</p>\n";
    require_once("../_etc/login_form.php");
  }
  require_once("footer.php");
}
?>
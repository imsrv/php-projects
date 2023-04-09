<?php
session_start();
require_once("../_etc/config.inc.php");
require_once("../_etc/mysql.php");
if (isset($_SESSION[eggblog])) {
  if (isset($_POST['submit'])) {
    $check = mysql_result(mysql_query("SELECT COUNT(*) FROM eggblog_forum_posts WHERE id='$_POST[id]' AND author='$_SESSION[eggblog]'"),0);
    if ($check == '1') {
      $sql="SELECT * FROM eggblog_forum_posts WHERE id='$_POST[id]' AND author='$_SESSION[eggblog]'";
      $result=mysql_query($sql);
      while ($row = mysql_fetch_array($result)) {
        $lasthour = time()-3601;
        if ($row[date] > $lasthour) {
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
          $now = time();
          $now_time=date("H:i.s",$now);
          $comments .= "\n\n<i>Edit made by $_SESSION[eggblog]</i>";
          $sql="UPDATE eggblog_forum_posts SET text='$comments' WHERE id='$id' AND author='$_SESSION[eggblog]'";
          mysql_query($sql);
          header("Location: topic.php?id=$topicid");
        }
        else {
          require_once("header.php");
          echo "		<p><b>Posts cannot be edited more than an hour after it has been posted.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
        }
      }
    }
    else {
      require_once("header.php");
      echo "		<p><b>This post could not be verified as belonging to you.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
    }
  }
  else {
    require_once("header.php");
    if (isset($_GET['id'])) {
      $check = mysql_result(mysql_query("SELECT COUNT(*) FROM eggblog_forum_posts WHERE id='$_GET[id]' AND author='$_SESSION[eggblog]'"),0);
      if ($check == '1') {
        $sql="SELECT date, text, topicid FROM eggblog_forum_posts WHERE id='$_GET[id]'";
        $result=mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
          $lasthour = time()-3601;
          if ($row[date] > $lasthour) {
            $comments=$row[text];
            $topicid=$row[topicid];
            echo "		<form name=\"reply\" action=\"edit.php\" method=\"post\">
			<p>
				<b><label for=\"comments\">Edit your message below and click submit:</label></b><br />
				The only allowed html tags are $allowedtagshtml
				<br /><br /><b>Add smilies:</b><br />\n";
            foreach ($eggblog_forum_smilies as $emote) {
              echo "		<a href=\"#post\" onclick=\"smilie(' [$emote] '); return false;\"><img src=\"../_images/smilies/$emote.gif\" alt=\"$emote\" /></a>&nbsp; \n";
            }
            echo "			</p>
			<textarea name=\"comments\" id=\"comments\" cols=\"82\" rows=\"8\">$comments</textarea><br /><br />
			<input type=\"hidden\" name=\"id\" value=\"$_GET[id]\" />
			<input type=\"hidden\" name=\"topicid\" value=\"$topicid\" />
			<input type=\"submit\" class=\"no\" name=\"submit\" value=\"Submit\" />
		</form>\n";
          }
          else {
            echo "		<p><b>Posts cannot be edited more than an hour after it has been posted.</b></p>\n<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
          }
        }
      }
      else {
        echo "		<p><b>This post could not be verified as belonging to you.</b></p>\n		<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
      }
    }
  }
}
else {
  require_once("header.php");
  echo "		<p><b>You are not currently logged in.</b></p>\n		<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
}

require_once("footer.php");
?>

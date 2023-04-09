<?php
require_once("header.php");
echo "		<h2>Forum posts ...</h2>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (isset($_GET[delete])) {
      if (isset($_GET[confirm])) {
        $sql="DELETE FROM eggblog_forum_posts WHERE id='$_GET[delete]'";
        if (mysql_query($sql)) {
          echo "		<p>Post deleted successfully.</p>\n";
        }
        else {
          echo "		<p>Error delting post:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        echo "		<p><a href=\"posts.php?delete=$delete&confirm\">Confirm</a> the deletion of this post.</p>\n";
      }
    }
    elseif (isset($_GET[edit])) {
      if (isset($_POST[submit])) {
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
        $comments .= "\n\n<i>Edit made by moderator: $_SESSION[eggblog]</i>";
        $sql="UPDATE eggblog_forum_posts SET text='$comments' WHERE id='$_GET[edit]'";
        if (mysql_query($sql)) {
          echo "		<p>Topic post updated successfully.</p>\n";
        }
        else {
          echo "		<p>Error updating post:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        $sql="SELECT text FROM eggblog_forum_posts WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
          $comments=$row[text];
          echo "		<form name=\"reply\" action=\"posts.php?edit=$_GET[edit]\" method=\"post\">
			<p>
				<b><label for=\"comments\">Edit your message below and click submit:</label></b><br />
				The only allowed html tags are ".htmlentities($eggblog_forum_tags)."
				<br /><br /><b>Add smilies:</b><br />\n";
          foreach ($eggblog_forum_smilies as $emote) {
            echo "		<a href=\"#post\" onclick=\"smilie(' [$emote] '); return false;\"><img src=\"../_images/smilies/$emote.gif\" alt=\"$emote\" /></a>&nbsp; \n";
          }
          echo "			</p>
			<textarea name=\"comments\" id=\"comments\" cols=\"82\" rows=\"8\">$row[text]</textarea><br /><br />
			<input type=\"submit\" class=\"no\" name=\"submit\" value=\"Submit\" />
		</form>\n";
        }
      }
    }
    else {
      $sql="SELECT * FROM eggblog_forum_posts WHERE topicid='$_GET[id]' ORDER BY date";
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
        echo "		<p><span class=\"date\"><b>$author</b> | $time | $date | <a href=\"posts.php?edit=$row[id]\">edit</a> | <a href=\"posts.php?delete=$row[id]\">delete</a></span><br />$text</p>\n";
      }
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
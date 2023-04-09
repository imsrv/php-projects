<?php
require_once("header.php");
echo "		<h2>Forum topics ...</h2>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (isset($_GET[delete])) {
      if (isset($_GET[confirm])) {
        $sql_t="DELETE FROM eggblog_forum_topics WHERE id='$_GET[delete]'";
        $sql_p="DELETE FROM eggblog_forum_posts WHERE topicid='$_GET[delete]'";
        if (mysql_query($sql_t)) {
          echo "		<p>Topic deleted successfully.</p>\n";
        }
        else {
          echo "		<p>Error deleting topic name:<br />".mysql_error()."</p>\n";
        }
        if (mysql_query($sql_p)) {
          echo "		<p>Topic posts deleted successfully.</p>\n";
        }
        else {
          echo "		<p>Error deleting topic posts:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        echo "		<p><a href=\"topics.php?delete=$delete&confirm\">Confirm</a> the deletion of this topic and its posts.</p>\n";
      }
    }
    elseif (isset($_GET[edit])) {
      if (isset($_POST[submit])) {
        $sql="UPDATE eggblog_forum_topics SET name='$_POST[name]' WHERE id='$_GET[edit]'";
        if (mysql_query($sql)) {
          echo "		<p>Topic name updated successfully.</p>\n";
        }
        else {
          echo "		<p>Error updating topic name:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        $sql="SELECT name FROM eggblog_forum_topics WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        while ($row=mysql_fetch_array($result)) {
          echo "		<p><label for=\"name\">Edit the topic name and click submit:</label></p>
		<form action=\"topics.php?edit=$edit\" method=\"post\">
			<p><input type=\"text\" size=\"30\" name=\"name\" id=\"name\" value=\"$row[name]\" /><br /><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></p>
		</form>\n";
        }
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
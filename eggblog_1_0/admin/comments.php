<?php
require_once("header.php");
echo "		<h2>Blog comments ...</h2>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (isset($_GET[edit])) {
      if (isset($_POST[submit])) {
        $sql="UPDATE eggblog_comments SET author='$_POST[author]', comments='$_POST[comments]' WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        echo "		<p><b>".mysql_affected_rows()." comment(s) updated.</p>\n";
      }
      else {
        $sql="SELECT * FROM eggblog_comments WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
          echo "		<p>Edit the comment below and click 'submit' to complete the changes.</p>

		<form action=\"comments.php?edit=$_GET[edit]\" method=\"post\">
			<table>
				<tr>
					<th>AUTHOR</th>
					<td><input type=\"text\" name=\"author\" size=\"12\" value=\"$row[author]\" /></td>
				</tr>
				<tr>
					<th>COMMENTS</th>
					<td><textarea name=\"comments\" cols=\"70\" rows=\"15\">$row[comments]</textarea></td>
				</tr>
				<tr>
					<th></th>
					<td><input type=\"submit\" value=\"Submit\" name=\"submit\" class=\"no\" /></td>
				</tr>
			</table>
		</form>\n";
        }	
      }
    }
    elseif (isset($_GET[delete])) {
      if (isset($_GET[confirm])) {
        $sql="DELETE FROM eggblog_comments WHERE id='$_GET[delete]'";
        $result=mysql_query($sql);
        echo "		<p>".mysql_affected_rows()." comment(s) deleted.</p>\n";
      }
      else {
        echo "		<p><a href=\"comments.php?delete=$_GET[delete]&confirm\">Confirm</a> the deletion of the comment.</p>\n";
      }
    }
    elseif (isset($_GET[blog])) {
      $sql="SELECT * FROM eggblog_comments WHERE article_id='$_GET[blog]'";
      $result=mysql_query($sql);
      $count=mysql_num_rows($result);
      echo "		<p><b>$count</b> comments were found.</p>
		<table>
			<tr>
				<th>AUTHOR</th>
				<th>COMMENTS</th>
				<th>EDIT</th>
				<th>DELETE</th>
			</tr>\n";


      while ($row = mysql_fetch_array($result)) {
        $id=$row[id];
        $author=$row[author];
        $comments=strip_tags($row[comments]);
        $maxTextLength=70;
        $aspace=" ";
        if(strlen($comments) > $maxTextLength) {
          $comments = substr(trim($comments),0,$maxTextLength); 
          $comments = substr($comments,0,strlen($comments)-strpos(strrev($comments),$aspace));
          $comments = $comments.'...';
        }
        echo "			<tr>
				<td>$author</td>
				<td>$comments</td>
				<td><a href=\"comments.php?edit=$row[id]\">edit</a></td>
				<td><a href=\"comments.php?delete=$row[id]\">delete</a></td>
			</tr>\n";
      }
      echo "		</table>\n";
    }
  }
  else {
    echo "		<p><b>You are not authorised to view the administration area of the blog.</b></p>\n";
  }
}
else {
  require_once("../_etc/login_form.php");
}
require "footer.php";
?>
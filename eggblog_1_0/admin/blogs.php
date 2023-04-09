<?php
require "header.php";
if (isset($_SESSION['eggblog'])) {
  if ($_SESSION['eggblog'] == $eggblog_forum_mods) {
    echo "		<h2>Blogs...</h2>\n";
    if (isset($_GET['edit'])) {
      if (isset($_POST['submit'])) {
        $sql="UPDATE eggblog_articles SET title='$_POST[title]', intro='$_POST[intro]', details='$_POST[details]', comments='$_POST[comments]' WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        echo "		<p>".mysql_affected_rows()." blog(s) updated.</p>\n";
        echo "		<p><a href=\"blogs.php\">Return</a> to the blogs.</p>\n";
      }
      else {
        $sql="SELECT * FROM eggblog_articles WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
          echo "		<p>Edit the blog below and click 'submit' to complete the changes.</p>
		<form action=\"blogs.php?edit=$_GET[edit]\" method=\"post\">
			<table>
				<tr>
					<th>ID</th>
					<td>$edit</td>
				</tr>
				<tr>
					<th>TITLE</th>
					<td><input type=\"text\" name=\"title\" size=\"50\" value=\"$row[title]\" /></td>
				</tr>
				<tr>
					<th>INTRO</th>
					<td><textarea name=\"intro\" cols=\"65\" rows=\"4\">$row[intro]</textarea></td>
				</tr>
				<tr>
					<th>DETAILS</th>
					<td><textarea name=\"details\" cols=\"65\" rows=\"15\">$row[details]</textarea></td>
				</tr>
				<tr>
					<th>COMMENTS</th>
					<td><input type=\"radio\" value=\"1\" name=\"comments\" "; if ($row[comments] == '1') { echo "checked=\"checked\" "; } echo "/> Yes<br /><input type=\"radio\" value=\"0\" name=\"comments\" "; if ($row[comments] == '0') { echo "checked=\"checked\" "; } echo "/> No</td>
				</tr>
				<tr>
					<th></th>
					<td><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></td>
				</tr>
			</table>
		</form>\n";
        }	
      }
    }
    elseif (isset($_GET['new'])) {
      if (isset($_POST['submit'])) {
        $date=time();
        $sql="INSERT INTO eggblog_articles SET date='$date', title='$_POST[title]', intro='$_POST[intro]', details='$_POST[details]', comments='$_POST[comments]'";
        $result=mysql_query($sql);
        echo "		<p>".mysql_affected_rows()." blog(s) added.</p>\n";
        echo "		<p><a href=\"blogs.php\">Return</a> to the blogs.</p>\n";
      }
      else {
        echo "		<p>Add the new blog below and click 'submit' to make this blog live.</p>

		<form action=\"blogs.php?new\" method=\"post\">
			<table>
				<tr>
					<th>ID</th>
					<td>[auto]</td>
				</tr>
				<tr>
					<th>DATE</th>
					<td>[auto]</td>
				</tr>
				<tr>
					<th>TITLE</th>
					<td><input type=\"text\" name=\"title\" size=\"50\" /></td>
				</tr>
				<tr>
					<th>INTRO</th>
					<td><textarea name=\"intro\" cols=\"65\" rows=\"4\"></textarea></td>
				</tr>
				<tr>
					<th>DETAILS</th>
					<td><textarea name=\"details\" cols=\"65\" rows=\"15\"></textarea></td>
				</tr>
				<tr>
					<th>COMMENTS</th>
					<td><input type=\"radio\" value=\"1\" name=\"comments\" checked=\"checked\" /> Yes<br /><input type=\"radio\" value=\"0\" name=\"comments\" /> No</td>
				</tr>
				<tr>
					<th></th>
					<td><input type=\"submit\" value=\"Submit\" name=\"submit\" /></td>
				</tr>
			</table>
		</form>\n";
      }
    }
    elseif (isset($_GET['delete'])) {
      if (isset($_GET['confirm'])) {
        $sql="DELETE FROM eggblog_articles WHERE id='$_GET[delete]'";
        $result=mysql_query($sql);
        echo "		<p>".mysql_affected_rows()." blog(s) deleted.</p>\n";
        echo "		<p><a href=\"blogs.php\">Return</a> to the blogs.</p>\n";
      }
      else {
        $blogtitle = mysql_result(mysql_query("SELECT title FROM eggblog_articles WHERE id='$_GET[delete]'"),0);
        echo "		<p><a href=\"blogs.php?delete=$_GET[delete]&confirm\">Confirm</a> the deletion of the '<b>$blogtitle</b>' blog.</p>\n";
      }
    }
    else {
      echo "		<p><a href=\"blogs.php?new\">Post a new blog</a></p>
		<table>\n";
      $sql="SELECT id, date, title FROM eggblog_articles ORDER BY date DESC";
      $result=mysql_query($sql);
      while ($row = mysql_fetch_array($result)) {
        $id = $row[id];
        $date=date("d M Y",$row[date]);
        $title=$row[title];
        echo "			<tr>
				<td>$date</td>
				<td>$title</td>
			</tr>
			<tr>
				<td></td>
				<td><a href=\"blogs.php?edit=$id\">edit</a> | <a href=\"blogs.php?delete=$id\">delete</a> | <a href=\"comments.php?blog=$id\">comments</a></td>
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
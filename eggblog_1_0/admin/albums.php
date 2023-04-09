<?php
require_once("header.php");
echo "		<h2>Photos ...</h2>\n";
echo "		<p><a href=\"photos.php?new=album\">create a new album</a> | <a href=\"photos.php?new=photo\">submit a new photo</a></p>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (isset($_GET['id'])) {
      $sql = "SELECT * FROM eggblog_photos WHERE album_id='$_GET[id]'";
      $result = mysql_query($sql);
      while ($row = mysql_fetch_array($result))
      {
        echo "		<p><b>$row[title]</b><br />$row[description]<br /><div id=\"photo\"><img src=\"../_images/photos/thumbnail/$row[id].gif\" alt=\"$row[title]\" /></div><a href=\"albums.php?edit=$row[id]\">edit</a> | <a href=\"albums.php?delete=$row[id]\">delete</a></p>\n";
      }
    }
    elseif (isset($_GET['delete'])) {
      if (isset($_GET['confirm'])) {
        $sql="DELETE FROM eggblog_photos WHERE id='$_GET[delete]'";
        if (mysql_query($sql)) {
          echo "		<p>Photo deleted successfully.</p>\n";
          unlink($eggblog_absolutepath."/_images/photos/thumbnail/".$_GET[delete].".gif");
          unlink($eggblog_absolutepath."/_images/photos/preview/".$_GET[delete].".gif");
          unlink($eggblog_absolutepath."/_images/photos/full/".$_GET[delete].".gif");
        }
        else {
          echo "		<p>Error deleting photo:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        echo "		<p><a href=\"albums.php?delete=$_GET[delete]&confirm\">Confirm</a> the deletion of this photo.</p>\n";
      }
    }
    elseif (isset($_GET['edit'])) {
      if (isset($_POST['submit'])) {
        $sql="UPDATE eggblog_photos SET title='$_POST[title]',description='$_POST[description]' WHERE id='$_GET[edit]'";
        if (mysql_query($sql)) {
          echo "		<p>Photo updated successfully.</p>\n";
        }
        else {
          echo "		<p>Error updating photo:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        $sql="SELECT * FROM eggblog_photos WHERE id='$_GET[edit]'";
        $result=mysql_query($sql);
        while($row=mysql_fetch_array($result)) {
          echo "		<p>Edit the photo text below and click submit:</p>
		<form action=\"albums.php?edit=$edit\" method=\"post\">
			<p>Title:<br /><input type=\"text\" size=\"30\" name=\"title\" value=\"$row[title]\" /></p>
			<p>Comments:<br /><textarea cols=\"70\" rows=\"8\" name=\"description\">$row[description]</textarea></p>
			<p><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></p>
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
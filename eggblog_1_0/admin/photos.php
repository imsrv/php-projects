<?php
require_once("header.php");
echo "		<h2>Photos ...</h2>\n";
echo "		<p><a href=\"photos.php?new=album\">create a new album</a> | <a href=\"photos.php?new=photo\">submit a new photo</a></p>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if ($_GET['new'] == 'photo') {
      if (isset($_FILES['the_file']['tmp_name'])) {
        $filetype = $_FILES['the_file']['type'];
        if (($filetype == 'image/pjpeg') OR ($filetype == 'image/jpeg')) {
        $sql = "INSERT INTO eggblog_photos SET album_id='$_POST[album]', title='$_POST[title]', description='$_POST[description]'";
        $result = mysql_query($sql);
        $id = mysql_insert_id();
        $array = array("thumbnail","preview","full");
        foreach ($array as $folder) {
          $uri_of_img = $_FILES['the_file']['tmp_name'];
          $uri_of_new_img = $eggblog_absolutepath."/_images/photos/".$folder."/".$id.".gif";
          $src = imagecreatefromjpeg($uri_of_img);
          $w = imagesx($src);
          $h = imagesy($src);
          if ($folder == "thumbnail") {
            if ($w > 170) {
              $ratio = 170/$w;
            }
            else {
              $ratio = 1;
            }
          }
          elseif ($folder == "preview") {
            if ($w > 400) {
              $ratio = 400/$w;
            }
            else {
              $ratio = 1;
            }
          }
          elseif ($folder == "full") {
            $ratio = "1";
          }
          $new_w = $w * $ratio;
          $new_h = $h * $ratio;
          $img = imagecreatetruecolor($new_w,$new_h);
          imagecopyresampled($img,$src,0,0,0,0,$new_w,$new_h,$w,$h);
          imagejpeg($img, $uri_of_new_img, 90);
          imagedestroy($img);
          if (file_exists($uri_of_new_img)) {
            echo "		<p>Picture format <b>$folder</b> successfully created.</p>\n";
          }
          else {
            echo "		<p>Picture format <b>$folder</b> failed.</p>\n";
            $sql_del="DELETE FROM eggblog_photos WHERE id='$id'";
            mysql_query($sql_del);
          }
        }
        }
        else {
          echo "		<p>Only <b>.jpg</b> files are allowed.</p>\n		<p>Please <a href=\"javascript:history.go(-1)\">go back</a> and try again.</p>\n";
        }
      }
      else {
        echo "		<p>Add a new photo to an existing photo album:</p>\n		<form enctype=\"multipart/form-data\" action=\"photos.php?new=photo\" method=\"post\">\n			<select name=\"album\">\n";
        $sql = "SELECT id, title FROM eggblog_photos_albums ORDER BY title";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
          echo "				<option value=\"$row[id]\">$row[title]</option>\n";
        }
        echo "			</select>
			<p>Title:<br /><input type=\"text\" name=\"title\" size=\"30\" /></p>
			<p>Description:<br /><textarea cols=\"70\" rows=\"8\" name=\"description\"></textarea></p>
			<p>The photo (only .jpg's are allowed):<br /><input type=\"file\" name=\"the_file\" /></p>
			<p><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></p>
		</form>\n";
      }
    }
    elseif ($_GET['new'] == 'album') {
      if (isset($_POST['title'])) {
        $sql = "INSERT INTO eggblog_photos_albums SET title='$_POST[title]', description='$_POST[description]'";
        $result = mysql_query($sql);
        $id = mysql_insert_id();
        $uri_of_img = $_FILES['the_file']['tmp_name'];
        $uri_of_new_img = $eggblog_absolutepath."/_images/photos/category/".$id.".gif";
        $src = imagecreatefromjpeg($uri_of_img);
        $img = imagecreatetruecolor("77","77");
        $w = imagesx($src);
        $h = imagesy($src);
        imagecopyresampled($img,$src,0,0,0,0,"77","77",$w,$h);
        imagejpeg($img, $uri_of_new_img, 90);
        imagedestroy($img);
        if (file_exists($uri_of_new_img)) {
          echo "		<p>Photo album <b>$_POST[title]</b> successfully created.</p>\n";
        }
        else {
          echo "		<p>Photo album <b>$_POST[title]</b> failed.</p>\n";
          $sql_del="DELETE FROM eggblog_photos_albums WHERE id='$id'";
          mysql_query($sql_del);
        }
      }
      else {
        echo "		<p>Create a new photo album:</p>
		<form enctype=\"multipart/form-data\" action=\"photos.php?new=album\" method=\"post\">
			<p>Title:<br /><input type=\"text\" name=\"title\" size=\"30\" /></p>
			<p>Description:<br /><textarea cols=\"70\" rows=\"5\" name=\"description\"></textarea></p>
			<p>The photo (only .jpg's are allowed):<br /><input type=\"file\" name=\"the_file\" /></p>
			<p><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></p>
		</form>\n";
      }
    }
    elseif (isset($_GET[delete])) {
      if (isset($_GET[confirm])) {
        $sql_a="DELETE FROM eggblog_photos_albums WHERE id='$_GET[delete]'";
        if (mysql_query($sql_a)) {
          echo "		<p>Photo album deleted successfully.</p>\n";
          $sql_p="DELETE FROM eggblog_photos WHERE album_id='$_GET[delete]'";
          if (mysql_query($sql_p)) {
            echo "		<p>Photos deleted successfully.</p>\n";
          }
          else {
            echo "		<p>Error deleting photos:<br />".myql_error()."</p>\n";
          }
        }          
        else {
          echo "		<p>Error deleting photo album:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        echo "		<p><a href=\"photos.php?delete=$delete&confirm\">Confirm</a> the deletion of this photo album.</p>\n";
      }
    }
    elseif (isset($_GET[edit])) {
      if (isset($_POST[submit])) {
        $sql="UPDATE eggblog_photos_albums set title='$_POST[title]', description='$description' WHERE id='$_GET[edit]'";
        if (mysql_query($sql)) {
          echo "		<p>Photo album title updated successfully.</p>\n";
        }
        else {
          echo "		<p>Error updating photo album title:<br />".mysql_error()."</p>\n";
        }
      }
      else {
        $title=mysql_result(mysql_query("SELECT title FROM eggblog_photos_albums WHERE id='$_GET[edit]'"),0);
        $description=mysql_result(mysql_query("SELECT description FROM eggblog_photos_albums WHERE id='$_GET[edit]'"),0);
        echo "		<p>Edit the name of the album and click submit:</p>
		<form action=\"photos.php?edit=$edit\" method=\"post\">
			<p><input type=\"text\" size=\"30\" name=\"title\" id=\"title\" value=\"$title\" /></p>
			<p>Description:<br /><textarea cols=\"70\" rows=\"5\" name=\"description\">$description</textarea></p>
			<p><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"no\" /></p>
		</form>\n";
      }
    }
    else {
      if (!isset($_GET[i])) {
        $i=0;
      }
      else {
        $i = $_GET[i];
      }
      $count=mysql_result(mysql_query("SELECT count(*) FROM eggblog_photos_albums ORDER BY title"),0);
      $from=$i+1;
      $to=$i+$eggblog_forum_index;
      if ($to > $count) {
        $to=$count;
      }
      if ($count == 0) {
        echo "		<p>There are currently <b>no albums</b> in the photos section.</p>\n";
      }
      else {
        echo "		<p>Showing albums <b>$from</b> to <b>$to</b> in alphabetical order:</p>\n";
        $sql="SELECT * FROM eggblog_photos_albums ORDER BY title LIMIT $i,$eggblog_forum_index";
        $result=mysql_query($sql);
        $previous=$i-$eggblog_forum_index;
        $next=$i+$eggblog_forum_index;
        while ($row=mysql_fetch_array($result)) {
          echo "		<p><a href=\"albums.php?id=$row[id]\" style=\"font-size:125%; font-weight:bold;\">$row[title]</a><br /><a href=\"photos.php?edit=$row[id]\">edit</a> | <a href=\"photos.php?delete=$row[id]\">delete</a></p>\n";
        }
      }
      echo "		<table width=\"100%\" summary=\"Forum navigation\">\n			<tr><td width=\"20%\" align=\"left\">";
      if ($i >= $eggblog_forum_index) {
        echo "<a href=\"photos.php?i=$previous\">previous page</a>";
      }
      echo "</td><td width=\"60%\" align=\"center\"> pages: ";
      $ii=0;
      while ($ii < $eggblog_forum_index) {
        $page=$ii*$eggblog_forum_index;
        if ($page < $count) {
          $ii++;
          echo "<a href=\"photos.php?i=$page\">$ii</a>&nbsp; ";
        }
        else {
          $ii=$eggblog_forum_index;
        }
      }
      echo "</td><td width=\"20%\" align=\"right\">";
      if ($next < $count) {
        echo "<a href=\"photos.php?i=$next\">next</a>";
      }
      echo "</td></tr>\n		</table>\n";
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
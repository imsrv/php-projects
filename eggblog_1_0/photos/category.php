<?php
require_once("../_etc/header.php");
if (isset($_GET[id])) {
  $album = mysql_result(mysql_query("SELECT title FROM eggblog_photos_albums WHERE id='$_GET[id]'"),0);
  echo "		<p><a href=\"index.php\">photo albums</a> | <a href=\"category.php?id=$_GET[id]\">$album</a></p>
		<p>Click a photo to make it bigger:<p>
		<ul id=\"photos\">\n";
  $sql = "SELECT * FROM eggblog_photos WHERE album_id='$_GET[id]'";
  $result = mysql_query($sql);
  while ($row = mysql_fetch_array($result))
  {
    echo "			<li><a href=\"photo.php?id=$row[id]\"><img src=\"../_images/photos/thumbnail/$row[id].gif\" alt=\"$row[title]\" /></a></li>\n";
  }
  echo "		</ul>\n";
}
else {
  echo "		<p><b>There has been an error.</b></p>\n		<p>Please <a href=\"javscript:history.go(-1)\">go back</a> and try again.</p>\n";
}
require_once("../_etc/footer.php");
?>

<?php
require_once("../_etc/header.php");
if (isset($_GET[id])) {
  $sql = "SELECT * FROM eggblog_photos WHERE id='$_GET[id]'";
  $result = mysql_query($sql);
  while ($row = mysql_fetch_array($result)) {
    $album = mysql_result(mysql_query("SELECT title FROM eggblog_photos_albums WHERE id='$row[album_id]'"),0);
    echo "		<p><a href=\"index.php\">photo gallery</a> | <a href=\"category.php?id=$row[album_id]\">$album</a> | <a href=\"../_images/full/$_GET[id].gif\" target=\"_blank\">$row[title]</a></p>
		<h2>$row[title]</h2>
		<p>$row[description]</p>
		<p><div id=\"photo\"><a href=\"../_images/photos/full/$id.gif\" target=\"_blank\"><img src=\"../_images/photos/preview/".$_GET[id].".gif\" alt=\"$row[title]\" /></a></div></p>\n";
  }
}
else {
  echo "		<p><b>There has been an error.</b></p>\n		<p>Please <a href=\"javscript:history.go(-1)\">go back</a> and try again.</p>\n";
}
require_once("../_etc/footer.php");
?>
<?php
require_once("../_etc/header.php");
echo "		<p><a href=\"index.php\">photo albums</a></p>
		<p><b>Here are some of my funky photo's from my plentiful excusrions.</b></p>
		<p>Click the category for a list of thumbnail photos.</p>

		<ul id=\"album\">\n";
$sql = "SELECT * FROM eggblog_photos_albums ORDER BY id DESC";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  echo "			<li>
				<div class=\"photo\"><a href=\"category.php?id=$row[id]\"><img src=\"../_images/photos/category/$row[id].gif\" alt=\"$row[title]\" width=\"77\" height=\"77\" ></a></div>
				<div class=\"text\"><h3><a href=\"category.php?id=$row[id]\">$row[title]</a></h3>$row[description]</div>
			</li>\n";
}
require_once("../_etc/footer.php");
?>
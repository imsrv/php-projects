	</div>

	<div id="menu">
<?php
if (isset($_SESSION[eggblog])) {
  echo "		<p class=\"head\">members</p>
		<p class=\"item\">you are currently logged in as:<br /><b>$_SESSION[eggblog]</b><br /><a href=\"../home/logout.php\">logout</a></p>\n";
}
?>

		<p class="head"><a href="../home/search.php">search</a></p>
		<form action="../home/search.php" method="post">
			<p class="item">search all blog articles:<br /><input type="text" size="17" name="q" value="<?=$q_html?>" /> <input type="submit" name="submit" value="Search" class="no" /></p>
		</form>

		<p class="head">options</p>
		<p class="item">
			<select name="category" style="width:148px;" onchange="form_jump('parent',this,0)">
				<option value="" selected="selected">Change Category</option>
				<option value="">---</option>
				<option value="../home/index.php">Blogs</option>
				<option value="../photos/index.php">Photos</option>
				<option value="../forum/index.php">Forum</option>
				<option value="../home/rss.php">XML RSS Feed</option>
				<option value="">---</option>
				<option value="../admin/index.php">Administration</option>
			</select>
		</p>

		<p class="head"><a href="../home/index.php">recent articles</a></p>
		<ul class="item">
<?php
$sql = "SELECT id, title FROM eggblog_articles ORDER BY date DESC LIMIT $eggblog_recent";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
  echo "		<li><a href=\"../home/blog.php?id=$row[id]\">$row[title]</a></li>\n";
}
?>
		</ul>

		<p class="head"><a href="../forum/index.php">recent forum topics</a></p>
		<ul class="item">
<?php
$sql_topics="SELECT id, name, lastpostid FROM eggblog_forum_topics ORDER BY lastpost DESC LIMIT 0,$eggblog_forum_index";
$result_topics=mysql_query($sql_topics);
$previous=$i-$eggblog_forum_index;
$next=$i+$eggblog_forum_index;
while ($row_topics=mysql_fetch_array($result_topics)) {
  $topic=$row_topics[name];
  $aspace=" ";
  if(strlen($topic) > 25) {
    $topic = substr(trim($topic),0,25); 
    $topic = substr($topic,0,strlen($topic)-strpos(strrev($topic),$aspace));
    $topic = $topic.'...';
  }
  $topicid=$row_topics[id];
  $postid=$row_topics[lastpostid];
  $sql_post="SELECT date, author, text FROM eggblog_forum_posts WHERE id='$postid'";
  $result_post=mysql_query($sql_post);
  while ($row_post = mysql_fetch_array($result_post)) {
    $author=$row_post[author];
    $time=date("H:i.s",$row_post[date]);
    $date=date("D jS M Y",$row_post[date]);
    $text=strip_tags($row_post[text]);
    $text=str_replace("\r","",$text);
    $text=str_replace("\n"," ",$text);
    foreach ($eggblog_forum_smilies as $emote) {
       $text = str_replace(" [$emote] "," ",$text);
    }
    $aspace=" ";
    if(strlen($text) > 25) {
      $text = substr(trim($text),0,25); 
      $text = substr($text,0,strlen($text)-strpos(strrev($text),$aspace));
      $text = $text.'...';
    }
    echo "			<li><a href=\"../forum/topic.php?id=$topicid\">$topic</a><br />$text</li>\n";
  }
}
?>
		</ul>

		<p class="head">blogroll</p>
		<ul class="item">
<?php
while (list($title, $url) = each($eggblog_blogroll)) {
   echo "			<li><a href=\"$url\" target=\"_blank\">$title</a></li>\n";
}
?>
		</ul>

		<p align="center"><a href="http://www.epicdesigns.co.uk/projects/eggblog"><img src="../_images/poweredby_<?=$eggblog_css?>.png" alt="powered by eggblog" width="88" height="31" /></a></p>
	</div>

	<div id="footer">
		<div>
			<p>&copy; copyright 2005 | powered by <a href="http://www.epicdesigns.co.uk/projects/eggblog">eggblog <?=$eggblog_release?></a> | some rights reserved</p>
		</div>
	</div>
</div>

</body>
</html><?php mysql_close($mysql); ?>
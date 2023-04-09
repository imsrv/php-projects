	</div>

	<div id="menu">
<?php
if (isset($_SESSION[eggblog])) {
  echo "		<p class=\"head\">members</p>
		<p class=\"item\">you are currentloy logged in as:<br /><b>$_SESSION[eggblog]</b><br /><a href=\"../home/logout.php\">logout</a></p>\n";
}
?>

		<p class="head">options</p>
		<ul class="item">
			<li><a href="index.php">Home</a></li>
			<li><a href="blogs.php">Blogs</a></li>
			<li><a href="forums.php">Forum Topics</a></li>
			<li><a href="photos.php">Photos</a></li>
			<li><a href="feedback.php">Feedback</a></li>
		</ul>
	</div>

	<div id="footer">
		<div>
			<p>&copy; copyright 2005 | powered by <a href="http://www.epicdesigns.co.uk/projects/eggblog">eggblog <?=$eggblog_release?></a> | some rights reserved</p>
		</div>
	</div>
</div>

</body>
</html><?php mysql_close($mysql); ?>
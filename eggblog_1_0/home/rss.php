<?php
require "../_etc/header.php";
echo "		<h2>xml RSS Feed</h2>

		<p><b>How do I get the RSS feed?</b><br />Simply copy the following url's into your chosen news agrgregator and your away:</p>
		<ul>
			<li><b>Blog RSS:</b> <a href=\"../rss/blog.php\" target=\"_blank\">$eggblog_url/rss/blog.php</a></li>
			<li><b>Forum RSS:</b> <a href=\"../rss/topics.php\" target=\"_blank\">$eggblog_url/rss/topics.php</a></li>
		</ul>

		<p><b>What is RSS?</b><br /><b>RSS (Really Simple Syndication)</b> is an easy way for you to keep updated automatically on websites you like. Instead of you having to go to websites to see if they've written a new article or feature, you can use RSS (Really Simple Syndication) to get them to tell you every time they have something new.</p>
		<p>I offer RSS feeds (or channels) for all of my blogs and forum topics. This RSS feed is updated every second of every day to ensure the latest content is delivered to your desktop.</p>

		<p><b>How can i use RSS?</b><br />Typical methods for using RSS include:</p>
		<ul>
			<li>Using a program known as a News Aggregator to collect, update and display RSS feeds</li>
			<li>Incorporating RSS feeds into web pages</li>
		</ul>

		<p><b>News Aggregators (also called news readers)</b> will download and display RSS feeds for you. A number of free and commercial News Aggregators are available for download. Popular news readers include <a href=\"http://www.newzcrawler.com/\" target=\"_blank\">News Crawler</a>, <a href=\"http://www.feeddemon.com/feeddemon/index.asp\" target=\"_blank\">FeedDemon</a> and <a href=\"http://www.newsgator.com/ngs/default.aspx\" target=\"_blank\">News Gator</a>.</p>
		<p><b>Trillian</b> has a very useful <a href=\"http://www.ceruleanstudios.com/downloads/pl_download.php?id=140\" target=\"_blank\">news plugin</a> for integrating news feeds (with pop-up alerts).</p>\n";
require "../_etc/footer.php";
?>
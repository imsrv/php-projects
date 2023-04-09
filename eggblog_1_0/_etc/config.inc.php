<?php

// THIS CONFIG FILE IS COMPATIBLE TO eggblog V0.2

$eggblog_title		= "";			// Website title
$eggblog_subtitle	= "";			// Website subtitle
$eggblog_domain		= "";			// Website url; excluding the "http://"; e.g. www.epicdesigns.co.uk
$eggblog_url		= "";			// Website url; including the "http://" without a trailing slash; e.g. http://www.epicdesigns.co.uk/egg
$eggblog_absolutepath	= "";			// Absolute path to the installation on the server without a trailing slash (refer to "phpinfo();"); e.g. "/www/sites/epicdesigns.co.uk/egg"
$eggblog_email		= "";			// Administrative email address

$eggblog_css		= "blue_dark";		// The name of the colour stylesheet to be used in the /_etc/ folder

$eggblog_home		= "3";			// the number of blogs to show on the homepage
$eggblog_recent		= "10";			// the number of blogs to show in the recent articles list
$eggblog_maxchars_index	= "400";		// Maximum number of characters of preview article
$eggblog_rss		= "10";			// the number of articles to list in the XML RSS feed

$eggblog_blogroll	= array("Egg" => "http://egg.epicdesigns.co.uk");
						// BlogRoll entries in the format: array("title1" => "url1","title2" => "url2");

$eggblog_forum_index	= "5";			// the number of topics to show on the forum homepage
$eggblog_forum_chars	= "52";			// the numebr of characters to show in the preview of a post
$eggblog_forum_smilies	= array("cool","cry","dblwink","grin","ill","innocent","sad","shock","smile","soso","straight","tongue","wink");
						// Smilies to use in the forums; each smilie must have a matching image in "/_images/smilies/"
$eggblog_forum_mods	= "";			// The ssername of the owner (this will give the user access to the admin area)
$eggblog_forum_tags	= "<a><br><b><i><img><p><u>";// HTML tags that are allowed in the forum posts
$eggblog_forum_censors	= array("shit","shite","fuck","dick","cock","cunt","arse","bollocks","crap","piss","bastard","wank","twat");
						// List of words that are not allowed in the forum (these get masked with *s)

$eggblog_mysql_host 	= "";			// MySQL hostname or IP address
$eggblog_mysql_user	= "";			// MySQL username
$eggblog_mysql_password	= "";			// MySQL password
$eggblog_mysql_db	= "";			// MySQL database
?>
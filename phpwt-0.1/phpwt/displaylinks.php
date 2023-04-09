<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

include("config.php");

if(agentSpider($_SERVER["HTTP_USER_AGENT"])) {
	echo "<a href='$scripturl/lang.php?lang=en&idlink=1'>English</a><br />";
	echo "<a href='$scripturl/lang.php?lang=de&idlink=1'>German</a><br />";
	echo "<a href='$scripturl/lang.php?lang=es&idlink=1'>Spanish</a><br />";
	echo "<a href='$scripturl/lang.php?lang=it&idlink=1'>Italian</a><br />";
	echo "<a href='$scripturl/lang.php?lang=ja&idlink=1'>Japanese</a><br />";
	echo "<a href='$scripturl/lang.php?lang=fr&idlink=1'>French</a><br />";
	echo "<a href='$scripturl/lang.php?lang=pt&idlink=1'>Portuguese</a><br />";
}

?>

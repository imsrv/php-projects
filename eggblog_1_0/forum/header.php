<?php
require_once("../_etc/config.inc.php");
if ($mysql == 0) { require_once("../_etc/mysql.php"); }
require_once("../_etc/header.php");
echo "		<p><a href=\"index.php\">forum homepage</a> | <a href=\"newtopic.php\">start a new topic</a> | <a href=\"search.php\">search the forum</a></p>\n";
?>
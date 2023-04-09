<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="0.92">
	<channel>
		<title>$insert[site_name]</title>
		<link>$insert[site_url]/index.php</link>
		<description>Last 20 items on $insert[site_name]</description>
		<generator>Esselbach Storyteller CMS System</generator>

TEMPLATE;
?>
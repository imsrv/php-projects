<?php
$dbconf = "db.inc.php";                 // Zugangsdaten für die mySQL db
$get_agent = "agent.inc.php";       // Icludedatei für die Browsererkennung



include("$dbconf");
include("$get_agent");

$url = urldecode($QUERY_STRING);
//$url = strtolower($url);


mysql_connect ("$dbhost", "$dbuser", "$dbpasswd");


$sql = "INSERT into $table (url, time, host, ip, ref, agent, os) VALUES('$url', NOW(), '$HTTP_HOST', '$REMOTE_ADDR', '$HTTP_REFERER', '$agent $agent_ver', '$os')";


mysql_db_query("$db","$sql");



header("Location: $url");
?>

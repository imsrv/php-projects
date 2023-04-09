<?
include("defaults_inc.php");
$fp = fopen("help_de.html","r");
readfile("help_$LANG.html");
fclose($fp);
?>

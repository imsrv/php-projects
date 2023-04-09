<?
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
//echo $host;
$isp = $host ;
$host = substr($host, strpos($host, ".") + 1);
$isp= str_replace($host, "*", $isp);
if ($isp =="193.*") {
include("");
}
else if ($isp =="213.*") {
include("");
}
else 
{
include("inter.php");
}

?>
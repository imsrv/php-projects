<?
include_once "config.php";

$sid=$_REQUEST["sid"];
$rating=$_REQUEST["rating"];
$ip=$_SERVER["REMOTE_ADDR"];
$sql=mysql_query("select * from sbwmd_ratings where sid=$sid and ip='$ip'");
$check=0;

if($rst=mysql_fetch_array($sql))
{
header("Location:"."software-description.php?msg=" . urlencode("You can rate one software once only!") .  "&id=".$sid);
}
else
{
mysql_query("insert into sbwmd_ratings (rating,ip,sid) values($rating,'$ip',$sid)");
header("Location:"."software-description.php?msg=" . urlencode("Thanks for rating the software") .  "&id=".$sid);

}


?>
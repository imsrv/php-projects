<?
include_once("logincheck.php");
include_once("../config.php");

$sql1="DELETE FROM sbwmd_ads  where id=" . $_REQUEST["id"];

mysql_query($sql1 );
header("Location: ". "ads.php?msg=" .urlencode("Ad has been Removed!") );
?>
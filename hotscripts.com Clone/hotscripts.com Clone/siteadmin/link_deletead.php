<?
include_once("logincheck.php");
include_once("../config.php");

$sql1="DELETE FROM sbwmd_banners  where id=" . $_REQUEST["id"];

mysql_query($sql1 );
header("Location: ". "link_ads.php?msg=" .urlencode("Banner has been Removed!") );
?>
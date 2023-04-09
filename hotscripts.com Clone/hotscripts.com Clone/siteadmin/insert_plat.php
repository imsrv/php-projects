<?
include "logincheck.php";
include_once "../config.php";

$cid=$_REQUEST["cid"];
$plat_name=$_REQUEST["plat_name"];
mysql_query("insert into sbwmd_platforms (cid,plat_name) values ($cid,'$plat_name')");

header("Location:"."platform.php?cid=".$cid."&msg=".urlencode("Platform has been added."));
?>
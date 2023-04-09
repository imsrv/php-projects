<?
include "logincheck.php";
include_once "../config.php";
if(isset($_REQUEST["pid"]) && isset($_REQUEST["cid"]))
{
mysql_query("update sbwmd_softwares set cid=".$_REQUEST["pid"]." where sbwmd_softwares.cid=".$_REQUEST["cid"]);
header("Location:"."browsecats.php?msg=".urlencode("successfully shifted listings"));
}
else
{
if(isset($_REQUEST["cid"])&& isset($_REQUEST["cat1"]))
mysql_query("update sbwmd_softwares set cid=".$_REQUEST["cat1"]." where sbwmd_softwares.cid=".$_REQUEST["cid"]);
header("Location:"."browsecats.php?msg=".urlencode("successfully shifted listings"));}
?>

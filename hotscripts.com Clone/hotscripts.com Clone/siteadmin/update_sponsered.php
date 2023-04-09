<?
include "logincheck.php";
include_once "../config.php";

$id=$_REQUEST["id"];
$pg=$_REQUEST["pg"];
$url=str_replace("'", "''",$_REQUEST["url"]);
$linktext=str_replace("'", "''",$_REQUEST["linktext"]);


mysql_query("update sbwmd_sideads set url='$url', linktext='$linktext' where id=$id");

header("Location:"."sponsered.php?id=$id&pg=$pg&msg=".urlencode("Advertisement entry has been edited."));
?>
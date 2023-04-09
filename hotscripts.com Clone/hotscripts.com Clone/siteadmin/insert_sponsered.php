<?
include "logincheck.php";
include_once "../config.php";

$url=str_replace("'", "''",$_REQUEST["url"]);
$linktext=str_replace("'", "''",$_REQUEST["linktext"]);

mysql_query("insert into sbwmd_sideads (url,linktext) values ('$url','$linktext')");
$id=mysql_fetch_array(mysql_query("select max(id) from sbwmd_sideads"));


header("Location:"."sponsered.php?id=".$id[0]."&msg=".urlencode("Advertisement entry has been added."));
?>
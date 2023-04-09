<?
include "logincheck.php";
include_once "../config.php";

$id=$_REQUEST["id"];
$pg=$_REQUEST["pg"];
$name_url=str_replace("'", "''",$_REQUEST["name_url"]);
$url=str_replace("'", "''",$_REQUEST["url"]);
$desc=str_replace("'","''",$_REQUEST["desc"]);

mysql_query("update sbwmd_featuredads set name_url='$name_url',url='$url',fd_desc='$desc' where id=$id");

header("Location:"."featured_ads.php?id=$id&pg=$pg&msg=".urlencode("Advertisement entry has been edited."));
?>
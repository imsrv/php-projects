<?
include "logincheck.php";
include_once "../config.php";
$name_url=str_replace("'", "''",$_REQUEST["name_url"]);
$url=str_replace("'", "''",$_REQUEST["url"]);
$desc=str_replace("'","''",$_REQUEST["desc"]);
mysql_query("insert into sbwmd_featuredads (name_url,url,fd_desc) values ('$name_url','$url','$desc')");
$id=mysql_fetch_array(mysql_query("select max(id) from sbwmd_featuredads"));


header("Location:"."featured_ads.php?id=".$id[0]."&msg=".urlencode("Advertisement entry has been added."));
?>
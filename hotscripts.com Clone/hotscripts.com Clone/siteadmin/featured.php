<?
include "logincheck.php";
include_once "../config.php";
$id=$_REQUEST["id"];
$rst=mysql_fetch_array(mysql_query("select * from sbwmd_softwares where id=".$_REQUEST["id"]));
if($rst["featured"]=="yes")
$featured="no";
else
$featured="yes";

mysql_query("update sbwmd_softwares set featured='$featured' where id=$id");
header("Location:"."software.php?id=$id&pg=".$_REQUEST["pg"]);

?>
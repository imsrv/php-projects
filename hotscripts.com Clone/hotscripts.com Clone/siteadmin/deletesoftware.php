<?

include "logincheck.php";
include_once "../config.php";

$id=$_REQUEST["id"];
mysql_query("delete from sbwmd_softwares where id=$id"); 


header("Location:"."software.php?id=$id&pg=".$_REQUEST["pg"]."&msg=".urlencode("You software has been deleted"));
?>
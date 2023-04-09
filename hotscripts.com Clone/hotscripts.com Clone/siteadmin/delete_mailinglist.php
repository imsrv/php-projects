<?
include_once "logincheck.php"; 
include_once "../config.php";

mysql_query("DELETE  from sbwmd_mailing_list Where id= ".$_REQUEST["id"]);
header("Location:"."mailing_list.php?id=".$_REQUEST["id"]."&pg=".$_REQUEST["pg"]."&msg=".urlencode("You have successfully removed mailing list entry."));

?>

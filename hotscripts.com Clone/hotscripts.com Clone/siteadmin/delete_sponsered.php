<?
include_once "logincheck.php"; 
include_once "../config.php";

mysql_query("DELETE  from sbwmd_sideads Where id= ".$_REQUEST["id"]);
header("Location:"."sponsered.php?id=".$_REQUEST["id"]."&pg=".$_REQUEST["pg"]."&msg=".urlencode("You have successfully removed sponsered entry from your listing."));

?>

<?
include_once "logincheck.php"; 
include_once "../config.php";

mysql_query("DELETE  from sbwmd_feedback Where id= ".$_REQUEST["id"]);
header("Location:"."feedback.php?id=".$_REQUEST["id"]."&pg=".$_REQUEST["pg"]."&msg=".urlencode("You have successfully removed feedback entry."));

?>

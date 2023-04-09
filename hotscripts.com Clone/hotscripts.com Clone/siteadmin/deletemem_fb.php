<?
include_once "logincheck.php"; 
include_once "../config.php";

mysql_query("DELETE  from sbwmd_member_feedback Where id= ".$_REQUEST["id"]);
header("Location:"."mem_feedback.php?id=".$_REQUEST["id"]."&pg=".$_REQUEST["pg"]."&msg=".urlencode("You have successfully removed feedback entry."));

?>

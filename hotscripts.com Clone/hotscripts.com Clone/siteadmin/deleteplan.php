<?
include_once("logincheck.php");
include_once("../config.php");

$sql1="DELETE FROM sbwmd_plans  where id=" . $_REQUEST["id"];

mysql_query($sql1 );
header("Location: ". "plans.php?msg=" .urlencode("Plan has been Removed!") );
?>
<?
include_once("logincheck.php");
include_once("../config.php");

					   
$sql1="insert into sbwmd_plans (credits,price) Values(" .
" " . str_replace("'","''",$_POST["credits"]) . ","  .
" " . str_replace("'","''",$_POST["price"]) . ")";
mysql_query($sql1 );
header("Location: ". "plans.php?id=" . $_REQUEST["id"] . "&msg=" .urlencode("New plan has been added!") );

?>
<?
include_once "config.php";
$custom=$_REQUEST["custom"];
$sql1="update  sbwmd_ads  set paid='yes' where id=$custom";
mysql_query($sql1 );

?>
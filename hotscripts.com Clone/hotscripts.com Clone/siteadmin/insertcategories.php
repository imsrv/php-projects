<?
include "logincheck.php";
include_once "../config.php";

$pid=$_REQUEST["pid"];
$cat_name=$_REQUEST["cat_name"];
mysql_query("insert into sbwmd_categories (pid,cat_name) values ($pid,'$cat_name')");
header("Location:"."browsecats.php?cid=".$pid."&msg=".urlencode("Category has been added."));
?>
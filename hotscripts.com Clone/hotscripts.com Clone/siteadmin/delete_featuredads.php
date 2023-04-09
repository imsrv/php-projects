<?
include_once "logincheck.php"; 
include_once "../config.php";

mysql_query("DELETE  from sbwmd_featuredads Where id= ".$_REQUEST["id"]);
header("Location:"."featured_ads.php?id=".$_REQUEST["id"]."&pg=".$_REQUEST["pg"]."&msg=".urlencode("You have successfully removed featured advertisement entry from your listing."));

?>

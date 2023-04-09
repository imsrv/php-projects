<?

include_once "logincheck.php";
include_once "../config.php";
 
	$plat=mysql_fetch_array(mysql_query("select * from sbwmd_platforms where id=".$_REQUEST["id"]));
	
mysql_query("UPDATE sbwmd_platforms SET plat_name='".str_replace("'","''",$_REQUEST["plat_name"])."' Where id= ".$_REQUEST["id"]); 
header("Location:"."platform.php?cid=".$plat["cid"]."&msg=".urlencode("Platform has been updated."));
?>

<? 
include "logincheck.php";
include "../config.php";

$plat=mysql_fetch_array(mysql_query("select * from sbwmd_platforms where id=".$_REQUEST["id"]));
mysql_query("DELETE  from sbwmd_platforms Where id= ".$_REQUEST["id"]);
header("Location:"."platform.php?cid=".$plat["cid"]."&msg=".urlencode("You have successfully removed Platform."));

?>

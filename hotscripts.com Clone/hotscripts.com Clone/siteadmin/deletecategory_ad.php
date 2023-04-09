<? 
include "logincheck.php";
include "../config.php";


mysql_query("DELETE  from sbwmd_categories Where id= ".$_REQUEST["cid"]);

header("Location:"."browsecats.php?msg=".urlencode("You have successfully  removed category " ));

?>

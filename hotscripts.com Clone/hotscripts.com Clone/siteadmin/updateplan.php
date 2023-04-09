<?

include_once "logincheck.php";
include_once "../config.php";
 
	
mysql_query("UPDATE sbwmd_plans SET credits='". str_replace("'","''",$_REQUEST["credits"])."' ,  price='". str_replace("'","''",$_REQUEST["price"])."' Where id= ".$_REQUEST["id"]); 

header("Location:"."plans.php?&msg=".urlencode("Plan has been updated."));
?>
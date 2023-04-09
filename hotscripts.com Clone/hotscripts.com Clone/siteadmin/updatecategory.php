<?

include_once "logincheck.php";
include_once "../config.php";

mysql_query("UPDATE sbwmd_categories SET cat_name='".str_replace("'","''",$_REQUEST["catname"])."' , cat_img='".str_replace("'","''",$_REQUEST["list1"])."'  Where id= ".$_REQUEST["cid"]); 
header("Location:"."browsecats.php?cid=".$_REQUEST["pid"]."&msg=".urlencode("Category has been updated"));
?>

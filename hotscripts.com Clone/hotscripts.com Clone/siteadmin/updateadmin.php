<?
include "logincheck.php";
include_once "../config.php";

//$admin_name=str_replace("'","''",$_REQUEST["admin_name"]);
//$pwd=str_replace("'","''",$_REQUEST["pwd"]);

$sql="update sbwmd_admin set
   id = '1',  
   pwd='$_POST[pwd]',
   admin_name='$_POST[admin_name]' " ;

//echo $sql;
//die();


mysql_query($sql);

header("Location:"."admin.php?msg=".urlencode("You have successfully configured your site parameters"));
?>
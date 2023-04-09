<?
include_once "config.php";

$username=$_REQUEST["username"];
$useremail=str_replace("'","''",$_REQUEST["useremail"]);


mysql_query("INSERT INTO sbwmd_mailing_list (username,useremail) VALUES('$username','$useremail')" );
header("Location:"."index.php?id=".$sid."&msg=".urlencode("Thanks for adding your email address to our mailing list."));
?>
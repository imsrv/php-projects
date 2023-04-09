<?
include "logincheck.php";
include "config.php";
mysql_query("UPDATE sbppc_members SET mem_name='".str_replace("'","''",$_REQUEST["AdvertiserName"])."', c_name='".str_replace("'","''",$_REQUEST["Company"])."', phone='".str_replace("'","''",$_REQUEST["Phone"]). "', email='".str_replace("'","''",$_REQUEST["EmailAddress"])."', pwd='".str_replace("'","''",$_REQUEST["Password"])."' Where id= ".$_REQUEST["id"]); 

header("Location:"."editmember.php?id=".$_REQUEST["id"]. "&msg=".urlencode("Profile has been updated"));
?>

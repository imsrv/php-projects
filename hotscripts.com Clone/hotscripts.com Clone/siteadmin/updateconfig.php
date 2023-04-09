<?
include "logincheck.php";
include_once "../config.php";

$site_name=str_replace("'","''",$_REQUEST["sitename"]);
$admin_email=str_replace("'","''",$_REQUEST["adminemail"]);
$site_addrs=str_replace("'","''",$_REQUEST["siteaddrs"]);
$recperpage=$_REQUEST["rec"];
$agreement=str_replace("'","''",$_REQUEST["agreement"]);
$recinpanel=$_REQUEST["recinpanel"];
$null_char=str_replace("'","''",$_REQUEST["null_char"]);
$no_of_friends=$_REQUEST["no_of_friends"];
$privacy=str_replace("'","''",$_REQUEST["privacy"]);
$legal=str_replace("'","''",$_REQUEST["legal"]);
$terms=str_replace("'","''",$_REQUEST["terms"]);
$username_len=$_REQUEST["username_len"];
$pwd_len=$_REQUEST["pwd_len"];
$pay_pal=$_REQUEST["pay_pal"];

$sql="update sbwmd_config set
site_name='$site_name',
admin_email='$admin_email',
site_addrs='$site_addrs',
recperpage=$recperpage,
agreement='$agreement',
recinpanel=$recinpanel,
null_char='$null_char',
no_of_friends=$no_of_friends,
privacy='$privacy',
legal='$legal',
pay_pal='$pay_pal',
terms='$terms',
username_len=$username_len,
pwd_len=$pwd_len" ;

//echo $sql;
//die();


mysql_query($sql);

header("Location:"."config.php?msg=".urlencode("You have successfully configured your site parameters"));
?>
<?
include_once("logincheck.php");
include_once("../config.php");
					   
$sql1="insert into sbwmd_ads (url,bannerurl,email,credits,displays,approved,paid) Values(" .
" '" . str_replace("'","''",$_POST["url"]) . "',"  .
" '" . str_replace("'","''",$_POST["bannerurl"]) . "',"  .
"'" . str_replace("'","''",$_POST["email"]) . "'," .
" " . $_POST["credits"] . " , " .
" " . $_POST["displays"] . " , " .
"'yes' , 'yes')";
mysql_query($sql1 );
header("Location: ". "ads.php?id=" . $_REQUEST["id"] . "&msg=" .urlencode("New banner has been added!") );

?>
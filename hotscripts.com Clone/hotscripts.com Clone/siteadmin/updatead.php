<?
include_once("logincheck.php");
include_once("../config.php");
					   
$id=$_REQUEST["id"];
$url=$_POST["url"];
$bannerurl=$_POST["bannerurl"];
$email=$_POST["email"];
$credits=$_POST["credits"];
$displays=$_POST["displays"];
$approved=$_POST["approved"];
$paid=$_POST["paid"];

$sql1="update sbwmd_ads set url='$url',bannerurl='$bannerurl',email='$email',credits='$credits',displays='$displays',approved='$approved',paid='$paid' where id=$id";
mysql_query($sql1 );

header("Location: ". "ads.php?id=" . $_REQUEST["id"] . "&msg=" .urlencode("Banner has been updated!") );

?>
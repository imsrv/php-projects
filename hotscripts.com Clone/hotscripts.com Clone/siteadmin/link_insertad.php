<?
include_once("logincheck.php");
include_once("../config.php");
					   
		$q1 = "insert into sbwmd_banners set 
							img_url = '$_POST[img_url]' ";
		
		mysql_query($q1) or die(mysql_error());
		
header("Location: ". "link_ads.php?id=" . $_REQUEST["id"] . "&msg=" .urlencode("New plan has been added!") );

?>
<?
include_once "logincheck.php";
include_once "config.php";


//////////////////////////////////
$cid_t=$_REQUEST["cat1"] ;
$rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where   id=" . $cid_t ));

while(  $rs_1["pid"] <>0)
{
 $cid_t=$rs_1["pid"];
 $rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=" . $cid_t ));
}

$cid_plat=$rs_1["id"];
//////////////////////////////////

//Make platform String
$platforms="-1";
$rs_query_t=mysql_query("select * from sbwmd_platforms where cid=" .$cid_plat );

$cnt=0 ;  //Accepts only first two choices
while( ( $rs_t=mysql_fetch_array($rs_query_t) ))
{
$indx="plat_name".$rs_t["id"];
if ( isset($_REQUEST[$indx]) )					   
{
$cnt++;
$platforms .="," . $rs_t["id"] ;
}
}
///////platform string made


$s_name=str_replace("'","''",$_REQUEST["program_name"]);
$cid=str_replace("'","''",$_REQUEST["cat1"]);
$lid=str_replace("'","''",$_REQUEST["license_id"]);
if (isset($_REQUEST["currency_symbol_id"])&&isset($_REQUEST["cost"]))
{
$cur_id=str_replace("'","''",$_REQUEST["currency_symbol_id"]);
$price=str_replace("'","''",$_REQUEST["cost"]);
}
else
{
$cur_id=0;
$price=0.0;
}

$ss_url=str_replace("'","''",$_REQUEST["screenshot_location"]);
$home_url=str_replace("'","''",$_REQUEST["home_page"]);
$soft_url=str_replace("'","''",$_REQUEST["location"]);
$eval_period=str_replace("'","''",$_REQUEST["eval_period"]);
$version=str_replace("'","''",$_REQUEST["version"]);
$digital_riverid=str_replace("'","''",$_REQUEST["digital_river_id"]);
$rel_date= $_REQUEST["rev_year"] . $_REQUEST["rev_month"] . $_REQUEST["rev_day"] . "000000" ;

$major_features=str_replace("'","''",$_REQUEST["major_features"]);
$prog_desc=str_replace("'","''",$_REQUEST["long_description"]);
$author_notes=str_replace("'","''",$_REQUEST["notes"]);
$addnl_soft=str_replace("'","''",$_REQUEST["addl_required"]);

if (isset($_REQUEST["size"]))
{$size=$_REQUEST["size"];}
else
{$size=0;}
$sql="INSERT INTO sbwmd_softwares (s_name,cid,lid,platforms,cur_id,price,ss_url,home_url,soft_url,eval_period,version,digital_riverid,rel_date,size,featured,page_views,hits_dev_site,downloads,featured_display,approved,popularity,date_submitted,uid) 
VALUES('$s_name','$cid','$lid','$platforms','$cur_id','$price','$ss_url','$home_url','$soft_url','$eval_period','$version','$digital_riverid','$rel_date','$size','no',0,0,0,0,'no',0,'" . date("Ymdhis",time()). "'," .$_SESSION["userid"].")";
mysql_query($sql);
$s_id=mysql_fetch_array(mysql_query("select max(id) from sbwmd_softwares"));
$sid=$s_id[0];
mysql_query("INSERT INTO sbwmd_soft_desc (sid,major_features,prog_desc,author_notes,addnl_soft) 
VALUES($sid,'$major_features','$prog_desc','$author_notes','$addnl_soft')");

///////////////////////////////////////////////////////

//Gets member info
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config "));

$to=$rs0["admin_email"];


			 $from ="$email_from";
			 $to = $to;
			 $subject ="New Software Added";
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;

 	 $body="Hi Admin,\n\n New software '" . $s_name . "' has been added to your site. Your approval is required for this software to appear on the web site. Login at " . $rs0["site_addrs"] ."/siteadmin\n\nThanks." ; 
	 
			 mail($to,$subject,$body,$header);

//////////////////////////////////////////////////////////



header("Location:"."userhome.php?msg=".urlencode("Thanks for submitting your software. Your software is awaiting approval from the admin. Once it is approved, it will appear on our website"));
die();

?>
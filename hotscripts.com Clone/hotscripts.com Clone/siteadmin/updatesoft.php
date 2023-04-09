<?
include_once "logincheck.php";
include_once "../config.php";


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



$rst=mysql_fetch_array(mysql_query("select * from sbwmd_softwares where id=".$_REQUEST["id"]));
$featured=$rst["featured"];
$approved=$rst["approved"];
$uid=$rst["uid"];
$popularity=$rst["popularity"];
$featured_display=$rst["featured_display"];
$downloads=$rst["downloads"];
$page_views=$rst["page_views"];
$hits_dev_site=$rst["hits_dev_site"];

$s_name=str_replace("'","''",$_REQUEST["program_name"]);
$cid=str_replace("'","''",$_REQUEST["cat1"]);
$lid=str_replace("'","''",$_REQUEST["license_id"]);
if (isset($_REQUEST["currency_symbol_id"])&&isset($_REQUEST["cost"]))
{
$cur_id=str_replace("'","''",$_REQUEST["currency_symbol_id"]);
$price=str_replace("'","''",$_REQUEST["cost"]);
}
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
$admin_desc=str_replace("'","''",$_REQUEST["admin_desc"]);
$major_features=str_replace("'","''",$_REQUEST["major_features"]);
$prog_desc=str_replace("'","''",$_REQUEST["long_description"]);
$author_notes=str_replace("'","''",$_REQUEST["notes"]);
$addnl_soft=str_replace("'","''",$_REQUEST["addl_required"]);

if (isset($_REQUEST["size"]))
$size=$_REQUEST["size"];
else
$size=0;
$sql="update sbwmd_softwares set s_name='$s_name',cid=$cid,lid=$lid,platforms='$platforms',cur_id=$cur_id,price=$price,ss_url='$ss_url',home_url='$home_url',soft_url='$soft_url',eval_period='$eval_period',version='$version',digital_riverid='$digital_riverid',rel_date='$rel_date',size=$size,featured='$featured',page_views=$page_views,hits_dev_site=$hits_dev_site,downloads=$downloads,featured_display=$featured_display,approved='$approved',popularity=$popularity,date_submitted='" . date("Ymdhis",time()). "',uid=$uid, admin_desc='$admin_desc' where id=".$_REQUEST["id"];

mysql_query($sql);


$sid=$_REQUEST["id"];

$sql1="update sbwmd_soft_desc set sid=$sid,major_features='$major_features',prog_desc='$prog_desc',author_notes='$author_notes',addnl_soft='$addnl_soft' where sid=$sid";

mysql_query($sql1);

header("Location:"."software.php?msg=".urlencode("You software has been edited"));

?>
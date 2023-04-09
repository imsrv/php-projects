<?
include "logincheck.php";
include_once "config.php";

$id=$_SESSION["userid"];
$c_name=str_replace("'","''",$_REQUEST["company_name"]);
$c_contact=str_replace("'","''",$_REQUEST["company_contact"]);
$stadd1=str_replace("'","''",$_REQUEST["stadd1"]);
$stadd2=str_replace("'","''",$_REQUEST["stadd2"]);
$city=str_replace("'","''",$_REQUEST["city"]);
$state_non_us="";
$state_us=0;


if(isset($_REQUEST["state_province"])  && $_REQUEST["state_province"]!=""  )
{

$state_us=str_replace("'","''",$_REQUEST["state_province"]);
}
  else
{

if( isset($_REQUEST["state_province_non"]) )
{
$state_non_us=str_replace("'","''",$_REQUEST["state_province_non"]);
}

}

$zip=str_replace("'","''",$_REQUEST["zip_code"]);
$country=str_replace("'","''",$_REQUEST["country"]);
$phone=str_replace("'","''",$_REQUEST["phone_number"]);
$fax=str_replace("'","''",$_REQUEST["fax_number"]);
$email=str_replace("'","''",$_REQUEST["email_addr"]);
$homepage=str_replace("'","''",$_REQUEST["home_page"]);
$username=mysql_fetch_array(mysql_query("select username from sbwmd_members where id=$id"));

if(isset($_REQUEST["offers"]))
$recieve_offer="y";
else
$recieve_offer="n";
$pwd=str_replace("'","''",$_REQUEST["pwd"]);
mysql_query("update sbwmd_members set c_name='$c_name',c_contact='$c_contact',stadd1='$stadd1',stadd2='$stadd2',city='$city',state_us='$state_us',state_non_us='$state_non_us',zip='$zip',country='$country',phone='$phone',fax='$fax',email='$email',homepage='$homepage',username='$username[0]',recieve_offer='$recieve_offer',pwd='$pwd' where id=$id" );

header("Location:"."userhome.php?msg=".urlencode("You have successfully updated your profile"));
?>
<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";



$rs0_query=mysql_query ("select * from sbwmd_members where username='" . $_REQUEST["username"]. "'");
if ($rs0=mysql_fetch_array($rs0_query))
{

function main()
{
?><p><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><br>
					<br>
				</strong></font></p>
<p align="center"><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Sorry, 
  Someone has already registered with this username.<br>
  Please go back and choose another userid for registration </strong></font></p>
<form>
  <div align="center">
    <input type="button" name="Submit" value="Back" onclick="javascript:window.history.go(-1);">
  </div>
</form>
<p align="center">
  <? 
  }
  include_once "template.php";

  
}
else
{







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
if(isset($_REQUEST["state_province_non"])&& $_REQUEST["state_province_non"]<>"")
$state_non_us=str_replace("'","''",$_REQUEST["state_province_non"]);
}
$zip=str_replace("'","''",$_REQUEST["zip_code"]);
$country=str_replace("'","''",$_REQUEST["country"]);
$phone=str_replace("'","''",$_REQUEST["phone_number"]);
$fax=str_replace("'","''",$_REQUEST["fax_number"]);
$email=str_replace("'","''",$_REQUEST["email_addr"]);
$homepage=str_replace("'","''",$_REQUEST["home_page"]);
$username=str_replace("'","''",$_REQUEST["username"]);
if(isset($_REQUEST["offers"]))
$recieve_offer=str_replace("'","''",$_REQUEST["offers"]);
else
$recieve_offer="n";
$pwd=str_replace("'","''",$_REQUEST["pwd"]);


mysql_query("INSERT INTO sbwmd_members (c_name,c_contact,stadd1,stadd2,city,state_us,state_non_us,zip,country,phone,fax,email,homepage,username,recieve_offer,pwd) 
VALUES('$c_name','$c_contact','$stadd1','$stadd2','$city','$state_us','$state_non_us','$zip','$country','$phone','$fax','$email','$homepage','$username','$recieve_offer','$pwd')");

mysql_query ("delete from sbwmd_signups where email='" . $email. "'");

///////////////////////////////////////////////////////

//Gets member info
$sql = "SELECT max(id) FROM sbwmd_members" ;
$rs_query=mysql_query($sql);
$rs=mysql_fetch_array($rs_query);
$uid=$rs[0];


$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_members where id=" . $uid));


//Reads email to be sebt
$sql = "SELECT * FROM sbwmd_mails where id=1" ;
$rs_query=mysql_query($sql);

if ( $rs=mysql_fetch_array($rs_query)  )
  {
			 $from =$rs["fromid"];
			 $to = $rs0["email"];
			 $subject =$rs["subject"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;

 	 $body=str_replace("<email>", $rs0["email"],str_replace("<username>",  $rs0["username"],str_replace("<password>", $rs0["pwd"],str_replace("<name>", $rs0["c_name"], $rs["mail"] )))) ; 
	 
    		 mail($to,$subject,$body,$header);

  }

//////////////////////////////////////////////////////////

header("Location:"."signinform.php?msg=".urlencode("You have successfully registerd with us"));
}
?>
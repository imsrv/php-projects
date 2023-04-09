<?
include "logincheck.php";
include_once "../config.php";
$id=$_REQUEST["id"];
$rst=mysql_fetch_array(mysql_query("select * from sbwmd_softwares where id=".$_REQUEST["id"]));
$uid=$rst["uid"];
$s=$rst["s_name"];
if($rst["approved"]=="yes")
{
$approved="no";
$mailid=3;
}
else
{
$approved="yes";
$mailid=2;
}
mysql_query("update sbwmd_softwares set approved='$approved' , date_approved='" . date("Ymdhis",time()) .  "' where id=$id");

///////////////////////////////////////////////////////

//Gets member info
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_members where id=" . $uid));


//Reads email to be sebt
$sql = "SELECT * FROM sbwmd_mails where id=$mailid" ;
$rs_query=mysql_query($sql);

if ( $rs=mysql_fetch_array($rs_query)  )
  {
			 $from =$rs["fromid"];
			 $to = $rs0["email"];
			 $subject =$rs["subject"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;

 	 $body=str_replace("<softwarename>", $s ,str_replace("<email>", $rs0["email"],str_replace("<username>",  $rs0["username"],str_replace("<password>", $rs0["pwd"],str_replace("<name>", $rs0["c_name"], $rs["mail"] ))))) ; 
	 
			 mail($to,$subject,$body,$header);

  }

//////////////////////////////////////////////////////////


header("Location:"."software.php?id=$id&pg=".$_REQUEST["pg"]);

?>
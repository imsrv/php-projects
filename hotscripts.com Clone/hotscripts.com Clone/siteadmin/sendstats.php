<?
include_once("logincheck.php");
include_once("../config.php");
					   
$id=$_REQUEST["id"];




///////////////////////////////////////////////////////

//Gets member info
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_ads where id=" . $id));


//Reads email to be sebt
$sql = "SELECT * FROM sbwmd_mails where id=5" ;
$rs_query=mysql_query($sql);

if ( $rs=mysql_fetch_array($rs_query)  )
  {
			 $from =$rs["fromid"];
			 $to = $rs0["email"];
			 $subject =$rs["subject"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;

 	 $body=str_replace("<displays>", $rs0["displays"],str_replace("<credits>", $rs0["credits"] ,str_replace("<balance>", ($rs0["credits"] - $rs0["displays"]   ) ,str_replace("<softwarename>", "" ,str_replace("<email>", $rs0["email"],str_replace("<username>", "" ,str_replace("<password>", "",str_replace("<name>", "", $rs["mail"] )))))))) ; 
	 
			 mail($to,$subject,$body,$header);
  }

//////////////////////////////////////////////////////////

header("Location: ". "ads.php?id=" . $_REQUEST["id"] . "&msg=" .urlencode("Stats have been sent!") );

?>
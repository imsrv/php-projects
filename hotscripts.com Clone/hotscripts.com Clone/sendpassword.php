<?
include_once("config.php");
if (  !isset($_REQUEST["email"]) ||($_REQUEST["email"]=="") )
{
 header("Location: ". "lostpassword.php?msg=Please provide your email id to retrieve your password!" );
 die();
}

  $sql = "SELECT * FROM sbwmd_members WHERE email = '" . $_REQUEST["email"] . "'" ;

$rs_query=mysql_query($sql);
if ( $rs=mysql_fetch_array($rs_query)  )
  {

							
			 $from ="admin@affiliates.com";
			 $to = $rs["email"];
			 $subject = "Affiliate System: Password Retrieval";
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
	
	$body="Hi,\n\nAs you had requested to send your user Id and password in your mailbox, here it is: \n\nUser Id : " . $rs["email"] . "\nPassword : " . $rs["password"] . "\n\nThanks, \nWMD Team\n";
			 mail($to,$subject,$body,$header);
			 header("Location: ". "signinform.php?msg=".urlencode( "You password has been e-mailed") );
}
else
{
 header("Location: ". "lostpassword.php?msg=" . urlencode("No Member found with this email id!") );
 die();
}
?>
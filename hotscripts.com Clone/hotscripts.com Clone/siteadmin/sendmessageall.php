<?
include_once("../config.php");

if ( $_REQUEST["radiobutton"]=='A' || $_REQUEST["radiobutton"]=='B')
{
			$sql="Select * from sbwmd_members";
			$rs0=mysql_query($sql);
			$cnt=0;
			while ( ($rs=mysql_fetch_array($rs0)) )
			{							
			 $from =$_REQUEST["email"];
			 $to = $rs["email"];
			 $subject = $_REQUEST["subject"];
			 $body = $_REQUEST["message"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
			 mail($to,$subject,$body,$header);
			}

}

if ( $_REQUEST["radiobutton"]=='M' || $_REQUEST["radiobutton"]=='B')
{
			$sql="Select * from sbwmd_mailing_list";
			$rs0=mysql_query($sql);
			$cnt=0;
			while ( ($rs=mysql_fetch_array($rs0)) )
			{							
			 $from =$_REQUEST["email"];
			 $to = $rs["useremail"];
			 $subject = $_REQUEST["subject"];
			 $body = $_REQUEST["message"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
			 mail($to,$subject,$body,$header);
			}

}


header("Location: ". "adminhome.php?msg=" . urlencode("Your Message has been sent!") );
?>
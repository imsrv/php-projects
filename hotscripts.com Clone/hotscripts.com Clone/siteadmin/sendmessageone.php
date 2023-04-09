<?
			 $from =$_REQUEST["from"];
			 $to = $_REQUEST["email"];
			 $subject = $_REQUEST["subject"];
			 $body = $_REQUEST["message"];
		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
			 mail($to,$subject,$body,$header);

header("Location: ". "adminhome.php?msg=" . urlencode("Your Message has been sent!") );
?>
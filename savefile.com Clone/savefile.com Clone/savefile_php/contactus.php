<?
	include("include/common.php");
	include("include/header.php");
	$tomail = $admin25email;
	if($name && $email2){
		$subject = "$sitename -- Contact Page";
		while( list($key,$val) = each($_POST) ){
			$amsg .= "<b>$key</b> : $val<br>\n";
		}
		$headers = "From: $name <$email2>\r\nReply-To: $replyto\r\n";
		$headers .= "X-Sender: <$email2>\n"; 
		$headers .= "X-Mailer: PHP\n"; // mailer
		$headers .= "Return-Path: <$tomail>\n";  // Return path for errors
		$headers .= "Content-type: text/html\n\n";
		mail($tomail,$subject,$amsg, $headers);
		echo "<font color=red>Thank you, your message was successfully sent.</font><br>";
	}
?>
<p>
	Please use this form to inquire about our site.  We will answer your question as soon as possible.</font>
	 
<form action="contactus.php" method="POST">
  <b>Name</b><br>
  <input type=text name=name size=30 tabindex="1">
  <br>
  <span style="padding-left:5px;"><br>
  <b>Email</b><br>
  </span> 
  <input type=input name=email2 size=30 tabindex="2">
  <br>
  <span style="padding-left:5px;"><br>
  <b>Questions/Comments</b><br>
  <textarea name="Questions" cols="39" rows="4" tabindex="3"></textarea>
  <br>
  </span> <br>
  <input type="hidden" name="subject" value="subject in subject line">
  <input type="submit" name="" value="Continue" tabindex="4" style="background-color:#e5e5e5; color:#000000; font-family:Verdana,Arial; font-weight: bold; font-size: 11px; border-left: 1 solid #a0a0a0; border-top: 1 solid #a0a0a0; border-right: 1 solid #000000; border-bottom: 1 solid #000000; padding: 2 2 2 2; outline: #a0a0a0 solid 2px;">
  <br>
</form></p>
<?
	include("include/footer.php");
?>
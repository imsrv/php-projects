<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
	  	<title>Custom Contact Form</title>
	</head>
<DIV ALIGN="center"><BODY background="backgroundbluelight.gif">
<TABLE BGCOLOR="#FFFFFF" BORDER="1" CELLSPACING="0" CELLPADDING="10" BORDERCOLOR="#000080">
<TR>
	<TD>
<!-- change above headers to your liking -->
<?php
/*
--------------------------------------------------------------
|Custom Contact Form version 1                               |
|(c)Mike Mason 2005                                          |
|For more scripts or assistance go to the forums at          |
| www.mikemason.org                                          |
|You may use this program only if the copyright & Authors    |
|Link remains intact. If it is not, it is a breach of your   |
|License                                                     |
--------------------------------------------------------------
*/
//change to your email address
$youremail = "you@yoursite.com";
@extract($_POST);
$name = stripslashes($name);
$email = stripslashes($email);
$subject = stripslashes($subject);
$message = stripslashes($message);
// add or remove these lines to reflect how many questions are in customcontact.php
$text1 = stripslashes($text1);
$text2 = stripslashes($text2);
$text3 = stripslashes($text3);
$text4 = stripslashes($text4);
$text5 = stripslashes($text5);
// below is the text of the email you will receive, change to suit your needs
$msg = "
Question 1: $text1
Question 2: $text2
Question 3: $text3
Question 4: $text4
Question 5: $text5
Message: $message
";
$validstring = '^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,3}))$';
if (!eregi($validstring,$email)&&$email) {
$emailcorrect = 0;
}
else  {
$emailcorrect = 1;
}
if($email&&$subject&&$name&&$message&&$emailcorrect) {
if(mail($youremail, $subject, $msg, "From: $name <$email>")) {
echo "Your e-mail was sent. <br>Thank you $name, for the message.<br><br>You will receive a reply shortly. ";
}
}
//These are the required fields your vistor must fill in
if(!$email||!$subject||!$name||!$message) {
echo  "Sorry, $name, <br>your e-mail was not sent<br> you have forgotten to fill in a detail.";
}
if (!$emailcorrect) {
echo "Sorry, $name, <br>your e-mail address is not valid.";
}
?>
</TD>
</TR>
</TABLE>
<!-- Authors Link --> 
<font size="-2">&copy;<A HREF="http://www.mikemason.org">MikeMason.org</A></font>
<!-- -->
</DIV>
</body>
</html>
<?PHP
/*
#
#	$Id: FEEDBACK.PHP
#	Version 2.0.0
#
*/

include "header.php";

 if($Submit) {
	$headers = "From: $mailname <$mailadmin>\nReply-To: $mailadmin";
	$subject = "PicMe Site Feedback from $userid";
	$message = "$userid - ($email)\n$message";
	mail($mailadmin, $subject, $message, $headers);
	
	echo "<br><br>Thank you for your feedback...";
	
} else {	

?>
<br><br>
<? echo "$FeedbackinfoText"; ?> 
<br><br>
Fields marked with an <font color="red" size="3">*</font> are required fields.<br>
<form name="feedback" action="<? $PHP_SELF; ?>" method="post">
<table border="0" cellpadding="0" cellspacing="1" width="100%" align="left">
<tr>
<td valign="top" align="left" width="25%" nowrap><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Your Name</font></td>
<td><input type="text" name="userid" size="24"><font size="5" color="red">*</font></td>
</tr>
<tr>
<td valign="top" align="left" colspan="2" bgcolor="#696969"></td>
</tr>
<tr>
<td valign="top" align="left" nowrap colspan="2" bgcolor="#ffefd5"><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="2">Enter your email address. </font></td>
</tr>
<tr>
<td valign="top" align="left" width="25%" nowrap><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Email Address</font></td>
<td><input type="text" name="email" size="24"><font size="5" color="red">*</font></td>
</tr>
<tr>
<td valign="top" align="left" colspan="2" bgcolor="#696969"></td>
</tr>
<tr>
<td valign="top" align="left" colspan="2" bgcolor="#ffefd5"><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="2">Enter you're feedback or comment below.</font></td>
</tr>
<tr>
<td valign="top" align="left"><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Message</font></td>
<td valign="top" align="left"><textarea name="message" cols="40" rows="4"></textarea></td>
</tr>
<tr>
<td valign="top" align="left" width="25%"><input type="submit" name="Submit" value="Submit"></td>
<td><input type="hidden" value="on" name="feedbacksubmit"></form>
</tr>
</table>
<?PHP
}
?>
<?PHP
include "footer.php";
?>
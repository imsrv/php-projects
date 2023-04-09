<?php
/*
#
#	$Id: FORGOT.PHP
#	Version 2.1.0
#
*/

 include "header.php";

 if($forgotsubmit) {
	$sql = "select * from users where email ='$email'";  	
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
		$userid = $row["userid"];
		$password = $row["password"];
	}
	$headers = "From: $mailname <$mailadmin>\nReply-To: $mailadmin\nMime-Version: 1.0\nContent-Type: text/html;\nContent-Transfer-Encoding: 7bit\n";
	$subject = "PicMe Forgotten Password";
	$msgPass = "<font face=\"Arial\" size=\"2\">
	You recently requested your <b>password</b> on our site.  Below is your information.  If you did not request this, please notify our administrator by visiting our site.<p></font>";
	mail($email, $subject, $msgPass."\n\n<br><b>Login:</b> $userid\n<br><b>Password:</b> $password\n\n<p>Thank you and enjoy…\n<br><a href=\"$siteurl\">$sitename</a>", $headers);		

	echo "<br><br>Please wait a few minutes for the system to process your request, <br>and then check your email for your password.";
	include "footer.php";
	exit;
 } else {

	 echo "<font size=2>\n
	 <br><br><center>Enter in your email address and we will send you the password.<p>\n
	 <table border=0 cellpadding=3 cellspacing=2>\n
	<tr>\n
		<td>\n
			<form name=ForgotPassword action=forgot.php method=get>\n
				<table border=0 cellpadding=0 cellspacing=0 width=100>\n
					
					<tr>\n
						<td><b><center>Your Email Address
							</b><input type=text name=email size=30 maxlength=50></td>\n
					</tr>\n
					<tr>\n
						<td>\n
							<div align=center>\n
								<input type=submit name=forgotsubmit value='Forgot Password'>\n
								</font></div>\n
						</td>\n
					</tr>\n
				</table>\n
			</form>\n
		</td>\n
		</tr>\n
	</table></center>\n";
 }
 include "footer.php";
?>
<?PHP
/*
#
#	$Id: JOIN.PHP
#	Version 2.1.0
#
*/

include "header.php";

if($submit) {

echo "<br>";
echo "<br>";
	if($emailvisible=="") { $emailvisible ="0";}
	$updated = date("Y-m-d");
	$sql = "select * from $users where userid ='$userid'";  	
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
	 $existing= $row["userid"];
	}
	if($existing == "$userid") {
	echo "<b>Ouch!</b> User ID $userid already exists.  Go back and pick another userid..";
		exit;		
		}
	$password = generate();
	$sql2 = "insert into users (id, userid, password, email, sex, hobbies, music, chat, updated, emailvisible, year, country, state, quote)values ('','$userid','$password','$email','','','','','$updated','$emailvisible', '', '', '', '')";  	
	$sql_result = mysql_query($sql2); 
	echo( mysql_error());
	$headers = "From: $mailname <$mailadmin>\nReply-To: $mailadmin\nMime-Version: 1.0\nContent-Type: text/html;\nContent-Transfer-Encoding: 7bit\n";
	$subject = "PicMe Registration Details";
	mail($email, $subject, $msgText."\n\n<br><b>Login:</b> $userid\n<br><b>Password:</b> $password\n\n<p>Thank you, enjoy… And behave...\n<br><a href=\"$siteurl\">$sitename", $headers);
	$headers = "From: NewID <$mailadmin>\nReply-To: $mailadmin";
	mail("$mainadmin", "New User ID", "userid: $userid $password \n", $headers);
echo "<b>Done!...</b><br>Thank you $userid, Please allow a few minutes for our system to process your request and check your email for you new generated password.";	 

} else {

?>
<br><br>
<div align="center">
<font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Fields marked with an </font><font color="red" size="3">*</font><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"> are required fields.</font>
<br><b><FONT COLOR=red>NOTE: The address of the computer you are using is: <? echo $ip; ?> </b></font>
</div>

<form name="newuser" action="<? $PHP_SELF; ?>" method="submit">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
<tr>
<td valign="top" align="left" nowrap colspan="2" bgcolor="#ffefd5">
Enter desired username. Example: <font color="red" size="2">jdoe</font>
</td>
</tr>
<tr>
<td valign="top" align="left" width="25%" nowrap>User Name
</td>
<td><input name="userid" size="24" ><font size="5" color="red">*</font>
</td>
</tr>
<tr>
<td valign="top" align="left" colspan="2" bgcolor="#696969"></td>
</tr>
<tr>
<td valign="top" align="left" nowrap colspan="2" bgcolor="#ffefd5"><font size="2">
Enter your email address. The password is emailed to you.</font>
</td>
</tr>
<tr>
<td valign="top" align="left" width="25%" nowrap><font size="1">Email Address</font>
</td>
<td><input name="email" size="24" ><font size="5" color="red">*</font>
</td>
</tr>
<tr>
<td valign="top" align="left"></td>
<td valign="top" align="left"><input type="checkbox" value="1" name="emailvisible" checked> <font size="1">
Email address is visible on profile</font>
</td>
</tr>
<tr>
<td valign="top" align="left" colspan="2" bgcolor="#696969"></td>
</tr>
</table>
<center><input type="submit" name="submit" value="Submit"></center>
</form>

<?PHP
}
include "footer.php";
?>
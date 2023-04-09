<HTML>
<HEAD><TITLE>Change Password</TITLE>

<?php
require("database.php3");
require("include.php3");

/* check password */
$result=mysql_query("SELECT *
                     FROM passwd
                     WHERE email='$email'");


if ($result!=0){
	$row=mysql_fetch_array($result);
	$ckpasswd=$row['epasswd'];
}

if (($ckpasswd == '') || ($email == '')){
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=changepassform.html\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
	msg_box("Account not found", 
	"<CENTER>Your account was not found in the database.</CENTER>", 
	"black");
	echo "</BODY></HTML>";
	exit;
}
 
if ($ckpasswd==$opasswd)
{
	if (($epasswd1!=$epasswd2) || ($epasswd1=='')) {
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"10; URL=changepassform.html\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
		msg_box("Change Password Results",
		"New passwords do not match, or you tried to change
		your password to a blank password.  The password
		cannot be blank!", "black");
		echo "</BODY></HTML>";
	} 
	else {	@mysql_query("		UPDATE passwd 
					SET epasswd='$epasswd1' 
					WHERE email='$email'");

		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3; URL=index.php3\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
		msg_box("Change Password Results",
		"<CENTER>New password was set successfully.</CENTER>", 
		"black");
		$epasswd=$epasswd1;
	}
} 

else { 	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=changepassform.html\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
	msg_box("Change Password Results", 
	"<CENTER>Current Password was not entered correctly!</CENTER>", 
	"black");

	$epasswd=$opasswd; /* set password to null since user doesn't know it */ 
}
?>

</CENTER>
</BODY>
</HTML>

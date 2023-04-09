<?php
require("database.php3");
require("include.php3");

?>
<!-- Code for top of page -->
<HTML>
<HEAD><TITLE>E-mail blocked</TITLE>
<?php

/* check password */
$result=mysql_query("SELECT *
                     FROM passwd
                     WHERE email='$email'");

while ($row=mysql_fetch_array($result)){
	$ckpasswd=$row['epasswd'];
	$blocked=$row['eblocked'];
}
if ($ckpasswd==''){
		echo "</HEAD><BODY BGCOLOR=#000000>";
		msg_box("Address Not Found!", 
		"Your E-mail address was not found in the database. 
		Please sign up for an account first.", "black");
		echo "</BODY></HTML>";
		exit;
}

if ($ckpasswd==$epasswd){
	if ($blocked=='N'){
		// Block from further messages
		@mysql_query("	UPDATE passwd
				SET eblocked='Y' WHERE email='$email'");
		// Delete any entries in the database
		@mysql_query("	DELETE FROM notify
				WHERE email='$email'");
		echo "</HEAD><BODY BGCOLOR=#000000>";
		msg_box("E-mail Blocked", "
		Your address was successfully blocked.  You will no longer
		receive any messages from this site.  If you'd like to 
		use E*Reminders, simply 'block' the address again with
		your current password, and it will no longer be blocked.<P>
		<B>Note:</B> You cannot request your password through E-mail 
		any more, so remember the password if you intend on 
		using this site again.", "black");
	} 
	else {
		@mysql_query("	UPDATE passwd
				SET eblocked='N' WHERE email='$email'");
		echo "</HEAD><BODY BGCOLOR=#000000>";
		msg_box("E-mail Un-Blocked", "
		Your address was successfully unblocked.  You can now use
		this site to schedule E*Reminders to be sent to your 
		address", "black");
	}
} 
else {	
	echo "</HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
	msg_box("Incorrect Password", 
	"Please enter correct password and try again.", "black");
}

?>

</BODY>
</HTML>


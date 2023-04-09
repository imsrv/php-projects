<HTML>
<HEAD><TITLE>Change Password</TITLE>

<?php
require("database.php3");
require("include.php3");

/* check password */
$result=mysql_query("SELECT *
                     FROM passwd
                     WHERE email='$email'");
if ($result){
	$row=mysql_fetch_array($result);
	$ckpasswd=$row['epasswd'];
	$email=$row['email'];
	$blocked=$row['eblocked'];
} 

$result=mysql_query("	SELECT unix_timestamp(esentpass)
			FROM passwd
			WHERE email='$email'");
if ($result){
	$row=mysql_fetch_array($result);
	$date_field=$row['unix_timestamp(esentpass)'];
}

$unixtime=date("U");
	
if (($ckpasswd != "") && ($blocked=='N') && ($unixtime-$date_field>86400))
{
	@mysql_query("	UPDATE passwd
			SET esentpass=NOW()
			WHERE email='$email'");
	$message.="This message was generated because a user at $REMOTE_ADDR\n";
	$message.="requested the E*REMINDERS password that is connected to\n";
	$message.="this mail address to be sent here.  \n\n";
	$message.="The password is: $ckpasswd\n\n";
	$message.="If you did not request this, please go to $site\n";
	$message.="and block your address from any further E-mail.\n";

	mail ($email, "E*REMINDERS PASSWORD", $message);

	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"10; URL=index..html\"></HEAD><BODY BGCOLOR=#000000>";
	
	msg_box("Send Password Results", 
	"<CENTER>The password was sent successfully</CENTER>", "black");
} 
else { 	
	echo "</HEAD><BODY BGCOLOR=#000000>";
	msg_box("Send Password Results",
	"<B>Mail address does not exist, is blocked, or you have 
	used this account or sent a password to this address within 
	the last 24 hours.</B><P>
	To create an account, go <A HREF=index.php3>here</A>
	and leave everything blank but the \"E-mail To\" field, and click
	on save.", "black");
}
?>

</CENTER>
</BODY>
</HTML>

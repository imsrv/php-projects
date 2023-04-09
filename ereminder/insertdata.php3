<HTML>
<HEAD><TITLE>E*Reminder Submissions</TITLE></HEAD>
<BODY BGCOLOR="#000000">
<CENTER>

<?php
require("database.php3");
require("include.php3");

/* check password to make sure it is correct OR blank */
$result=mysql_query("	SELECT * 
			FROM passwd 
			WHERE email='$email'");

while ($row=mysql_fetch_array($result)){
	$ckpasswd=$row['epasswd'];
	$blocked=$row['eblocked'];
}

$edate=date("M d Y, h:ia ").$dbtimezone; 

/* Is this a new user that doesn't have a password yet?  Joy! :-) */
if (($ckpasswd=="") && ($email != ''))
{
	/* Let's generate a new random password */
	
	// Seed random generator
	srand((double)microtime()*1000000);
	
	for ($i=1; $i<=$passlength; $i++){
		$epasswd=$epasswd.chr(rand(97,122));
	}	
	
	@mysql_query("	INSERT INTO passwd (email,epasswd,eip,edate)
			VALUES ('$email','$epasswd','$REMOTE_ADDR','$edate')");
	$ckpasswd=$epasswd;
	
	$message = "A request originating from ".$REMOTE_ADDR." was made\n";
	$message .= "to add this E-mail address to the Reminders database\n";
	$message .= "at ".$site.".  \n\n";
	$message .= "To use the service, log in with this password: ".$epasswd;
	$message .= "\n\nIf you did not sign up for this, please go to";
	$message .= "\nthe site above to block your address from further\n";
	$message .= "messages.  Don't delete this message yet, you will\n";
	$message .= "need the password in here to block your address\n";

	mail ($email, "E*REMINDER PASSWORD", $message);

	msg_box("New Account",
	"This seems to be a new account, so your event is not yet set up.<P>
	The new account password has been generated and sent to $email.  Please click
	the <b>back</b> button on your browser now, and use the password coming
	momentarily in your email to resubmit your first event reminder.<P>
	Thank you for using E*Reminders!","black");

	// Yes, this exit in the middle is not optimal, but it works. 
	echo "</BODY></HTML>";
	exit;	
}

/* if password matches, do the database add */
if ($ckpasswd==$epasswd) 
{
	/* Rewrite the passwd data to update edate and eip */
	@mysql_query("	UPDATE passwd
			SET edate='$edate'
			WHERE email='$email'");
	/* ...maybe this can be shortened to just one query? */
	@mysql_query("	UPDATE passwd
			SET eip='$REMOTE_ADDR'
			WHERE email='$email'");

	/* Construct Database Query , also check for 12 pm/am idiosyncracy */

	if ($ampm == "pm") {$hour=$hour+12;}
	if ($hour == "12") {$hour=0;}
	if ($hour == "24") {$hour=12;}

	$query=$year.$month.$cal_day.$hour.$minute."00";	
	$id=uniqid("");

	$shortcomment=$comment;

	/* Show the time THEY set the event for, in THEIR timezone */
	if ($adv_notice == "yes"){
		$comment=$month."-".$cal_day."-".$year." at ".$hour.":".$minute." GMT".$localzone."...\n\n".$comment;
	}

	@mysql_query("	INSERT INTO notify
				(date_field,email,comment,recur_num,
				 recur_val,adv_notice,notify_num,notify_val,
				 recurring,id,subject)
			VALUES 
				('$query','$email','$comment','$recur_num',
				 '$recur_val','$adv_notice',
				 '$notify_num','$notify_val','$recurring','$id','$subject')
				");

	/* 	if advanced notice was checked calculate actual notify date 
		and update.  this is kind of messy.  we really could be
		using the newer mysql support for this.  Maybe we'll find
		time to do it one day
	*/
	if ($adv_notice=="yes") {
			$result=mysql_query("	SELECT *
               		                   	FROM notify
                                  		WHERE id='$id'");
 			$row=mysql_fetch_array($result);
			$interval=$row['notify_num'];

	                switch ($row['notify_val']) {
                        case "day"      :
                                $interval=$interval*86400;
                                break;
                        case "minute"      :
                                $interval=$interval*60;
                                break;
                        case "hour"     :
                                $interval=$interval*3600;
                                break;
                        case "month"    :
				$interval=$interval*2592000;
                                break;
                        case "year"     :
                                $interval=$interval*31536000;
                                break;
					}
			$result=mysql_query("
					SELECT unix_timestamp(date_field)
                        	        FROM notify
                                	WHERE id='$id'
			");

                	$row=mysql_fetch_array($result);
			$new_time=$row['unix_timestamp(date_field)']-$interval;

                	@mysql_query("  UPDATE notify
					SET date_field=FROM_UNIXTIME($new_time)
                                        WHERE id='$id'");
	}

	/* Adjust event date to compensate for Timezone user selected */
	$result=mysql_query("
		SELECT unix_timestamp(date_field)
                FROM notify
                WHERE id='$id'
	");

        $row=mysql_fetch_array($result);
	$new_time=$row['unix_timestamp(date_field)']-(($dbtzcorrect+$localzone)*3600);

        @mysql_query("  UPDATE notify
			SET date_field=FROM_UNIXTIME($new_time)
                        WHERE id='$id'");
			
?> 
	<TABLE BGCOLOR="#CCCCCC" CELLPADDING=5 CELLSPACING=1 BORDER=0 WIDTH=60%>
	<TD BGCOLOR="#6677DD" ALIGN=CENTER COLSPAN=2><B>
	<FONT SIZE=+1 COLOR=#FFFFFF FACE='arial,helvetica'>
	Reminder Submission</FONT></B> 
	</TD>
	<TR>
	<TD ALIGN=CENTER COLSPAN=2><FONT SIZE=+1>
<?php
	echo "Message will be sent to: $email
	<P>
	For the following date and time: <BR>
	$month/$cal_day/$year $hour:$minute:00 GMT$localzone
	<P>
	Event: $subject<P>
	Content of message:<BR>
	$shortcomment 
	</FONT></TD></TR>
	<TR><TD ALIGN=center>
	<FORM METHOD=POST ACTION=listdata.php3>
	<INPUT TYPE=hidden VALUE=$email NAME=email>
	<INPUT TYPE=hidden VALUE=$epasswd NAME=epasswd>
	<INPUT TYPE=submit VALUE='Edit Pending Reminders'>
	</FORM></TD>
	<TD ALIGN=center>
	<A HREF=\"help.html\">Help/About</A><BR><A HREF=\"adminoptions.html\">Account Options</A><BR><A HREF=\"index.php3\">Home</A>
	</TD></TR>
	</TABLE></CENTER>";
} 
else {
	msg_box("Incorrect Password",
	"The password entered was incorrect, or E-mail 
	has been blocked to this account.", "black");
}
?>

</BODY>
</HTML>



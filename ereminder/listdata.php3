<?php
require("database.php3");
require("include.php3");

?>
<!-- Code for top of page -->
<HTML>
<HEAD><TITLE>Pending E*Reminders</TITLE>
<?php

/* check password */
$result=mysql_query("SELECT *
                     FROM passwd
                     WHERE email='$email'");

while ($row=mysql_fetch_array($result)){
	$ckpasswd=$row['epasswd'];
}

if (($ckpasswd=='') || ($email=='')){
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3; URL=listpassword.html\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
	msg_box("Account not found", 
	"<CENTER>Your Account was not found in the database.</CENTER>", 
	"black");
	echo "</BODY></HTML>";
	exit;
}

if ($ckpasswd==$epasswd){
	/* Query Database */
	$num=1;
	$result=mysql_query("   SELECT email, subject, comment,
UNIX_TIMESTAMP(date_field),id,recurring,recur_num,recur_val,adv_notice,notify_num,notify_val
        	                FROM notify
                	        WHERE email='$email'      ");
	echo "
	</HEAD><BODY BGCOLOR=\"#000000\"><FORM METHOD=POST ACTION=deletedata.php3?option=WRITE>
	<INPUT TYPE=hidden NAME=email VALUE=$email>
	<INPUT TYPE=hidden NAME=epasswd VALUE=$epasswd>
	<CENTER>
	<TABLE BORDER=0 BGCOLOR=#DDDDDD CELLSPACING=1 CELLPADDING=3 WIDTH=80%>
	<FONT SIZE=+2>
	<TD COLSPAN=6 BGCOLOR=#6677DD>
	<CENTER>
	<FONT SIZE=+1 FACE=\"arial,helvetica\" COLOR=#FFFFFF>
	Pending E*Reminders for: $email</FONT>
	</CENTER>	
	</TD>
	<TR>
	<TD ALIGN=CENTER><B>Delete</B></TD> 
	<TD ALIGN=CENTER><B>Date of next message</B></TD>
	<TD ALIGN=CENTER><B>Advance Notice</B></TD>
	<TD ALIGN=CENTER><B>Recurring</B></TD>
	<TD ALIGN=CENTER><B>Event</B></TD>
	<TD ALIGN=CENTER><B>Message</B></TD>
	";
 
	while ($row=mysql_fetch_array($result)){
		$email=$row['email'];
		$subject=$row['subject'];
		$comment=$row['comment'];

		/* Get date field to friendly format */
		$date_field=$row['UNIX_TIMESTAMP(date_field)'];
		$neat_date=date("D M d, Y h:i:s A",$date_field);
	
		$id=$row['id'];
		$recurring=$row['recurring'];
		$recur_num=$row['recur_num'];	
		$recur_val=$row['recur_val'];
		$adv_notice=$row['adv_notice'];
		$notify_num=$row['notify_num'];
		$notify_val=$row['notify_val'];
		$r1=$recurring.", ".$recur_num." ".$recur_val;
		$n1=$adv_notice.", ".$notify_num." ".$notify_val; 
		if ($recurring=="") {$r1="no";}
		if ($adv_notice=="") {$n1="no";}
		echo "
		<TR>
		<TD ALIGN=CENTER>
		<INPUT TYPE=checkbox VALUE=$id NAME=del[$num]></TD>
		<TD ALIGN=CENTER>$neat_date $dbtimezone</TD>
		<TD ALIGN=CENTER>$n1</TD>
		<TD ALIGN=CENTER>$r1</TD>
		<TD ALIGN=CENTER>&nbsp;$subject</TD>
		<TD>&nbsp;$comment</TD>
		";
		$num=$num+1;
        } 
	if ($num==1) {
		echo "
		<TR>
		<TD COLSPAN=6 ALIGN=CENTER>
		<FONT SIZE=+1>
		<BR><BR><BR>
		<B>You have no pending E*Reminders!</B>
		<BR><BR><BR>
		</FONT>
		</TD>
		";
	}
	echo "<TR><TD COLSPAN=5 ALIGN=CENTER>
	<INPUT TYPE=submit VALUE='Delete marked Entries'>
	</TD>
	<TD ALIGN=CENTER><A HREF=\"help.html\">Help/About</A><BR><A HREF=\"adminoptions.html\">Account Options</A><BR><A HREF=\"index.php3\">Home</A></TD>
	</TR>
	</FORM></TABLE></FONT></CENTER>
	";
} 
else {	
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3; URL=listpassword.html\"></HEAD><BODY BGCOLOR=\"#000000\" TEXT=#FFFFFF>";
	msg_box("Incorrect Password", 
	"<CENTER>Please enter correct password and try again.</CENTER>",
	"black");
}

?>

</BODY>
</HTML>


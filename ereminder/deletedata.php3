<?php
require("database.php3");

function convert_time($mysql_timestamp){
// YYYYMMDDHHMMSS

if (ereg("^([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$mysql_timestamp,$res)):

  $info["year"]=$res[1];
  $info["month"]=$res[2];
  $info["day"]=$res[3];
  $info["hour"]=$res[4];
  $info["min"]=$res[5];
  $info["sec"]=$res[6];
 
 return(mktime($info["hour"],$info["min"],$info["sec"],$info["month"],$info["day"],$info["year"]));
else:
 return(false);
endif;
}

/* Query Database */
$num=1;
$result=mysql_query("   SELECT *
                        FROM notify
                        WHERE email='$email'      ");

echo "	
	<HTML>
	<HEAD><TITLE>Delete E*Reminders</TITLE><META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3; URL=index.php3\"></HEAD>
	<BODY BGCOLOR=#000000>
	
	<CENTER>
	<TABLE BORDER=0 BGCOLOR=CCCCCC CELLSPACING=1 CELLPADDING=3
WIDTH=80%> 
	<TD COLSPAN=6 BGCOLOR=#6677DD ALIGN=CENTER>
	<FONT COLOR=#FFFFFF Face='arial,helvetica' SIZE=+2>
	Deleted E*Reminders for: $email</FONT>
	</TD><TR>

	<TD ALIGN=CENTER><B>Deleted</B></TD> 
	<TD ALIGN=CENTER><B>Date</B></TD>
	<TD ALIGN=CENTER><B>Advance Notice</B></TD>
	<TD ALIGN=CENTER><B>Recurrence Settings</B></TD>
	<TD ALIGN=CENTER><B>Event</B></TD>
	<TD ALIGN=CENTER><B>Message</B></TD>
	";
 
while ($row=mysql_fetch_array($result)){
	$email=$row['email']; 
	$subject=$row['subject'];
	$comment=$row['comment'];
 	$date_field=$row['date_field'];
      	$id=$row['id'];
      	$recurring=$row['recurring'];
	$recur_num=$row['recur_num'];
	$recur_val=$row['recur_val'];
      	$adv_notice=$row['adv_notice'];
      	$notify_num=$row['notify_num'];
      	$notify_val=$row['notify_val'];
	$dele=$del[$num];

	if ($recurring==""){
		$recurring="Not set";
		$recur_num="";
		$recur_val="";
	}

	if ($adv_notice==""){
		$adv_notice="Not set";
		$notify_num="";
		$notify_val="";
	}

	if ($id==$dele) {
		@mysql_query("DELETE FROM notify WHERE id='$id'");

		$neat_date=date("D M d, Y h:i:s A",convert_time($date_field));

		echo "  
		<TR>
		<TD ALIGN=CENTER>yes</TD>
		<TD ALIGN=CENTER>$neat_date $dbtimezone</TD>
		<TD ALIGN=CENTER>$adv_notice $notify_num $notify_val</TD>
		<TD ALIGN=CENTER>$recurring $recur_num $recur_val</TD>
		<TD ALIGN=CENTER>$subject</TD>
		<TD ALIGN=CENTER>&nbsp;$comment</TD>
		";
	}

	$num=$num+1;
}


?>

<TR>
</TABLE>
</BODY>
</HTML>

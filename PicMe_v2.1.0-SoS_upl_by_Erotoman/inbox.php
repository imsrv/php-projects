<?PHP
/*
#
#	$Id: INBOX.PHP
#	Version 2.1.0
#
*/
include "header.php";

if ($action == "readprivate") {
	$sql = "select * from messages where id ='$id'";
	$sql_result = mysql_query($sql); 
	while ($row = mysql_fetch_array($sql_result)) { 
	 $id = $row["id"];
	 $subject = $row["title"];
	 $message = $row["message"];	 
	 $from = $row["fromuserid"];
	 $sdate = $row["sdate"];
	 $isread = $row["isread"];
	 $msgtext = "<br><br>
		<table border=0 cellpadding=0 cellspacing=2 width=100%>
		<tr>
		<td valign=top align=center>
		<div align=left>
		<table border=0 cellpadding=0 cellspacing=1 width=100%>
		<tr>
		<td bgcolor=8080FF><a href=$PHP_SELF?action=deleteprivate&id=$id><img src=images/delete.gif border=0 alt=Delete Message></a>  
		<br><b>From:</b> $from 
		<br><b>Subject:</b> $subject
		<br><b>Date:</b>  $sdate
		</td>
		</tr>
		<tr>
		<td bgcolor=8080FF><b>Message:</b></td>
		</tr>
		<tr>
		<td bgcolor=FFFFC0>$message</td>
		</tr>
		</table>
		</div>
		</table>
		<br>";
echo $msgtext;
	$sql = "update messages set isread='1' where id ='$id'";
	$sql_result = mysql_query($sql); 
	}
}

// DELETE PRIVATE MESSAGE
if($action == "deleteprivate") {
		$sql = "delete from messages where id ='$id'";
		$sql_result = mysql_query($sql); 		
		echo "<br><br>Message deleted!";
}
		
include "footer.php";
?>
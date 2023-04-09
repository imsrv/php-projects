<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	include("../_include/connection.php");
	
	
	$deleted = false;
	if(isset($e))
	{
		$result = mysql_query("SELECT subject, DATE_FORMAT(event_date, '%D %b %Y') as event_date,  DATE_FORMAT(event_date, '%r') as event_time, detail, event_recur FROM calendar_event WHERE event_id = $e");
		$row = mysql_fetch_array($result);
	}

	if(isset($de))
	{
		mysql_query("DELETE FROM calendar_event WHERE event_id = $de");
		$deleted = true;
	}
		
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
	<title>::  ::</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
<style type="text/css">
	td {font: 9pt arial}
	input {font: 9pt arial}
	select {font: 9pt arial}
	.title {font: bold 9pt arial}
	.day {font: bold 9pt arial}
	.add {font: 9pt arial}
</style>
</head>

<body bgcolor="white">
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#eeeeee">
<tr><td class="title" align="center" height="10">View Event</td></tr>
<tr>
	<td>
		<table width="100%" cellpadding="2" cellspacing="0" border="0" bgcolor="white">
		<tr><td colspan="3">&nbsp;</td></tr>
		<?php if($deleted) {?>
		<tr><td colspan="3" align="center">Event successfully deleted from calendar.<br><br><input type="button" value="Close" onClick="javascript: window.opener.location.href = window.opener.location.href; self.close();"></td></tr>
		<?php }else{ ?>
		<tr>
			<td width="38%">Subject</td><td width="1%">:</td><td><?=htmlentities($row["subject"])?></td>
		</tr>
		<tr>
			<td>Date</td><td width="1%">:</td>
			<td><?=$row["event_date"]?></td>
		</tr>
		<tr>
			<td>Time</td><td width="1%">:</td>
			<td><?=$row["event_time"]?></td>
		</tr>
		<tr>
			<td>Repeat yearly?</td><td width="1%">:</td>
			<td>
			<?php
				if($row["event_recur"] == "1")
					echo "Yes";
				else
					echo "No";
			?>
			</td>
		</tr>
		<tr valign="top">
			<td>Description</td><td width="1%">:</td><td><?php
				if(isHTMLEnabled())
					echo $row["detail"];
				else
					echo str_replace("\n","<br>",htmlentities($row["detail"]));
				?></td>
		</tr>
		<tr>
			<form>
			<td colspan="3" align="center">
		
			<input type="button" value="Edit" onClick="document.location.href='editEvent.php?e=<?=$e?>';">
			&nbsp;
			<input type="button" value="Delete" onClick="document.location.href='viewEvent.php?de=<?=$e?>';">
			&nbsp;
		
			<input type="button" value="Close" onClick="self.close();">
			</td>
			</form>
		</tr>
		<?php } ?>
		</table>
	</td></form>
</tr>
</table>
</body>
</html>

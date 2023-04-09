<?php
	
	$success = false;
	
	if(isset($addEvent))
	{
		include("./_include/connection.php");
		include("./_include/functions.php");
		$queue = isQueueEnabled();
		$time = "$y-$m-$d ";
		if($ap == 1)
		{
			if($h != 12)
				$h += 12;
			$time .= "$h:$mi:00";
		}
		else
		{
			if($h == 12)
				$h = 0;
			$time .= "$h:$mi:00";
		}
		 
		if(mysql_query("INSERT INTO calendar_event (subject, detail, event_date, event_recur,  queue_flag) VALUES ('$subject', '$detail', '$time', '$event_recur','$queue')"))
			$success = true;
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
<script language="javascript">
	function checkForm()
	{
		if(document.eventForm.subject.value == "")
		{
			alert("Please fill in the event subject.");
			return false;
		}
		if(document.eventForm.detail.value == "")
		{
			alert("Please fill in the event description.");
			return false;
		}


	}
</script>
</head>

<body bgcolor="white">
<table width="100%" cellpadding="1" cellspacing="1" bgcolor="#eeeeee">
<tr><td class="title" align="center" height="10">Add Event</td></tr>
<tr><form action="addEvent.php" method="post" onSubmit="javascript: return checkForm();" name="eventForm">
	<td>
		<table width="100%" cellpadding="2" cellspacing="0" border="0" bgcolor="white">
		<tr><td colspan="3">&nbsp;</td></tr>
		<?php if($success){ ?>
		<tr><td colspan="3" align="center">
			<?php
				if($queue == 0){
			?>
				Event successfully added into calendar.
			<?php }else{ ?>
				Event successfully added and awaiting approval from the site admin.
			<?php }?><br><br><input type="button" value="Close" onClick="javascript: window.opener.location.href = window.opener.location.href; self.close();"></td></tr>
		<?php }else{ ?>
		<tr>
			<td width="38%">Subject</td><td width="1%">:</td><td><input type="text" name="subject" maxlength="88"></td>
		</tr>
		<tr>
			<td>Date</td><td width="1%">:</td>
			<td>
				<?php 
					$month_name = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
					echo $d." ".$month_name[$m]." ".$y;
					echo "<input type='hidden' name='d' value='$d'>";
					echo "<input type='hidden' name='m' value='$m'>";
					echo "<input type='hidden' name='y' value='$y'>";
				?>
				<!--<select name="d">
				<?php
					for($i=1;$i<32;$i++)
					{
						if($i == $d)
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				?>
				</select>
				<select name="m">
				<?php
					
					for($i=1;$i<13;$i++)
					{
						if($i == $m)
							echo "<option value='$i' selected>".$month_name[$i];
						else
							echo "<option value='$i'>".$month_name[$i];
					}
				?>
				</select>
				<select name="y">
				<?php
					for($i=2002;$i<2010;$i++)
					{
						if($i == $y)
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				?>
				</select>-->
			</td>
		</tr>
		<tr>
			<td>Time</td><td width="1%">:</td>
			<td>
			<select name="h">
			<?php	
				for($i=1;$i<13;$i++)
				{
					if($i < 10)
						echo "<option value='$i'>0$i";
					else
						echo "<option value='$i'>$i";
				}
			?>
			</select>:
			<select name="mi">
			<?php	
				for($i=0;$i<60;$i++)
				{
					if($i < 10)
						echo "<option value='$i'>0$i";
					else
						echo "<option value='$i'>$i";
				}
			?>
			</select>
			<select name="ap">
				<option value="0">AM
				<option value="1">PM
			</select>
			</td>
		</tr>
		<tr>
			<td>Repeat yearly?</td><td width="1%">:</td><td><input type="radio" name="event_recur" value="0" checked>No &nbsp;<input type="radio" name="event_recur" value="1">Yes</td>
		</tr>
		<tr valign="top">
			<td>Description</td><td width="1%">:</td><td><textarea style="font: 9pt arial" cols="38" rows="8" name="detail"></textarea></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><input type="submit" name="addEvent" value="Add"></td>
		</tr>
		<?php } ?>
		</table>
	</td></form>
</tr>
</table>
</body>
</html>

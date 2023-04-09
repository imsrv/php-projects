<?php
	session_start();
	include("../_include/functions.php");
	checkLogin();
	$success = false;
	$error = "";
	include("../_include/connection.php");
	if(isset($addEvent))
	{
		if(checkdate($m,$d,$y))
		{
			$time = "$y-$m-$d ";
			if($ap == 1)
			{
				//$h += 12;
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
			
			if(mysql_query("UPDATE calendar_event SET subject = '$subject', detail = '$detail', event_date = '$time', event_recur = '$event_recur' WHERE event_id = $e"))
				$success = true;
			else
				echo mysql_error();
		}
		else
		{
			$error = "Please select a valid date.";
		}
	}
	
	if(!$success)
	{
		$result = mysql_query("SELECT subject, DAYOFMONTH(event_date) as `day`, MONTH(event_date) as `month`, YEAR(event_date) as `year`,  DATE_FORMAT(event_date, '%l') as event_hour, MINUTE(event_date) as event_minute, DATE_FORMAT(event_date, '%p') as event_ap, detail, event_recur FROM calendar_event WHERE event_id = $e");

		$row = mysql_fetch_array($result);
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
	.error {font: bold 9pt arial; color: red}
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
<tr><td class="title" align="center" height="10">Edit Event</td></tr>
<tr><form action="editEvent.php" method="post" onSubmit="javascript: return checkForm();" name="eventForm">
	<td>
		<table width="100%" cellpadding="2" cellspacing="0" border="0" bgcolor="white">
		<tr><td colspan="3">&nbsp;</td></tr>
		<?php if($success){ ?>
		<tr><td colspan="3" align="center">Event successfully saved into calendar.<br><br><input type="button" value="Close" onClick="javascript: window.opener.location.href = window.opener.location.href; self.close();"></td></tr>
		<?php }else{ ?>
		<?php if($error != "") { ?>
			<tr>
				<td colspan="3" class="error"><?=$error?></td>
			</tr>
		<?php } ?>
		<tr>
			<td width="38%">Subject</td><td width="1%">:</td><td><input type="text" name="subject" maxlength="88" value="<?=$row["subject"]?>"></td>
		</tr>
		<tr>
			<td>Date</td><td width="1%">:</td>
			<td>
				<select name="d">
				<?php
					for($i=1;$i<32;$i++)
					{
						if($i == $row["day"])
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				?>
				</select>
				<select name="m">
				<?php
					$month_name = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
					for($i=1;$i<13;$i++)
					{
						if($i == $row["month"])
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
						if($i == $row["year"])
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				?>
				</select>
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
					{
						if($i == $row["event_hour"])
							echo "<option value='$i' selected>0$i";
						else
							echo "<option value='$i'>0$i";
					}
					else
					{
						if($i == $row["event_hour"])
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				}
			?>
			</select>:
			<select name="mi">
			<?php	
				for($i=0;$i<60;$i++)
				{
					if($i < 10)
					{
						if($i == $row["event_minute"])
							echo "<option value='$i' selected>0$i";
						else
							echo "<option value='$i'>0$i";
					}
					else
					{
						if($i == $row["event_minute"])
							echo "<option value='$i' selected>$i";
						else
							echo "<option value='$i'>$i";
					}
				}
			?>
			</select>
			<select name="ap">
				<option value="0"<?php if($row["event_ap"] == "AM") echo " selected"; ?>>AM
				<option value="1"<?php if($row["event_ap"] == "PM") echo " selected"; ?>>PM
			</select>
			</td>
		</tr>
		<tr>
			<td>Repeat yearly?</td><td width="1%">:</td><td><input type="radio" name="event_recur" value="0"<?php if($row["event_recur"] == "0") echo " checked"; ?>>No &nbsp;<input type="radio" name="event_recur" value="1"<?php if($row["event_recur"] == "1") echo " checked"; ?>>Yes</td>
		</tr>
		<tr valign="top">
			<td>Description</td><td width="1%">:</td><td><textarea style="font: 9pt arial" cols="38" rows="8" name="detail"><?=$row["detail"]?></textarea></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><input type="hidden" value="<?=$e?>" name="e"><input type="submit" name="addEvent" value="Save"></td>
		</tr>
		<?php } ?>
		</table>
	</td></form>
</tr>
</table>
</body>
</html>

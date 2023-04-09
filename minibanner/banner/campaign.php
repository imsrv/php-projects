<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: ../relogin.php');
	
	if(isset($submitForm))
	{
		if($cname!=''&&(($to_day!='-'&&$to_month!=''&&$to_year!='')||$clicks!=''||$impression!=''))
		{
			include('conn.php');
			$clicks = $clicks == '' ? 0 : $clicks;
			$impression = $impression == '' ? 0 : $impression;
			if($to_day == '-')
			{
				$end_date = '2999-01-01';
				$dc = 1;
			}
			else
			{
				$end_date = $to_year.'-'.$to_month.'-'.$to_day;
				$to = mktime(1,1,1,$to_month,$to_day,$to_year);
				$from = mktime(1,1,1,$from_month,$from_day,$from_year);
				$dc = $to - $from;
			}
			
			if($dc > 0)
			{
				$start_date = $from_year.'-'.$from_month.'-'.$from_day;
				$SQL = "INSERT INTO campaign (id,group_id,name,start_date,end_date,clicks,views) VALUES(null,$group,'$cname','$start_date','$end_date',$clicks,$impression)";
				mysql_query($SQL,$con);
				$iid = mysql_insert_id();
				header("Location: add_banner.php?cid=$iid");
				exit;
			}
			else
			{
				$clicks = $clicks == 0 ? '' : $clicks;
				$impression = $impression == 0 ? '' : $impression;
				$message = 'End Date must be later than Start Date';
			}
		}
		else
		{
			$message = 'You must fill in the campaign name and at least one of End Date, No. of Clicks or No. of Display.';
		}
	}
?>	
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Campaign</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
<script language="javascript">
	function checkNumber(form)
	{
		var nonDigit = /\D/g;
  		if(nonDigit.test(form.clicks.value))
		{
			alert("No. of Clicks must be a round number.");
			form.clicks.focus();
			return false;
		}
    	if(nonDigit.test(form.impression.value))
		{
			alert("No. of Displays must be a round number.");
			form.impression.focus();
			return false;
		}
		return true;
	
	}
</script>
</head>
<body bgcolor="white">
<center>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br>
<form action="campaign.php" method="post" onSubmit="javascript: return checkNumber(this);">
<table width="80%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="78%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b>New Campaign</b></font><br><hr width="80%">
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><font face="arial" size="2" color="red"><?php print($message); ?></font></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><font face="arial" size="2"><b>Campaign Name</font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="cname" maxlength="200" size="25" value="<?php echo $cname; ?>"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Start Date</font></td><td><font face="arial" size="2">:</font></td>
			<td><select name="from_day">
			<?php
				for($i=1;$i<32;$i++)
				{
					if(Date("d") == $i)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select><select name='from_month'>";
				$month_array = array("January","February","March","April","May","June","July","August","September","October","November","December");
				for($i=0;$i<12;$i++)
				{
					if(Date("m") == ($i+1))
						echo "<option value='".($i+1)."' selected>".$month_array[$i];
					else
						echo "<option value='".($i+1)."'>".$month_array[$i];
				}
			echo "</select><select name='from_year'>";
				for($i=2001;$i<2010;$i++)
				{
					if(Date("Y") == $i)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select>";
			?>
			</td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>End Date</font></td><td><font face="arial" size="2">:</font></td><td>
			<select name='to_day'>
			<option value='-'>-
			<?php
				for($i=1;$i<32;$i++)
				{
					if($i==$to_day)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select><select name='to_month'><option value='-'>-";
				$month_array = array("January","February","March","April","May","June","July","August","September","October","November","December");
				for($i=0;$i<12;$i++)
				{
					if($to_month == ($i + 1))
						echo "<option value='".($i+1)."' selected>".$month_array[$i];
					else
						echo "<option value='".($i+1)."'>".$month_array[$i];
				}
			echo "</select><select name='to_year'><option value='-'>-";
				for($i=2001;$i<2010;$i++)
				{
					if($i==$to_year)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select>";
			?>
			
			</td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>No of Clicks</font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="clicks" maxlength="5" size="25" value="<?php echo $clicks; ?>"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>No of Display</font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="impression" maxlength="5" size="25" value="<?php echo $impression; ?>"></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><font face="arial" size="1"><i>** The end date, no. of clicks and no. of display will determine how long the campaign will last.
		<br>** Please fill which ever criteria you want. If you select all then which ever comes first will end the campaign.</i></font></td></tr>
		<tr><td colspan="3" align="right"><input type="button" value="Cancel" onClick="javascript: location.href='banner_main.php';">&nbsp;&nbsp;&nbsp;<input type="submit" name="submitForm" value="Create"></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3" align="center"><font face="arial" size="1"><a href="../bug_report.php">Report a Bug</a></font></td></tr>
		</table>
		</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>
</form>
<? include("../include/copyright.php"); ?>
</center>
</body>
</html>

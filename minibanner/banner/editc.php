<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: ../relogin.php');
	
	include('conn.php');
	if(isset($submitForm))
	{
		if($cname!=''&&(($to_day!='-'&&$to_month!=''&&$to_year!='')||$clicks!=''||$impression!=''))
		{
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
				$SQL = "UPDATE campaign SET name = '$cname',start_date = '$start_date',end_date = '$end_date',clicks = $clicks ,views = $impression WHERE id = $cid";
				mysql_query($SQL,$con);
				$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
				$html .= '<html><head><title>Campaign</title><meta name="Author" content="Yip Kwai Fong">';
				$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
				$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
				$html .= '<script language="javascript">opener.document.location.href=opener.document.location.href;</script></head><body bgcolor="white"><center><br><br><br>';
				$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
				$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
				$html .= '<tr><td align="center"><br><br><font face="arial" size="2">Campaign Saved!!!</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
				$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
				print($html);
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
	if(isset($cid))
	{
		$SQL = "SELECT name,start_date,end_date,clicks,views FROM campaign WHERE id = $cid AND group_id = $group";
		$result = @mysql_query($SQL,$con);
		if(mysql_affected_rows()>0)
		{
			$row = mysql_fetch_array($result);
			$cname = $row[0];
			$sdate = explode(" ",$row['start_date']);
			$start_date = explode("-",$sdate[0]);
			$edate = explode(" ",$row['end_date']);
			if($edate[0] == '2999-01-01')
			{
				$to_day = '-';
				$to_month = '-';
				$to_year = '-';
			}
			else
			{
				$end_date = explode("-",$edate[0]);
				$to_day = $end_date[2];
				$to_month = $end_date[1];
				$to_year = $end_date[0];
			}
			$clicks = $row['clicks'];
			$impression = $row['views'];
			mysql_free_result($result);
		}
		else
		{
			$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
			$html .= '<html><head><title>Add Banner</title><meta name="Author" content="Yip Kwai Fong">';
			$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
			$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
			$html .= '</head><body bgcolor="white"><center><br><br><br>';
			$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
			$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">This campaign does not belong to you. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
		}
	}
	else
	{
		$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
		$html .= '<html><head><title>Add Banner</title><meta name="Author" content="Yip Kwai Fong">';
		$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
		$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
		$html .= '</head><body bgcolor="white"><center><br><br><br>';
		$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
		$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
		$html .= '<tr><td align="center"><br><br><font face="arial" size="2">There is error accessing this page. You may have access this page incorrectly. <br>Please try again.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
		$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
		print($html);
		exit;
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
<form action="editc.php" method="post" onSubmit="javascript: return checkNumber(this);">
<table width="80%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="78%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b><?php echo $cname; ?></b></font><br><hr width="80%">
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
					if($start_date[2] == $i)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select><select name='from_month'>";
				$month_array = array("January","February","March","April","May","June","July","August","September","October","November","December");
				for($i=0;$i<12;$i++)
				{
					if($start_date[1] == ($i+1))
						echo "<option value='".($i+1)."' selected>".$month_array[$i];
					else
						echo "<option value='".($i+1)."'>".$month_array[$i];
				}
			echo "</select><select name='from_year'>";
				for($i=2001;$i<2010;$i++)
				{
					if($start_date[0] == $i)
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
		<tr><td colspan="3" align="right"><input type="hidden" name="cid" value="<?php echo $cid; ?>"><input type="button" value="Cancel" onClick="javascript: self.close();">&nbsp;&nbsp;&nbsp;<input type="submit" name="submitForm" value="Save"></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3" align="center"><font face="arial" size="1"><a href="bug_report.php">Report a Bug</a></font></td></tr>
		</table>
		</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>
</form>
<font face="arial" size="1">
<center>&copy 2001 miniScript.com</center>
</i>
</center>
</body>
</html>

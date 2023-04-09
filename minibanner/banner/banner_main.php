<?php
	session_start();
	if($id == '')
	{
		//header('Location: relogin.php');
		exit;
	}

	
	include_once('conn.php');
	$expired = 0;
	$started = 0;
	if(!isset($list))
	{	
		if(isset($listall))
		{
			$SQL = "SELECT id, name, clicks, views, start_date,end_date,  (now() > end_date) as expired, (now() > start_date) as started FROM campaign WHERE group_id = $group";
		}
		else
		{
			$SQL = "SELECT id, name, clicks, views, start_date,end_date, 0 as expired, 1 as started FROM campaign WHERE (now() BETWEEN start_date AND end_date) AND group_id = $group";
		}
		if(!$result = mysql_query($SQL,$con))
		{
			header('Location: relogin.php');
		}
	}
	else
	{
		$active_date = $from_year.'-'.$from_month.'-'.$from_day;
		$SQL = "SELECT id, name, clicks, views, start_date,end_date,(now() > end_date) as expired, (now() > start_date) as started FROM campaign WHERE (start_date <= '$active_date' AND end_date >= '$active_date') AND group_id = $group";
		if(!$result = mysql_query($SQL,$con))
		{
			header('Location: relogin.php');
		}
	}	
	while($row = mysql_fetch_array($result))
	{
		$start_date = explode(" ",$row['start_date']);
		$end_date = explode(" ",$row['end_date']);
		$SQL = "SELECT clicks,views FROM banner_stat WHERE campaign_id = ".$row['id'];
		$result2 = mysql_query($SQL,$con);
		$count = mysql_affected_rows();
		$clicks = 0;
		$views = 0;
		$expired = $row['expired'];
		$started = $row['started'];
		while($banner = mysql_fetch_array($result2))
		{
			$clicks = $clicks + $banner[0];
			$views = $views + $banner[1];
		}
		$clickthrough = $clicks != 0  ? round(($clicks / $views)*100,2) : "N/A";
		$clickratio = $clicks.'/'.$row['clicks'];
		$viewratio = $views.'/'.$row['views'];

		if((($views >= $row['views']) && ($row['views'] != 0)) || (($clicks >= $row['clicks']) && ($row['clicks'] != 0)) || $expired)
			$bgcolor = "bgcolor='pink'";
		else
		{
			if($started)
				$bgcolor = "bgcolor='#99FFCC'";
			else
				$bgcolor = '';
		}

		if($end_date[0] == '2999-01-01')
			$myedate = "Not Set";
		else
			$myedate = $end_date[0];
		$html .= "<tr $bgcolor><td><font face='arial' size='2'><a href='add_banner.php?cid=".$row['id']."'>".$row['name']."</a></font></td><td align='center'><font face='arial' size='2'>$count</font></td><td align='center'><font face='arial' size='2'>".$clickthrough."</font></td><td align='right'><font face='arial' size='2'>".$clickratio."</font></td><td align='right'><font face='arial' size='2'>".$viewratio."</font></td><td align='right'><font face='arial' size='2'>".$start_date[0]."</font></td><td align='right'><font face='arial' size='2'>".$myedate."</font></td>";					
		
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Banner Manager</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
</head>
<body bgcolor="white">
<center>
<br>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br><hr width="80%">
<form method="post">
<table width="80%" cellpadding="1" cellspacing="0" border="0">
<tr><td><font face="arial" size="2"><?php echo Date("d F Y")?></font></td>
	<td align="center">
		<font face="arial" size="2"><a href="campaign.php">Add a new Campaign</a></font>
	</td>
	<td align="right"><font face="arial" size="2"><a href="login.php?action=logout">Logout</a> <b></b></font></td>
</tr>
</table></form>
<br>
<table width="95%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td align="center">
		<table width="90%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td><font face="arial" size="2"><b>List Campaigns</b></font><br></td>
		</tr>
		<tr align="center">
			<td>
			<form action="banner_main.php" method="post">
			<font face="arial" size="2">
			Banner On : 
			<select name="from_day">
			<?php
				for($i=0;$i<32;$i++)
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
					if(Date("m") == $i)
						echo "<option value='".($i)."' selected>".$month_array[$i-1];
						
					else
						echo "<option value='".($i)."'>".$month_array[$i-1];
				}
			echo "</select><select name='from_year'>";
				for($i=2001;$i<2010;$i++)
				{
					if(Date("Y") == $i)
						echo "<option value='$i' selected>$i";
					else
						echo "<option value='$i'>$i";
				}
			echo "</select>&nbsp;<input type='submit' value='List' name='list'>";
			?>
			&nbsp;<input type="submit" name="listall" value="List All"> 
			</font>
			</form>
			</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		</td>
	</tr>
</table>
<br>
<table width="95%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td align="center">
		<table width="95%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td><font face="arial" size="2"><b><?php if(!isset($list)){ if(isset($listall)){ print("All Campaign(s)"); } else {print('Current Campaigns');} }else{ print("Banner on $active_date");} ?></b></font><br></td>
		</tr>
		<tr><td><hr>
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
		<tr align="center" bgcolor="#eeeee0"><td width="30%"><font face="arial" size="2"><b>Name</b></font></td><td><font face="arial" size="2"><b>Total Banner</b></font></td><td><font face="arial" size="2"><b>% Click Through</b></font></td><td><font face="arial" size="2"><b>Clicks</b></font></td><td><font face="arial" size="2"><b>Impressions</b></font></td><td><font face="arial" size="2"><b>Start Date</b></font></td><td><font face="arial" size="2"><b>End Date</b></font></td></tr>
			<?php 
				if($html != '')
					echo $html;
				else
					echo "<tr><td colspan='7' align='center'><font face='arial' size='2'>No Campaign Available</font></td></tr>";
			?>
		</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		</table>
		</td></tr>
		</table>
		</td>
	</tr>
</table>
<table width='95%' cellpadding='0' cellspacing='0' border='0'>
<tr><td>
<font face="arial" size="1">
NOTES:<br>
<i>
** Name - Name of the campaign<br>
** Total Banner - Total banner in the campaign<br>
** % Click Through - Percentage of total clicks over total impression<br>
** Clicks - Total clicks over targeted total clicks<br>
** Impressions - Total impression over total target impression<br>
** Start Date - The starting date of the campaign<br>
** End Date - The ending date of the canpaign<br></font>
</td>
<td>
<table width='100' cellpadding='0' cellspacing='2'>
<tr><td colspan='2'><font face='arial' size='2'><b>Legend:</b></font></td></tr>
<tr><td bgcolor='pink' width='15'>&nbsp;</td><td><font face='arial' size='2'>Expired</font></td></tr>
<tr><td bgcolor='#99FFCC' width='15'>&nbsp;</td><td><font face='arial' size='2'>Running</font></td></tr>
<tr><td bgcolor="#eeeeee" width='15'>&nbsp;</td><td><font face='arial' size='2'>Not Active</font></td></tr>
</table>
</td>

</tr></table>
</center>
<br><br><font face="arial" size="1">
<center>&copy 2001 miniScript.com</center>
</i>
</font>
</body>
</html>

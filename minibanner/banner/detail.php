<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: ../relogin.php');

	include('conn.php');
	$SQL = "SELECT banner.id,url,graphic,alt,banner.campaign_id,banner_size.size,name, banner_stat.clicks, banner_stat.views FROM campaign,banner,banner_size,banner_stat WHERE group_id = $group AND banner.campaign_id = campaign.id AND banner.id = $bid AND banner.size = banner_size.id AND banner.id = banner_stat.banner_id";
	$result = @mysql_query($SQL,$con);
	if(@mysql_affected_rows()>0)
	{
		$row = mysql_fetch_array($result);		
	}
	else
	{
		$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
		$html .= '<html><head><title>Banner Detail</title><meta name="Author" content="Yip Kwai Fong">';
		$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
		$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
		$html .= '</head><body bgcolor="white"><center><br><br><br>';
		$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
		$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
		$html .= '<tr><td align="center"><br><br><font face="arial" size="2">This banner does not belong to you. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
		$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
		print($html);
		exit;
	}
	
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Banner Detail</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
</script>
</head>
<body bgcolor="white">
<center>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br>
<table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr align="center">
			<td colspan="2">
				<font face="arial" size="3"><b><?php echo $row['name']; ?></b></font><br><hr width="80%">
			</td>
		</tr>
		<tr><td align="center">
		<table width="88%" height="100%" cellpadding="1" cellspacing="0" border="1" bgcolor="#eeeeee">
		
		<tr valign="top">
			<td><font face="arial" size="2"><b>URL</b></font></td><td><font face="arial" size="2"> <?php echo $row['graphic'];?></font></td>
		</tr>
		<tr valign="top">
			<td><font face="arial" size="2"><b>Link</b></font></td><td><font face="arial" size="2"> <?php echo $row['url'];?></font></td>
		</tr>
		<tr valign="top">
			<td><font face="arial" size="2"><b>Text</b></font></td><td><font face="arial" size="2"> <?php echo $row['alt'];?></font></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Size</b></font></td><td>
			<font face="arial" size="2"> <?php echo $row['size']; ?>		
			</td>
		</tr>
		<tr valign="top">
			<td><font face="arial" size="2"><b>Clicks</b></font></td><td><font face="arial" size="2"> <?php echo $row['clicks'];?></font></td>
		</tr>
		<tr valign="top">
			<td><font face="arial" size="2"><b>Impression</b></font></td><td><font face="arial" size="2"> <?php echo $row['views'];?></font></td>
		</tr>
		<tr valign="top">
			<td><font face="arial" size="2"><b>% Clicks</b></font></td><td><font face="arial" size="2"> <?php if($row['views'] != '0') echo round(($row['clicks']/$row['views'])*100,2) ; else echo '0'?>%</font></td>
		</tr>
		
		</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>
<font face="arial" size="1"><i>&copy 2001 miniScript.com</i></font>
</center>
</body>
</html>
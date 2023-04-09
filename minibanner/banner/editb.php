<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: relogin.php');

	include('conn.php');
	if(isset($submitForm))
	{
		$SQL = "UPDATE banner SET graphic = '$url', url= '$link', alt = '$alt', size= $size WHERE campaign_id = $campaign AND id = $bid";
		if(@mysql_query($SQL,$con))
		{
			
			$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
			$html .= '<html><head><title>Add Banner</title><meta name="Author" content="Yip Kwai Fong">';
			$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
			$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
			$html .= '<script language="javascript">opener.document.location.href=opener.document.location.href;</script></head><body bgcolor="white"><center><br><br><br>';
			$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
			$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">Banner Edited!!!</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
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
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">There is some error during banner editing. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="history.back();"><font face="arial" size="2"><b>Back</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
		}
	}
	else
	{
		$SQL = "SELECT banner.id,url,graphic,alt,campaign_id,size,name FROM campaign,banner WHERE group_id = $group AND campaign_id = campaign.id AND banner.id = $bid";
		$result = @mysql_query($SQL,$con);
		if(@mysql_affected_rows()>0)
		{
			$row = mysql_fetch_array($result);		
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
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">This banner does not belong to you. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
		}
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Edit Banner</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
</script>
</head>
<body bgcolor="white">
<center>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br>
<form action="editb.php" method="post">
<table width="90%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="88%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b><?php echo $row['name']; ?></b></font><br><hr width="80%">
			</td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner URL</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="url" maxlength="255" size="38" value="<?php echo $row['graphic'];?>"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner Link</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="link" maxlength="255" size="38" value="<?php echo $row['url'];?>"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>ALT Text</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="alt" maxlength="200" size="38" value="<?php echo $row['alt'];?>"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner Size</b></font></td><td><font face="arial" size="2">:</font></td><td>
			<select name="size">
			<option value="0">[Select a Size]
			<?php
				$SQL = "SELECT * FROM banner_size";
				$result = @mysql_query($SQL,$con);
				while($size = mysql_fetch_array($result))
				{	
					if($size[0] == $row['size'])
						echo '<option value="'.$size[0].'" selected>'.$size[1];
					else
						echo '<option value="'.$size[0].'">'.$size[1];
				}
			?>
			</select>
			</td>
		</tr>
		<tr><td colspan="3"><font face="arial" size="1"><i>** Note that all banners in a campaign are recommended be of the same size for it work properly.</i></font></td></tr>
		<tr><td colspan="3" align="right"><input type="hidden" name="bid" value="<?php echo $bid; ?>"><input type="hidden" name="campaign" value="<?php echo $row['campaign_id']; ?>"><input type="submit" name="submitForm" value="Save Banner"></td></tr>
		</table>
		</td></tr>
		</table>
		</td>
	</tr>
</table>
</form>
<font face="arial" size="1"><i>&copy 2001 miniScript.com</i></font>
</center>
</body>
</html>
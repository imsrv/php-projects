<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: ../relogin.php');

	include('conn.php');
	if(isset($submitForm))
	{
		$SQL = "SELECT name FROM campaign WHERE id = $campaign AND group_id = $group";
		$result = @mysql_query($SQL,$con);
		if(mysql_affected_rows()>0)
		{
			mysql_free_result($result);
			$SQL = "INSERT INTO banner(id,campaign_id,size,graphic,url,alt,master) VALUES (null,$campaign,$size,'$url','$link','$alt','$code')";
			if(@mysql_query($SQL,$con))
			{
				$banner_id = mysql_insert_id();
				$SQL = "INSERT INTO banner_stat(id,campaign_id,banner_id,clicks,views) VALUES(null,$campaign,$banner_id,0,0)";
				mysql_query($SQL,$con);
				$html = '<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">';
				$html .= '<html><head><title>Add Banner</title><meta name="Author" content="Yip Kwai Fong">';
				$html .= '<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">';
				$html .= '<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">';
				$html .= '<script language="javascript">opener.document.location.href=opener.document.location.href;</script></head><body bgcolor="white"><center><br><br><br>';
				$html .= '<table width="70%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">';
				$html .= '<tr><td><table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">';
				$html .= '<tr><td align="center"><br><br><font face="arial" size="2">Banner Added!!!</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
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
				$html .= '<tr><td align="center"><br><br><font face="arial" size="2">There is some error during banner insertion. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="history.back();"><font face="arial" size="2"><b>Back</b></font></a><br><br></td></tr></table></td></tr></table>';
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
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">This campaign does not belong to you. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="#" onClick="self.close();"><font face="arial" size="2"><b>Close Window</b></font></a><br><br></td></tr></table></td></tr></table>';
			$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
			print($html);
			exit;
		}
	}
	if(isset($cid))
	{
		$SQL = "SELECT name FROM campaign WHERE id = $cid AND group_id = $group";
		$result = @mysql_query($SQL,$con);
		if(mysql_affected_rows()>0)
		{
			$row = mysql_fetch_array($result);
			$campaign_name = $row[0];
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
		$html .= '<tr><td align="center"><br><br><font face="arial" size="2">There is error accessing this page. You may have access this page incorrectly. <br>Please try again.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="index.php"><font face="arial" size="2"><b>Home</b></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: history.back();"><b><font face="arial" size="2">Back</b></font></a><br><br></td></tr></table></td></tr></table>';
		$html .= '<br><br><font face="arial" size="1"><i>&copy 2001</i></font></body></html>';
		print($html);
		exit;
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Add Banner</title>
<meta name="Author" content="Yip Kwai Fong">
<meta name="Keywords" content="Banner Management, Banner Rotation, PHP Scripts">
<meta name="Description" content="Banner management scripts for automatic banner rotation in a website.">
<script language="javascript">
	function checkSize(form)
	{
		if(form.size.options[form.size.selectedIndex].value=="0")
		{
			alert("Please select a banner size.");
			return false;
		}
		if(form.url.value == "")
		{
			alert("Please enter a banner URL.");
			return false;
		}
		if(form.link.value == "")
		{
			alert("Please enter a banner link.");
			return false;
		}
		return true;
	}
</script>
</head>
<body bgcolor="white">
<center>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br>
<form action="addb.php" method="post">
<table width="90%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="88%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b><?php echo $campaign_name; ?></b></font><br><hr width="80%">
			</td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner File Path</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="url" maxlength="255" size="38"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner Link</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="link" maxlength="255" size="38"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>ALT Text</b></font></td><td><font face="arial" size="2">:</font></td><td><input type="text" name="alt" maxlength="200" size="38"></td>
		</tr>
		<tr>
			<td><font face="arial" size="2"><b>Banner Size</b></font></td><td><font face="arial" size="2">:</font></td><td>
			<select name="size">
			<option value="0">[Select a Size]
			<?php
				$SQL = "SELECT * FROM banner_size";
				$result = @mysql_query($SQL,$con);
				while($row = mysql_fetch_array($result))
					echo '<option value="'.$row[0].'">'.$row[1];
			?>
			</select>
			</td>
		</tr>
		<tr><td colspan="3"><font face="arial" size="1"><i>** Note that all banners in a campaign are recommended be of the same size for it work properly.</i></font></td></tr>
		<tr><td colspan="3" align="right"><input type="hidden" name="campaign" value="<?php echo $cid; ?>"><input type="hidden" name="code" value="<?php echo $code; ?>"><input type="button" value="Cancel" onClick="javascript: self.close();">&nbsp;&nbsp;<input type="submit" name="submitForm" value="Add Banner"  onClick="return checkSize(form);"></td></tr>
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
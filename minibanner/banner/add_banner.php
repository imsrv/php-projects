<?php
	session_start();
	if($user_name == '' && $id == '')
		header('Location: ../relogin.php');
		
	include('conn.php');

	if(isset($submitForm))
	{
		if($master != '0')
		{
			$SQL = "UPDATE banner SET master = 'n' WHERE campaign_id = $cid";
			if(@mysql_query($SQL,$con))
			{
				$SQL = "UPDATE banner SET master = 'y' WHERE id = $master and campaign_id = $cid";
				mysql_query($SQL,$con);
			}
		}
	}
	if(isset($bid)&&isset($cid))
	{
		$SQL = "SELECT name FROM campaign, banner WHERE group_id = $group AND campaign_id = $cid AND banner.id = $bid";
		@mysql_query($SQL,$con);
		if(mysql_affected_rows()>0)
		{
			$SQL = "DELETE FROM banner WHERE id = $bid";
			@mysql_query($SQL,$con);
			
			$SQL = "DELETE FROM banner_stat WHERE banner_id = $bid";
			@mysql_query($SQL,$con);
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
			$html .= '<tr><td align="center"><br><br><font face="arial" size="2">This campaign does not belong to you. Please try another.</font><br><br></td></tr><tr><td>&nbsp;</td></tr><tr><td align="center"><a href="index.php"><font face="arial" size="2"><b>Home</b></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: history.back();"><b><font face="arial" size="2">Back</b></font></a><br><br></td></tr></table></td></tr></table>';
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
	function deleteMe(myid)
	{
		if(confirm("Are you sure you want to delete this banner?"))
		{
			document.deleteIt.bid.value=myid;
			document.deleteIt.submit();
		}
		else
		{
			return false;
		}
	}
</script>
</head>
<body bgcolor="white">
<form method="post" name="deleteIt" action="add_banner.php?cid=<?php echo $cid; ?>">
<input type="hidden" name="bid" value="">
<input type="hidden" name="cid" value="<?php echo $cid; ?>">
</form>
<center>
<font face="arial" size="3"><b>Banner Manager Admin</b></font><br>
<form action="add_banner.php?cid=<?php echo $cid; ?>" method="post">
<table width="80%" cellpadding="1" cellspacing="0" border="0" bgcolor="black">
	<tr>
		<td>
		<table width="100%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr><td>&nbsp;</td></tr>
		<tr><td align="center">
		<table width="78%" height="100%" cellpadding="1" cellspacing="0" border="0" bgcolor="#eeeeee">
		<tr align="center">
			<td colspan="3">
				<font face="arial" size="3"><b><?php echo $campaign_name; ?></b></font><br><hr width="80%">
			</td>
		</tr><tr>
			<td>
				<?php 
					$SQL = "SELECT banner.id,url,graphic,alt,b.size,master FROM banner,banner_size b WHERE campaign_id = $cid AND banner.size=b.id";
					$result = @mysql_query($SQL,$con);
					if(mysql_affected_rows()>0)
					{
						$count = 0;
						while($row = mysql_fetch_array($result))
						{
							$count += 1;
							$thesize = explode('x',$row['size']);
							$html .= "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr valign='top'><td><font face='arial' size='1'><b>$count";
							if($row['master'] == 'y')
								$html .= '(Default)';
							$html .= "</b></font></td></tr><tr><td rowspan='3'><a href='".$row['url']."'><img src='".$row['graphic']."' border='0' alt='".$row['alt']."' width='".rtrim(ltrim($thesize[0]))."' height='".rtrim(ltrim($thesize[1]))."'></a></td><td><font face='arial' size='2'><b><a href='add_banner.php' onClick='javascript: window.open(\"editb.php?bid=".$row['id']."\",\"\",\"width=600,heigth=400,toolbar=no,location=no,resizable=yes,scrollbars=yes\"); return false;'>Edit</a></b></font></td></tr><tr><td><font face='arial' size='2'><b><a href='add_banner.php' onClick='javascript: window.open(\"detail.php?bid=".$row['id']."\",\"\",\"width=650,heigth=400,toolbar=no,location=no,resizable=yes,scrollbars=yes\"); return false;'>Details</a></b></font></td></tr><tr><td><font face='arial' size='2'><b><a href='add_banner.php' onClick='javascript: deleteMe(\"".$row['id']."\"); return false;'>Delete</a></b></font></td></tr></table>";					
							if($row['master'] == 'y')
								$options .= "<option value='".$row['id']."' selected>Banner $count";
							else
								$options .= "<option value='".$row['id']."'>Banner $count";
						}
						print $html;
						$code = 'n';
						
					}
					else
					{
						$code = 'y';
						echo '<center><font face="arial" size="2">No banners available for this campaign.</font></center>';
					}
				?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<?php
			if($options != '')
			{
				print("<tr align='right'><td><select name='master'><option value='0'>[Select a Default]$options</select>&nbsp;<input type='submit' name='submitForm' value='Set Default'></td></tr>");
			}
		?>
		
		<tr><td><font face='arial' size='1'><i>**Please enable JavaScript for this program to work properly.<br>**A default banner is useful when the campaign is over and you forgot to take it out.<br>**URL is the location of your banner graphic.<br>**Link is where you banner should point to when clicked.<br>**The banner will be shown correctly on the above space when your setting is correct.</i></font></td></tr>
		<tr><td align="right"><input type="button" value="Generate Code" onClick='javascript: window.open("code.php?cid=<?php echo $cid; ?>","","width=450,heigth=200,toolbar=no,location=no,resizable=yes,scrollbars=yes");'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Edit Campaign Setting" onClick='javascript: window.open("editc.php?cid=<?php echo $cid; ?>","","width=650,heigth=550,toolbar=no,location=no,resizable=yes,scrollbars=yes");'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Add Banner" onClick='javascript: window.open("addb.php?cid=<?php echo $cid; ?>&code=<?php echo $code; ?>","","width=600,heigth=400,toolbar=no,location=no,resizable=yes,scrollbars=yes");'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="    OK    " onClick="javascript: document.location.href='banner_main.php';"></td></tr>
		<tr><td>&nbsp;</td></tr>
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
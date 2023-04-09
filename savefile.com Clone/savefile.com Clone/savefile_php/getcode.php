<?
	include("include/common.php");
	include("include/header.php");
	if($loggedin){
		include("include/accmenu.php");
	}
	$sql = "SELECT * FROM images25 WHERE id='$img'";
	$a = mysql_fetch_object( mysql_query($sql) );
	$filen = $siteurl."/".str_replace('./', '', $att_path)."/".$a->filename;
	$filen = str_replace('http://','%%',$filen);
	$filen = str_replace('//','/',$filen);
	$filen = str_replace('%%','http://',$filen);
?> 
<div align="center">
  <p><b>Here is your code below to display your File:</b></p>
  <p><br>
  </p>
</div>
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td><div align="center"><img src="<?=$filen?>"></div></td>
	</tr>
	<tr>
		<td><div align="center"><br>
			To insert this File in a message board post copy and paste the following
			code:<br>
			<textarea name="textarea" cols="100" wrap="soft" rows="3">[url=<?=$siteurl?>][img]<?=$filen?>[/img][/url]</textarea>
		</div></td>
	</tr>
	<tr>
		<td><div align="center"><br>
			To send this File to friends and family, copy and paste this code: <br>
			<textarea name="textarea2" cols="100" rows="4"><?=$filen?></textarea>
		</div></td>
	</tr>
	<tr>
		<td><div align="center"><br>
			To insert this File using HTML, copy and paste the following
			code:<br>
			<textarea name="textarea3" cols="100" wrap="soft" rows="3"><a href="<?=$siteurl?>" target="_blank"><img alt="File Hosted by <?=$sitename?>" src="<?=$filen?>" /></a></textarea>
		</div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
<?
	include("include/footer.php");
?>
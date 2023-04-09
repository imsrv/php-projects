<?include(DIR_LNG.'content_channel_form.php');?>
<tr>
	<td><table align="center" border="0" cellspacing="0" cellpadding="1" background="images/head_bg.jpg" width="90%">
	<tr>
		<td><b>&nbsp;&nbsp;<?=TEXT_PUT_CODE?></b></td>
	</tr>
	</table>
	<table align="center" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=CONTENT_CHANNEL_BORDER_COLOR?>" width="90%">
	<tr>
		<td align="center" bgcolor="#FFFFFF"><br><form method=post action="<?=$this_file_name?>">
			<textarea name="content" rows="12" cols="60"><!-- Start code for random joke/picture -->
<script	language="Javascript" src="<?=HTTP_SERVER?>daily_joke_picture.php?type=js">
</script>
<noscript>
<img src="<?=HTTP_SERVER?>daily_joke_picture.php?type=img" border="0" alt="">
</noscript>
<!-- End code for random joke/picture -->
</textarea>
		</form><br>
			
		</td>
	</tr>
	</table>	
	</td>
</tr>
<tr>
	<td align="center">
		
		<br><br>
	</td>
</tr>
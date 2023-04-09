<?
	include("include/common.php");
	include("include/header.php");
?>
	<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<p>&nbsp; </p>
      <p align="left"><strong><font color="#333333">Welcome to 
        <?=$sitename?>
        ! </font></strong></p>
      <p>We are YOUR source for free file hosting. Feel free to upload all 
        the files you would like! 
        <?=$sitename?>
        It's great for posting images on message boards, online auctions, classifieds 
        and even sharing pictures with your family! Share your files with 
      friends and family.</p>
      <p><b>Now for FULL control over your files, please register before you 
      upload.</b></p>
      <p>The possibilites are ENDLESS! </p>
      <p>Also, make sure you read our <a href="rules.php">rules</a> before 
      uploading anything to avoid your files being deleted. </p>
      <p><br>
      </p>
		</td>
	</tr>
	<tr>
		<td>
			<div align=center>
			<form ENCTYPE="multipart/form-data" method="post" name="form1" action="upload.php">
				<INPUT NAME="attached" TYPE="file"  size="50"><br>
				File extensions allowed: <b><?=implode("</b>, <b>",explode("|",$att_filetypes))?></b><br>
				File size limit: <b><?=$att_max_size?>KB</b>
				<br><br>
				<input type="submit" name="submit" value="Upload File">
			</form>
			</div>
		</td>
	</tr>
	</table>
<?
	include("include/footer.php");
?>
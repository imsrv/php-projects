<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ROOT."site_settings.php");
include (DIR_SERVER_ADMIN."admin_header.php");
$this_file_name = HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF']);

$mix = $HTTP_GET_VARS['mix'];
if(!$mix)
{
	$page_title = "Language specific images";
	$language_dir = $HTTP_GET_VARS['language'] ? $HTTP_GET_VARS['language'] : $language;
	$http_image = HTTP_LANGUAGES.$language_dir."/images/";
	$dir_image = DIR_LANGUAGES.$language_dir."/images/";
}
else
{
	$http_image = urldecode($HTTP_GET_VARS['http_image'] ? $HTTP_GET_VARS['http_image'] : ($HTTP_POST_VARS['http_image'] ? $HTTP_POST_VARS['http_image'] : ""));
	$dir_image = urldecode($HTTP_GET_VARS['dir_image'] ? $HTTP_GET_VARS['dir_image'] : ($HTTP_POST_VARS['dir_image'] ? $HTTP_POST_VARS['dir_image'] : ""));
	$page_title = "Images on '".ereg_replace(".*/", "", ereg_replace("/$", "", $dir_image))."' directory";
}

echo "<center><b>".$page_title." </b></center><br>"; 

// Delete image
if ($HTTP_GET_VARS['action']=="delete" && (($HTTP_GET_VARS['file']!="") or ($HTTP_GET_VARS['file']!="none")))
	@unlink ( $dir_image.$HTTP_GET_VARS['file']);

// Upload new image
if ($HTTP_POST_VARS['submitted'] && (($HTTP_POST_FILES['uploadimage']['name']!="none") || ($HTTP_POST_FILES['uploadimage']['name']!="")))
{
	if ( !move_uploaded_file($HTTP_POST_FILES['uploadimage']['tmp_name'], $dir_image.$HTTP_POST_FILES['uploadimage']['name']) )
		echo "<table width=\"100%\"><tr><td align=\"center\"><font color=\"#cc0000\"><b>The image can't be uploaded !</b></font></td></tr></table>";

}

?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
<?if(!$mix)
{?>
<tr>
	<td>
		<br>
		<form method="post" name="language_form" style="margin-width:0px;margin-height:0px">
		<blockquote>Edit 
		<select name="lang" onChange="document.language_form.action='<?=$this_file_name?>?language='+document.language_form.lang.options[this.selectedIndex].value;this.form.submit();" style="font-size:10px">
			<?=show_language($this_file_name, DIR_LANGUAGES, $language)?> images</blockquote>
		</select>
		</form>
		<br>
	</td>
</tr>
<?}?>
<tr>
	<td>
		<blockquote>
<?
if (!is_dir($dir_image))
{
	echo bx_error("Image directory doesn't exist! Please create first an 'images' directory into ".$language_dir." directory<br>");
	exit;
}
?>
		</blockquote>
	</td>
</tr>
</table>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="570">
<tr>
	<td bgcolor="#CCCCCC">
		
<?
$image_type = array('.gif', '.jpg', '.swf', '.jpeg'); 
$handle = opendir($dir_image);
$i=0;
while (false != ($file = readdir($handle)))
	for ($j = 0; $j < sizeof($image_type) ; $j++)
		if ($file != "." && $file != ".." && strstr($file, $image_type[$j]))
			$all_files[$i++] = $file;
	

closedir($handle);

if ($all_files!=0)
{
	sort ($all_files);
	?>
		<table align="center" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff" width="100%">
	<?
	for ($n=0; $n<$i ;$n+=1 )
	{
		
	?>
		<tr>
			<td align="center" width="100%">
	<?	
			echo "<img src=\"".$http_image.$all_files[$n]."\" border=\"0\" alt=\"\">"."<br><font size=\"2\" face=\"verdana\" color=\"#3333CC\">".$all_files[$n]."</font><br><a href=\"".$this_file_name."?mix=".$mix."&file=".$all_files[$n]."&action=delete&dir_image=".urlencode($dir_image)."&http_image=".urlencode($http_image)."\" onClick=\"javascript:return confirm('Are you sure you delete this item?')\"><font size=\"1\" face=\"verdana\" color=\"#CC0000\">Delete this file</font></a>";
	?>
	<!-- 		</td>
			<td align="center"> -->
	<?		
/*			if ( ($n +1) < $i )
			{
				echo "<img src=\"".$http_image.$all_files[$n+1]."\" border=\"0\" alt=\"\">"."<br><font size=\"2\" face=\"verdana\" color=\"#3333CC\">".$all_files[$n+1]."</font><br><a href=\"".$this_file_name."?mix=".$mix."&file=".$all_files[$n+1]."&action=delete&dir_image=".urlencode($dir_image)."&http_image=".urlencode($http_image)."\" onClick=\"javascript:return confirm('Are you sure you delete this item?')\"><font size=\"1\" face=\"verdana\" color=\"#CC0000\">Delete this file</font></a>";
			}else{
				echo "&nbsp;";
			}
*/	?>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="1"><hr size="1">
			</td>
		</tr>

	<?							
	}
	echo "</table>";
}else{
	echo "<center>There are no images !</center>";
}
?>
	</td>
</tr>
<form enctype="multipart/form-data" action="<?=$this_file_name?>?mix=<?=$mix?>&language_dir=<?=$language_dir?>" method="post" name="form1">

<tr bgcolor="#D6D3CE">
	<td align="center" height="30"><font face="arial" size="2" color="#330099">Upload new image :</font>
		<input type="hidden" name="submitted" value="1">
		&nbsp;<input type="file" name="uploadimage" id="uploadimage">
		&nbsp;<input type="submit" name="upload" value="Upload" class="button">
		<input type="hidden" name="dir_image" value="<?=urlencode($dir_image)?>">
		<input type="hidden" name="http_image" value="<?=urlencode($http_image)?>">
	</td></form>

</tr>

</table>

<?
include (DIR_SERVER_ADMIN."admin_footer.php");
?>
<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");

$page_title = "Setting Daily Joke/Picture Form for Partner Sites";

if (MULTILANGUAGE_SUPPORT == "on") 
{
   $dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
		$lngname = split("\.",$dirs[$i]);
		echo "<a href=\"".HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF'])."?language=".$lngname[0].""."\" onmouseover=\"window.status='".BROWSE_THIS_PAGE_IN." ".$lngname[0]."'; return true;\" onmouseout=\"window.status=''; return true;\"><img src=".HTTP_FLAG.$dirs[$i]." border=\"0\" alt=".$lngname[0]." hspace=\"3\"></a>";	
		
   }
 
} 

if ($HTTP_POST_VARS['update_channel'] == "1")
{
	$towrite = "<?\n";
	$towrite .=	"\$nr_of_joke_characters = \"";
	$towrite .=	$HTTP_POST_VARS['nr_of_joke_characters']."\";\n";
	$towrite .=	"\$table_width = \"";
	$towrite .=	$HTTP_POST_VARS['table_width']."\";\n";
	$towrite .=	"\$header_font_color = \"";
	$towrite .=	$HTTP_POST_VARS['header_font_color']."\";\n";
	$towrite .=	"\$header_font_bgcolor = \"";
	$towrite .=	$HTTP_POST_VARS['header_font_bgcolor']."\";\n";
	$towrite .=	"\$internal_table_bgcolor =	\"";
	$towrite .=	$HTTP_POST_VARS['internal_table_bgcolor']."\";\n";
	$towrite .=	"\$content_joke_font_color =	\"";
	$towrite .=	$HTTP_POST_VARS['content_joke_font_color']."\";\n";
	$towrite .=	"\$content_under_font_color =	\"";
	$towrite .=	$HTTP_POST_VARS['content_under_font_color']."\";\n";

	if(strstr($HTTP_POST_VARS['link_address'], "http://"))
		$link_address =	$HTTP_POST_VARS['link_address'];
	else
		$link_address =	"http://" .	$HTTP_POST_VARS['link_address'];

	$towrite .=	"\$link_address	= \"";
	$towrite .=	$link_address."\";\n";
	$towrite .=	"\$link_text = \"";
	$towrite .=	$HTTP_POST_VARS['link_text']."\";\n";
	$towrite .=	"?".">";
	
	$fp	= fopen("../daily_joke_picture_config_file.php","w+");
	fwrite($fp,	$towrite);
	fclose($fp);

}
else{}
include("../daily_joke_picture_config_file.php");

?>

<table align="center" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?></b></font></td>
</tr>
</table>
<br>

<table align="center" border="0" cellspacing="0" cellpadding="1" width="480">
<tr>
	<td bgcolor="#000000">

<form method=post action="<?=basename($HTTP_SERVER_VARS['PHP_SELF'])?>">
<table border="0" cellpadding="0" cellspacing="3" width="100%" align="center" bgcolor="#ffffff">
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="230"	class="text">
		Nr of character	for	displaying jokes:
	</td>
	<td>
		<input type="text" name="nr_of_joke_characters"	value="<?=$nr_of_joke_characters?>"	class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Header and border color:
	</td>
	<td>
		<input type="text" name="header_font_bgcolor" value="<?=$header_font_bgcolor?>"	class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Header font	color:
	</td>
	<td>
		<input type="text" name="header_font_color"	value="<?=$header_font_color?>"	class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Background color:
	</td>
	<td>
		<input type="text" name="internal_table_bgcolor" value="<?=$internal_table_bgcolor?>" class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Joke text color:
	</td>
	<td>
		<input type="text" name="content_joke_font_color" value="<?=$content_joke_font_color?>" class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Link font color:
	</td>
	<td>
		<input type="text" name="content_under_font_color" value="<?=$content_under_font_color?>" class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Table width	in pixel:
	</td>
	<td>
		<input type="text" name="table_width" value="<?=$table_width?>"	class="" size="10">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Link text under	picture:
	</td>
	<td>
		<input type="text" name="link_text"	value="<?=$link_text?>"	class="" size="35">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	width="180"	class="text">
		Link address under picture:
	</td>
	<td>
		<input type="text" name="link_address" value="<?=$link_address?>" class="" size="35">
	</td>
</tr>
<tr>
	<td width="5">
		&nbsp;
	</td>
	<td	colspan="3"	align="right"><br>
		<input type="hidden" name="update_channel" value="1">
		<input type="submit" name="submit" value="Submit" class="button">&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
</tr>
</table>
</form>
		
	</td>
</tr>
</table>


<br>
<?
if ($HTTP_POST_VARS['rebuild_channel'] == "1")
{
	include(DIR_SERVER_ROOT. 'daily_joke_picture.php');
}
else
{
?>
<!-- Start	code for random	joke/picture -->
<script	language="Javascript" src="<?=HTTP_SERVER?>daily_joke_picture.php?type=js">
</script>
<noscript>
<img src="<?=HTTP_SERVER?>daily_joke_picture.php?type=img"	border="0" alt="">
</noscript>
<!-- End code for random joke/picture -->
<?
}
?>
<br><br>
<table align="center" border="0" cellspacing="0" cellpadding="4" width="400">
<tr>
	<td align="center">
		<b><font color="#FF3300">If you get some errors <br>push this button to rebuild the joke/picture of the day</font></b>
	</td>
</tr>
<tr>
	<td align="center">
		<form method=post action="<?=HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF'])?>" style="margin-width:0px;margin-height:0px">
		<input type="hidden" name="rebuild_channel" value="1">
		<input type="submit" name="submit" value="Rebuild Content Channel" class="">
		</form>
	</td>
</tr>
</table>
<!-- <table align="center" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<b>Put this code into the page:</b>
	</td>
</tr>
<tr>
	<td>
		<form method=post action="">
			<textarea name="" rows="6" cols="70"> --><!-- Start	code for random	joke/picture -->
<!-- <script	language="Javascript" src="<?=HTTP_SERVER?>daily_joke_picture.php?type=js">
</script>
<noscript>
<img src="<?=HTTP_SERVER?>daily_joke_picture.php?type=img"	border="0" alt="">
</noscript> -->
<!-- End code for random joke/picture --></textarea>
<!-- 		</form>
	</td>
</tr>
</table> -->
<br>
<?
include("admin_footer.php");

?>
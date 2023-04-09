<?
include ("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
include (DIR_SERVER_ROOT."site_settings.php");


if (MULTILANGUAGE_SUPPORT == "on") 
{
   $dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
		$lngname = split("\.",$dirs[$i]);
		echo "<a href=\"".HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF'])."?language=".$lngname[0].""."\" onmouseover=\"window.status='".BROWSE_THIS_PAGE_IN." ".$lngname[0]."'; return true;\" onmouseout=\"window.status=''; return true;\"><img src=".HTTP_FLAG.$dirs[$i]." border=\"0\" alt=".$lngname[0]." hspace=\"3\"></a>";	
		
   }
 
} 

$database_table_name = $bx_db_table_newsletter_categories;
$this_file_name = HTTP_SERVER_ADMIN.basename($HTTP_SERVER_VARS['PHP_SELF']);

$page_title = "Newsletters Category (".$language.")";
$big_table_width = BIG_TABLE_WIDTH;
$table_head_bgcolor = TABLE_HEAD_BGCOLOR;
$inside_table_width = INSIDE_TABLE_WIDTH;
$table_bordercolor = TABLE_BORDERCOLOR;
$inside_table_bg_color = INSIDE_TABLE_BG_COLOR;
$edit_field_name = "newsletter_category_name".$slng;
if ($HTTP_POST_VARS['update'])	//update via ID
{
	for( $i = 0 ; $i < sizeof($HTTP_POST_VARS['newsletter_category_id']); $i++ )
	{
		$update_SQL = "update $database_table_name set active='".$HTTP_POST_VARS["active_id".$i]."', ".$edit_field_name."='".$HTTP_POST_VARS[$edit_field_name][$i]."' where newsletter_category_id='".$HTTP_POST_VARS['newsletter_category_id'][$i]."'";

		$update_query = bx_db_query($update_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	}
}
else{}



if ($HTTP_POST_VARS['dpp'])
{
	$display_nr = $HTTP_POST_VARS['dpp'];
	$get_vars = "dpp=".$display_nr;
}
elseif ($HTTP_GET_VARS['dpp'])
{
	$display_nr = $HTTP_GET_VARS['dpp'];
	$get_vars = "dpp=".$display_nr;
}
else{}

$SQL = "select * from $database_table_name order by newsletter_category_id";
if($list_to_end == "yes")
	$SQL .= " desc";

$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

?>


<table border="0" cellpadding="0" cellspacing="0" width="<?=$big_table_width?>" align="center">
<tr>
	<td align="center"><h3><?=$page_title?></h3></td>
</tr>
<tr>
	<td>
<?


$count_query = bx_db_query($SQL);
echo "Total number of ".$page_title." <b>".bx_db_num_rows($count_query)."</b>.<br><br>";

?>
	</td>
</tr>
<tr>
	<td bgcolor="<?=$table_bordercolor?>" align="center"> 
		<table width="<?=$inside_table_width?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=$table_head_bgcolor?>">
			<td align="center" width="7%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>ID</b></font></td>
			<td align="center" width="23%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Active <?=MULTILANGUAGE_SUPPORT == "on" ? "(global)" : ""?></b></font></td>
			<td align="center" width="70%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Categories</b></font></td>
		</tr>
		<form method=post action="<?=$this_file_name?>?from=<?=$item_back_from?>" name="forms">
<?
for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=$inside_table_bg_color?>">
			<td class="text">
				<input type="hidden" name="dpp" value="<?=$display_nr?>">
				<?=$result_array[$i]['newsletter_category_id'];?>
			</td>
			<td class="text" align="center">
<?
			$active = "";
			if ($result_array[$i]['active'] == "on")
			{
				$active = "checked";
			}
?>
				<input type="checkbox" name="active_id<?=$i?>" <?=$active?>>
			</td>
			<td class="text" align="center">
				<input type="text" name="<?=$edit_field_name?>[]" value="<?=$result_array[$i][$edit_field_name];?>" class="" size="20">
				<input type="hidden" name="newsletter_category_id[]" value="<?=$result_array[$i]['newsletter_category_id']?>">
			</td>
		 </tr>
		 
<?
}
?>
		<tr bgcolor="<?=$inside_table_bg_color?>">
			<td colspan="3" height="3"><font style="font-size:1pt">&nbsp;</font></td>
		</tr>
		<tr bgcolor="<?=$inside_table_bg_color?>">
			<td>
				&nbsp;
			</td>
			<td colspan="2">
				<input type="submit" name="update" value="Update All" class="button">
			</td>
			</form>
		</tr>
 
		</table>
	</td>
</tr>
</table>
<br>

<?
include ("admin_footer.php");
?>
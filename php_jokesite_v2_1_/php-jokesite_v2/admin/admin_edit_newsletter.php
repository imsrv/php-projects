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


$database_table_name = $bx_db_table_daily_newsletters;
$this_file_name = basename($HTTP_SERVER_VARS['PHP_SELF']);
$page_title = "Update joke of the day";
$nr_of_cols = 4;
$primary_id_name = "joke_id";
$primary_id = $HTTP_GET_VARS[$primary_id_name];

if ($HTTP_POST_VARS['update_button'] || $HTTP_POST_VARS['hidden_update']=="1")
{
	$updateSQL = "update $database_table_name set joke_text".$slng."='".strip_tags($HTTP_POST_VARS['joke_text'])."', joke_title".$slng."='".strip_tags($HTTP_POST_VARS['joke_title'])."' where ".$primary_id_name."='".$HTTP_POST_VARS[$primary_id_name]."'";
	$update_query = bx_db_query($updateSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
}


$SQL = "select * from $database_table_name where date >= current_date ORDER BY date asc";
$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, 30);

?>

<table border="0" cellpadding="0" cellspacing="0" width="<?=BIG_TABLE_WIDTH?>" align="center">
<tr>
	<td align="center"><font face="helvetica"><b><?=$page_title?><br><br></b></font></td>
</tr>
<tr>
	<td bgcolor="<?=TABLE_BORDERCOLOR?>" align="center"> 
		<table width="<?=INSIDE_TABLE_WIDTH?>" border="0" cellspacing="1" cellpadding="2" align="center">
		<tr bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
			<td align="center" width="4%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>ID</b></font></td>
			<td align="center" width="14%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Date</b></font></td>
			<td align="center" width="68%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Joke of the day</b></font></td>
			<td align="center" width="25%"><font color="<?=TABLE_HEAD_FONT_COLOR?>"><b>Action</b></font></td>
		</tr>
<?
if (sizeof($result_array) == 0)
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
			<td colspan="<?=$nr_of_cols?>" align="center">
				<b>There are no jokes!</b>
			</td>
		</tr>
<?
}
?>
<?
for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<tr bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" align="center">
		<form method="post" action="<?=$this_file_name?>">
		<input type="hidden" name="hidden_update" value="1">
			<td>
				<?=$result_array[$i][$primary_id_name];?>
			</td>
			<td class="text">
				<?echo $result_array[$i]['date'];?>
			</td>
			<td class="text" align="center">
<?
if ($result_array[$i]['joke_text'.$slng] == '')
{
	echo "No more joke for this language!";
}
?>
				<table align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<b>Joke title: </b><input type="text" name="joke_title" value="<?echo $result_array[$i]['joke_title'.$slng];?>" class="">
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<b>Joke text:</b> <textarea name="joke_text" rows="5" cols="40"><?echo $result_array[$i]['joke_text'.$slng];?></textarea>
					</td>
				</tr>
				</table>
			</td>
			<td class="text" align="center">
				<input type="submit" value="Update" name="update_button" class="button" valign="middle">
				<input type="hidden" name="<?=$primary_id_name?>" value="<?=$result_array[$i][$primary_id_name];?>">
			</td>
		</form>
		</tr>
<?
}
?>

		</table>
	</td>
</tr>
<tr>
	<td>
		<br>&nbsp;<a href="<?$HTTP_SERVER_ADMIN?>admin_random_newsletter_jokes.php?rebuild=2&make=1">Rebuild all data <?=MULTILANGUAGE_SUPPORT=="on" ? "in this language" : "" ?></a>
	</td>
</tr>
<?
if(MULTILANGUAGE_SUPPORT=="on")
{
?>
<tr>
	<td>
		&nbsp;<a href="<?$HTTP_SERVER_ADMIN?>admin_random_newsletter_jokes.php?rebuild=1&make=1">Rebuild all data in all language</a>
	</td>
</tr>
<?}?>
</table>
<br>

<?
include(DIR_SERVER_ADMIN."admin_footer.php");
?>
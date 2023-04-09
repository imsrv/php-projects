<?
include(DIR_LNG.'pictures_category_with_images_form.php');
	if (!$cat_id)
		$post_string = " All Categories";
	else
	{
		$select_category_name_SQL = "select * from $database_table_name1 where category_id='".$cat_id."'";
		$select_category_name_query = bx_db_query($select_category_name_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$select_category_name_result = bx_db_fetch_array($select_category_name_query);
		$post_string = "'<b>".$select_category_name_result['category_name'.$slng]."</b>' ".TEXT_CATEGORY;
	}
?>
<tr valign="top">
	<td>

<?

$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);

echo "<table width=\"100%\"><tr><td align=\"center\"><b><font size=\"3\" font-family=\"verdana\" color=\"".TOP_PICTURES_PAGE_TITLE_FONTCOLOR."\">"."&nbsp;&nbsp;".$type.$post_string."&nbsp;&nbsp;"."</font></td></tr></table><br></b>";

if (sizeof($result_array) == 0)
{
?>
		<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr align="center">
			<td colspan="4" align="center">
				<table align="center" border="0" cellspacing="0" cellpadding="1" width="100%" bgcolor="<?=THERE_ARE_NO_PICTURES_BORDERCOLOR?>">
				<tr>
					<td>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="<?=THERE_ARE_NO_PICTURES_INTERNAL_BGCOLOR?>">
						<tr>
							<td align="center" style="color:<?=THERE_ARE_NO_PICTURES_FONT_COLOR?>">
							<br><b><?=TEXT_NO_PICTURES?></b><br><br>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<?
}

for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
	$new_res = '<img src="'.HTTP_LANG_IMAGES.'new.gif" border="0" alt="">';
	$new_res = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_pictures-1,date('Y'))) < $result_array[$i]['added'] ? $new_res : "");
?>
		<table align="center" border="0" cellspacing="10" cellpadding="1" width="100%">
			<tr>
				<td width="10" valign="top">
					<font size="1" color="#A330AF">&nbsp;<?=$from+$i+1?>.<?=$new_res?></font>
				</td>
				<td width="30%" valign="top">
					<a href="<?=HTTP_SERVER?>creat_postcard.php?cat_id=<?=$cat_id?>&img_id=<?=$result_array[$i]['img_id']?>"><img src="<?=HTTP_INCOMING?><?=$result_array[$i]['little_img_name']?>" border="0" alt=""></a>
				</td>
				<td>
					&nbsp;
				</td>
				<td>
					<?=($slng==$result_array[$i]['slng'] ? (wordwrap(nl2br($result_array[$i]['comment']),40)) : "");?>
				</td>
			</tr>
		</table>
<?
}
?>

		<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
$get_vars = "cat_id=".$cat_id;
make_next_previous_with_number( $from, $SQL, $this_file_name, $get_vars ,$display_nr);
?>
			</td>
		</tr>
		</table>
	</td>
</tr>
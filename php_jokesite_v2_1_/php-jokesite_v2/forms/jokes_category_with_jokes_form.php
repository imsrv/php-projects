<?
include(DIR_LNG.'jokes_category_with_jokes_form.php');
	if (!$HTTP_GET_VARS['cat_id'])
		$post_string = TEXT_ALL_CATEGORIES;
	else
	{
		$select_category_name_SQL = "select * from $database_table_name1 where category_id='".$HTTP_GET_VARS['cat_id']."'";
		$select_category_name_query = bx_db_query($select_category_name_SQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$select_category_name_result = bx_db_fetch_array($select_category_name_query);
		$post_string = "'<b>".$select_category_name_result['category_name'.$slng]."</b>' ".TEXT_CATEGORY;
	}
?>
<tr valign="top">
	<td>

<?

if($mode != "random" && $mode != "search")
{
	$from = $HTTP_GET_VARS['from'];
	$result_array = step( $HTTP_GET_VARS['from'], $item_back_from, $SQL, $display_nr);
}

echo "<table width=\"100%\"><tr><td align=\"center\"><b><font size=\"3\" font-family=\"verdana\" color=\"".TOP_JOKES_PAGE_TITLE_FONTCOLOR."\">"."&nbsp;&nbsp;".$type." ".$post_string."&nbsp;&nbsp;"."</font></td></tr></table><br></b>";

if (sizeof($result_array) == 0)
{
?>
		<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr align="center">
			<td colspan="4" align="center">
				<table align="center" border="0" cellspacing="0" cellpadding="1" width="100%" bgcolor="<?=THERE_ARE_NO_JOKES_BORDERCOLOR?>">
					<tr><td>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="<?=THERE_ARE_NO_JOKES_INTERNAL_BGCOLOR?>">
							<tr><td align="center" style="color:<?=THERE_ARE_NO_JOKES_FONT_COLOR?>">
								<br><b><?=TEXT_NO_JOKES?></b><br><br>
							</td></tr></table>
						</td></tr></table>
			</td>
		</tr>
		</table>
<?
}
for( $i = 0 ; $i < sizeof($result_array) ; $i++ )
{
?>
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="90%">
		<tr>
			<td background="images/head_bg.jpg" bgcolor="<?=SHORT_JOKE_TITLE_HEAD_BGCOLOR?>" width="5%">
<?
$new_res = '<img src="'.HTTP_LANG_IMAGES.'new.gif" border="0" alt="">';
echo $new_res = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y'))) < $result_array[$i]['date_add'] ? $new_res : "&nbsp;");
?>
			</td>
			<td background="images/head_bg.jpg" bgcolor="<?=SHORT_JOKE_TITLE_HEAD_BGCOLOR?>" align="center" width="95%">
				<font size="<?=JOKE_TOPHEADER_FONT_SIZE?>" color="<?=JOKE_TOPHEADER_FONT_COLOR?>"><?=TEXT_JOKE_POSTED?> <b><?=$result_array[$i]['name'];?></b> <?=TEXT_AT?> <?=$result_array[$i]['date_add'];?></font>
			</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="<?=SHORT_JOKE_TITLE_BORDERCOLOR?>" >
				<table align="center" border="0" cellspacing="0" cellpadding="2" width="100%" bgcolor="<?=SHORT_JOKE_TITLE_BGCOLOR?>">
<?
$get_extra= ($HTTP_POST_VARS['adv_search']=="1" || $HTTP_GET_VARS['adv_search']=="1" ? "&adv_search=1" : "").($HTTP_POST_VARS['x'] =="1" ? "&q_search=1" : "");
?>
				<tr>
					<td colspan="2">
						<font size="<?=SHORT_JOKE_TITLE_FONT_SIZE?>" color="<?=SHORT_JOKE_TITLE_FONTCOLOR?>">&nbsp;<?=$from+$i+1?>.-</font>
						<a href="<?=HTTP_SERVER?>jokes.php?joke_id=<?=$result_array[$i]['joke_id']?><?=$get_extra?>&cat_id=<?=$HTTP_GET_VARS['cat_id']?>&jtype=<?=$jtype?>" style="text-decoration:none;color:<?=SHORT_JOKE_TITLE_FONTCOLOR?>;font-weight:bold"><?=$result_array[$i]['joke_title']?></a>
						<br>
						&nbsp;<font size="<?=SHORT_JOKE_TEXT_SIZE?>" color="<?=SHORT_JOKE_TEXT_COLOR?>"><?=short_string($result_array[$i]['joke_text'], $joke_listing_show_characters, "...");?></font>
					</td>
				</tr>
				<tr>
					<td align="right" style="font-size:9pt;color:<?=SHORT_JOKE_RATE_EMAIL_FONT_COLOR?>" colspan="2">
						&nbsp;<b><?=TEXT_RATE?>
						<?
						if($result_array[$i]['rating_value'] > 0)
						{
							for ($star=0;$star<$result_array[$i]['rating_value'] && $result_array[$i]['rating_value'] != '0';$star++ )
							{
								echo "<img src=\"".DIR_IMAGES."star2.gif\" border=\"0\">";
							}
						}
						elseif($result_array[$i]['rating_value'] == '0' || $result_array[$i]['rating_value']='NULL' || $result_array[$i]['rating_value']=='')
								echo "0";
							?>
						
						</b>,
						&nbsp;<b><?=TEXT_EMAILED?></b>&nbsp;<?=$result_array[$i]['emailed_value'];?>&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>

<?
}
?>

		<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td>
<?

make_next_previous_with_number( $from, $SQL, $this_file_name, $get_vars ,$display_nr);
?>
			</td>
		</tr>
		</table>
	</td>
</tr>
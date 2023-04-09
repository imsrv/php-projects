<?
include (DIR_LANGUAGES.$language."/picture_categories_form.php");
?>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=LEFT_PART_WIDTH?>">
		<tr>
			<td bgcolor="<?=PICTURES_CATEGORY_LISTING_BORDERCOLOR?>">
				<table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" width="100%">
				<tr><td colspan="2"><img src="<?=HTTP_LANGUAGES.$language?>/images/pictures_categories.gif" border="0"><br><img src="images/lines2.gif" border="0"></td></tr>
				<tr>
<!-- 					<td>
						&nbsp;
					</td> -->
					<td>
<?
$database_table_name1 = $bx_db_table_image_categories;  
$select_joke_categories_SQL = "select * from $database_table_name1";
$select_joke_categories_query = bx_db_query($select_joke_categories_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
while ($select_joke_categories_result = bx_db_fetch_array($select_joke_categories_query))
{
	
	$selectCountSQL = "select * from $bx_db_table_images where category_id='".$select_joke_categories_result['category_id']."' and validate='1'  order by added desc";
	$selectCount_query = bx_db_query($selectCountSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$selectCount_res = bx_db_fetch_array($selectCount_query);

	$countedPictures = $showCountedPictures ? '&nbsp;('.bx_db_num_rows($selectCount_query).')' : '';

	$new_res = '<font style="font-size:9px;color:#FF0000;font-family:verdana">&nbsp;'.$countedPictures.'</font>';
	$countedPictures = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_pictures-1,date('Y'))) < $selectCount_res['added'] ? $new_res : '<font style="font-size:9px;font-family:verdana">&nbsp;'.$countedPictures."</font>");

?>
<img src="images/bullet.gif" border="0"><a href="<?=$this_file_name?>?cat_id=<?=$select_joke_categories_result['category_id']?>" class="category"><?=$select_joke_categories_result['category_name'.$slng]?></a><?=$countedPictures?><br>
<?
}
?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
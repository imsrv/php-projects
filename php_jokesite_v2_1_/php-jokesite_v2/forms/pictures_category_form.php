<?
$database_table_name1 = $bx_db_table_image_categories;
$database_table_name2 = $bx_db_table_images;
?>
<tr>
	<td>
		<img src="<?=HTTP_LANG_IMAGES?>funny_pictures.gif" border="0" alt="">
	</td>
</tr>
<tr>
	<td>
		<table align="center" border="0" cellspacing="1" cellpadding="14" width="90%">
		
<?
$select_funny_pictures_SQL = "select * from $database_table_name1";
$select_funny_pictures_query = bx_db_query($select_funny_pictures_SQL);
$count_funny_pictures = bx_db_num_rows($select_funny_pictures_query);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

$i=0;
$rows=0;
while ($select_funny_pictures_result = bx_db_fetch_array($select_funny_pictures_query))
{
	++$i;
	
	if($show_images_at_home!="on")
		$select_one_image_SQL = "select * from $database_table_name2 where category_id='".$select_funny_pictures_result['category_id']."' and validate='1'";
	else 
		$select_one_image_SQL = "select * from $database_table_name2 where category_id='".$select_funny_pictures_result['category_id']."' and validate='1' and show_images_at_home='1'";

	$select_one_image_query = bx_db_query($select_one_image_SQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$select_one_image_result = bx_db_fetch_array($select_one_image_query);
	if ($select_one_image_result ==0)
		continue;

	++$j;

	$selectNewSQL = "select added from $bx_db_table_images where category_id='".$select_one_image_result['category_id']."'";

	$selectNew_query = bx_db_query($selectNewSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$selectNew_res = bx_db_fetch_array($selectNew_query);
	//$new_res = '<font style="font-size:10px;color:#FF0000">&nbsp;<sup>New</font>';
	$new_res = '<img src="'.HTTP_LANG_IMAGES.'new.gif" border="0" alt="">';
	$new_res = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_pictures-1,date('Y'))) < $selectNew_res['added'] ? $new_res : "");



	if ($j%3 == 1)
	{
			echo "<tr align=\"center\" valign=\"top\"><td width=\"33%\"><a href=\"pictures_category.php?cat_id=".$select_funny_pictures_result['category_id']."\" class=\"category\">".$select_funny_pictures_result['category_name'.$slng].$new_res."<br><img src=\"".DIR_IMAGES."0.gif\" border=\"0\" height=\"6\"><br><img src=\"".HTTP_INCOMING.$select_one_image_result['little_img_name']."\" border=\"0\"></a></td>";
		++$rows;
	}
	elseif ($j%3 == 0)
	{
		echo "<td width=\"33%\"><a href=\"pictures_category.php?cat_id=".$select_funny_pictures_result['category_id']."\" class=\"category\">".$select_funny_pictures_result['category_name'.$slng].$new_res."<br><img src=\"".DIR_IMAGES."0.gif\" border=\"0\" height=\"6\"><br><img src=\"".HTTP_INCOMING.$select_one_image_result['little_img_name']."\" border=\"0\"></a></td></tr>";
	}
	else
	{
		echo "<td width=\"33%\"><a href=\"pictures_category.php?cat_id=".$select_funny_pictures_result['category_id']."\" class=\"category\">".$select_funny_pictures_result['category_name'.$slng].$new_res."<br><img src=\"".DIR_IMAGES."0.gif\" border=\"0\" height=\"6\"><br><img src=\"".HTTP_INCOMING.$select_one_image_result['little_img_name']."\" border=\"0\"></a></td>";
	}

}
if ($j%3 !=0)
{
	$need_td = 3-$j%3;
	while($need_td--)
	{
		if ($need_td == -10)
		{
			exit;
		}
		echo "<td>&nbsp;</td>";
	}
}

?>
		</table>
			
	</td>
</tr>

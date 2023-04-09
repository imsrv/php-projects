<?
$database_table_name = $bx_db_table_joke_categories;
?>

<tr>
	<td>
		<img src="<?=HTTP_LANG_IMAGES?>jokes_by_category.gif" border="0" alt="">
	</td>
</tr>
<tr>
	<td>
		<table align="center" border="0" cellspacing="1" cellpadding="10" width="100%">
<?
	$select_category_SQL = "select * from $database_table_name";
	$select_category_query = bx_db_query($select_category_SQL);
	$count_category = bx_db_num_rows($select_category_query);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

	$i=0;
	$rows=0;
	while ($select_category_result = bx_db_fetch_array($select_category_query))
	{
		++$i;
		
		$selectCountSQL = "select date_add from $bx_db_table_jokes where category_id='".$select_category_result['category_id']."' and validate='1' and slng='".$slng."' order by date_add desc";
		$selectCount_query = bx_db_query($selectCountSQL);
		SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
		$selectCount_res = bx_db_fetch_array($selectCount_query);

		$countedJokes = $showCountedJokes ? '&nbsp;<font style="font-size:10px;font-family:verdana">('.bx_db_num_rows($selectCount_query).')</font>' : '';

		$new_res = '<img src="'.HTTP_LANG_IMAGES.'new.gif" border="0" alt="">';
		$new_res = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y'))) < $selectCount_res['date_add'] ? $new_res : "");

		if ($i%3 == 1)
		{
			echo "<tr align=\"center\"><td width=\"33%\"><a href=\"jokes_category.php?cat_id=".$select_category_result['category_id']."\" class=\"category\">".$select_category_result['category_name'.$slng]."</a>".$countedJokes.$new_res."</td>";
			++$rows;
		}
		elseif ($i%3 == 0)
		{
			echo "<td width=\"33%\"><a href=\"jokes_category.php?cat_id=".$select_category_result['category_id']."\" class=\"category\">".$select_category_result['category_name'.$slng]."</a>".$countedJokes.$new_res."</td></tr>";
		}
		else
		{
			echo "<td width=\"33%\"><a href=\"jokes_category.php?cat_id=".$select_category_result['category_id']."\" class=\"category\">".$select_category_result['category_name'.$slng]."</a>".$countedJokes.$new_res."</td>";
		}

		if ($count_category == $i)
		{
			$need_td = $rows * 3 - $count_category;
			while($need_td--)
			{
				if ($need_td == -10)
				{
					exit;
				}
				echo "<td>&nbsp;</td>";
			}
		}
	} 
?>
		</table>
		<br>
	</td>
</tr>


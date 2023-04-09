<?
include (DIR_LANGUAGES.$language."/joke_categories_form.php");
?>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=LEFT_PART_WIDTH?>">
<!-- 		<tr>
			<td bgcolor="<?=JOKES_CATEGORY_LISTING_HEAD_BGCOLOR?>" align="center"><font face="verdana, helvetica, arial" size="2" color="<?=JOKES_CATEGORY_LISTING_HEAD_FONT_COLOR?>"><b><?=TEXT_JOKES_CATEGORIES?></b></font></td>
		</tr> -->
		<tr>
			<td bgcolor="<?=JOKES_CATEGORY_LISTING_BORDERCOLOR?>">
				<table align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" width="100%">
				<tr><td colspan="2"><img src="<?=HTTP_LANGUAGES.$language?>/images/jokes_categories.gif" border="0"><br><img src="images/lines2.gif" border="0"></td></tr>
				<tr>
					<!-- <td>&nbsp;</td> -->
					<td>
						<table align="center" border="0" cellspacing="0" cellpadding="0"  width="100%">
<?
$select_joke_categories_SQL = "select * from $database_table_name1";
$select_joke_categories_query = bx_db_query($select_joke_categories_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
while ($select_joke_categories_result = bx_db_fetch_array($select_joke_categories_query))
{
	$selectCountSQL = "select date_add from $bx_db_table_jokes where category_id='".$select_joke_categories_result['category_id']."' and validate='1' ";
	if ($HTTP_GET_VARS['jtype'] =="new")
		$selectCountSQL .= " and (date_add between '".date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y')))."' and '".date('Y-m-d')."')";
	
	$selectCount_query = bx_db_query($selectCountSQL);
	SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
	$selectCount_res = bx_db_fetch_array($selectCount_query);

	$countedJokes = $showCountedJokes ? '&nbsp;('.bx_db_num_rows($selectCount_query).')' : '';

	$new_res = '<font style="font-size:9px;color:#FF0000;font-family:verdana">&nbsp;'.$countedJokes.'</font>';
	$countedJokes = (date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y'))) < $selectCount_res['date_add'] ? $new_res : '<font style="font-size:9px;font-family:verdana">&nbsp;'.$countedJokes."</font");

	if((basename($HTTP_SERVER_VARS['PHP_SELF']) =="advanced_search.php" || basename($HTTP_SERVER_VARS['PHP_SELF']) =="quick_search.php") && !$HTTP_GET_VARS['jtype'])
	{
?>
		<tr><td><a href="<?=HTTP_SERVER?>jokes_category.php?cat_id=<?=$select_joke_categories_result['category_id']?>&jtype=<?=$HTTP_GET_VARS['jtype']?>" class="category"><?=$select_joke_categories_result['category_name'.$slng]?></a><?=$countedJokes?></td></tr>
<?
	}
	elseif ($HTTP_GET_VARS['jtype'])
	{
		switch($HTTP_GET_VARS['jtype'])
		{
			case "emailed":
				$j_file_name = 'top_emailed_jokes.php';	
				break;
			case "ten":
				$j_file_name = 'top_ten_jokes.php';	
				break;
			case "random":
				$j_file_name = 'top_random_jokes.php';	
				break;
			case "new":
				$j_file_name = 'new_jokes.php';	
				break;
			default:
				$j_file_name = 'jokes_category.php';	
				break;
			
		}
?>
	<tr><td><img src="images/bullet.gif" border="0"><a href="<?=$j_file_name?>?cat_id=<?=$select_joke_categories_result['category_id']?>&jtype=<?=$HTTP_GET_VARS['jtype']?>" class="category"><?=$select_joke_categories_result['category_name'.$slng]?></a><?=$countedJokes?></td></tr>
<?
	}
	else
	{
	$HTTP_GET_VARS['jtype'] = 1;
?>
	<tr><td><img src="images/bullet.gif" border="0"><a href="jokes_category.php?cat_id=<?=$select_joke_categories_result['category_id']?>&jtype=<?=$HTTP_GET_VARS['jtype']?>" class="category"><?=$select_joke_categories_result['category_name'.$slng]?></a><?=$countedJokes?></td></tr>
<?
	}
}
if (($jokes_file != '1' && basename($HTTP_SERVER_VARS['PHP_SELF']) !="advanced_search.php" && basename($HTTP_SERVER_VARS['PHP_SELF']) !="quick_search.php") && $HTTP_GET_VARS['jtype'])
{
?>
	<tr><td><img src="images/bullet.gif" border="0"><a href="<?=$j_file_name?>" class="category"><?=TEXT_ALL_CATEGORIES?></a></td></tr>
<?
}
?>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
<?include(DIR_LNG.'joke_form.php');?>
<tr>
	<td>
<?

$select_joke_SQL = "select * from $database_table_name2 where joke_id='".$HTTP_GET_VARS['joke_id']."'";
$select_joke_query = bx_db_query($select_joke_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$select_joke_result = bx_db_fetch_array($select_joke_query);

if (!$HTTP_GET_VARS['joke_id'] || bx_db_num_rows($select_joke_query)=='0')
{
	$message_to_user = TEXT_JOKE_NOT_FOUND;
	include (DIR_FORMS."message_form.php");
	include(DIR_SERVER_ROOT. 'footer.php');
	exit;
}
else
	$cat_id = $select_joke_result['category_id'];
	//$cat_id = $HTTP_GET_VARS['cat_id'];
?>
		<table border="0" cellspacing="0" cellpadding="0" width="80%" align="center">
		<tr>
			<td>
<?
if (!$HTTP_GET_VARS['p'])
{
?>				
				<BR>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center"><tr><td>
				</td><td align="right"><a href="javascript:printitWindow(500,550)" style="text-decoration:none;color:#990000"><img src="<?=DIR_IMAGES?>printit.gif" border="0" alt=""> <?=PRINTABLE_VERSION?></a></td></tr></table><BR><hr color="<?=HR_COLOR?>" width="<?=HR_WIDTH?>">
<?}?>
			</td>
		</tr>
		<tr>
			<td style="color:#185616;font-size:12pt;">
				<b><?=TEXT_JOKE_CATEGORY?></b>
<?

$select_category_SQL = "select * from $database_table_name1 where category_id='".$cat_id."'";
$select_category_query = bx_db_query($select_category_SQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$select_category_result = bx_db_fetch_array($select_category_query);
if (!$HTTP_GET_VARS['p'])
	echo "<a href=\"".HTTP_SERVER."jokes_category.php?cat_id=".$cat_id."\" style=\"text-decoration:none;color:#CC0000\";font-weight:bold;>".$select_category_result['category_name'.$slng]."</a>";
else
	echo '<font style="text-decoration:none;color:#CC0000">'.$select_category_result['category_name'.$slng].'</font>';
?>
			</td>
		</tr>
<?
if (!$HTTP_GET_VARS['p'])
{
	if($use_censor == "yes")
	{
?>
		<tr>
			<td style="color:#185616;">
<?
$selectContentSQL = "select * from $bx_db_table_censor_categories where censor_category_id='".$select_joke_result['censor_type']."'";
$selectContent_query = bx_db_query($selectContentSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$selectContent_res = bx_db_fetch_array($selectContent_query);
?>
				<b><?=TEXT_CONTENT_CATEGORY?></b>
				<?=$selectContent_res['censor_category_name'.$slng]?>
				<br><br>
			</td>
		</tr>
<?	}
?>
		<tr>
			<td style="color:#185616;font-size:9pt;">
				<b>&nbsp;<?=TEXT_SUBMITED_BY?></b>
				<?=$select_joke_result['name']?> <?=TEXT_ON?> <?=$select_joke_result['date_add']?>
			</td>
		</tr>
		<tr>
			<td style="color:#185616;font-size:9pt;">
				<b>&nbsp;<?=TEXT_TYPE?></b>
				<?=$select_joke_result['joke_type']?>
			</td>
		</tr>
		<tr>
			<td style="color:#185616;font-size:9pt;">
				<b>&nbsp;<?=TEXT_RATE?></b>
				<?=$select_joke_result['rating_value']?>
			</td>
		</tr>
		<tr>
			<td style="color:#185616;font-size:9pt;">
				<b>&nbsp;<?=TEXT_SENT?></b>
				<?=$select_joke_result['emailed_value']?>
			</td>
		</tr>
<?}?>
		<tr>
			<td style="color:#185616;font-size:12pt;">
				<BR><hr color="<?=HR_COLOR?>" width="<?=HR_WIDTH?>"><b><?=TEXT_TITLE?></b>
				<font color="#CC0000"><?=$select_joke_result['joke_title']?></font>
			</td>
		</tr>
		<tr>
			<td style="color:#185616;font-size:12pt;">
				<br><?=nl2br($select_joke_result['joke_text'])?>
			</td>
		</tr>
<?
if (!$HTTP_GET_VARS['p'])
{
?>
		<tr>
			<td><BR><hr color="<?=HR_COLOR?>" width="<?=HR_WIDTH?>">
			</td>
		</tr>
		<tr>
			<td>
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="70%">
				<tr>
					<td width="50%" >
<?
switch($HTTP_GET_VARS['jtype'])
{
	case "emailed":
		$condition = " where ".($HTTP_GET_VARS['cat_id'] ? "category_id=".$HTTP_GET_VARS['cat_id']." and" : "")."  validate='1' and slng='".$slng."' ORDER BY emailed_value desc, rating_value DESC limit 0, 10";	
		break;
	case "ten":
		$condition = " where ".($HTTP_GET_VARS['cat_id'] ? "category_id=".$HTTP_GET_VARS['cat_id']." and" : "")." validate='1' and slng='".$slng."' ORDER BY rating_value DESC limit 0, 10";
		break;
	case "random":
		$condition = " where ".($HTTP_GET_VARS['cat_id'] ? "category_id=".$HTTP_GET_VARS['cat_id']." and" : "")." validate='1' and slng='".$slng."' order by rand() limit 0,10";
		break;
	case "new":
		$condition = " where ".($HTTP_GET_VARS['cat_id'] ? "category_id=".$HTTP_GET_VARS['cat_id']." and" : "")." validate='1' and slng='".$slng."' and (date_add between '".date('Y-m-d',mktime (0,0,0,date('m'),date('d')-$newperiod_for_jokes-1,date('Y')))."' and '".date('Y-m-d')."') ORDER BY rating_value DESC";
		break;
	default:
		$condition = " where ".($HTTP_GET_VARS['cat_id'] ? "category_id=".$HTTP_GET_VARS['cat_id']." and" : "")." validate='1' and slng='".$slng."' order by rating_value desc limit 0,10";	
		break;
}

$selectPreviousSQL = "select * from $database_table_name2  ".$condition;
$select_Previous = bx_db_query($selectPreviousSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));

$count_temp=-1;
while ($previous_res = bx_db_fetch_array($select_Previous))
{
	$count_temp++;
	if ($previous_res['joke_id'] == $HTTP_GET_VARS['joke_id'])
	{
		$count_temp_nr=$count_temp;
	}
}
if ( $count_temp_nr > 0 )
{
	mysql_data_seek ($select_Previous, $count_temp_nr-1);
	$previous_res = bx_db_fetch_array($select_Previous);
	$previous_id = $previous_res['joke_id'];
	$exist_previous_id = 1;
}else
{
	$exist_previous_id = 0;
}

if ( $count_temp_nr < $count_temp )
{
	mysql_data_seek ($select_Previous, $count_temp_nr+1);
	$previous_res = bx_db_fetch_array($select_Previous);
	$next_id = $previous_res['joke_id'];
	$exist_next_id = 1;
}else
{
	$exist_next_id = 0;
}


if (!$HTTP_GET_VARS['adv_search']=="1" && !$HTTP_GET_VARS['q_search']=="1")
{
		if(bx_db_num_rows($select_Previous))
		{
				
			if ($exist_previous_id)
			{
				echo '<a href="'.HTTP_SERVER.'jokes.php?joke_id='.$previous_id.'&cat_id='.$HTTP_GET_VARS['cat_id'].'&jtype='.$HTTP_GET_VARS['jtype'].'" style="text-decoration:none">';
			}
			
		}
		?>
			<font color="<?=(($exist_previous_id)?NEXT_PREVIOUS_TEXT_COLOR:NEXT_PREVIOUS_NA_TEXT_COLOR)?>"><b>&lt;&lt; Prevoius</b></font>
		<?
			if($exist_previous_id) echo '</a>';
		?>
							</td>
							<td width="50%" align="right">
		<?
			if ($exist_next_id)
			{
				echo '<a href="'.HTTP_SERVER.'jokes.php'.'?joke_id='.$next_id.'&cat_id='.$HTTP_GET_VARS['cat_id'].'&jtype='.$HTTP_GET_VARS['jtype'].'" style="text-decoration:none">';
			}	
		?>
			<font color="<?=(($exist_next_id)?NEXT_PREVIOUS_TEXT_COLOR:NEXT_PREVIOUS_NA_TEXT_COLOR)?>"><b>Next &gt;&gt;</b></font>
		<?
			if($exist_next_id) echo '</a>';
}else{
		echo "&nbsp;<a href=\"javascript:history.go(-1)\" style=\"text-decoration:none\"><font color=\"".BACK_TEXT_COLOR."\">".BACK_TEXT."</font></a></td><td width=50%>&nbsp;";
}
		?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
<?}?>
		</table>

		
	</td>
</tr>

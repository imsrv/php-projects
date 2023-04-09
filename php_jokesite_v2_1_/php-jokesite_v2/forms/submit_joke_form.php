<?include(DIR_LNG.'submit_joke_form.php');?>

<tr valign="top">
	<td>
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="80%">
		<tr valign="top">
	<td colspan="2"><br>
		<b><?=TEXT_BEFORE_SUBMIT?></b>
	</td>
</tr>
<tr valign="top">
	<td colspan="2" width="<?=HTML_WIDTH-200?>">
		&nbsp;&nbsp;&nbsp;<?=TEXT_LI1?><br><br><br>
	</td>
</tr>
		<tr>
			<td background="images/head_bg.jpg" align="center">
				<b><?=TEXT_YOUR_JOKE?></b>
			</td>
		</tr>
		<tr>
			<td bgcolor="<?=SUBMIT_JOKE_HEAD_BORDERCOLOR?>">
				<form method=post action="<?=$this_file_name.$HTTP_GET_VARS['joke'] ? "?joke=".$HTTP_GET_VARS['joke'] : ""?>">
				<table align="center" border="0" cellspacing="0" cellpadding="5" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" width="100%">
				<tr valign="top">
					<td width="35%">
						<b><?=TEXT_YOUR_NAME?></b>
					</td>
					<td>
						<input type="text" name="sender_name" value="<?=$HTTP_POST_VARS['sender_name']?>" class="">
						<input type="hidden" name="submit_joke" value="1">
<?
if ($sender_name_error)
{
	display_error("<br> ".TEXT_ERROR_NAME);
}
?>
					</td>
				</tr>
				<tr valign="top">	<td>
						<b><?=TEXT_YOUR_EMAIL?></b>
					</td>
					<td>
						<input type="text" name="sender_email" value="<?=$HTTP_POST_VARS['sender_email'] ? $HTTP_POST_VARS['sender_email'] : (ENABLE_ANONYMOUS_POSTING ? TEXT_ANONYMOUS : "")?>" class="">
<?
if ($sender_email_error)
{
	display_error("<br> ".TEXT_ERROR_EMAIL);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_JOKE_CATEGORY?></b>
					</td>
					<td>
						<select  name="joke_category" class="input" >
							<option selected value="0"><?=TEXT_SELECT_A_CATEGORY?>&nbsp;</option>
<?
$SQL = "select * from $database_table_name1 order by category_name".$slng;
$select_category_query = bx_db_query($SQL);
while($select_category_result = bx_db_fetch_array($select_category_query))
{
	echo "<option value=\"".$select_category_result['category_id']."\"";
	
	if($HTTP_POST_VARS['joke_category'] == $select_category_result['category_id'])
		echo "selected";
	echo ">".$select_category_result['category_name'.$slng]."</option>";

}
?>
						</select>
<?
if ($joke_category_error)
{
	display_error("<br>".TEXT_ERROR_CATEGORY);
}
?>
					</td>
				</tr>
<?
if($use_censor == "yes")
{
?>
				<tr valign="top">
					<td>
						<b><?=TEXT_CONTENT_CATEGORY?></b>
					</td>
					<td>
						<select name="censor_category">
							<option selected value="0"><?=TEXT_SELECT_A_CATEGORY?>&nbsp;</option>
<?
	$SQL = "select * from $database_table_name2 order by censor_category_name".$slng;
	$select_category_query = bx_db_query($SQL);
	while($select_category_result = bx_db_fetch_array($select_category_query))
	{
		echo "<option value=\"".$select_category_result['censor_category_id']."\"";
		
		if($HTTP_POST_VARS['censor_category'] == $select_category_result['censor_category_id'])
			echo "selected";
		echo ">".$select_category_result['censor_category_name'.$slng]."</option>";

	}
?>				
						</select>
<?
	if ($censor_category_error)
	{
		display_error("<br>".TEXT_ERROR_JOKE_CATEGORY);
	}
?>
					</td>
				</tr>
<?
}
?>
				<tr valign="top">
					<td>
						<b><?=TEXT_JOKE_TITLE?></b>
					</td>
					<td>
						<input type="text" name="joke_title" value="<?=stripslashes($HTTP_POST_VARS['joke_title'])?>" class="">
<?
if ($joke_title_error)
{
	display_error("<br>".TEXT_ERROR_TITLE);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_ENTER_JOKE?></b>
					</td>
					<td>
						<textarea name="joke_text" rows="10" cols="30"><?=stripslashes($HTTP_POST_VARS['joke_text'])?></textarea><?
if ($joke_text_error)
{
	display_error("<br>".TEXT_ERROR_JOKE." ".$long_jokes_length);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2" align="center">
						<input type="submit" name="submit" value="<?=TEXT_SUBMIT_J?>" class="button">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?=JOKE_CONFIRM_TEXT?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table></form>
	</td>
</tr>
<tr>
	<td>
		&nbsp;
	</td>
</tr>
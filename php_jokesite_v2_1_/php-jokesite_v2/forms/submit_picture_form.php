<?include(DIR_LNG.'submit_picture_form.php');?>
<tr valign="top">
	<td>
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="80%">
		<tr valign="top">
			<td><br>
				<b><?=TEXT_BEFORE_SUBMIT?></b>
			</td>
		</tr>
		<tr valign="top">
			<td>
				&nbsp;&nbsp;&nbsp;<?=TEXT_LI?><br><br><br>
			</td>
		</tr>
		<tr>
			<td background="images/head_bg.jpg" align="center"><!-- bgcolor="<?=SUBMIT_PICTURE_HEAD_COLOR?>" -->
				<b><?=TEXT_YOUR_PICTURE?></b>
			</td>
		</tr>
		<tr>
			<td bgcolor="<?=SUBMIT_PICTURE_TABLE_BORDERCOLOR?>">
				<form method=post action="<?=$this_file_name?>" enctype="multipart/form-data">
				<table align="center" border="0" cellspacing="0" cellpadding="5" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" width="100%">
				<tr valign="top">
					<td width="35%"><b><?=TEXT_YOUR_NAME?></b></td>
					<td>
						<input type="text" name="sender_name" value="<?=$HTTP_POST_VARS['sender_name'] ?>" class="">
						<input type="hidden" name="submit_image" value="1">
<?
if ($sender_name_error)
{
	display_error("<br>".TEXT_ERROR_NAME);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_YOUR_EMAIL?></b>
					</td>
					<td>
						<input type="text" name="sender_email" value="<?=$HTTP_POST_VARS['sender_email'] ? $HTTP_POST_VARS['sender_email'] : (ENABLE_ANONYMOUS_POSTING ? TEXT_ANONYMOUS : "")?>" class="">
<?
if ($sender_email_error)
{
	display_error("<br>".TEXT_ERROR_EMAIL);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_PICTURE_CATEGORY?></b>
					</td>
					<td>
						<select  name="image_category" class="input" >
							<option selected value="0"><?=TEXT_SELECT_A_CATEGORY?>&nbsp;</option>
<?
$SQL = "select * from $database_table_name1 order by category_name".$slng;
$select_category_query = bx_db_query($SQL);
while($select_category_result = bx_db_fetch_array($select_category_query))
{
	echo "<option value=\"".$select_category_result['category_id']."\"";
	
	if($HTTP_POST_VARS['image_category'] == $select_category_result['category_id'])
		echo "selected";
	echo ">".$select_category_result['category_name'.$slng]."</option>";

}
?>
						</select>
<?
if ($image_category_error)
{
	display_error("<br>".TEXT_ERROR_PICTURE_CATEGORY);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_SELECT_A_PICTURE?></b>
					</td>
					<td>
						<input type="file" name="photo">
<?
if ($photo_error)
{
	display_error("<br>".TEXT_ERROR_PICTURE." ");
	if($imagemagic != 'yes')
		display_error(TEXT_ERROR_PICTURE_CONTINUE." ".$big_photo_width." x ".$big_photo_height);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<b><?=TEXT_COMMENT?></b>
					</td>
					<td>
						<textarea name="comment" rows="10" cols="30"><?=stripslashes($HTTP_POST_VARS['comment'])?></textarea>
<?
if ($pict_text_error)
{
	display_error("<br>".TEXT_ERROR_LONG_COMMENT." ".$comment_max_length." ".TEXT_CHARACTER);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td colspan="3" align="center">
						<input type="submit" name="submit" value="<?=TEXT_SUBMIT_P?>" class="button">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?=PICTURE_CONFIRM_TEXT?>
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
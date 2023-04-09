<?include(DIR_LNG.'creat_postcard_form.php');?>

<tr>
	<td>
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="90%">
		<tr>
			<td align="center" colspan="3" background="images/head_bg.jpg">
				<b><?=TEXT_SEND_POSTCARD?></b>
			</td>
		</tr>
		<tr>
			<td bgcolor="<?=SEND_POSTCARD_BORDER_COLOR?>">
				<form method=post action="<?=$this_file_name?>">
				<table align="center" border="0" cellspacing="4" cellpadding="0" width="100%" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" >

				<tr>
					<td align="center" colspan="3"><br>
						<img src="<?=HTTP_INCOMING?><?=$picture_result['big_img_name']?>" border="0" alt=""><br><br>
					</td>
				</tr>
				<tr valign="top">
					<td width="40%">
						<?=TEXT_TITLE?> 
					</td>
					<td>
						<input type="text" name="title" value="<?=$HTTP_POST_VARS['title']?>" class="">
						<input type="hidden" name="postcard_message" value="1">
						<input type="hidden" name="img_id" value="<?=$img_id?>">
<?
if ($title_error)
{
	display_error("<br>".TEXT_ERROR_TITLE);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<?=TEXT_MESSAGE?><br>
						<?=TEXT_MAX_CHAR_MESSAGE?>
					</td>
					<td>
						<textarea name="message" rows="10" cols="30"><?=htmlspecialchars($HTTP_POST_VARS['message'])?></textarea>
<?
if ($message_error)
{
	display_error("<br>".TEXT_ERROR_MESSAGE);
}
?>

					</td>
				</tr>
				<tr valign="top">
					<td>
						<?=TEXT_YOUR_NAME?>
					</td>
					<td>
						<input type="text" name="sender_name" value="<?=$HTTP_POST_VARS['sender_name']?>" class="">
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
						<?=TEXT_YOUR_EMAIL?>
					</td>
					<td>
						<input type="text" name="sender_email" value="<?=$HTTP_POST_VARS['sender_email']?>" class="">
<?
if ($sender_email_error)
{
	display_error("<br>".TEXT_ERROR_YOUR_EMAIL);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<?=TEXT_HIM_NAME?>
					</td>
					<td>
						<input type="text" name="sender_to_name" value="<?=$HTTP_POST_VARS['sender_to_name']?>" class="">
<?
if ($sender_to_name_error)
{
	display_error("<br>".TEXT_ERROR_HIM_NAME);
}
?>
					</td>
				</tr>
				<tr valign="top">
					<td>
						<?=TEXT_HIM_EMAIL?>
					</td>
					<td>
						<input type="text" name="sender_to_email" value="<?=$HTTP_POST_VARS['sender_to_email']?>" class="">
<?
if ($sender_to_email_error)
{
	display_error("<br>".TEXT_ERROR_HIM_EMAIL);
}
?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<br><input type="submit" name="submit" value="<?=TEXT_SUBMIT_P?>" class="button">
					</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		&nbsp;
	</td>
</tr>
<?include(DIR_LNG.'joke_to_friend_form.php');?>
<tr>
	<td>
	<form method=post action="<?=$this_file_name?>?joke_id=<?=$HTTP_GET_VARS['joke_id']?>&cat_id=<?=$HTTP_GET_VARS['cat_id']?>&jtype=<?=$HTTP_GET_VARS['jtype']?>">
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="200">
		<tr>
			<td align="center" style="color:#F7FFE1;font-size:10pt;" background="images/head_bg.jpg">
				<font color="<?=SEND_TO_FRIEND_FORM_TEXT_COLOR?>"><b><?=TEXT_SEND_TO_YOUR_FRIEND?></b></font>
			</td>
		</tr>
		<tr>
			<td bgcolor="<?=SEND_TO_FRIEND_FORM_HEAD_COLOR?>">
				<table align="center" border="0" cellspacing="0" cellpadding="1" width="500" bgcolor="<?=SEND_TO_FRIEND_FORM_HEAD_COLOR?>">

				<tr bgcolor="<?=SITE_INTERNAL_BGCOLOR?>">
					<td width="100%">

						<table align="center" border="0" cellspacing="0" cellpadding="2" width="100%">
						<tr>
							<td width="20%" style="color:<?=SEND_TO_FRIEND_FORM_TEXT_COLOR?>;font-size:9pt;font-weight:bold">
								<input type="hidden" name="joke_text" value="<?=htmlspecialchars($select_joke_result['joke_text'])?>">
								<input type="hidden" name="joke_title" value="<?=htmlspecialchars($select_joke_result['joke_title'])?>">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=TEXT_YOUR_NAME?> 
							</td>
							<td>
								<input type="text" name="your_name" value="<?if($email_sent != "success") echo $HTTP_POST_VARS['name'];?>" class="" size="15">
							</td>
							<td width="5">&nbsp;</td>
							<td style="color:<?=SEND_TO_FRIEND_FORM_TEXT_COLOR?>;font-size:9pt;font-weight:bold">
								<?=TEXT_FRIEND_NAME?>
							</td>
							<td>
								<input type="text" name="to_name" value="<?if($email_sent != "success") echo $HTTP_POST_VARS['email'];?>" class="" size="20">
							</td>
						</tr>
						<tr>
							<td width="20%" style="color:<?=SEND_TO_FRIEND_FORM_TEXT_COLOR?>;font-size:9pt;font-weight:bold">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=TEXT_YOUR_EMAIL?> 
							</td>
							<td>
								<input type="text" name="your_email" value="<?if($email_sent != "success") echo $HTTP_POST_VARS['name'];?>" class="" size="15">
							</td>
							<td width="5">&nbsp;</td>
							<td style="color:<?=SEND_TO_FRIEND_FORM_TEXT_COLOR?>;font-size:9pt;font-weight:bold">
								<?=TEXT_FRIEND_EMAIL?>
							</td>
							<td>
								<input type="text" name="to_email" value="<?if($email_sent != "success") echo $HTTP_POST_VARS['email'];?>" class="" size="20">
							</td>
						</tr>
						<tr>
							<td colspan="5" align="center">
							<input type="hidden" name="joke2friend_form" value="1">
							<input type="submit" name="submit" value="<?=TEXT_SEND_JOKE?>" class="button"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</form>
	</td>
</tr>
<tr>
	<td>
		&nbsp;
	</td>
</tr>
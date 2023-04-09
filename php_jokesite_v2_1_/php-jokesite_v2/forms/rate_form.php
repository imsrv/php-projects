<?include(DIR_LNG.'rate_form.php');?>
<tr>
	<td>
		&nbsp;
	</td>
</tr>
<tr>
	<td align="center">
		<form method=post action="<?=$this_file_name?>?cat_id=<?=$HTTP_GET_VARS['cat_id']?>&joke_id=<?=$HTTP_GET_VARS['joke_id']?>&jtype=<?=$HTTP_GET_VARS['jtype']?>">
		<table align="center" border="0" cellspacing="0" cellpadding="1" width="200">
		<tr bgcolor="<?=RATE_FORM_HEAD_COLOR?>"><!-- #66CC00 -->
			<td align="center" style="color:#F7FFE1;font-size:9pt;" background="images/head_bg.jpg"><img src="<?=DIR_IMAGES?><?=$select_joke_result['rating_value'] ? "joke".number_format($select_joke_result['rating_value'],0).".gif" : "jokeno.gif"?>" border="0" alt="" align="left"><font color="<?=RATE_FORM_TEXT_COLOR?>"><b><?=TEXT_RATE_THIS_JOKE?> - <?=TEXT_CURRENT_RATING_VALUE?> <?=$select_joke_result['rating_value']?></b></font>
			</td>
		</tr>
		<tr>
			<td bgcolor="<?=RATE_FORM_HEAD_COLOR?>">
					<table align="center" border="0" cellspacing="0" cellpadding="1" width="100%" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>">
					
					<tr>
						<td> 
							<table align="center" border="0" cellspacing="0" cellpadding="2" width="100%">
							<tr align="center">
								<td style="color:#982953;font-size:8pt;">
									&nbsp;<?=TEXT_STUPID?>&nbsp;
								</td>
								<td>
									<input type="radio" name="rating_value" value="1" class="radio">
								</td>
								<td>
									<input type="radio" name="rating_value" value="2" class="radio">
								</td>
								<td>
									<input type="radio" name="rating_value" value="3" class="radio">
								</td>
								<td>
									<input type="radio" name="rating_value" value="4" class="radio">
								</td>
								<td>
									<input type="radio" name="rating_value" value="5" class="radio">
								</td>
								<td style="color:#982953;font-size:8pt;">
									&nbsp;<?=TEXT_GREAT?>&nbsp;&nbsp;&nbsp;
								</td>
								<td rowspan="2">
									<input type="hidden" name="rate_form" value="1">
									<input type="submit" name="submit" value="<?=TEXT_RATE_IT?>" class="button">&nbsp;&nbsp;
								</td>
							</tr>
							<tr align="center">
								<td>
									&nbsp;
								</td>
								<td>
									<img src="<?=DIR_IMAGES?>joke1.gif" border="0" alt="">
								</td>
								<td>
									<img src="<?=DIR_IMAGES?>joke2.gif" border="0" alt="">
								</td>
								<td>
									<img src="<?=DIR_IMAGES?>joke3.gif" border="0" alt="">
								</td>
								<td>
									<img src="<?=DIR_IMAGES?>joke4.gif" border="0" alt="">
								</td>
								<td>
									<img src="<?=DIR_IMAGES?>joke5.gif" border="0" alt="">
								</td>
								<td>
									&nbsp;
								</td>
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
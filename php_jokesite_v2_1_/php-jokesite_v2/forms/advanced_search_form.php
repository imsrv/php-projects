	<tr>
	<td>
		<form method="post" action="<?=$this_file_name?>">
		<input type="hidden" name="x" value="1">
		<table border="0" cellpadding="1" cellspacing="0" align="center" width="90%" bgcolor="<?=ADV_SEARCH_BORDER_COLOR?>">
			<tr><td align="center" class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" background="images/head_bg.jpg"><b><?=TEXT_SEARCH_FORM?></b></td></tr>
			<tr>
				<td>
				<table border="0" cellpadding="4" cellspacing="0" align="center" width="100%" bgcolor="<?=ADV_SEARCH_BG_COLOR?>">
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" align="right"><b><?=TEXT_POSTED_BY?></b></td>
					<td>
						<input type="text" name="posted_by" value="<?echo stripslashes(htmlspecialchars($HTTP_POST_VARS['posted_by']));?>" class="" size="20">
					</td>
				</tr>
				<tr>
					<td class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" align="right"><b><?=TEXT_KEYWORDS?></b></td>
					<td>
						<input type="text" name="search" value="<?echo stripslashes(htmlspecialchars($HTTP_POST_VARS['search']));?>" class="" size="48">
					</td>
				</tr>
				<tr>
					<td class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" align="right"><b><?=TEXT_WITH?></b></td>
					<td>
						<select name="type" size="1">
							<option value="any" <?if($HTTP_POST_VARS['type']=="any"){echo "selected";}?>><?=TEXT_ANY_OF_WORDS?></option>
							<option value="all" <?if($HTTP_POST_VARS['type']=="all"){echo "selected";}?>><?=TEXT_ALL_OF_THE_WORD?></option>
							<option value="phrase" <?if($HTTP_POST_VARS['type']=="phrase"){echo "selected";}?>><?=TEXT_THE_EXACT_PHRASE?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" align="right"><b><?=TEXT_CASE?></b></td>
					<td>
						<select name="case_" size="1">
							<option value="insensitive" <?if($HTTP_POST_VARS['case_']=="insensitive"){echo "selected";}?>><?=TEXT_INSENSITIVE?></option>
							<option value="sensitive"  <?if($HTTP_POST_VARS['case_']=="sensitive"){echo "selected";}?>><?=TEXT_SENSITIVE?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text1" style="color:<?=ADV_SEARCH_TEXT_COLOR?>;" align="right"><b><?=TEXT_RESULTS?></b></td>
					<td>
						<select name="display_nr" size="1">
							<option value="5"  <?if($HTTP_POST_VARS['display_nr']==5){echo "selected";}?>>5 <?=TEXT_RESULT_PER_PAGE?></option>
							<option value="10" <?if($HTTP_POST_VARS['display_nr']==0){echo "selected";}?>>10 <?=TEXT_RESULT_PER_PAGE?></option>
							<option value="20" <?if($HTTP_POST_VARS['display_nr']==20){echo "selected";}?>>20 <?=TEXT_RESULT_PER_PAGE?></option>
							<option value="25" <?if($HTTP_POST_VARS['display_nr']==25){echo "selected";}?>>25 <?=TEXT_RESULT_PER_PAGE?></option>
							<option value="50" <?if($HTTP_POST_VARS['display_nr']==50){echo "selected";}?>>50 <?=TEXT_RESULT_PER_PAGE?></option>
							<option value="100"  <?if($HTTP_POST_VARS['display_nr']==100){echo "selected";}?>>100 <?=TEXT_RESULT_PER_PAGE?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr><input type="hidden" name="adv_search" value="1">
				<tr><td align="center" colspan="2"><input type="submit" name="submit" value="<?=TEXT_SEARCH_A?>" class="button"></td></tr> 
				</table>

				</td>
			</tr>
		</table>
		</form>
	</td>
</tr>

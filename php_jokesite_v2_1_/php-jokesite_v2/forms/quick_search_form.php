<?include(DIR_LNG.'quick_search_form.php');?>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?=QUICK_SEARCH_TABLE_WIDTH?>">
<tr>
	<td>
	<table align="center" border="0" cellspacing="<?=QUICK_SEARCH_CELLSPACING?>" cellpadding="<?=QUICK_SEARCH_CELLPADDING?>" width="100%" height="60" bgcolor="<?=QUICK_SEARCH_BORDERCOLOR?>">

	<tr>
		<td >
			<form method="post" action="quick_search.php" style="margin-top: 0px;margin-bottom: 0px;">
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="<?=QUICK_SEARCH_BGCOLOR?>">
			<tr>
				<td width="100%" align="center" colspan="3">
				<font size="2" face="helvetica, verdana, arial" color="<?=STATS_TEXT_COLOR?>"><img src="<?=HTTP_LANG_IMAGES?>quick_search.gif" border="0"></font><br><img src="<?=DIR_IMAGES?>lines2.gif" border="0"><br><br></td>
			</tr>
			<tr>
				<td align="center">
					<input type="text" name="search" value="" class="input" size="10" style="width:140px" class="input">
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="hidden" name="x" value="1">
					<input type="submit" name="submit" value="<?=TEXT_SEARCH_Q?>" class="button">
				</td>
			</tr>
			<tr>
				<td align="right"><br>
					<a href="<?=HTTP_SERVER?>advanced_search.php"><font color="<?=ADVANCED_SEARCH_TEXT_COLOR?>"><?=TEXT_ADVANCED_SEARCH?></font></a></td>
			</tr>
			</table>
				
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</form>	
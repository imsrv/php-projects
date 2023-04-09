<?include(DIR_LNG.'stats_form.php');
$selectCountJokesSQL = "select * from $bx_db_table_jokes where validate='1' and slng='".$slng."'";
$selectCountJokes_query = bx_db_query($selectCountJokesSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$countJokes = bx_db_num_rows($selectCountJokes_query);
$selectCountPicturesSQL = "select * from $bx_db_table_images where validate='1'";
$selectCountPictures_query = bx_db_query($selectCountPicturesSQL);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$countPictures = bx_db_num_rows($selectCountPictures_query);
?>
<table align="center" border="0" cellspacing="<?=STATS_CELLSPACING?>" cellpadding="<?=STATS_CELLPADDING?>"  width="<?=STATS_TABLE_WIDTH?>" bgcolor="<?=STATS_BORDERCOLOR?>">
<tr>
	<td >
	<table align="center" border="0"  cellspacing="0" cellpadding="0" width="100%" bgcolor="<?=STATS_BGCOLOR?>">
	<tr>
		<td width="100%" align="center" colspan="3"><img src="<?=HTTP_LANG_IMAGES?>our_database.gif" border="0"></td>
	</tr>
	<tr>
		<td width="100%" align="center" colspan="3"><img src="<?=DIR_IMAGES?>lines2.gif" border="0"></td>
	</tr>
	<tr>
		<td align="left" width="55%">&nbsp;&nbsp;<font size="2" face=" verdana,helvetica, arial" color="<?=STATS_TEXT_COLOR?>"><b><?=STATS_TEXT_JOKES?></b></font></td><td>&nbsp;</td><td width="35%"><?=$countJokes?></td>
	</tr>
	<tr>
		<td align="left">&nbsp;&nbsp;<font size="2" face=" verdana,helvetica, arial" color="<?=STATS_TEXT_COLOR?>"><b><?=STATS_TEXT_PICTURES?></b></font></td><td>&nbsp;</td><td><?=$countPictures?></td>
	</tr>
	</table>
	</td>
</tr>
</table>

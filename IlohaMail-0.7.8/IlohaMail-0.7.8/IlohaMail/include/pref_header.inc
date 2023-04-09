<?
/********************************************************

	FILE: include/pref_header.inc
	PURPOSE:
		Show header in "source/prefs.php" and "source/pref_colors.php"
		
********************************************************/
?>
<table border="0" cellspacing="0" cellpadding="0">
<tr><td><H2><?=$prefHeaderStrings[0]?></H2></td></tr>
<tr><td>
    [<a href="prefs.php?user=<? echo $sid; ?>"><?=$prefHeaderStrings[1]?></a>]
    [<a href="pref_colors.php?user=<? echo $sid; ?>"><?=$prefHeaderStrings[2]?></a>]
</td></tr>
</table>
<?
/***************************************************************************
 *                         AutoHits  PRO                                   *
 *                      -------------------                                *
 *   Version         : 1.0                                                 *
 *   Released        : 02.20.2003                                          *
 *   copyright       : (C) 2003 SupaTools.com                              *
 *   email           : info@supatools.com                                  *
 *   website         : www.supatools.com                                   *
 *   custom work     :http://www.gofreelancers.com                         *
 *   support         :http://support.supatools.com                         *
 *                                                                         *
 ***************************************************************************/
require('error_inc.php');
require('config_inc.php');
require('header_inc.php');

if($pri=='Set new prices'){
	$f=fopen('prices.inc.php','w');
	fputs($f,"<?\n");
	fputs($f,"\$p1='$p1';\n");
	fputs($f,"\$p2='$p2';\n");
	fputs($f,"\$p3='$p3';\n");
	fputs($f,"\$p4='$p4';\n");
	fputs($f,"\$p5='$p5';\n");
	fputs($f,"\$c1='$c1';\n");
	fputs($f,"\$c2='$c2';\n");
	fputs($f,"\$c3='$c3';\n");
	fputs($f,"\$c4='$c4';\n");
	fputs($f,"\$c5='$c5';\n");
	fputs($f,"?>");
	fclose($f);
	print "<p class=red>New prices has been set.</p>";
}
if($delay=="Set new values"){
	if(is_numeric($delay_t)){
		if($delay_t < 1) $delay_t = 1;
		if($delay_t > 60) $delay_t = 60;
		if($autoplay_t == "on") $autoplay_t=1;
		else $autoplay_t = 0;
		
		$f=fopen('timer.inc.php','w');
		fputs($f,"<?\n");
		fputs($f,"\$delay_t='$delay_t';\n");
		fputs($f,"\$autoplay_t=$autoplay_t; // set to 1 for autoplay, 0 for pause\n");
		fputs($f,"?>");
		fclose($f);
		print "<p class=red>New delay has been set.</p>";
	}else print "<p class=red>Error! Enter numeric ( 1 < x < 60 ) value.</p>";
}

include('prices.inc.php');
include('timer.inc.php');
?>
<table>
<form action="" method=post>
<tr>
	<td>
		<p><b>Editing prices:</b></p>
		<table><tr align=center bgcolor=#AAAAAA><td><b>Credits</td><td><b>Price</td></tr>
		<tr><td><input type=text size=10 name='c1' value='<? print $c1; ?>'></td><td><input type=text size=10 name='p1' value='<? print $p1; ?>'></td></tr>
		<tr><td><input type=text size=10 name='c2' value='<? print $c2; ?>'></td><td><input type=text size=10 name='p2' value='<? print $p2; ?>'></td></tr>
		<tr><td><input type=text size=10 name='c3' value='<? print $c3; ?>'></td><td><input type=text size=10 name='p3' value='<? print $p3; ?>'></td></tr>
		<tr><td><input type=text size=10 name='c4' value='<? print $c4; ?>'></td><td><input type=text size=10 name='p4' value='<? print $p4; ?>'></td></tr>
		<tr><td><input type=text size=10 name='c5' value='<? print $c5; ?>'></td><td><input type=text size=10 name='p5' value='<? print $p5; ?>'></td></tr>
		<tr><td colspan=2 align=center><input type=submit name=pri value='Set new prices'></td></tr>
		</table>
	</td>
	<td width="50">&nbsp;</td>
	<td valign="top">
		<p><b>Editing AutoHits refresh time:</b></p>
		<table border="0">
			<tr align=center bgcolor=#AAAAAA>
				<td colspan="2"><b>Refresh timer settings</b></td>
			</tr>
			<tr valign="middle">
				<td align="right" valign="middle">Enter autorefresh time in sec</td>
				<td align="left" valign="middle"><input type=text size=10 name='delay_t' value='<?=$delay_t?>'></td>
			</tr>
			<tr valign="middle">
				<td align="right" valign="middle">Auto start refresh</td>
				<td align="left" valign="middle"><input type="Checkbox" name='autoplay_t' <?if($autoplay_t==1) echo "checked";?>></td>
			</tr>
			<tr valign="middle">
				<td colspan="2" align="right" valign="middle"><input type=submit name=delay value='Set new values'></td>
			</tr>
		</table>
	</td>
</tr>
</form>
</table>
<?
include('footer_inc.php');
?>


<?
/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/
require('error_inc.php');
require('config_inc.php');
require('header_inc.php');

if($pri=='Set new prices'){
	$f=fopen('prices1.inc.php','w');
	fputs($f,"<?\n");
	fputs($f,"\$p1='$p1';\n");
	fputs($f,"\$p2='$p2';\n");
	fputs($f,"?>");
	fclose($f);
	print "<p class=red>New prices have been set.</p>";
	}

include('prices1.inc.php');
?>
<p><b>Editing Membership Prices:</b></p>
<form action="" method=post>
<table><tr align=center bgcolor=#AAAAAA><td><b>Type</td><td><b>Price</td></tr>
<tr><td>Silver</td><td><input type=text size=10 name='p1' value='<? print $p1; ?>'></td></tr>
<tr><td>Gold</td><td><input type=text size=10 name='p2' value='<? print $p2; ?>'></td></tr>
<tr><td colspan=2 align=center><input type=submit name=pri value='Set new prices'></td></tr>
</table>
</form>
<?
include('footer_inc.php');
?>


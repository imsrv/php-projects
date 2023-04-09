<?
include "config.php";
include "header.php";
?>
<form action=forgot.php method=post>
<Table Align="center" Border="1" CellPadding="3" CellSpacing="0">
<tr>
	<td BgColor="#5588aa">
	<font color="white" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $f_r;?>:</font>
	</td>
</tr>
<tr>
	<td>
	<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><? echo $e_si?></font><BR>
	<input type=text name=sid><BR>
	<input type=hidden name=a value=forgot><BR>
	<input type=submit name=submit><BR>
	</td>
</tr>
</table>
</form>
<?
if ($a == "forgot" AND $REQUEST_METHOD == "POST") {
	$query = mysql_db_query ($dbname,"Select password,email from top_user Where sid=$sid",$db) or die (mysql_error());
	$num_rows = @mysql_num_rows($query);
	if ($num_rows < 1) { echo "<center><font color=\"red\" face=\"$font_face\" size=\"$font_size\">$f_n</font></center>";}
	if ($num_rows > 0) { 
		$rows = mysql_fetch_array($query);
		$msg = " $e_si: $sid\n $i_password : $rows[password]";
		mail($rows[email],"Password from $top_name",$msg,"From: $admin_email\nReply-To: $admin_email");
		echo "<center><font color=\"red\" face=\"$font_face\" size=\"$font_size\">$f_m</font></center>";
	}
}
include "footer.php";
?>
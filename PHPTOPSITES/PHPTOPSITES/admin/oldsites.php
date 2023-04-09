<?
set_time_limit(0);

include "../config.php";
include "header.php";

$ctime = date ("Ymd");
$otime = date ("Ym");
$otime --;
$otime.=date ("d");

$query = mysql_db_query ($dbname,"select sid,title,email from top_user",$db) or die (mysql_error());

?>
<table align=center border=1 cellpadding=3 cellspacing=0>
<tr>
	<td align=center bgcolor="#5087AF" colspan=3>
	<B><font face=verdana size=2 color="white">Sites without hits in last 30 days</font></B>
	</td>
</tr>
<tr>
	<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Site ID:</font></B></td>
	<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Site Title:</font></B></td>
	<td align=center bgcolor="#5087AF"><B><font face=verdana size=2 color="white">Action:</font></B></td>
</tr>

<?
while ($rows = mysql_fetch_array($query)) {
	$tquery = mysql_db_query ($dbname,"select sid,cdate from top_hits where sid=$rows[sid] and cdate between $otime and $ctime limit 1",$db) or die (mysql_error());
	$trows = mysql_fetch_array($tquery);
	if (!$trows) {
		echo "<tr><td><font size=1>$rows[sid]</font></td><td><font size=1>$rows[title]</font></td><td><font size=1><a href=\"seditor.php?sid=$rows[sid]&a=edit\">Edit</a> | <a href=\"seditor.php?sid=$rows[sid]&a=delete\">Delete</a></font></td></tr>";

		if ($a == "send_notice" AND $submit AND $notice) {
			@mail($rows[email],"Notification from $top_name",$notice,"From: $admin_email\nReply-To: $admin_email");
		}
	}
}
?>
<?
if (!$a and !$submit) {
	?>
	<tr>
		<td colspan=3 align=center>
		<B><font face=verdana size=2 color="black">Send notice to all inactive sites.</font></B>
		<form action="oldsites.php" method="post">
		<textarea rows=10 cols=40 name=notice></textarea><BR>
		<input type=submit name=submit>
		<input type=hidden name=a value="send_notice">
		</form>
		</td>
	</tr>
	<?
}
?>
</table>
<?
include "footer.php";
?>

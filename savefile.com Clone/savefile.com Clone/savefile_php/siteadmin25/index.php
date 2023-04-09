<?
	chdir("..");
	include("include/common.php");
	include("siteadmin25/accesscontrol.php");
	include("siteadmin25/header.php");
?>
<p><font face=arial size=3>
	<?
		list($users25) = mysql_fetch_row( mysql_query("SELECT COUNT(*) FROM users25") );
		list($images25) = mysql_fetch_row( mysql_query("SELECT COUNT(*) FROM images25") );
		list($aimages25) = mysql_fetch_row( mysql_query("SELECT COUNT(*) FROM images25 WHERE user='0'") );
		list($uimages25) = mysql_fetch_row( mysql_query("SELECT COUNT(*) FROM images25 WHERE user!='0'") );
	?>
	<b>Welcome!!!... From this admin25istration panel you will have full control of your site.</B> 
</p><br>
	<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR="#C0C0C0" STYLE="border-collapse: collapse">
	<TR>
		<TD class='a1'><font face=arial size=3>Total Number of Users:</TD>
		<TD class='a1'><font face=arial size=3><?=$users25?></TD>
	</tr>
	<TR>
		<TD class='a1'><font face=arial size=3>Total Number of Uploads:</TD>
		<TD class='a1'><font face=arial size=3><?=$images25?></TD>
	</tr>
	<TR>
		<TD class='a1'><font face=arial size=3>Total Number of Anonymous Uploads:</TD>
		<TD class='a1'><font face=arial size=3><?=$aimages25?></TD>
	</tr>
	<TR>
		<TD class='a1'><font face=arial size=3>Total Number of Uploads from Users:</TD>
		<TD class='a1'><font face=arial size=3><?=$uimages25?></TD>
	</tr>
	</table>
	<br><br><br>
</p>
<?
	include("siteadmin25/footer.php");
?>
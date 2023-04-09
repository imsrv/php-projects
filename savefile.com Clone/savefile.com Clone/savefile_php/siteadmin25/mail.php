<?
	chdir("..");
	include("include/common.php");
	include("siteadmin25/accesscontrol.php");
	include("siteadmin25/header.php");
	if($_POST['subject'] && $_POST['message']){
		$sql = "SELECT * FROM users25";
		$result = mysql_query($sql) or die( mysql_error() );
		if ($result){
			while( $row = mysql_fetch_object($result) ){
				mail(
					$row->name." <".$row->email.">", 
					$_POST['subject'], 
					$_POST['message'], 
					"From: $sitename <$admin25email>\nReturn-Path: $admin25email\n");
			}
		}
		echo "<font color=red>Message Sent</font><br>";
	}
?>
	<form method="POST">

	<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR="#C0C0C0" STYLE="border-collapse: collapse">
	<TR>
		<TD class='a1'><strong>Subject</font></strong></td>
		<TD class='a1'><INPUT maxLength=200 size=25 name=subject>
	</tr>
	<TR>
		<TD class='a1'><strong>Message</font></strong></td>
		<TD class='a1'><TEXTAREA name=message rows=7 cols=30></TEXTAREA></TD>
	</tr>
	<tr>
		<td colspan="3">
			<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
				<input type="submit" alt="submit" width="66" height="20" hspace="5" vspace="5" border="0">
			</font></div>
		</td>
	</tr>
	</table>
	</form>
<?
	include("siteadmin25/footer.php");
?>
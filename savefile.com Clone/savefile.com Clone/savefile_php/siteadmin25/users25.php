<?
	chdir("..");
	include("include/common.php");
	include("siteadmin25/accesscontrol.php");
	include("siteadmin25/header.php");

	if (!$step){$step = 1;}
	switch($step){
		case "4":													// delete users25
			$sql = "DELETE FROM users25 WHERE uid=$uid";
			$qr1 = mysql_query($sql);
			break;
		case "9":													// delete users25
			mysql_query("UPDATE users25 SET status='$stat' WHERE uid=$uid");
			break;
		default:													// user index
			break;
	}
?>
<TABLE class=design bgColor=#ffffff cellPadding=3 cellSpacing=0 width=100% border='1' BORDERCOLOR="#C0C0C0" STYLE="border-collapse: collapse">
<TR>
	<TD class='a1' align=center><strong>user name</font></strong></td>
	<TD class='a1' align=center><strong>email</font></strong></td>
	<TD class='a1' align=center><strong>action</font></strong></td>
</tr>
<?
	$sql = "SELECT * FROM users25";
	$result = mysql_query($sql) or die( mysql_error() );
	if ($result){
		while( $row = mysql_fetch_object($result) ){
			if($row->status == 1){
				$nst=0;
				$status = "DeActivate";
			}else{
				$nst=1;
				$status = "Activate";
			}
?>
			<tr>
				<TD class='a1'><?=$row->username?></font></td>
				<TD class='a1'><?=$row->email?></font></td>
				<TD class='a1'>
						<a href="<?=$PHP_SELF?>?a=<?=$a?>&step=9&stat=<?=$nst?>&uid=<?=$row->uid?>"><font color=black><?=$status?></a> | 
						<a onclick="return confirm('are you sure you wish to delete this user?');" href="<?=$PHP_SELF?>?a=<?=$a?>&step=4&uid=<?=$row->uid?>"><font color=black>remove</a>
					</font>
				</td>
			</tr>
<?
		}
	}
?>
</table>
<br><br>
<?
	include("siteadmin25/footer.php");
?>
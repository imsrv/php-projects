<?
	include("include/common.php");

	if(!$loggedin){
		ob_start();
		header("Location: login.php");
	}
	include("include/header.php");
	include("include/accmenu.php");

	if($submit){
?>
		<h3>Delete Your Account</h3>
		<?=$table2?>
<?
		mysql_query("delete from users25 where uid='$myuid'");
		mysql_query("delete from bio where user='$myuid'");
		mysql_query("delete from portfolio where user='$myuid'");
?>
		<tr align=center><td>PooF!<p>Account Deleted!
		</table><p>
<?
	}else{
?>	
		<h3>Delete Your Account</h3>
		<?=$table2?><form method="post">
<?
		$this->g=mysql_query("select last_paid from users25 where uid='$myuid'");
		$this->h=mysql_fetch_object($this->g);
		if ($this->h->last_paid != "free") {
?>
			<tr align=center>
				<td>
					In order to delete your paid account, simply log into your PayPal account and 
					cancel your subscription to "<?=$paypal_item?>". 
<?
		}
		if ($this->h->last_paid == "free") {
?>
			<tr align=center>
				<td>
					Are you sure you want to delete your account? It's Forever!
					<p><input type=submit name=submit value='YES'>
<?
		}
?>
		</table>
<?
	}
	include("include/footer.php");
?>
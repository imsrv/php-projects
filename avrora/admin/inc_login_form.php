	<table width="300" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#000000">
		<tr>
			<td>
				<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF">
					<form action="index.php" method="post">
					<tr><td colspan="2" align="center" bgcolor="#0000FF"><font class="titleTextWhite"><?php print $lang['Access data']?></font></td></tr>
					<tr>
						<td><font class="name"><?php print $lang['login']?>: </font></td>
						<td><input type="text" name="_login" value="" class="input"></td>
					</tr>
					<tr>
						<td><font class="name"><?php print $lang['password']?>: </font></td>
						<td><input type="password" name="_pass" class="input"></td>
					</tr>
					<tr><td colspan="2"><input type="submit" name="cmd_login" value="<?php print $lang['join']?>" class="button"></td></tr>
					</form>
				</table>
			</td>
		</tr>
	</table>

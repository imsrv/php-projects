<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template login_dologin -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Login</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
		<font face="Arial" size="2">
			Fill in your username and password to login<br /><br />
			<form action="login.php" method="post">
				Username: <input name="lusername" size="32">	
				Password: <input type="password" name="lpassword" size="32"><br />
				<input type="submit" value="Submit">
			</form>
			Login issues? <a href="logout.php">Click here</a> to reset your cookies
		</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>
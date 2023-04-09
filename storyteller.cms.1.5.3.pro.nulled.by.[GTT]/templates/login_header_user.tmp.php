<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template login_header_user -->

			<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
			<tr>
			<td>
			<table cellspacing="1" cellpadding="3" width="100%" border="0">
				<tr>
				<td bgcolor="#008000">
					<font face="Arial" size="1" color="#FFFFFF">
						<b>Welcome back, $insert[login_name]!</b>
					</font>
				</td>
				</tr>
				<tr>
				<td bgcolor="#ccffcc">
					<font face="Arial" size="1">
						Click <a href="logout.php">here</a> to logout.
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
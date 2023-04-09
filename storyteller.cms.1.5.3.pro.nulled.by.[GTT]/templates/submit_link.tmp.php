<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template submit_link -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Submit Link</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form action="submitlink.php" method="post">
			<table>
			<tr>
			<td>
				<font face="Arial" size="2">
				Your name:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="author" size="32">
			</td>
			</tr>
			<tr>
			<td>
				<font face="Arial" size="2">
				Your email:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="email" size="32">
			</td>
			</tr>			
			<tr>
			<td>
				<font face="Arial" size="2">
				Link title:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="subject" size="32">
			</td>
			</tr>
			<tr>
			<td>
				<font face="Arial" size="2">
				Link URL:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="text" size="32">
			</td>
			</tr>			
			
			<tr>
			<td> 
			</td>
			<td>
			</td>
			<td>
				<input type="submit" value="Submit">
			</td>
			</tr>
			</form>
		</table>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>
<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template download_brokenlink -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Report broken link</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form action="brokenlink.php" method="post">
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
				<input name="name" size="32">
			</td>
			</tr>
			<tr>
			<td>
				<font face="Arial" size="2">
				File:
				</font>
			</td>
			<td>
			</td>
			<td>
			        <input name="title" size=32" value="$insert[broken_file]">				
			</td>
			</tr>
			<tr>
			<td valign="top">
				<font face="Arial" size="2">
				Comments:
				</font>
			</td>
			<td>
			</td>
			<td>
				<textarea cols="38" name="comments" rows="6"></textarea>
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
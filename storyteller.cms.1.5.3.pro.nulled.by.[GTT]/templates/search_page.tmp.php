<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_page -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Search</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form action="search.php" method="post">
				<font face="Arial" size="2">
					Search <input name="query" size="32"> in <select size="1" name="where">
					<option value="1">News</option>
					<option value="2">Reviews</option>
					<option value="3">FAQ</option>
					<option value="4">Files</option>
					<option value="5">Pages</option>
					</select>
				</font>
			<input type="submit" value="Submit">
			</form>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>
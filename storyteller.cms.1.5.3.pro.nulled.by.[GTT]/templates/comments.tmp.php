<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template comments -->
<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">

	<tr>
		<td bgcolor="#008000">
		<a href="comments.php?action=delete&id=$insert[comment_id]">
		<img src="images/delete.png" alt="Delete Message" border="0" align="right" /></a>
		<a href="comments.php?action=edit&id=$insert[comment_id]">
		<img src="images/edit.png" alt="Edit Message" border="0" align="right" /></a>
		<a href="comments.php?action=quote&id=$insert[comment_id]">
		<img src="images/quote.png" alt="Quote Message" border="0" align="right" /></a>				
		<font face="Arial" color="#ffffff" size="2">
				<b>$insert[comment_author]</b>
		</font>
		</td>
	</tr>
	<tr>
		<td bgcolor="#ccffcc">
		<font face="Arial" size="1">
			<img src="images/icons/$insert[comment_iconimage]" border="0" align="left" />&nbsp;#$insert[comment_result] Posted on: $insert[comment_time]
		</font>
	</td>
	</tr>
	<tr>
		<td bgcolor="#ffffff">
		<font face="Arial" size="2">
		 $insert[comment_text]<br />
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
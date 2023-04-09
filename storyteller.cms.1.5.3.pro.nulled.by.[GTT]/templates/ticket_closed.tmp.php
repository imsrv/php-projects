<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template ticket_closed -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Ticket - $insert[ticket_title] (Closed)</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				$insert[ticket_text]
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
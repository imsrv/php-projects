<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template ticket_send -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Trouble Ticket - Done</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
		<font face="Arial" size="2">
			Thanks. Your tracking code is $insert[ticket_tracking].<br /><br />
			You can view your ticket <a href="ticket.php?tracking=$insert[ticket_tracking]">here</a>.
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
<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template ticket_edit -->

<form action="ticket.php" method="post">

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000" colspan="2">
			<font face="Arial" color="#ffffff" size="2">
				<b>Ticket - $insert[ticket_title] (Priority: $insert[ticket_priority])</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff" colspan="2">
			<font face="Arial" size="2">
				$insert[ticket_text]
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Add to ticket:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<textarea cols="38" name="message" rows="6"></textarea>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
		<input type="hidden" name="tupdate" value="$insert[ticket_pass]">
		</td>
		<td bgcolor="#ffffff">
			<input type="submit" value="Submit">
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>
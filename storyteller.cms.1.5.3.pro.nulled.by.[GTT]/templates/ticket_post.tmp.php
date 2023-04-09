<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template ticket_post -->

<form action="ticket.php" method="post">

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Open New Ticket</b>
			</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Subject:</b>
			</font>
		</td>
  		<td bgcolor="#ffffff">
			<input name="subject" size="32" value="$insert[ticket_title]">
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Category:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			$insert[ticket_categories]
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Message:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<textarea cols="38" name="message" rows="6"></textarea>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				<b>Priority Level:</b>
			</font>
		</td>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
			      <input type="radio" name="priority" value="1" /> 1
			      <input type="radio" name="priority" value="2" /> 2
			      <input type="radio" name="priority" value="3" checked="checked" /> 3
			      <input type="radio" name="priority" value="4" /> 4
			      <input type="radio" name="priority" value="5" /> 5
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
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
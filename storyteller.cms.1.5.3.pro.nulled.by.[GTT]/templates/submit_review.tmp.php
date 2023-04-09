<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template submit_review -->

<script language="JavaScript">
<!--
function AutoInsert1(tag) {
document.review.text.value =
document.review.text.value + tag;
}
// -->
</script>

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Submit Review</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form name="review" action="submitreview.php" method="post">
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
				Review title:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="subject" size="50">
			</td>
			</tr>
			<tr>
			<td valign="top">
				<font face="Arial" size="2">
				Review text:
				</font>
			</td>
			<td>
			</td>
			<td>
				<textarea cols="58" name="text" rows="20"></textarea><br />
				<center><a href="javascript:AutoInsert1('[NEWPAGE]')">New page</a></center>
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
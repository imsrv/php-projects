<?php
global $insert;

// Teaser image?
if ($insert[story_teaser]) $teaserline = "<img src=\"images/teaser/$insert[story_teaser]\" border=\"0\" align=\"right\" hspace=\"10\" vspace=\"10\">";

$EST_TEMPLATE = <<<TEMPLATE

<!-- Template story -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>$insert[story_title]</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ccffcc">
			<font face="Arial" size="1">
				Posted by $insert[story_author] on: $insert[story_time]<br />
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
		 $teaserline
			<font face="Arial" size="2">
				$insert[story_text]<br /><br />
				$insert[story_extendedtext]
			</font>
		</td>
		</tr>
		<tr>
		<td align="right" bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				News Source: $insert[story_source]
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
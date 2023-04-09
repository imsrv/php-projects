<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template download_get -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>$insert[download_title]</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
		<font face="Arial" size="2">
			$insert[download_text]<br /><br />
			$insert[download_extendedtext]<br /><br />
			Your download will automatically start in 5 seconds. If it doesn't, you can click <a href="$insert[download_location]">HERE</a> to start the download manually.<br /><br />
			<b>Webmasters:</b> Please link to the previous page. Thanks!
		</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

<SCRIPT LANGUAGE="JavaScript">
<!-- 
setTimeout('location.href="$insert[download_location]"',5000);
-->
</SCRIPT>

TEMPLATE;
?>
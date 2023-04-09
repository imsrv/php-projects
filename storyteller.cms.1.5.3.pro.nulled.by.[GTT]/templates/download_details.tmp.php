<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template download_details -->

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
		<td bgcolor="#ccffcc">
			<font face="Arial" size="1">
				Category: $insert[downloadscat_name] - $insert[download_count] downloads<br />
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				$insert[download_text]<br /><br />
				$insert[download_extendedtext]<br /><br />
				Download: $insert[download_url1] $insert[download_url2] $insert[download_url3] $insert[download_url4] $insert[download_url5] $insert[download_url6] $insert[download_url7] $insert[download_url8]<br /><br />
				<a href="brokenlink.php?file=$insert[download_id]">Report a bad link</a>
			</font>		
		</td>
		</tr>
		<tr>
		<td bgcolor="#008000" align="right">
			<font face="Arial" color="#ffffff" size="2">
				<b>Rating: $insert[download_rating] ($insert[download_votes] Votes)</b>
			</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<form action="download.php" method="post">
	<p align="right">
		<font face="Arial" color="#ffffff" size="2">
			<b>Rate this download: </b>
		</font>
		<select size="1" name="vote">
			<option value="1">1 ... Bad</option>
			<option value="2">2 ... Not the best</option>
			<option selected value="3">3 ... Average</option>
			<option value="4">4 ... Good</option>
			<option value="5">5 ... Awesome</option>
		</select>
	<input type="hidden" name="vfile" value="$insert[download_id]">
	<input type="submit" value="Vote">
	</p>
</form>
<br />

TEMPLATE;
?>
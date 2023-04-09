<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template submit_download -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>Submit Download</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form action="submitdownload.php" method="post">
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
				Program title:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="subject" size="32">
			</td>
			</tr>
			<tr>
			<td valign="top">
				<font face="Arial" size="2">
				Description:
				</font>
			</td>
			<td>
			</td>
			<td>
				<textarea cols="38" name="story" rows="6"></textarea>
			</td>
			</tr>
			<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #1:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url1" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #2:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url2" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #3:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url3" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #4:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url4" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #5:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url5" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #6:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url6" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #7:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url7" size="32">
			</td>
			</tr>			
		<tr>
			<td>
				<font face="Arial" size="2">
				Download URL #8:
				</font>
			</td>
			<td>
			</td>
			<td>
				<input name="url8" size="32">
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
<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template comments_nav -->

			<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
			<tr>
			<td>
			<table cellspacing="1" cellpadding="3" width="100%" border="0">
				<tr>
				<td bgcolor="#ccffcc" width="50%" align="left">
					<font face="Arial" size="2">
						$insert[comment_prevpage]
					</font>
				</td>
				<td bgcolor="#ccffcc" width="50%" align="right">
					<font face="Arial" size="2">
						$insert[comment_nextpage]
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
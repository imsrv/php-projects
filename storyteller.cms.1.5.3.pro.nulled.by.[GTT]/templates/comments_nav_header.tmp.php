<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template comments_nav_header -->

			<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
			<tr>
			<td>
			<table cellspacing="1" cellpadding="3" width="100%" border="0">
				<tr>
				<td bgcolor="#ccffcc">
					<font face="Arial" size="2">
						<b>$insert[comment_entries] comment(s) $insert[comment_pages] page(s)</b>
					</font>
				</td>
				<td bgcolor="#ccffcc" align="right">
					<font face="Arial" size="2">

TEMPLATE;
?>
<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template poll_header -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>$insert[poll_title]</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				$insert[poll_text]<br /><br />
				<form action="poll.php" method="post">
				
            <table border="0" cellpadding="4" cellspacing="0" width="100%">				

TEMPLATE;
?>
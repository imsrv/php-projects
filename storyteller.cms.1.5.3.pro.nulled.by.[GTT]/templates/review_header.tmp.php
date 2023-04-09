<?php
global $insert;

// Review author / page subject?
if($insert[review_author]) $insert[review_author] = "by ".$insert[review_author];
if($insert[review_pagesub]) $insert[review_pagesub] = "<b>$insert[review_pagesub]</b><br /><br />";

$EST_TEMPLATE = <<<TEMPLATE

<!-- Template review_header -->

<table cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#000000" border="0">
	<tr>
	<td>
	<table cellspacing="1" cellpadding="3" width="100%" border="0">
		<tr>
		<td bgcolor="#008000">
			<font face="Arial" color="#ffffff" size="2">
				<b>$insert[review_title] - Page $insert[review_page]/$insert[review_allpages]</b>
			</font>
		</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff">
			<font face="Arial" size="2">
				Created on $insert[review_date] $insert[review_author] [<a href="printer.php?action=review&id=$insert[review_id]&page=$insert[review_page]">Print</a>]<br /><br />
				$insert[review_pagesub]

TEMPLATE;
?>
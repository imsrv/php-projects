<?php

	include("global.inc");

	Header("Content-type: image/$subtype");

	$data = imap_fetchbody($mailbox, $msgnum, $part_no);

	echo imap_base64($data);
?>

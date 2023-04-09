<?php

	include("global.inc");

	header("Content-type: $type/$subtype");
	header("Content-Disposition: attachment; filename=$name");

	if($encoding == "base64")
	{
		echo imap_base64(imap_fetchbody($mailbox, $msgnum, $part_no));
	}
	else
	{
		echo imap_fetchbody($mailbox, $msgnum, $part_no);
	}
	
?>

<?php	
	include("global.inc");

	echo "<title>Viewing Headers</title>\n<pre>";
	echo htmlentities(imap_fetchbody($mailbox, $msgnum, 0)) . "\n</pre>";
?>
<?php

include("global.inc");

$tofolder = $tofolder == "INBOX" ? "INBOX" : construct_folder_str($tofolder);

if ($what == "move")
{
		$msgs = $msglist ? implode($msglist, ",") : $msglist;
		if(!imap_mail_move($mailbox, $msgs, $tofolder))
		{
			echo "summin went rong<br>";
		}
}

if ($what == "delall")
{
		for($i = 0; $i < count($msglist); $i++)
		{
			imap_delete($mailbox, $msglist[$i]);
		}
}

if ($what == "delete")
{
		imap_delete($mailbox, $msgnum);
}

imap_expunge($mailbox);
imap_close($mailbox);

header("Location: index.php?folder=" . urlencode($folder));  

?>



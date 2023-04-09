<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// MBOX actions, del message, move messages, etc
// -----------------------------------------------------------------------

// --
if($curmbox == "") exit();
$mbox = decode_strip($curmbox);
$pagehdr_msg = imap_utf7_decode($mbox);
// --

// --
// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

// connect to the imap server
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");
// --

// --
if(empty($msgID)) { // no messages selected, so push the mbox listing again with an error message
    $err_msg = $lng->p(221);
    push_mboxlist();
}

// --
// Move the messages, but no folder selected   
if(!$toMbox && $moveSelected != "") { // no folder selected
    $err_msg = $lng->p(220);
    push_mboxlist();
    my_exit();
}

// --
// Ok now perform the desired action
$from_mbox_upper = strtoupper($mbox);
$to_mbox_upper = strtoupper($toMbox);
if($from_mbox_upper != "INBOX") $mbox_from = $BSX_MDIR . $mbox;
else $mbox_from = "Inbox";
if($to_mbox_upper != "INBOX") $mbox_to = $BSX_MDIR . imap_utf7_encode(decode_strip($toMbox));
else $mbox_to = "Inbox";
if($delSelected && $user_set["movetrash"]) $mbox_to = $BSX_MDIR . $BSX_TRASH_NAME;

// Reopen the source mbox
$imap->reopbox($mbox_from);

// Del/purge/move the messages one by one
$act_i = 1;
while(list($indx, $msgUID) = each($msgID)) {
    if($purgeSelected != "") { // purge the messages (we are in Trash)
	if(($rc = $imap->rmmail($msgUID)) == false) $err_msg = $lng->p(226);
        else $info_msg = $lng->p(227);
    } else if($delSelected != "") { // delete the messages
        if($user_set["movetrash"]) {
	   // move the msg to trash
	   if(($rc = $imap->mvmail($msgUID, $mbox_to)) == false) $err_msg = $lng->p(222);
	   else {
		$lng->sb(223); $lng->sr("%d", $act_i);
		$info_msg = $lng->sp();
	   }
        } else {
	   // or delete it
	   if(($rc = $imap->rmmail($msgUID)) == false) $err_msg = $lng->p(224);
	   else $info_msg = $lng->p(225);
        }
    } else if($moveSelected != "") { // move the message to the desired folder
	if(($rc = $imap->mvmail($msgUID, $mbox_to)) == false) $err_msg = $lng->p(222);
	else $info_msg = $lng->p(225);
    }
    $act_i++;
}
// --

// --
// Expunge the mailbox
$imap->expng();
// and print the mailbox list
push_mboxlist();
?>

<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Delete the specified message
// -----------------------------------------------------------------------

// --
if($mbox == "" || $ID == "") my_exit();
$mbox = imap_utf7_encode(decode_strip($mbox));
// --

// --
require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");
// --

// -- delete the msg
lang_load("mboxlst");
$info_msg = del_msg($ID);

// -- the mboxlist
$pagehdr_msg = imap_utf7_decode($mbox);
if(!$prevID && !$nextID) {
	push_mboxlist();
} else {
	// or the next message
	if($nextID > 0) {
		$ID = $nextID;
	} else {
		// or the prev
		$ID = $prevID;
	}
	require("$BSX_LIBDIR/readmsg.inc");
	push_msgdetail();
}
// --
?>

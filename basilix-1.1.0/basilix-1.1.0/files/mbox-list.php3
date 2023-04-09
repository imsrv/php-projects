<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// MBOX listing procedure
// -----------------------------------------------------------------------
if($mbox == "") $mbox = "Inbox";

$mbox = imap_utf7_encode(decode_strip($mbox));

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

// connect to the imap server
require("$BSX_LIBDIR/imap2.inc");

// print the mbox list
require("$BSX_LIBDIR/mbox.inc");

$pagehdr_msg = imap_utf7_decode($mbox);
push_mboxlist();
?>

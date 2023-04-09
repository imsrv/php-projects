<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Read the message
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
	
// --
require("$BSX_LIBDIR/readmsg.inc");
$pagehdr_msg = imap_utf7_decode($mbox);

if(isset($part)) push_msgatch($part);
else push_msgdetail();
// --
?>

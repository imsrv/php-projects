<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Print the message
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
push_msgprint();
// --
?>

<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Reply ALL a message (similar to message-reply.php3)
// -----------------------------------------------------------------------

require("$BSX_LIBDIR/getvals.inc");

if(empty($mbox) || empty($ID)) {
	echo "No mbox or ID variable!<br>\n";
	my_exit();
}

$mbox = imap_utf7_encode(decode_strip($mbox));

require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");

// get some values
require("$BSX_LIBDIR/compose.inc");
get_reply(1);

// initiate a new message
$sql->open();
$premail = cmps_newmsg($customerID);

// update fields for fwd mail
update_premail($customerID, $premail, $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc, $cmps_subject, $cmps_body);

// load the addressbook
require("$BSX_LIBDIR/abook.inc");
load_abook();

// send the compose form
$pagehdr_msg = $lng->p(104);
push_compose();
// --
?>

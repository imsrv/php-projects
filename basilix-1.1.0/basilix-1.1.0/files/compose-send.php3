<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Send the message
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

// --
require("$BSX_LIBDIR/compose.inc");
require("$BSX_LIBDIR/abook.inc");

// decode job
$cmps_from = decode_strip($cmps_from); $cmps_to = decode_strip($cmps_to);
$cmps_cc = decode_strip($cmps_cc); $cmps_bcc = decode_strip($cmps_bcc);
$cmps_subject = decode_strip($cmps_subject); $cmps_body = decode_strip($cmps_body);
$mbox = imap_utf7_encode(decode_strip($mbox));

$pagehdr_msg = $lng->p(104);

$sql->open();

if(!empty($cmps_atchform)) { // will attach/unattach
	update_premail($customerID, $premail, $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc, $cmps_subject, $cmps_body);
	$sql->close();
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSATCH&premail=" . $premail);
	exit();
}

if(!empty($cmps_savedraft)) { // saving the draft
	update_premail($customerID, $premail, $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc, $cmps_subject, $cmps_body);
	$sql->close();
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSMENU");
	exit();
}
		

$dontsend = 0;
// check form (to, cc, bcc)
if(empty($cmps_to) && empty($cmps_cc) && empty($cmps_bcc)) {
	$err_msg = $lng->p(430);
	$BODY_ONLOAD = "onLoad='document.composeMail.cmps_to.focus();'";
	$dontsend = 1;
}

// body
if(empty($cmps_body)) {
	if(empty($err_msg)) {
		$BODY_ONLOAD = "onLoad='document.composeMail.cmps_body.focus();'";
		$err_msg = $lng->p(431);
	}
	$dontsend = 1;
}

if($dontsend) {
	// load the abook
	require("$BSX_LIBDIR/abook.inc");
	load_abook();

	// and re-compose menu
	push_compose();
}

// save the mail just in case
update_premail($customerID, $premail, $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc, $cmps_subject, $cmps_body);
// ok send it
$rc = compose_sendmail();
?>

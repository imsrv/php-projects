<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Compose a new message
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

// load compose related functions
require("$BSX_LIBDIR/compose.inc");

$cmps_to = decode_strip($cmps_to);

if((!empty($delDraft) || !empty($contDraft)) && empty($premail)) {
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSMENU");
	exit();
}

$sql->open();
if(!empty($delDraft) && !empty($premail)) { // delete the selected draft
	$atch_dir = $BSX_ATTACH_DIR . "/" .  "$domain_name" . "/" . "$username";
	del_draft($customerID, $premail);
	$sql->close();
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSMENU&delDraft=1");
	exit();
}

// load the addressbook
require("$BSX_LIBDIR/abook.inc");
load_abook();
$sql->close();

// --
$sql->open();
if(!empty($contDraft) && !empty($premail)) { // continue to the selected draft
	// load the settings of the mail and push the compose form
	$sendmsgs_details = load_details($customerID, $premail);
	$cmps_from = decode_strip($sendmsgs_details["MSGFROM"]);
	$cmps_to = decode_strip($sendmsgs_details["MSGTO"]);
	$cmps_cc = decode_strip($sendmsgs_details["MSGCC"]);
	$cmps_bcc = decode_strip($sendmsgs_details["MSGBCC"]);
	$cmps_subject = decode_strip($sendmsgs_details["MSGSUBJECT"]);
	$cmps_body = decode_strip($sendmsgs_details["MSGBODY"]);
	$cmps_atchs = decode_strip($sendmsgs_details["MSGATCHS"]);
}

if(!empty($createNew)) {
	$premail = cmps_newmsg($customerID);
}

if(!empty($cmps_to) && $premail == -1) { 	// compose a message to the address retrieved 
	$premail = cmps_newmsg($customerID); 	// from a read message body
	update_premail($customerID, $premail, $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc, $cmps_subject, $cmps_body);
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSNEW&premail=$premail&cmps_to=" . $cmps_to);
}
$pagehdr_msg = $lng->p(104);
push_compose();
exit();
// --
?>

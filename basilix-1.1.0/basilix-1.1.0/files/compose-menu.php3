<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Compose menu, draft or new message
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");


// load compose related functions
require("$BSX_LIBDIR/compose.inc");

$sql->open();
// load the drafts
$rc = del_empty_drafts($customerID);
$draft_msgs = load_drafts($customerID);
if(empty($draft_msgs)) {
	if($delDraft) {
		url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=MBOXLST");
	} else {
		$newMsgID = cmps_newmsg($customerID);
		url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=CMPSNEW&premail=$newMsgID");
	}
	$sql->close();
	exit();
}
// choose draft menu
$pagehdr_msg = $lng->p(104);
include("$BSX_HTXDIR/header.htx");
include("$BSX_HTXDIR/menu.htx");
include("$BSX_HTXDIR/compose-menu.htx");
include("$BSX_HTXDIR/footer.htx");
// --
?>

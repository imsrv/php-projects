<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Message searching functions
// ----------------------------------------------------------------------

require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");

function search_menu() {
    global $BSX_HTXDIR, $BSX_VERSION;
    global $BSX_THEMEDIR, $BSX_BASEHREF, $BSX_LAUNCHER, $BSX_MDIR;
    global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $RequestID, $SESSID, $is_js, $is_ssl, $lng, $imap;
    global $err_msg, $info_msg;
    global $search_txt, $search_src, $doSearch;
    global $search_mbox;

    $err_found = 0;
    if(empty($doSearch)) $search_src = 1;
    else {
	if(empty($search_mbox)) {
	   $err_msg = $lng->p(612);
	   $err_found = 1;
	} else if(!$search_src) {
	   $err_msg = $lng->p(601);
	   $err_found = 1;
	   $BODY_ONLOAD="onLoad='document.findMail.search_src.focus();'";
	} else if(empty($search_txt)) {
	   $err_msg = $lng->p(602);
	   $err_found = 1;
	   $BODY_ONLOAD="onLoad='document.findMail.search_txt.focus();'";
	} else if(strlen($search_txt) < 3) {
	   $err_msg = $lng->p(603);
	   $err_found = 1;
	   $BODY_ONLOAD="onLoad='document.findMail.search_txt.focus();'";
	}
    }
   
    if(!$err_found && !empty($doSearch)) { // ok search
	$search_query = "";
	switch($search_src) {
	   case 1:
		$search_query = "BODY \"$search_txt\"";
		break;
	   case 2:
		$search_query = "SUBJECT \"$search_txt\"";
		break;
	   case 3:
		$search_query = "FROM \"$search_txt\"";
		break;
	}

	// search the mboxes one by one
	for($i = 0, $cnt = 0 ; $i < count($search_mbox) ; $i++) {
	    if(empty($search_mbox[$i])) continue;
	    $search_mbox[$i] = imap_utf7_encode(decode_strip($search_mbox[$i]));

	    if(strtoupper($search_mbox[$i]) != "INBOX")
	       if(!$imap->reopbox($BSX_MDIR . $search_mbox[$i])) 
                   continue;

	    $search_ok = $imap->srch($search_query);
	    for($j = 0 ; $j < count($search_ok) ; $j++) {
		if($cnt == 50) break;	// max 50 msgs?
	    	// msg UID&NO
		$msg_uid = $search_ok[$j];
	    	if(empty($msg_uid)) continue;
	    	$msg_no = $imap->msgno($msg_uid);
	    
	    	$search_result[$cnt]["mbox"] = $search_mbox[$i];
	    	$search_result[$cnt]["uid"] = $msg_uid;
	    
	    	// the header
	    	$msg_hdr = $imap->msghdr($msg_no);
	    	$msg_fromobj = $msg_hdr->from[0];
	    	if($msg_hdr->Unseen == "U" || $msg_hdr->Recent == "N")
		   $search_result[$cnt]["class"] = "newmsg";
	    	else
		   $search_result[$cnt]["class"] = "oldmsg";
		
	    	if(is_object($msg_fromobj)) {
		   if(empty($msg_fromobj->personal))
		   	$msg_from = substr($msg_fromobj->mailbox . "@" . strtolower($msg_fromobj->host), 0, 40);
		   else
		   	$msg_from = substr(decode_mime($msg_fromobj->personal), 0, 40);
	    	} else {
		   $msg_from = $lng->p(7);
	    	}
	    	if(strlen($msg_from) > 37) {
		   $msg_from = substr($msg_from, 0, 37);
		   $msg_from .= "...";
	    	}
	    	$search_result[$cnt]["from"] = $msg_from;
	    	$search_result[$cnt]["date"] = date("d M Y H:i", $msg_hdr->udate);
	    	$msg_subject = (chop($msg_hdr->subject ==  "")) ?  "(no subject)" : $msg_hdr->subject;
	    	$msg_subject = decode_mime($msg_subject);
	    	if(strlen($msg_subject) > 37) {
		   $msg_subject = substr($msg_subject, 0, 37);
		   $msg_subject .= "...";
	    	}
	    	$search_result[$cnt]["subject"] = $msg_subject;
	    	$cnt++;
            }
	}
        $lng->sb(605); 
	if($cnt == 50) $lng->sr("%d", "&gt;" . $cnt); 
	else $lng->sr("%d", $cnt);
	$info_msg = $lng->sp();
    }
    
    $bsx_mboxes = getbsxmboxes();
    $found_cnt = $cnt;

    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/menu.htx");
    include("$BSX_HTXDIR/search.htx");
    include("$BSX_HTXDIR/footer.htx");
}
?>

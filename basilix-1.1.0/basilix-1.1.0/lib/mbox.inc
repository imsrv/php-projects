<?
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Mbox listing functions..
// -----------------------------------------------------------------------

function list_mbox($mbox, $from, &$box_info) {
    global $imap, $user_set, $pluspsize, $plusone, $minuspsize, $lng;
    global $BSX_MDIR, $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $username, $domain_name;
   
    global $sort;

    if(strtoupper($mbox) != "INBOX") 
      if(!$imap->reopbox($mbox)) 
         return array();

    $bsx_mboxes = $imap->getmailboxes($BSX_MDIR . "%");

    if(empty($bsx_mboxes)) {
       crt_sentmail($imap);
       crt_trash($imap);
    }

    $mbox_info = $imap->mboxinfo();

    if(empty($from) || $from < 0) $from = 0;
    $box_info["nmsgs"] = $mbox_info->Nmsgs;
    $box_info["unread"] = $mbox_info->Unread;
    $box_info["size"] = $mbox_info->Size;

    $plusone = $from + 1;
    $pluspsize = $from + $user_set["psize"]; // user set 
    $minuspsize = $from - $user_set["psize"]; // user set
    if($plusone > $box_info["nmsgs"]) $plusone = $box_info["nmsgs"];
    if($pluspsize > $box_info["nmsgs"]) $pluspsize = $box_info["nmsgs"];
    $box_info["frommsg"] = $from;

    if(empty($sort)) $sort = $user_set["sort"];

    if($sort == 2) $sort_arr = $imap->mboxsrt(SORTFROM, $user_set["rsort"]);
    else if($sort == 3) $sort_arr = $imap->mboxsrt(SORTSUBJECT, $user_set["rsort"]);
    else if($sort == 4) $sort_arr = $imap->mboxsrt(SORTSIZE, $user_set["rsort"]);
    else if($sort == 5) $sort_arr = $imap->mboxsrt(SORTTO, $user_set["rsort"]);
    else { // $sort_arr = $imap->mboxsrt(SORTDATE, $user_set["rsort"]);
	for($i = 0 ; $i < $box_info["nmsgs"] ; $i++) {
	    if($user_set["rsort"]) $num = $box_info["nmsgs"] - $i;
	    else $num = $i + 1;
	    $sort_arr[$i] = $num;
        }
    }

    $mbox_sntmail = $BSX_MDIR . $BSX_SENTMAIL_NAME;

    // organise our array, filled it detailed information about the messages
    $cnt = 0;
    for($i = $from ; $i < count($sort_arr) ; $i++) {
	// uset set 
	if($cnt == $user_set["psize"]) break;
	$cur_msg = $sort_arr[$i];
	$msg_header = $imap->msghdr($cur_msg);
	$msg_no = $msg_header->Msgno;
	$box_detailed[$cnt]["uid"] = $imap->msguid($msg_no);
	$from_obj = $msg_header->from[0];
	
	// the from part
	if(is_object($from_obj)) {
 	   if(empty($from_obj->personal)) 
	       $msg_from = substr($from_obj->mailbox . "@" . strtolower($from_obj->host), 0, 40);
	    else
	       $msg_from = substr(decode_mime($from_obj->personal), 0, 40);
	} else {
	   $msg_from = $lng->p(7);
	}

	// retrieve the "To" part to see if the "Recepient" is me.
        $msg_to = ""; // We hope the receipent is in the To part
        for($j = 0 ; $j < count($msg_header->to) ; $j++) {
            $to_obj = $msg_header->to[$j];
	    if(is_object($to_obj)) {
               if(empty($to_obj->personal))
       	          $msg_to = substr($to_obj->mailbox .  "@" . strtolower($to_obj->host), 0, 40);
               else
                  $msg_to = substr(decode_mime($to_obj->personal), 0, 40);
            } else {
	       $msg_to = $lng->p(7);
            }
      	}
        if(empty($msg_to)) { // no, it is in the CC part
           for($j = 0 ; $j < count($msg_header->cc) ; $j++) {
               $cc_obj = $msg_header->cc[$j];
               if(is_object($cc_obj)) {
                  if(empty($cc_obj->personal))
                     $msg_to = substr($cc_obj->mailbox .  "@" . strtolower($cc_obj->host), 0, 40);
                  else
                     $msg_to = substr(decode_mime($cc_obj->personal), 0, 40);
	       } else {
		  $msg_to = $lng->p(7);
               }
           }
        }
	// date, size and the subject
        $box_detailed[$cnt]["date"] = date("d M Y H:i", $msg_header->udate);
	$box_detailed[$cnt]["size"] = convert_size($msg_header->Size);
	$msg_subject = (chop($msg_header->subject ==  "")) ?  $lng->p(211) : $msg_header->subject;
	$msg_subject = decode_mime($msg_subject);
	
	// new and old messages must differ in the way they look
	if(($msg_header->Unseen == "U") || ($msg_header->Recent == "N")) 
	   $box_detailed[$cnt]["trclass"] = "newmsg";
	else
	   $box_detailed[$cnt]["trclass"] = "oldmsg";

	// check if the message has an attachment
	$fetch_arr = $imap->ftchstr($cur_msg);
	$subtype = $fetch_arr->subtype;
	$ifdisp = $fetch_arr->ifdisposition;
	if($subtype == MIXED || $subtype == ALTERNATIVE || $subtype == SIGNED || $ifdisp == 1)
	   $box_detailed[$cnt]["mixed"] = 1;
	else
	   $box_detailed[$cnt]["mixed"] = 0;

        if($msg_to == $username . "@" . $domain_name) $box_detailed[$cnt]["rcptme"] = 1;
	else $box_detailed[$cnt]["rcptme"] = 0;

	// cut the from and the subject parts
	if(strlen($msg_from) > 37) {
	   $msg_from = substr($msg_from, 0, 37);
	   $msg_from .= "...";
	}

        $box_detailed[$cnt]["orgsubject"] = $msg_subject;
	if(strlen($msg_subject) > 37) {
	   $msg_subject = substr($msg_subject, 0, 37);
	   $msg_subject .= "...";
	}
	$box_detailed[$cnt]["from"] = $msg_from;
	$box_detailed[$cnt]["subject"] = $msg_subject;
	
	// and may be the "To" also..
	if($mbox == $mbox_sntmail) {
           if(strlen($msg_to) > 37) {
	      $msg_to = substr($msg_to, 0, 37);
	      $msg_to .= "...";
           }
	   $box_detailed[$cnt]["to"] = $msg_to;
	}
	$cnt++;
    }
    return $box_detailed;
}

function getbsxmboxes($init = "") {
    global $imap, $BSX_MDIR, $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;

    $mboxes = $imap->getmboxes($BSX_MDIR . "%");
    $snt_found = 0;
    $trsh_found = 0;
    if(!empty($init)) {
	$cnt = count($mboxes);
	for($i = 0 ; $i < $cnt ; $i++) {
		if($mboxes[$i] == $BSX_SENTMAIL_NAME) $snt_found++;
		if($mboxes[$i] == $BSX_TRASH_NAME) $trsh_found++;
	}
	if(!$snt_found) {
		crt_sentmail($imap);
		$mboxes[$cnt++] = $BSX_SENTMAIL_NAME;
	}
	if(!$trsh_found) {
		crt_trash($imap);
		$mboxes[$cnt] = $BSX_TRASH_NAME;
	}
    }
    sort($mboxes);
    return $mboxes;
}

function push_emptfol($mbox) {
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $lng, $is_js, $SESSID, $is_ssl;
  
    if($is_js) {
       $confirm_msg = $lng->p(229);
       $confirm_url = "$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=EMPTFOL&mbox=" . urlencode(imap_utf7_decode($mbox)) . "&is_js=" . $is_js;
       if($SESSID) $confirm_url .= "&SESSID=" . $SESSID;
       if($is_ssl) $confirm_url .= "&is_ssl=" . $is_ssl;
       echo "<script language=\"Javascript\" src=\"$BSX_BASEHREF/js/confirm.js\"></script>\n";
       echo "<a href=\"javascript:ask_confirm('$confirm_msg', '$confirm_url');\">" . $lng->p(214) . "</a>";
    } else { // if no javascript, then no confirmation }:>
       put_ahref("RequestID=EMPTFOL&mbox=" . urlencode(imap_utf7_decode($mbox)) . "&confirmed=0", $lng->p(214));
    }
}

function push_emptfol_nonjs($mbox) {
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $lng, $SESSID;
    
    $confirm_msg = "<b>$mbox</b>: " . $lng->p(180);
    $confirm_url_yes = "$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=EMPTFOL&mbox=" . urlencode(imap_utf7_decode($mbox)) . "&confirmed=1";
    $confirm_url_no = "$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=MBOXLST&mbox=" . urlencode(imap_utf7_decode($mbox));
    if($SESSID) {
	$confirm_url_yes .= "&SESSID=" . $SESSID;
	$confirm_url_no .= "&SESSID=" . $SESSID;
    }
    echo $confirm_msg . "<br><br>\n";
    echo "<a href=\"$confirm_url_yes\">" . $lng->p(1) . "</a> | <a href=\"$confirm_url_no\">" . $lng->p(2) . "</a>\n";
}
function push_mboxlist() {
    global $RequestID;
    global $mbox, $fromPage, $fromMsg, $lng, $sort;
    global $imap, $err_msg, $info_msg;
    global $bsx_mboxes, $bsx_mboxes_curmbox, $sentmail_upper;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $REFRESH_URL, $REFRESH_SEC, $SESSID;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_MDIR;
    global $BSX_VERSION;
    global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $is_js, $is_ssl;
    global $push_lastinfo, $last_host, $last_addr, $last_time;
    global $username, $domain_name;

    global $user_set;

   if(strtoupper($mbox) != "INBOX") {
	$bsx_mbox = $BSX_MDIR . $mbox;
   } else {
      $bsx_mbox = "INBOX";
      $REFRESH_URL = "$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=MBOXLST";
      $REFRESH_URL .= $is_js ? "&is_js=$is_js" : "";
      $REFRESH_URL .= $is_ssl ? "&is_ssl=$is_ssl" : "";
      $REFRESH_URL .= $SESSID ? "&SESSID=$SESSID" : "";
      $REFRESH_SEC = 300;
   }

   include("$BSX_HTXDIR/header.htx");
   include("$BSX_HTXDIR/menu.htx");

   // collect the information
   $box_detailed = list_mbox($bsx_mbox, $fromMsg, $box_info);
   $bsx_mboxes = getbsxmboxes();
   $this_many_msgs = count($box_detailed);
   if(!$this_many_msgs) {
       if($fromMsg > 0) {
	   $box_detailed = list_mbox($bsx_mbox, 0, $box_info);
	   $fromMsg = 0;
	   $fromPage = 0;
	   $this_many_msgs = count($box_detailed);
       }
   }
  
   if(!$this_many_msgs) {
       if(empty($info_msg)) $info_msg = $lng->p(219);
       else $info_msg = "$info_msg<br>" . $lng->p(219);
       $no_msgs_infolder = 1;
   }

   // list the mbox with the message infos
   include("$BSX_HTXDIR/mbox-list.htx");
   include("$BSX_HTXDIR/footer.htx");
}

function push_moveselect() {
    global $bsx_mboxes, $mbox, $BSX_SENTMAIL_NAME, $lng;
    global $sentmail_upper, $bsx_mboxes_curmbox; // not exist at the moment, for future use..
    
    echo $lng->p(212) . "&nbsp;" . "<select name=\"toMbox\" size=\"1\">\n";
    echo "<option value=\"0\">" . $lng->p(3) . "</option>\n";
    echo "<option value=\"0\">------------</option>\n";

    $bsx_mboxes_curmbox = strtoupper($mbox);
    $sentmail_upper = strtoupper($BSX_SENTMAIL_NAME);

    // forbidden moves:
    // XX --> XX
    // Sent Mail --> XX
    // XX --> Sent Mail
    if(!empty($bsx_mboxes_curmbox) && $bsx_mboxes_curmbox != $sentmail_upper && $bsx_mboxes_curmbox != "INBOX")
       echo "<option value=\"Inbox\">Inbox</option>\n";
    for($z = 0 ; $z < count($bsx_mboxes) ; $z++) {
        $bsx_mboxes_upper = strtoupper(imap_utf7_encode($bsx_mboxes[$z]));
        if($bsx_mboxes_upper == $bsx_mboxes_curmbox ||
           $bsx_mboxes_upper == $sentmail_upper) continue;
           echo "<option value=\"$bsx_mboxes[$z]\">$bsx_mboxes[$z]</option>\n";
    }
    echo "</select>";
}

function push_delpurge() {
    global $user_set, $BSX_TRASH_NAME, $mbox, $lng;
 
    if($user_set["movetrash"] && $mbox != $BSX_TRASH_NAME) { // user setting for Trash
       $butname = "delSelected";
       $butval = $lng->p(215);
    } else {
       $butname = "purgeSelected";
       $butval = $lng->p(216);
    }
    echo "<div align=\"center\">";
    echo "<input type=\"submit\" class=\"button\" name=\"$butname\" value=\"$butval\" onMouseOver='inset(this, 1)' onMouseOut='outset(this, 1)'>";
    echo "</div>";
}

function push_prevnext($nmsgs) {
    global $sort, $fromMsg, $fromPage, $lng, $mbox, $nextPage, $prevPage;
    global $minuspsize, $pluspsize, $plusone;
    global $user_set;
 
    if(empty($sort)) $sort = $user_set["sort"];

    // prints the previous|XXX|next stuff
    if($nmsgs > $user_set["psize"]) {
       if($minuspsize >= 0)
          put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $minuspsize . "&fromPage=" . $prevPage, $lng->p(217));
       else
          echo $lng->p(217);
       echo "&nbsp;|&nbsp;" . $plusone . " - " . $pluspsize . " / " . $nmsgs;
    } else {
       if($minuspsize >= 0)
          put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $minuspsize . "&fromPage=" . $prevPage, $lng->p(217));
       else
          echo $lng->p(217);
       echo "&nbsp;|&nbsp;" . $plusone . " - " . $nmsgs;
    }
    echo "&nbsp;|&nbsp;";
    if(($pluspsize >= $user_set["psize"]) && ($pluspsize < $nmsgs))
       put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $pluspsize . "&fromPage=" . $nextPage, $lng->p(218));
    else 
       echo $lng->p(218);
}

function push_lastinfo() {
    global $push_lastinfo, $last_host, $last_addr, $last_time;
    global $lng, $info_msg;

    if($push_lastinfo && $last_addr) {
       $mymsg = $lng->p(230) . " " . $last_addr;
       // if($last_host) $mymsg .= " ($last_host)";
       $mymsg .= " @ " . date("d M Y H:i", $last_time);
       echo "<!-- LASTLOGIN INFO : START -->";
       echo "<table width=\"90%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
       echo "<tr><td class=\"info\" align=\"center\">&nbsp;$mymsg&nbsp;</td></tr>";
       echo "</table>\n";
       echo "<!-- LASTLOGIN INFO : FINISH -->";
    }
}
function create_mbox($mbox) {
    global $imap;
    return $imap->crtmbox($mbox);
}
function del_mbox($mbox) {
    global $imap;
    return $imap->delmbox($mbox);
}
function rename_mbox($old, $new) {
    global $imap;
    return $imap->renmbox($old, $new);
}

function del_msg($ID) {
    global $imap, $mbox, $lng, $user_set;
    global $BSX_MDIR, $BSX_TRASH_NAME;

    if(strtoupper($mbox) != "INBOX") $imap->reopbox($BSX_MDIR . $mbox);

    if($user_set["movetrash"]) {
       $imap->mvmail($ID, $BSX_MDIR . imap_utf7_encode($BSX_TRASH_NAME));
       $ret = $lng->p(231);
    } else { 
       $imap->rmmail($ID);
       $ret = $lng->p(232);
    }
    $imap->expng();
    return $ret;
}

function update_user_folders($cid, $folders) {
	global $sql;

	$fstr = "";
	$glue = "";
	for($i = 0 ; $i < count($folders) ; $i++) {
		$fstr .= $glue . addslashes($folders[$i]);
		$glue = chr(2);
	}
	return $sql->folders_update($cid, $fstr);
}
?>

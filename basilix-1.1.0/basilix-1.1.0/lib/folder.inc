<?
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Folder related functions, create mbox, folder list, etc..
// -----------------------------------------------------------------------
function crt_sentmail($imap) {
    global $BSX_SENTMAIL_NAME, $BSX_MDIR, $lng;
    if(@$imap->crtmbox($BSX_MDIR . $BSX_SENTMAIL_NAME) == false)
      err_exit($lng->p(182));
}

function crt_trash($imap) {
    global $BSX_TRASH_NAME, $BSX_MDIR, $lng;
    global $IMAP_STYPE; 
    if(@$imap->crtmbox($BSX_MDIR . $BSX_TRASH_NAME) == false)
     err_exit($lng->p(181));
}

function folder_list(&$total, &$mbox_cnt, $stype) {
    global $imap, $BSX_MDIR, $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    
    // list the folders of the user
    $total["msg"] = 0;
    $total["size"] = 0;
    $total["unread"] = 0;

    // first inbox
    $inbox_info = $imap->mboxinfo();
    $inbox_nmsgs = $inbox_info->Nmsgs;
    $inbox_unread = $inbox_info->Unread;
    $inbox_size = $inbox_info->Size;
    $mboxes[0]["name"] = "Inbox";
    $mboxes[0]["unread"] = $inbox_unread;
    $mboxes[0]["nmsgs"] = $inbox_nmsgs;
    $mboxes[0]["size"] = convert_size($inbox_size);
    $total["msg"] += $inbox_nmsgs;
    $total["size"] += $inbox_size;
    $total["unread"] += $inbox_unread;

    // then other mboxes
 
    if($stype == 2 || $stype == 3) {	// Courier or Cyrus
       $other_list = $imap->lstmbox($BSX_MDIR . "%");
       // courier 0.21 returns array to function imap_listsubscribed()
       // whereas 1.3.8 returns "string".
       // weird..
       $sep = "}";
    } else {  // wu-imapd
       $other_list = $imap->lstmbox($BSX_MDIR . "%");
       $sep = "/";
    }

    if($stype == 3) {
	$sent_mail_ok = 0;
	for($i = 0 ; $i < count($other_list) ; $i++) {
	    $str2 = $other_list[$i];
	    $str2_arr = explode($sep, $str2);
	    $str2_mbox = $str2_arr[1];
	    $str2_mbox_arr = explode(".", $str2_mbox);
	    $srv_sentmail = $str2_mbox_arr[1];
	    // {imap_host:143}INBOX.Sent Mail
	    if($srv_sentmail == $BSX_SENTMAIL_NAME) $sent_mail_ok = 1;
        }
	if(!$sent_mail_ok) { // create the sent mail
       	    crt_sentmail($imap);
	    // and reload the other mailboxes
	    $other_list = $imap->lstmbox($BSX_MDIR . "%");
	}

    }

    if(empty($other_list) && $stype != 3) {
       crt_sentmail($imap);
       crt_trash($imap);    
       $other_list = $imap->lstmbox($BSX_MDIR . "%");
       if(!$other_list) return false;
    }

    for($mbox_cnt = 1 ; $mbox_cnt <= count($other_list) ; $mbox_cnt++) {
       $j = $mbox_cnt - 1;
       if(!$imap->reopbox2($other_list[$j])) return array();
       $other_info = $imap->mboxinfo();
       $other_arr = explode($sep, $other_info->Mailbox);
       if($stype == 3) { // courier
	  $other2_arr = explode(".", $other_arr[1]);
	  $tmp_name = "";
	  $glue = "";
	  for($k = 1; $k < count($other2_arr) ; $k++) {
	      $tmp_name .= $glue . $other2_arr[$k];
	      $glue = ".";
	  }
       } else {
          $j = count($other_arr) - 1;
	  $tmp_name = $other_arr[$j];
       }
       $mboxes[$mbox_cnt]["name"] = imap_utf7_decode($tmp_name);
       $total["unread"] += $mboxes[$mbox_cnt]["unread"] = $other_info->Unread;
       $total["msg"] += $mboxes[$mbox_cnt]["nmsgs"] = $other_info->Nmsgs;
       $total["size"] += $mbox_size = $other_info->Size;
       $mboxes[$mbox_cnt]["size"] = convert_size($mbox_size);
    }
    return $mboxes;
}

function empty_folder($mbox) {
    global $BSX_MDIR, $imap;

    if(strtoupper($mbox) != "INBOX") {
       $bsx_mbox = $BSX_MDIR . $mbox;
       $imap->reopbox($bsx_mbox);
    } else $bsx_mbox = "Inbox";

    $mbox_info = $imap->mboxinfo();
    $mbox_nmsgs = $mbox_info->Nmsgs;
    
    $seq = "1";
    for($i = 2 ; $i <= $mbox_info->Nmsgs ; $i++) $seq .= ",$i";

    if(!$imap->setflg($seq, "\\Deleted")) return false;
    $imap->expng();
    return true;
}
?>

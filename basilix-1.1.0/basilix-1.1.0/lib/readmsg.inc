<?
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Msg reading
// ------------------------------------------------------------------

/*
Just in case.. I got a message with this header, so we better let users
see this message. Well, this is the header of the email I received:

MIME-Version: 1.0
Content-Type: text/plain; charset=iso-8859-1
Content-Transfer-Encoding: quotedGMprintable
                           ^^^^^^^^^^^^^^^^^
No X-Mailer. Probably a newbie spam lamer. But anyway, we need to inform the user.
On the other hand the imap server (IMAP4rev1 v12.264) didnot set the 
"encoding" variable to "5" (other) which was expected. It set to "6" so I 
added another "other" encoding type with code 6.
*/

$unknown_enc = "<hr><b>INFO:</b> The encoding algorithm of the current message is not one of: ";
$unknown_enc .= "7bit, 8bit, binary, base64, quoted_printable. This is not something I can do since ";
$unknown_enc .= "the encoding this message used is <b>not</b> a standard. If this is an emergency ";
$unknown_enc .= "e-mail, please inform the person who sent this e-mail to you, and suggest him/her ";
$unknown_enc .= "to re-send the message with one of the above encoding algorithms. If this is not ";
$unknown_enc .= "the case, simply you can ignore/delete this message.<hr>";


// Primary body types
$body_type = array(
	0	=>	'text',
	1	=>	'multipart',
	2	=>	'message',
	3	=>	'application',
	4	=>	'audio',
	5	=>	'image',
	6	=>	'video',
	7	=>	'other'
);

$atch_type = array(
	"text"		=>	$lng->p(275),
	"application"	=>	$lng->p(276),
	"audio"		=>	$lng->p(277),
	"image"		=>	$lng->p(278),
	"video"		=>	$lng->p(279)
);
	


// Transfer encoding types
$encode_type = array(
	0	=>	'7bit',
	1	=>	'8bit',
	2	=>	'binary',
	3	=>	'base64',
	4	=>	'quoted_printable',
	5	=>	'other',
	6	=>	'other'
);

// and their related functions
function enc_func0($body) {	// 7bit 
    return $body;
}

function enc_func1($body) {	// 8bit
    return enc_func4(imap_8bit($body));
}

function enc_func2($body) {	// binary
    return enc_func3(imap_binary($body));
}

function enc_func3($body) {	// base64
    return imap_base64($body);
}

function enc_func4($body) {	// quoted-printable
    return imap_qprint($body);
}

function enc_func5($body) {	// other
    global $unknown_enc;
    return $unknown_enc . $body;
}

function enc_func6($body) {	// another 'other'
    global $unknown_enc;
    return $unknown_enc . $body;
}

function enc_func($body) {	// no encoding
    return $body;
}

// Checks the body and applies the necessary decodings
function check_body($msg_no, $msg_uid, $msg_body) {
    global $imap, $lng;

    $msg_str = $imap->ftchstr($msg_no);
    if(is_array($msg_str->parts)) $msg_bpart = $msg_str->parts[0];
    else $msg_bpart = $msg_str;
    $msg_type = $msg_bpart->type;
    $msg_subtype = $msg_bpart->subtype;
    if($msg_subtype != "PLAIN" && $msg_subtype != "HTML") {
		return $lng->p(258);
    }
    $msg_encoding = $msg_bpart->encoding;
    $enc_func = "enc_func" . $msg_encoding;
    if(function_exists($enc_func)) 
       $new_body = $enc_func($msg_body);
    else
       $new_body = enc_func($msg_body);
    if(strlen($new_body) < 3) $new_body = $lng->p(258);
    return $new_body;
}

// Checks if the message has an attachment
function check_atch($msg_no) {
    global $imap, $body_type;

    $msg_str = $imap->ftchstr($msg_no);
    $msg_btype = $msg_str->type;
    $msg_ifdisp = $msg_str->ifdisposition;
    if($msg_btype == 1 || $msg_ifdisp == 1) return true;
    return false;
}


// Find the attachments in the message
function find_atch($msg_no) {
    global $imap, $body_type, $lng, $atch_type;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $ID, $mbox, $msg_cbody;

    $msg_str = $imap->ftchstr($msg_no);
    $msg_ifdisp = $msg_str->ifdisposition;

    for($i = 1, $j = 0 ; $i < count($msg_str->parts) ; $i++) {
        // type/subtype, disposition
	$atch_part = $msg_str->parts[$i];

        $tmp_type = $body_type[$atch_part->type];
        if(empty($tmp_type)) $tmp_type = "text";

        $msg_atch[$j]["type"] = $tmp_type;
        $tmp_subtype = strtolower($atch_part->subtype);
        if(empty($tmp_subtype)) $tmp_subtype = "x-unknown";
        $msg_atch[$j]["subtype"] = $tmp_subtype;
        $msg_atch[$j]["disposition"] = ($atch_part->ifdisposition) ? strtolower($atch_part->disposition) : "attachment";

	// size
	$msg_atch[$j]["size"] = convert_size($atch_part->bytes);

	// filename
	if($atch_part->ifparameters) {
	  while(list(, $atch_param) = each($atch_part->parameters)) {
	     switch(strtolower($atch_param->attribute)) {
		case "filename":
		case "name":
		   $msg_atch[$j]["name"] = $atch_param->value;
		   break;
	     }
          }
    	}
	if($atch_part->ifdparameters && empty($msg_atch[$j]["name"])) {
	  while(list(, $atch_param) = each($atch_part->dparameters)) {
	     switch(strtolower($atch_param->attribute)) {
		case "filename":
		case "name":
		   $msg_atch[$j]["name"] = $atch_param->value;
		   break;
	     }
          }
    	}


	// description
	if(isset($atch_part->ifdescription)) $msg_atch[$j]["desc"] = $atch_part->description;
	else {
	    if(!empty($msg_atch[$j]["name"])) $msg_atch[$j]["desc"] = $msg_atch[$j]["name"];
	    else $msg_atch[$j]["name"] = "unknown file";
	}

	// --file
        if(empty($msg_atch[$j]["name"])) $msg_atch[$j]["name"] = preg_replace('|\W|', '_', $msg_atch[$j]["desc"]);
	if(empty($msg_atch[$j]["name"])) { // still no filename
	   switch($msg_atch[$j]["subtype"]) {
		case "html":
	     	    $msg_atch[$j]["name"] = "message.html";
		    $msg_atch[$j]["desc"] = $lng->p(269);
		    break;
		case "rfc822":
	     	    $msg_atch[$j]["name"] = "message.txt";
		    $msg_atch[$j]["desc"] = $lng->p(270);
		    break;
		case "delivery-status":
	     	    $msg_atch[$j]["name"] = "message.txt";
		    $msg_atch[$j]["desc"] = $lng->p(271);
		    break;
		case "plain":
	     	    $msg_atch[$j]["name"] = "message.txt";
		    $msg_atch[$j]["desc"] = $lng->p(272);
		    break;
		case "enriched":
	     	    $msg_atch[$j]["name"] = "message.rtf";
		    $msg_atch[$j]["desc"] = $lng->p(273);
		    break;
		case "pgp-signature":
		    $msg_atch[$j]["name"] = "pgp-signature.txt";
		    $msg_atch[$j]["desc"] = $lng->p(280);
		    break;
	    }
	    if(empty($msg_atch[$j]["name"])) // still no filename??
	       $msg_atch[$j]["name"] = $lng->p(274);
        }
	// -- desc
	if(empty($msg_atch[$j]["desc"])) { // no description
	   switch($msg_atch[$j]["subtype"]) {
		case "html":
		    $msg_atch[$j]["desc"] = $lng->p(269);
		    break;
		case "rfc822":
		    $msg_atch[$j]["desc"] = $lng->p(270);
		    break;
		case "delivery-status":
		    $msg_atch[$j]["desc"] = $lng->p(271);
		    break;
		case "plain":
		    $msg_atch[$j]["desc"] = $lng->p(272);
		    break;
		case "enriched":
		    $msg_atch[$j]["desc"] = $lng->p(273);
		    break;
	    }
	    if(empty($msg_atch[$j]["desc"])) // no desc?
	       $msg_atch[$j]["desc"] = $atch_type[$msg_atch[$j]["type"]];
        }
	// -- DBG
	// echo "NAME: " . $msg_atch[$j]["name"] . "<br>\n";
	// echo "DESC: " . $msg_atch[$j]["desc"] . "<br>\n";
	// echo "DISP: " . $msg_atch[$j]["disp"] . "<br>\n";
	// echo "TYPE: " . $msg_atch[$j]["type"] . "<br>\n";
	// echo "SUBTYPE: " . $msg_atch[$j]["subtype"] . "<br>\n";
	// --
	$j++;
    }
    return $msg_atch;
}

// Push the desired attachment of the message
function push_msgatch($part) {
    global $imap, $mbox, $ID;
    global $BSX_MDIR;
    global $body_type, $lng;

    if(strtoupper($mbox) != "INBOX") $imap->reopbox($BSX_MDIR . $mbox);

    $msg_no = $imap->msgno($ID);
    $msg_str = $imap->ftchstr($msg_no);

    if(!$part) {
	$atch_part = $msg_str->parts[0];
	if(!is_object($atch_part)) 
	   $atch_part = $msg_str;
    } else {
	$atch_part = $msg_str->parts[$part];
    }

    settype($myatch, "object");

    // type/subtype, disposition
    $myatch->type = $body_type[$atch_part->type];
    $myatch->subtype = strtolower($atch_part->subtype);
    if(empty($myatch->subtype)) $myatch->subtype = "x-unknown";
    if(empty($myatch->type)) {
	switch($myatch->subtype) {
	   case "html":
	   case "plain":
	   case "enriched":
		$myatch->type = "text";
		break;
	   case "rfc822":
	   case "delivery-status":
		$myatch->type = "message";
		break;
	   default:
		$myatch->type = "application";
		break;
	}
    }

    // disposition
    switch(strtolower($myatch->type)) {
        case "image":
	case "text":
	     $myatch->disp = "inline";
	     break;
    }

    if(empty($myatch->disp))
       $myatch->disp = ($atch_part->ifdisposition) ? strtolower($atch_part->disposition) : "attachment";

    // filename
    if($atch_part->ifparameters) {
       while(list(, $atch_param) = each($atch_part->parameters)) {
           switch(strtolower($atch_param->attribute)) {
	      case "filename":
              case "name":
		  $myatch->name = $atch_param->value;
		  break;
	   }
       }
    }
    if($atch_part->ifdparameters) {
       while(list(, $atch_param) = each($atch_part->dparameters)) {
           switch(strtolower($atch_param->attribute)) {
	      case "filename":
              case "name":
		  $myatch->name = $atch_param->value;
		  break;
	   }
       }
    }
    
    // description
    if(isset($atch_part->ifdescription)) $myatch->desc = $atch_part->description;
    else {
       if(!empty($myatch->name)) $myatch->desc = $myatch->name;
       else $myatch->desc = $lng->p(274);
    }
    // if(empty($myatch->name)) $myatch->name = preg_replace('|\W|', '_', $myatch->desc);
    if(empty($myatch->name)) {
	   switch($myatch->subtype) {
		case "html":
	     	    $myatch->name = "message.html";
		    break;
		case "rfc822":
	     	    $myatch->name = "message.txt";
		    break;
		case "delivery-status":
	     	    $myatch->name = "message.txt";
		    break;
		case "plain":
	     	    $myatch->name = "message.txt";
		    break;
		case "enriched":
	     	    $myatch->name = "message.rtf";
		    break;
		case "pgp-signature":
		    $myatch->name = "pgp-signature.txt";
		    break;
	    }
    }

    if(empty($myatch->name)) {
	$tt = time();
	if(!$part)
		$myatch->name = "msg$ID.txt";
	else 
		$myatch->name = "unknown_file_$tt.dat";
	if(empty($myatch->desc))
		$myatch->desc = "unknown-description-$tt";
    }
    

    // body
    $atch_body = $imap->ftchbody($msg_no, $part + 1);
    $msg_encoding = $atch_part->encoding;
    $enc_func = "enc_func" . $msg_encoding;
    $myatch->body = $enc_func($atch_body);

    // -- DBG
    // echo "NAME: " . $myatch->name . "<br>\n";
    // echo "DESC: " . $myatch->desc . "<br>\n";
    // echo "DISP: " . $myatch->disp . "<br>\n";
    // echo "ENCODING: " . $msg_encoding . "<br>\n";
    // echo "TYPE: " . $myatch->type . "<br>\n";
    // echo "SUBTYPE: " . $myatch->subtype . "<br>\n";
    // --
    
    // Push it
    Header("Content-Type: $myatch->type/$myatch->subtype");
    Header("Content-Disposition: $myatch->disp; filename=\"" . $myatch->name . "\"");
    echo $myatch->body;
    my_exit();
}

// Get the header of the message
function get_msghdr($mbox, $msg_uid) {
    global $imap;
   
    // --
    if(strtoupper($mbox) != "INBOX") 
       if(!$imap->reopbox($mbox)) return "no header";
    // -

    $msg_no = $imap->msgno($msg_uid);
    return $imap->ftchhdr($msg_no);
}

// Retrieve the information about the message
function get_msg($mbox, $msg_uid, &$msg_no, &$msg_atchlist) {
    global $imap, $sort, $lng, $err_msg, $body_type;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
   
    // --
    if(strtoupper($mbox) != "INBOX") 
       if(!$imap->reopbox($mbox)) return array();
    // -

    $mbox_info = $imap->mboxinfo();
    $msg_no = $imap->msgno($msg_uid);
    if(!$msg_no) {
	$err_msg = $lng->p(259);
	return array();
    }

    $msg_header = $imap->msghdr($msg_no);
    $msg_str = $imap->ftchstr($msg_no);

    $from_obj = $msg_header->from[0];

    // the from part
    if(is_object($from_obj)) {
       $from_addr = $from_obj->mailbox . "@" . strtolower($from_obj->host);
       if(empty($from_obj->personal))
	  $msg_detailed["from"] = $from_addr;
       else
          $msg_detailed["from"] = htmlspecialchars(decode_mime($from_obj->personal) . "  <$from_addr>");
       $msg_detailed["fromaddr"] = $from_addr;
    } else {
       $msg_detailed["from"] = $lng->p(7);
    }
    
    // to
    $msg_detailed["to"] = $msg_header->to;
    
    // cc
    $msg_detailed["cc"] = $msg_header->cc;

    // the header
    $msg_detailed["header"] = $imap->ftchhdr($msg_no);
   
    // date and the subject
    $msg_detailed["date"] = date("d M Y H:i", $msg_header->udate);
    $msg_subject = (chop($msg_header->subject ==  "")) ?  $lng->p(267) : $msg_header->subject;
    $msg_detailed["subject"] = decode_mime($msg_subject);

    // the body part
    $msg_cbody = check_body($msg_no, $msg_uid, $imap->ftchbody($msg_no, 1));
 
    // the attachments if any
    if(check_atch($msg_no))
       $msg_atchlist = find_atch($msg_no);

    if($msg_str->subtype != HTML) $msg_detailed["body"] = handle_emails(handle_urls(nl2br($msg_cbody)));
    else $msg_detailed["body"] = $msg_cbody;

    return $msg_detailed;
}

function push_msgdetail() {
    global $RequestID;
    global $mbox, $sort, $lng, $err_msg, $info_msg, $ID, $imap;
    global $bsx_mboxes, $bsx_mboxes_curmbox, $sentmail_upper;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_MDIR;
    global $BSX_VERSION;
    global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $is_js, $is_ssl, $SESSID, $user_set;

    if(strtoupper($mbox) != "INBOX") $bsx_mbox = $BSX_MDIR . $mbox;
    else $bsx_mbox = "Inbox";

    // collect the information
    $msg_detailed = get_msg($bsx_mbox, $ID, $msg_no, $msg_atchlist);
    $bsx_mboxes = getbsxmboxes();

    // prev next if set
    if($user_set["prevnext"]) {
        if(empty($sort)) $sort = $user_set["sort"];
	if($sort == 2) $sort_arr = $imap->mboxsrt(SORTFROM, $user_set["rsort"]);
	else if($sort == 3) $sort_arr = $imap->mboxsrt(SORTSUBJECT, $user_set["rsort"]);
	else if($sort == 4) $sort_arr = $imap->mboxsrt(SORTSIZE, $user_set["rsort"]);
	else if($sort == 5) $sort_arr = $imap->mboxsrt(SORTTO, $user_set["rsort"]);
	else $sort_arr = $imap->mboxsrt(SORTDATE, $user_set["rsort"]);

	$msg_previd = -1;
	$msg_found = 0;
	$msg_nextid = -1;
	for($i = 0 ; $i < count($sort_arr) ; $i++) {
		$cur_msg = $sort_arr[$i];
		$msg_header = $imap->msghdr($cur_msg);
		$dest_uid = $imap->msguid($msg_header->Msgno);
		if($msg_found) {
			$msg_nextid = $dest_uid;
			break;
		}
		if($dest_uid == $ID) {
			$msg_found++;
			continue;
		}
		$msg_previd = $dest_uid;
	}
    }

    // --
    if(empty($msg_detailed)) {
       if(empty($err_msg)) $err_msg = $lng->p(259);
       $msg_not_found = 1;
    }

    // print the information about the message
    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/menu.htx");
    include("$BSX_HTXDIR/readmsg.htx");
    include("$BSX_HTXDIR/footer.htx");
}

function push_msgprint() {
    global $RequestID;
    global $mbox, $sort, $lng, $ID;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_MDIR;
    global $BSX_VERSION;

    if(strtoupper($mbox) != "INBOX") $bsx_mbox = $BSX_MDIR . $mbox;
    else $bsx_mbox = "Inbox";

    // collect the information
    $msg_detailed = get_msg($bsx_mbox, $ID, $msg_no, $msg_atchlist);

    // print the information about the message
    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/printmsg.htx");
    echo "</body></html>\n";
    // include("$BSX_HTXDIR/footer.htx");
}

function push_msghdr() {
    global $RequestID;
    global $mbox, $lng, $ID;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_MDIR;
    global $BSX_VERSION;
    global $is_js, $is_ssl, $SESSID;

    if(strtoupper($mbox) != "INBOX") $bsx_mbox = $BSX_MDIR . $mbox;
    else $bsx_mbox = "Inbox";

    $msg_header = get_msghdr($bsx_mbox, $ID);

    // print the information about the message
    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/readmsg-header.htx");
    // include("$BSX_HTXDIR/footer.htx");
    echo "</body></html>\n";
}

function push_tocc($attr, $tocc) {
    global $lng;

    for($i = 0 ; $i < count($tocc) ; $i++) {
       if(!$i) {
          echo "<tr><td class=\"rmsghdr\" align=\"left\" width=\"10%\" nowrap>" . nbsp($attr) . "</td>";
       } else {
          echo "<tr><td class=\"rmsghdr\" align=\"left\" width=\"10%\" nowrap>&nbsp;</td>";
       }
       $tocc_obj = $tocc[$i];
       if(is_object($tocc_obj)) {
          $tocc_addr = $tocc_obj->mailbox . "@" . strtolower($tocc_obj->host);
          if(empty($tocc_obj->personal))
             $tocc_complete = $tocc_addr;
          else
             $tocc_complete = htmlspecialchars(decode_mime($tocc_obj->personal) . "  <$tocc_addr>");
       } else {
          $tocc_complete = $lng->p(7);
       }
       echo "<td class=\"rmsgval\" align=\"left\" width=\"80%\" nowrap>" . nbsp($tocc_complete) . "</td></tr>\n";
    }
}
?>

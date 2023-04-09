<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Compose message functions
// -----------------------------------------------------------------------


function push_compose_abook() {
    global $RequestID, $lng;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_VERSION;
    global $BSX_BASEHREF, $BSX_LAUNCHER;

    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/compose-abook.htx");
    include("$BSX_HTXDIR/footer.htx");
}

function push_compose() {
    global $customerID, $RequestID, $sql, $lng;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_VERSION;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $SESSID, $BODY_ONLOAD, $is_js, $is_ssl;
    global $abook_items, $abook_items_cnt;
    global $abook_grpitems, $abook_grpitems_cnt;
    global $err_msg, $info_msg;


    // --
    global $premail, $cmps_atchs;

    global $user_set;	// settings

    global $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc;
    global $cmps_subject, $cmps_body, $cmps_sign, $cmps_atchlist;

    global $cmps_f0, $cmps_f1, $cmps_f2; global $cmps_s0, $cmps_s1, $cmps_s2;
    global $cmps_c0, $cmps_c1, $cmps_c2;

    if(empty($cmps_from)) $cmps_from = $user_set["name"];

    if(empty($cmps_to))
       $BODY_ONLOAD="onLoad='document.composeMail.cmps_to.focus();'";

    $BODY_ONUNLOAD="onUnLoad='closeWins();'";

    $cwurl = $BSX_BASEHREF . "/" . $BSX_LAUNCHER . "?RequestID=CMPSCLNUP" . "&is_js=" . $is_js . "&is_ssl=" . $is_ssl;
    if($SESSID) $cwurl .= "&SESSID=" . $SESSID;

    if(empty($cmps_atchlist)) $cmps_atchlist = $lng->p(411);

    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/menu.htx");
    include("$BSX_HTXDIR/compose-new.htx");
    include("$BSX_HTXDIR/footer.htx");
}

function abook_fetch_field($abook_items, $id, $what) {
	global $abook_items_cnt;

	for($i = 0 ; $i < $abook_items_cnt ; $i++) {
		if($abook_items[$i]["id"] == $id) {
			return $abook_items[$i]["$what"];
		}
	}
}

function js_getmembers($memberlist, $abook_items) {
	global $abook_items_cnt;

	$rstr = "";
	$glue = "";
	$tmp_arr = explode(",", $memberlist);
	for($i = 0 ; $i < count($tmp_arr) ; $i++) {
		$idx = $tmp_arr[$i];
		$tmp_name = abook_fetch_field($abook_items, $idx, "name");
		$tmp_email = abook_fetch_field($abook_items, $idx, "email");
		if(empty($tmp_name)) $rstr .= $glue . $tmp_email;
		else $rstr .= $glue . "\"" . $tmp_name . "\" <" . $tmp_email . ">";
		$glue = ",";
	}
	return $rstr;
}

function js_getitems($tmp) {
	if(empty($tmp["name"])) return $tmp["email"];
	else return "\"" . $tmp["name"] . "\" <" . $tmp["email"] . ">";
}

function push_jsaddrs() {
	global $abook_items_cnt, $abook_grpitems_cnt;
	global $abook_items, $abook_grpitems;

	echo "<script language=\"JavaScript\"><!-- //\n";
	if($abook_items_cnt) {
		echo "var addrItems = new Array();\n";
		echo "var addrGrpItems = new Array();\n";
		for($i = 0 ; $i < $abook_items_cnt ; $i++) {
			$tmp_item = js_getitems($abook_items[$i]);
			echo "addrItems[" . $abook_items[$i]["id"] . "] = \"" . addslashes($tmp_item) . "\";\n";
		}
		for($i = 0 ; $i < $abook_grpitems_cnt ; $i++) {
			$tmp_members = js_getmembers($abook_grpitems[$i]["member"], $abook_items);
			echo "addrGrpItems[" . $abook_grpitems[$i]["id"] . "] = \"" . addslashes($tmp_members) . "\";\n";
		}
	}
	echo "// --></script>\n";
}

function compose_rmatchs($total_atchs) {
	global $atch_dir;

	$tmp_atchs = explode(chr(2), $total_atchs);
       	for($j = 0 ; $j < count($tmp_atchs) ; $j++) {
		$tmp_atchstr = $tmp_atchs[$j];
                $tmp_arr = explode(chr(3), $tmp_atchstr);
                $tmp_file = $tmp_arr[0];
		$tmp_filepath = $atch_dir . "/" . $tmp_file;
                if(empty($tmp_file) || !file_exists($tmp_filepath)) continue;
		$tmp_remove = "/bin/rm -f $tmp_filepath";
		@sexec($tmp_remove);
	}
}

function compose_rmpremail() {
	global $sql;
	global $premail;
	global $customerID;

	$sql->sendmsgs_del_premail($customerID, $premail);
}

function prepare_data($d) {
	$nd = ereg_replace("\r", "", $d);
	$nd = ereg_replace("\n", "\r\n", $nd);
	return $nd;
}

function generate_rcpt_header($myarr, $str, &$cmps_rcpts, &$msg_header, &$farr) {
	global $tmp_glue;
	
	for($j = 0 ; $j < count($myarr) ; $j++) {
		$tmp_rcpt_arr = $myarr[$j];
		$tmp_mbox = $tmp_rcpt_arr->mailbox;
		$tmp_host = $tmp_rcpt_arr->host;
		$tmp_name = $tmp_rcpt_arr->personal;
		if(empty($tmp_mbox) && empty($tmp_host)) continue;
		$tmp_email = $tmp_mbox . "@" . $tmp_host;
		$cmps_rcpts .= $tmp_glue . $tmp_email;
		$tmp_glue = " ";
	
		if(!empty($tmp_name)) {
			$tmp_rcpt = "\"" . $tmp_name . "\" <" . $tmp_email . ">";
		} else {
			$tmp_rcpt = $tmp_email;
		}

		$msg_header .= $str . ": " . $tmp_rcpt . "\r\n";
		$farr[] = $tmp_rcpt;
	}
}


function compose_sendmail() {
	global $BSX_ATTACH_DIR, $BSX_VERSION;
	global $BSX_BASEHREF, $BSX_LAUNCHER, $BSX_LIBDIR;
	global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_SENTMAIL;
	global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME, $BSX_MDIR;
	global $SESSID, $BODY_ONLOAD, $is_js, $is_ssl;
	
	global $BSX_USE_SENDMAIL, $BSX_SENDMAIL_PATH;

	global $customerID, $RequestID, $sql, $imap, $lng, $user_set;
	global $bsx_domains, $domain_name, $domain, $username, $password;

	global $info_msg, $err_msg;

	// --
	global $premail;

	global $cmps_from, $cmps_to, $cmps_cc, $cmps_bcc;
	global $cmps_subject, $cmps_body, $cmps_sign, $cmps_atchlist;

	include("$BSX_HTXDIR/header.htx");

	$total_atchs = load_atchs($customerID, $premail);

	// generate header
	$atch_dir = $BSX_ATTACH_DIR . "/" .  "$domain_name" . "/" . "$username";
	$msg_header = "";

	// in replyto
	if(!empty($cmps_fromMsgID)) 
	   $msg_header .= "In-Reply-To: $cmps_fromMsgID\r\n";

	// replyto 
	if(!empty($user_set["replyto"])) {
	   if(!empty($user_set["name"])) {
		$repto = "\"" . $user_set["name"] . "\" <" . $user_set["replyto"] . ">";
	   } else {
		$repto = $user_set["replyto"];
	   }
	} else {
	   if(!empty($user_set["name"])) {
		$repto = "\"" . $user_set["name"] . "\" <" . $username . "@" . $domain_name . ">";
	   } else {
		$repto = $username . "@" . $domain_name;
	   }
	}

	// from subject etc
	$cmps_from_email = $username . "@" . $domain_name;
	$msg_header .= "Message-ID: <BasiliX-" .$BSX_VERSION . "-" . uniqid(time()) . "@" . trim(`hostname --fqdn`) . ">\r\n";
	$msg_header .= "X-Mailer: BasiliX " . $BSX_VERSION . " -- http://basilix.org\r\n";
	$msg_header .= "X-SenderIP: " . $GLOBALS["REMOTE_ADDR"] . "\r\n";
	$msg_header .= "Date: " . date("D, d M Y H:i:s T", time()) . "\r\n";
	$msg_header .= "From: " . $cmps_from . " <" . $cmps_from_email . ">\r\n";
	$msg_header .= "Reply-To: " . $repto . "\r\n";
	$cmps_subject = empty($cmps_subject) ? "(no subject)" : $cmps_subject;
	$msg_header .= "Subject: " . $cmps_subject . "\r\n";


	// all recipients
	$cmps_rcpts = "";
	$tmp_glue = "";
	if(!empty($cmps_to)) {
		$cmps_to_arr = imap_rfc822_parse_adrlist($cmps_to, $domain_name);
		generate_rcpt_header($cmps_to_arr, "To", &$cmps_rcpts, &$msg_header, &$farr);
	}
	if(!empty($cmps_cc)) {
		$cmps_cc_arr = imap_rfc822_parse_adrlist($cmps_cc, $domain_name);
		generate_rcpt_header($cmps_cc_arr, "Cc", &$cmps_rcpts, &$msg_header, &$farr);
	}
	if(!empty($cmps_bcc)) {
		$cmps_bcc_arr = imap_rfc822_parse_adrlist($cmps_bcc, $domain_name);
		generate_rcpt_header($cmps_bcc_arr, "Bcc", &$cmps_rcpts, &$msg_header, &$farr);
	}

	$cmps_finalinfo = $farr;

	// include signature
	if($cmps_sign) $cmps_body .= "\r\n--  \r\n" . $user_set["sign"];

	// generate attachments
	$msg_boundary = md5(uniqid(time())) . "-" . time();
	$msg_body = "";

	if(!empty($total_atchs)) {
		$msg_header .= "MIME-Version: 1.0\r\n";
		$msg_header .= "Content-Type: multipart/mixed; boundary=\"" . $msg_boundary . "\"\r\n\r\n";
		$msg_header .= "--" . $msg_boundary . "\r\n";
		$msg_header .= "Content-Type: text/plain\r\n\r\n";
		$msg_header .= $cmps_body . "\r\n\r\n";

		$tmp_atchs = explode(chr(2), $total_atchs);
		$atched = 0;
        	for($j = 0 ; $j < count($tmp_atchs) ; $j++) {
	                $tmp_arr = explode(chr(3), $tmp_atchs[$j]);
	                $tmp_file = $tmp_arr[0];
			$tmp_content = $tmp_arr[1];
	                $tmp_size = $tmp_arr[2];
			$tmp_filepath = $atch_dir . "/" . $tmp_file;
	                if(empty($tmp_file) || !file_exists($tmp_filepath)) continue;
			$tmp_fp = fopen($tmp_filepath, "r");
			$tmp_filein = fread($tmp_fp, filesize($tmp_filepath));
			fclose($tmp_fp);
			$msg_header .= "--" . $msg_boundary . "\r\n";
			if(empty($tmp_content)) $tmp_content = "application/octet-stream";
			else $tmp_content = strtolower($tmp_content);
			$msg_header .= "Content-Type: " . $tmp_content . "\r\n";
			$tmp_filein = chunk_split(base64_encode($tmp_filein), 60);
			$msg_header .= "Content-Transfer-Encoding: base64\r\n";
			$msg_header .= "Content-Description: $tmp_file\r\n";
			$tmp_type = strtok($tmp_content, "/");
			if($tmp_type == "image") $tmp_disp = "inline";
			else $tmp_disp = "attachment";
			$msg_header .= "Content-Disposition: " . $tmp_disp . "; filename=\"" . $tmp_file . "\"\r\n\r\n";
			$msg_header .= $tmp_filein;
			$atched = 1;
		}
	}
	if($atched) {
		$msg_header .= "--" . $msg_boundary . "--\r\n";
	} else {
		$msg_body = "\r\n" . $cmps_body . "\r\n";
	}


	// prepare the datas
	$msg_header = prepare_data($msg_header);
	$msg_body = prepare_data($msg_body);
	$msg_body = trans_tr($msg_body);
	
	// log the sent mails to find the abusers or harassment e-mail senders quickly (just in case)
	// we log these:
	// 1 - date time
	// 2 - the IP address of the user
	// 3 - the name of the sender (e.g; Murat Arslan)
	// 4 - the email address of the sender (e.g; arslanm@basilix.org)
	// 5 - the subject of the email
	// 6 - the To part
	// 7 - the Cc part
	// 8 - the Bcc part
	// --
	$logfile = "/var/log/webmail/BASILIX_" . $domain_name;
	$fplog = @fopen($logfile, "a+");
	if($fplog) {
		$logbuf = date("d/m/Y H:i:s", time()) . "|" . $GLOBALS["REMOTE_ADDR"] . "|";
		$logbuf .= $cmps_from . "|";
		$logbuf .= $username . "@" . $domain_name . "|";
		$logbuf .= $cmps_subject . "|" . $cmps_to . "|" . $cmps_cc . "|" . $cmps_bcc;
		$logbuf .= "\n";
		fwrite($fplog, $logbuf);
		fclose($fplog);
	}
	// -- end of log

	// send the mail
	$ok_sent = false;
	// echo "CMPS_FROM: [$cmps_from_email]<Br>\n";
	// echo "CMPS_RCPTS: [$cmps_rcpts]<br>\n";
//	echo "MSG_HEADER: [$msg_header]<br>\n";
//	echo "MSG_BODY: [$msg_header]<br>\n";
//	echo $cmps_finalinfo;
//	$zzz = count($cmps_finalinfo);
//	echo "($zzz)<Br>\n";
//	for($i = 0 ; $i < count($cmps_finalinfo) ; $i++) {
//		echo "RCPT: [" . $cmps_finalinfo[$i] . "]<br>\n";
//	}
//	exit();
	if($BSX_USE_SENDMAIL && @is_executable($BSX_SENDMAIL_PATH)) {
		// use sendmail to send the mail
		$pmail = popen("$BSX_SENDMAIL_PATH -i -f$cmps_from_email -- $cmps_rcpts", "w");
		$prc = fputs($pmail, $msg_header . "\r\n");
		$prc += fputs($pmail, $msg_body);
		if(pclose($pmail) != 0) $prc = 0;
		else $ok_sent = true;
	}  else {
		// send it via SMTP
		require("$BSX_LIBDIR/smtp.class");
	
		$SMTP_HOST = $bsx_domains["$domain"]["smtp_host"];
		$smtp = new SMTP($SMTP_HOST);

		// debug
		// $smtp->togdebug();
	
		$rc = $smtp->connect();
		if(!rc) {
		   switch($rc) {
			case -4:
				err_exit($lng->p(455));
			case -5:
				err_exit($lng->p(456));
			default:
			err_exit($lng->p(457));
		    }
	        }
		$msg_rcpt = explode(" ", $cmps_rcpts);
		if(!($smtp->mailfrom("<" . $username . "@" . $domain_name . ">")
		   && $smtp->rcptall($msg_rcpt)
		   && $smtp->startdata()
		   && $smtp->senddata($msg_header)
		   && $smtp->senddata($msg_body)
		   && $smtp->stopdata()
		   && $smtp->disconnect())) {
			$msg_errno = $smtp->geterr(&$msg_error, &$msg_srverror);
			$err_msg = "SMTP Error $msg_errno:<br>";
			$err_msg .= "Error Message is: " . htmlspecialchars($msg_error) . "<br>";
			$err_msg .= "Server $SMTP_HOST replied: " . $msg_srverror . "<br>\n";
		} else {
			$ok_sent = true;
		}
	}

	// successfuly sent
	if($ok_sent == true) {
		compose_rmatchs($total_atchs);
		compose_rmpremail();	
		$info_msg = $lng->p(444);
			
		if($user_set["savesent"]) {
			// append to sent mail
			require("$BSX_LIBDIR/imap2.inc");
		        $imap->reopbox($BSX_SENTMAIL);
			$imap->apnd($BSX_SENTMAIL, $msg_header . "\r\n\r\n" . $msg_body);
		}
	}

	include("$BSX_HTXDIR/menu.htx");
	include("$BSX_HTXDIR/compose-finalinfo.htx");
	include("$BSX_HTXDIR/footer.htx");
}

function reply_data($d) {
	$d = "> " . $d;				// put a leading "> "
	$nd = ereg_replace("\r", "", $d);
	$nd = ereg_replace("\n", "\r\n> ", $nd);
	$nd = substr($nd, 0, strlen($nd) - 2);	// get rid of trailing "> "
	return $nd;
}

require("$BSX_LIBDIR/readmsg.inc");
function get_reply($what = 0) { // 0 (default) = reply, 1 = reply all, 2 = forward
    global $BSX_MDIR, $BSX_ATTACH_DIR, $BODY_ONLOAD, $ID, $mbox;
    global $cmps_to, $cmps_cc, $cmps_subject, $cmps_body;
    global $err_msg, $info_msg, $body_type;
    global $lng, $imap, $username, $domain_name;

    global $cmps_atchs;

    // --
    if(strtoupper($mbox) != "INBOX")
      if(!$imap->reopbox($BSX_MDIR . $mbox)) return;
    // -
    
    $mbox_info = $imap->mboxinfo();
    $msg_no = $imap->msgno($ID);
    if(!$msg_no) {
        $err_msg = $lng->p(445);
        return;
    }

    $msg_header = $imap->msghdr($msg_no);
    $msg_str = $imap->ftchstr($msg_no);

    $reply_obj = $msg_header->reply_to[0];

    if(is_object($reply_obj)) {
       $reply_addr = $reply_obj->mailbox . "@" . strtolower($reply_obj->host);
       if(empty($reply_obj->personal))
          $msg_from = $reply_addr;
       else
          $msg_from = decode_mime($reply_obj->personal) . " <$reply_addr>";
    } else {
       $msg_from = "";
    }

    // clean the "," for possible mistakes
    $cmps_to = ereg_replace(",", "", $msg_from);
    $my_addr = $username . "@" . strtolower($domain_name);
    $glue = ",";

	
    if($what == 1) { // replying to all
	// generate "to"
	for($i = 0 ; $i < count($msg_header->to) ; $i++) {
	    $to_obj = $msg_header->to[$i];
	    if(is_object($to_obj)) {
	       $to_addr = $to_obj->mailbox . "@" . strtolower($to_obj->host);
	       if($to_addr == $my_addr) continue;
	       if(empty($to_obj->personal))
		  $msg_to = $to_addr;
	       else
		  $msg_to = ereg_replace(",", "", decode_mime($to_obj->personal)) . " <$to_addr>";
	       $cmps_to .= $glue . $to_addr;
	    }
	}
	$cmps_cc = "";
	$glue = "";
	// and "cc"
	for($i = 0 ; $i < count($msg_header->cc) ; $i++) {
	    $cc_obj = $msg_header->cc[$i];
	    if(is_object($cc_obj)) {
	       $cc_addr = $cc_obj->mailbox . "@" . strtolower($cc_obj->host);
	       if($cc_addr == $my_addr) continue;
	       if(empty($cc_obj->personal))
		  $msg_cc = $cc_addr;
	       else
		  $msg_cc = ereg_replace(",", "", decode_mime($cc_obj->personal)) . " <$cc_addr>";
	       $cmps_cc .= $glue . $cc_addr;
	       $glue = ",";
	    }
	}
    }
    
    if($what == 2 && check_atch($msg_no) == true) { // get the attachments
        $atch_dir = $BSX_ATTACH_DIR . "/" .  "$domain_name" . "/" . "$username";
	$cmd = "/bin/mkdir -p $atch_dir";
	@sexec($cmd);

	$cmps_atchs = "";
	$glue = "";
        for($i = 0 ; $i <= count($msg_str->parts) ; $i++) {
		$tmp_type="";$tmp_subtype="";$tmp_file="";$tmp_filepath="";
   
		// attachment part
		if(!$i) {
		   $atch_part = $msg_str->parts[0];
		   if(!is_object($atch_part)) 
			$atch_part = $msg_str;
		} else {
		   $atch_part = $msg_str->parts[$i];
		}

		if(!is_object($atch_part)) continue;

		// content type
		$tmp_type = $body_type[$atch_part->type];
		$tmp_subtype = strtolower($atch_part->subtype);
		if(empty($tmp_subtype)) $tmp_subtype = "x-unknown";
		$tmp_content = $tmp_type . "/" . $tmp_subtype;

		if(empty($tmp_type)) {
		   switch($tmp_subtype) {
			case "html":
			case "plain":
			case "enriched":
			    $tmp_type = "text";
			    break;
			case "rfc822":
			case "delivery-status":
			    $tmp_type = "message";
			    break;
			default:
			$tmp_type = "application";
			    break;
		    }
		}
		// filename
		if($atch_part->ifparameters) {
		   while(list(, $atch_param) = each($atch_part->parameters)) {
			switch(strtolower($atch_param->attribute)) {
			    case "filename":
			    case "name":
				$tmp_file = $atch_param->value;
				break;
			}
		   }
		}
		if($atch_part->ifdparameters && empty($tmp_file)) {
		   while(list(, $atch_param) = each($atch_part->dparameters)) {
			switch(strtolower($atch_param->attribute)) {
			    case "filename":
			    case "name":
				$tmp_file = $atch_param->value;
				break;
			}
		   }
		}
		if(empty($tmp_file)) {
		    switch($tmp_subtype) {
			case "html":
				$tmp_file = "message.html";
				break;
                	case "rfc822":
                    		$tmp_file = "message.txt";
                    		break;
                	case "delivery-status":
                    		$tmp_file = "message.txt";
                    		break;
                	case "plain":
                    		$tmp_file = "message.txt";
                    		break;
                	case "enriched":
                    		$tmp_file = "message.rtf";
                    		break;
                	case "pgp-signature":
                    		$tmp_file = "pgp-signature.txt";
                    		break;
            	    }
    		}

		if(empty($tmp_file)) {
		   if(!$i) {
			$tmp_file = "msg$ID.txt";
			$tmp_content = "text/plain";
		   } else {
			$tt = time();
			$tmp_file = "unknown_file_$tt.dat";
			$tmp_content = "application/x-unknown";
		   }
		}

                $tmp_filepath = $atch_dir . "/" . $tmp_file;

		// the file itself
		$tmp_encoding = $atch_part->encoding;
		$tmp_encfunc = "enc_func" . $tmp_encoding;
		$atch_body = $imap->ftchbody($msg_no, $i + 1);
		$tmp_filein = $tmp_encfunc($atch_body);

		// ok copy and ready the file there
		$fp = fopen($tmp_filepath, "wb");
		if(!$fp) continue; // wtf?
		fwrite($fp, $tmp_filein);
		fclose($fp);
		$tmp_size = filesize($tmp_filepath);

		// finally set variables
		$cmps_atchs = $cmps_atchs . $glue . $tmp_file . chr(3) . $tmp_content . chr(3) . $tmp_size;
		$glue = chr(2);
	}
    }		  

    $msg_body = check_body($msg_no, $ID, $imap->ftchbody($msg_no, 1));
    $msg_date = date("d M Y H:i T", $msg_header->udate);
    $msg_subject = $msg_header->subject;
    $cmps_subject = decode_mime($msg_subject);

    if($what == 0 || $what == 1) {
        $lng->sb(446); $lng->sr("%d", $msg_date); $wrote_str = $lng->sp();
	if(strtolower(substr($cmps_subject, 0, 3)) != "re:")
		$cmps_subject = "Re: " . $cmps_subject;
        $cmps_body = $wrote_str . "\r\n\r\n" . reply_data($msg_body);

	$BODY_ONLOAD="onLoad='document.composeMail.cmps_body.focus();'";
    } else {
	$fwd_str = $lng->p(447);
	$lng->sb(448); $lng->sr("%d", $msg_date); $date_str = $lng->sp();
	$lng->sb(449); $lng->sr("%f", $msg_from); $from_str = $lng->sp();
	$lng->sb(450); $lng->sr("%s", $msg_subject); $subj_str = $lng->sp();
	if(strtolower(substr($cmps_subject, 0, 4)) != "fwd:")
		$cmps_subject = "Fwd: " . $cmps_subject;
        $cmps_body = $fwd_str . "\r\n" . $date_str . "\r\n" . $from_str . "\r\n" . $subj_str . "\r\n\r\n" . prepare_data($msg_body);

	// since we'll forward, empty the "To" part and focus
	$cmps_to = "";
	$BODY_ONLOAD="onLoad='document.composeMail.cmps_to.focus();'";
    }
}

function load_drafts($cid) {
	global $sql;
	return $sql->sendmsgs_load_drafts($cid);
}

function cmps_newmsg($cid) {
	global $sql;
	return $sql->sendmsgs_init($cid);
}

function load_details($cid, $pm) {
	global $sql;
	return $sql->sendmsgs_load_premail($cid, $pm);
}
function del_draft($cid, $pm) {
	global $sql, $atch_dir;

	$total_atchs = load_atchs($cid, $pm);
	compose_rmatchs($total_atchs);
	return $sql->sendmsgs_del_draft($cid, $pm);
}
function del_empty_drafts($cid) {
	global $sql;
	return $sql->sendmsgs_del_empty_drafts($cid);
}

function load_atchs($cid, $pm) {
	global $sql;
	return $sql->sendmsgs_load_atchs($cid, $pm);
}

function check_premail($cid, $pm) {
	global $sql;
	return $sql->sendmsgs_check_premail($cid, $pm);
}

function update_atchs($cid, $pm, $atchs) {
	global $sql;
	return $sql->sendmsgs_update_premail_atchs($cid, $pm, $atchs);
}

function update_premail($cid, $pm, $from, $to, $cc, $bcc, $subject, $body) {
	global $sql;
	return $sql->sendmsgs_update_premail($cid, $pm, $from, $to, $cc, $bcc, $subject, $body);
}

function is_already_attached($file, $filelist) { 
	$tmp_arr = explode(chr(2), $filelist);
	for($i = 0 ; $i < count($tmp_arr) ; $i++) {
		$tmp_arr2 = explode(chr(3), $tmp_arr[$i]);
		if($tmp_arr2[0] == $file) return true;
	}
	return false;
}
function remove_atchfile($before, $rmfile) {
	$after = "";
	$tmp_arr = explode(chr(2), $before);
	$glue = "";
	for($i = 0 ; $i < count($tmp_arr) ; $i++) {
		if(empty($tmp_arr[$i])) continue;
		$tmp_arr2 = explode(chr(3), $tmp_arr[$i]);
		$file = $tmp_arr2[0];
		$type = $tmp_arr2[1];
		$size = $tmp_arr2[2];
		if($file == $rmfile) continue;
		$after .= $glue . $file . chr(3) . $type . chr(3) . $size;
		$glue = chr(2);
	}
	return $after;
}

?>

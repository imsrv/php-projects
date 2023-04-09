<?
/////////////////////////////////////////////////////////
//	
//	source/compose2.php
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE:  source/compose.php
	PURPOSE:
		1.  Provide interface for creating messages
		2.  Provide interface for uploading attachments
		3.  Form MIME format (RFC822) compliant messages
		4.  Send message
		5.  Save to "sent items" folder if so specified
	PRE-CONDITIONS:
		$user - Session ID for session validation and user preference retreaval
	POST-CONDITIONS:
		Displays standard message composition interface by default
		If "upload" button pressed, displays all inputted text and attachment info
		If "send" button pressed, sends, files, and displays status
	COMMENTS:
	
********************************************************/

include("../include/super2global.inc");
include("../include/header_main.inc");
include("../lang/".$my_prefs["lang"]."compose.inc");
include("../lang/".$my_prefs["lang"]."dates.inc");
include("../include/icl.inc");
include("../include/version.inc");
include("../conf/defaults.inc");

/******* Init values *******/
if (!isset($attachments)) $attachments=0;

if (isset($change_contacts)) $show_contacts = $new_show_contacts;

//Handle ddresses submitted from contacts list 
//(in contacts window)
if (is_array($contact_to)) $to .= (empty($to)?"":", ").urldecode(implode(", ", $contact_to));
if (is_array($contact_cc)) $cc .= (empty($cc)?"":", ").urldecode(implode(", ", $contact_cc));
if (is_array($contact_bcc)) $bcc .= (empty($bcc)?"":", ").urldecode(implode(", ", $contact_bcc));
//(in compose window)
if ((isset($to_a)) && (is_array($to_a))){
    reset($to_a);
    while ( list($key, $val) = each($to_a)) $$to_a_field .= ($$to_a_field!=""?", ":"").stripslashes($val);
}

//generate authenticated email address
if (empty($init_from_address)){
	$sender_addr = $loginID.( strpos($loginID, "@")>0 ? "":"@".$host );
}else{
	$sender_addr = str_replace("%u", $loginID, str_replace("%h", $host, $init_from_address));
}

//generate user's name
$from_name = (empty($my_prefs["user_name"])?"":"\"".LangEncodeSubject($my_prefs["user_name"], $my_charset)."\" ");

if ($TRUST_USER_ADDRESS){
    //Honor User Address
    //If email address is specified in prefs, use that in the "From"
    //field, and set the Sender field to an authenticated address
    $from_addr = (empty($my_prefs["email_address"]) ? $sender_addr : $my_prefs["email_address"] );
    $from = $from_name."<".$from_addr.">";
    $reply_to = "";
}else{
    //Default
    //Set "From" to authenticated user address
    //Set "Reply-To" to user specified address (if any)
	$from_addr = $sender_addr;
    $from = $from_name."<".$sender_addr.">";
    if (!empty($my_prefs["email_address"])) $reply_to = $from_name."<".$my_prefs["email_address"].">";
    else $reply_to = "";
}
$original_from = $from;

if (isset($send)){
	$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if (!$conn)
		echo "failed";
	else{
		//echo "Composing...<br>\n"; flush();
		
		$error = "";
		
		/**** Check for subject ***/
        $no_subject = false;
		if ((strlen($subject)==0)&&(!$confirm_no_subject)){
            $error .= $composeErrors[0]."<br>\n";
            $no_subject = true;
        }
		
		/**** Check "from" ***/
		if (strlen($from)<7) $error .= $composeErrors[1]."<br>\n";
		
		/**** Check for recepient ***/
		$to = stripslashes($to);
		if ((strcasecmp($to, "self")==0) || (strcasecmp($to, "me")==0)) $to=$my_prefs["email_address"];
		if ((strlen($to) < 7) || (strpos($to, "@")===false))
			$error .= $composeErrors[2]."<br>\n";
			
		/**** Anti-Spam *****/
		$as_ok = true;
		//echo "lastSend: $lastSend <br> numSent: $numSent <br>\n";
		//echo "$max_rcpt_message $max_rcpt_session $min_send_interval <br>";
		if ((isset($max_rcpt_message)) && ((isset($max_rcpt_session))) && (isset($min_send_interval))){
			$num_recepients = substr_count($to.$cc.$bcc, "@");
			if ($num_recepients > $max_rcpt_message) $as_ok = false;
			if (($num_recepients + $numSent) > $max_rcpt_session) $as_ok = false;
			if ((time() - $lastSend) < $min_send_interval) $as_ok = false;
		}else{
			echo "Bypassing anti-spam<br>\n";
		}
		if (!$as_ok){
			$as_error = $composeErrors[5];
			$as_error = str_replace("%1", $max_rcpt_message, $as_error);
			$as_error = str_replace("%2", $max_rcpt_session, $as_error);
			$as_error = str_replace("%3", $min_send_interval, $as_error);
			$error .= $as_error;
		}
		/**********************/

		if ($error){
			//echo "<font color=\"red\">".$error."</font><br><br>\n";
		}else{
			//echo "<p>Sending....";
			//flush();
			
			$num_parts=0;
	
			/*** Initialize header ***/
			$headerx = "Date: ".TZDate($my_prefs["timezone"])."\n";
			$headerx.= "X-Mailer: IlohaMail/".$version." (On: ".$_SERVER["SERVER_NAME"].")\n";
			if (!empty($replyto_messageID)) $headerx.= "In-Reply-To: <".$replyto_messageID.">\n";
		
			/****  Attach Sig ****/
				
			if ($attach_sig==1) $message.="\n\n".$my_prefs["signature1"];
				
			/****  Encode if Japanese ****/
			$subject=stripslashes($subject);
			$message=stripslashes($message);
			$subject=LangEncodeSubject($subject, $my_charset);
			$part[0]=LangEncodeMessage($message, $my_charset);

			/***********************/
				
			/****  Pre-process addresses */
			$from = stripslashes($from);
			$to = stripslashes($to);
				
			$to = LangEncodeAddressList($to, $my_charset);
			$from = LangEncodeAddressList($from, $my_charset);
					
			if (!empty($cc)){
				$cc= stripslashes($cc);
				$cc = LangEncodeAddressList($cc, $my_charset);
			}
			if (!empty($bcc)){
				$bcc = stripslashes($bcc);
				$bcc = LangEncodeAddressList($bcc, $my_charset);
			}
			/***********************/

                    
			/****  Add Recipients *********/
			//$headerx.="Return-Path: ".$sender_addr."\n";
			$headerx.="From: ".$from."\n";
            //$headerx.="Sender: ".$sender_addr."\n";
			$headerx.="Bounce-To: ".$from."\n";
            $headerx.="Errors-To: ".$from."\n";
			if (!empty($reply_to)) $headerx.="Reply-To: ".stripslashes($reply_to)."\n";
			if ($cc){
				$headerx.="CC: ". stripslashes($cc)."\n";
			}
			if ($bcc){
				$headerx.="BCC: ".stripslashes($bcc)."\n";
			}
			/************************/
				
			/****  Prepare attachments *****/
			echo "Attachments: $attachments <br>\n";
			$attachment_size = 0;
			if ($attachments>0){
				for ($i=0;$i<$attachments;$i++){
					$var="attach_".$i;
					$a_attach=${$var};
					if ($a_attach==1){
						echo "Adding attachment $i <br>\n";
						$var="attachment_path_".$i;
						$a_path=${$var};
						
						if (file_exists($a_path)){
							echo "Attachment $i is good <br>\n";
							$num_parts++;
									
							$var="attachment_name_".$i;
							$a_name=${$var};
						
							$var="attachment_type_".$i;
							$a_type=${$var};
							$a_type=strtolower($a_type);
							if ($a_type=="") $a_type="application/octet-stream";								
								
							$part[$num_parts]["type"]="Content-Type: ".$a_type."; name=\"".$a_name."\"\r\n";
							$part[$num_parts]["disposition"]="Content-Disposition: attachment; filename=\"".$a_name."\"\r\n";
							$part[$num_parts]["encoding"]="Content-Transfer-Encoding: base64\r\n";
							$part[$num_parts]["size"] = filesize($a_path);
							$attachment_size += $part[$num_parts]["size"];
							$part[$num_parts]["path"] = $a_path;
						}
					} //if attach
				}
			}
			
			/**** Put together MIME message *****/
			echo "Num parts: $num_parts <br>\n";
			
			$headerx = "To: ".$to."\r\n".(!empty($subject)?"Subject: ".$subject."\r\n":"").$headerx;
			
			if ($num_parts==0){
				//simple message, just store as string
				$headerx.=$part[0]["type"];
				if (!empty($part[0]["encoding"])) $headerx.=$part[0]["encoding"];
				$body=$part[0]["data"];
				
				$message = $headerx."\r\n".$body;
				$is_file = false;
			}else{
				//for multipart message, we'll assemble it and dump it into a file
				
				//check for uploads directory
				$uploadDir = "../uploads/".$loginID.".".$host;
				echo "Uploads directory: $uploadDir <br>\n";
				if (is_dir($uploadDir)){
					$tempID = $loginID.time();
					$boundary="RWP_PART_".$tempID;
					

					$temp_file = $uploadDir."/".$tempID;
					echo "Temp file: $temp_file <br>\n";
					$temp_fp = fopen($temp_file, "w");
					if ($temp_fp){
						//setup header
						$headerx.="MIME-Version: 1.0 \r\n";
						$headerx.="Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"; 

						//write header to temp file
						fputs($temp_fp, $headerx."\r\n");
					
						//write main body
						fputs($temp_fp, "This message is in MIME format.\r\n");
			
						//loop through attachments
						for ($i=0;$i<=$num_parts;$i++){
							//write boundary
							fputs($temp_fp, "\r\n--".$boundary."\r\n");
							
							//form part header
							$part_header = "";
							if ($part[$i]["type"]!="") $part_header .= $part[$i]["type"];
							if ($part[$i]["encoding"]!="") $part_header .= $part[$i]["encoding"];
							if ($part[$i]["disposition"]!="") $part_header .= $part[$i]["disposition"];
							
							//write part header
							fputs($temp_fp, $part_header."\r\n");
								
							//open uploaded attachment
							$ul_fp = false;
							if ((!empty($part[$i]["path"])) && (file_exists($part[$i]["path"]))){
								$ul_fp = fopen($part[$i]["path"], "r");
							}
							if ($ul_fp){
								//read uploaded file
								while(!feof($ul_fp)){
									//read 57 bytes at a time
									$buffer = fread($ul_fp, 57);
									//base 64 encode and write (line len becomes 76 bytes)
									fputs($temp_fp, base64_encode($buffer)."\r\n");
								}
								fclose($ul_fp);
								unlink($part[$i]["path"]);
							}else if (!empty($part[$i]["data"])){
								//write message (part is not an attachment)
								fputs($temp_fp, $part[$i]["data"]."\r\n");
							}
						}
						
						//write closing boundary
						fputs($temp_fp, "\r\n--".$boundary."--");
						
						//close temp file
						fclose($temp_fp);
						
						$message = $temp_file;
						$is_file = true;
					}else{
						$error .= "Temp file could not be opened: $temp_file <br>\n";
					}
				}else{
					$error .= "Invlalid uploads directory<br>\n";
				}
			}


			/**** Send message *****/
			if (!empty($error)){
				echo $error;
				echo "</body></html>";
				exit;
			}
			
			
			include("../include/smtp.inc");
			
			//connect to SMTP server
			$smtp_conn = smtp_connect($SMTP_SERVER, "25");
			
			//generate list of recipients
			$recipients = $to.", ".$cc.", ".$bcc;
			$recipient_list = smtp_expand($recipients);
			
			//send!!
			if (smtp_mail($smtp_conn, $from_addr, $recipient_list, $message, $is_file)){
				echo "Sending...<br>"; flush();
				
				//save in send folder
				flush();
				if ($my_prefs["save_sent"]==1){
					if ($is_file) $saved = iil_C_AppendFromFile($conn, $my_prefs["sent_box_name"], $message);
					else $saved = iil_C_Append($conn, $my_prefs["sent_box_name"], $message);
					if (!$saved) echo "Couldn't save...<br>\n";
				}
				
				//delete temp file, if necessary
				if ($is_file) unlink($message);
				
				//if replying, flag original message
				if (isset($in_reply_to)) $reply_id = $in_reply_to;
				else if (isset($forward_of)) $reply_id = $forward_of;
				if (isset($reply_id)){
					$pos = strrpos($reply_id, ":");
					$reply_num = substr($reply_id, $pos+1);
					$reply_folder = substr($reply_id, 0, $pos);
					
					if (iil_C_Flag($conn, $reply_folder, $reply_num, "ANSWERED") < 1){
						echo "Flagging failed:".$conn->error;
					}
				}
				
				//update spam-prevention related records
				include("../include/as_update.inc");

				echo "<p>Message successfully sent.";
				echo "<script type=\"text/javascript\"><!--\nwindow.close();\n--></script>";
				echo "<br><br>"; flush();
			}else{
				echo "<p><font color=\"red\">Send FAILED</font><br>$smtp_errornum : ".nl2br($smtp_error);
			}

			iil_Close($conn); 
			exit;
		}
	iil_Close($conn);
	}
}

if ((isset($replyto)) || (isset($forward))){
    // if REPLY, or FORWARD
	if ((isset($folder))&&(isset($id))){
        include_once("../include/mime.inc");
        
		$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
		$header=iil_C_FetchHeader($conn, $folder, $id);
        $structure_str=iil_C_FetchStructureString($conn, $folder, $id);
        $structure=iml_GetRawStructureArray($structure_str);
		
		$subject=LangDecodeSubject($header->subject, $my_prefs["charset"]);
		$lookfor=(isset($replyto)?"Re:":"Fwd:");
		$pos = strpos ($subject, $lookfor);
        if ($pos===false) {
			$pos = strpos ($subject, strtoupper($lookfor));
        	if ($pos===false) {
				$subject=$lookfor." ".$subject;
			}
        }
		
		//get messageID
		$replyto_messageID = $header->messageID;
		
		//get "from";
		$from = $header->from;
		//replace to "reply-to" if specified
		if ($replyto){
			$to = $from;
			if (!empty($header->replyto)) $to = $header->replyto;
		}
		if ($replyto_all){
			if (!empty($header->to)) $to .= (empty($to)?"":", ").$header->to;
			if (!empty($header->cc)) $cc .= (empty($cc)?"":", ").$header->cc;
		}
		
		//mime decode "to," "cc," and "from" fields
		if (isset($to)){
			$to_a = LangParseAddressList($to);
			$to = "";
			while ( list($k, $v) = each($to_a) ){
                //remove user's own address from "to" list
                if ((stristr($to_a[$k]["address"], $from_addr) === false) and
 				    (stristr($to_a[$k]["address"], $loginID."@".$host) === false)){
                    $to .= (empty($to)?"":", ")."\"".LangDecodeSubject($to_a[$k]["name"], $my_prefs["charset"])."\" <".$to_a[$k]["address"].">";
                }
            }
		}
		if (isset($cc)){
			$cc_a = LangParseAddressList($cc);
			$cc = "";
			while ( list($k, $v) = each($cc_a) ){
                //remove user's own address from "cc" list
                if ((stristr($cc_a[$k]["address"], $from_addr) === false) and
 				    (stristr($cc_a[$k]["address"], $loginID."@".$host) === false)){
                    $cc .= (empty($cc)?"":", ")."\"".LangDecodeSubject($cc_a[$k]["name"], $my_prefs["charset"])."\" <".$cc_a[$k]["address"].">";
                }
            }
		}
		$from_a = LangParseAddressList($from);
		$from = "\"".LangDecodeSubject($from_a[0]["name"], $my_prefs["charset"])."\" <".$from_a[0]["address"].">";
		
		//format headers for reply/forward
		if (isset($replyto)){
			$message_head = $composeStrings[9];
			$message_head = str_replace("%d", LangFormatDate($header->timestamp, $lang_datetime["prevyears"]), $message_head);
			$message_head = str_replace("%s", $from, $message_head);
		}else if (isset($forward)){
			if ($show_header){
				$message_head = iil_C_FetchPartHeader($conn, $folder, $id, 0);
			}else{
				$message_head = $composeStrings[10];
				$message_head .= $composeHStrings[5].": ".ShowDate2($header->date,"","short")."\n";
				$message_head .= $composeHStrings[1].": ". LangDecodeSubject($from, $my_prefs["charset"])."\n";
				$message_head .= $composeHStrings[0].": ".LangDecodeSubject($header->subject, $my_prefs["charset"])."\n\n";
			}
		}
		if (!empty($message_head)) $message_head = "\n".$message_head."\n";
		
		//get message
        if (!empty($part)) $part.=".1";
        else{
            $part = iml_GetFirstTextPart($structure, "");
        }
        
		$message=iil_C_FetchPartBody($conn, $folder, $id, $part);
		if (empty($message)){
            $part = 0;
            $message = iil_C_FetchPartBody($conn, $folder, $id, $part);
		}
        
		//decode message if necessary
        $encoding=iml_GetPartEncodingCode($structure, $part);        
		if ($encoding==3) $message = base64_decode($message);
		else if ($encoding==4){
            if ($encoding == 3 ) $message = base64_decode($message);
            else if ($encoding == 4) $message = quoted_printable_decode($message);					
            //$message = str_replace("=\n", "\n", $message);
            //$message = quoted_printable_decode(str_replace("=\r\n", "\n", $message));
        }
		
        //add quote marks
		//$message = str_replace("\n", "\n", $message);
		$message=LangConvert($message, $my_prefs["charset"]);
		if (isset($replyto)) $message=">".str_replace("\n","\n>",$message);
		$message = "\n".LangConvert($message_head, $my_prefs["charset"]).$message;

		iil_Close($conn);			
	}
}
?>
<FORM ENCTYPE="multipart/form-data" ACTION="compose2.php" METHOD="POST">
	<input type="hidden" name="user" value="<?=$user?>">
	<input type="hidden" name="show_contacts" value="<?=$show_contacts?>">
	<?
        if ($no_subject) echo '<input type="hidden" name="confirm_no_subject" value="1">';
    
		if ($replyto){
			$in_reply_to = $folder.":".$id;
			echo "<input type=\"hidden\" name=\"in_reply_to\" value=\"$in_reply_to\">\n";
			echo "<input type=\"hidden\" name=\"replyto_messageID\" value=\"$replyto_messageID\">\n";
		}else if ($forward){
			$forward_of = $folder.":".$id;
			echo "<input type=\"hidden\" name=\"forward_of\" value=\"$forward_of\">\n";
		}
	?>
	
	<table border="0" width="100%">
	<tr>
		<td valign="bottom" align="left">
			<font size=+1><b><? echo $composeStrings[0]; ?></b></font>
			&nbsp;&nbsp;&nbsp;
			<font size="-1">[<a href="" onClick="window.close();"><?=$composeStrings[11]?></a>]</font>
		</td>
		<td valign="bottom" align="right">
						
		</td>
	</tr>
	</table>
    
    <?
    if (!empty($error)) echo '<br><font color="red">'.$error.'</font>';
    ?>
	
	<p><?=$composeHStrings[0]?>:<input type=text name="subject" value="<?=htmlspecialchars(stripslashes($subject))?>" size="60">
	<input type=submit name=send value="<?= $composeStrings[1]?>">
	<?
	
		$to = htmlspecialchars($to);
		$cc = htmlspecialchars($cc);
		$bcc = htmlspecialchars($bcc);
	
		// format sender's email address (i.e. "from" string)
        /*
		$email_address=$my_prefs["email_address"];
		if ($email_address=="") $email_address=$loginID."@".$host;
		if (!empty($my_prefs["user_name"])) 
			$email_address=htmlspecialchars("\"".$my_prefs["user_name"]."\" <".$email_address.">");
		*/
        $email_address = htmlspecialchars($original_from);
		echo "<table>";
		echo "<tr><td align=right>".$composeHStrings[1].":</td><td>$email_address</td></tr>\n";
  
		echo "<tr><td align=right valign=top>";
		if ($show_contacts){
			echo "<select name=\"to_a_field\">\n";
			echo "<option value=\"to\">".$composeHStrings[2].":\n";
			echo "<option value=\"cc\">".$composeHStrings[3].":\n";
			echo "<option value=\"bcc\">".$composeHStrings[4].":\n";
			echo "</select>\n";
		}
		echo"</td><td>";
		
		// display "select" box with contacts
		if ($show_contacts){
			include("../include/read_contacts.inc");
			if ((is_array($contacts)) && (count($contacts) > 0)){
				echo "<select name=\"to_a[]\" MULTIPLE SIZE=5>\n";
				while ( list($key, $foobar) = each($contacts) ){
					$contact = $contacts[$key];
					if (!empty($contact["email"])){
						$line = "\"".$contact["name"]."\" <".$contact["email"].">";
						echo "<option>".htmlspecialchars($line)."\n";
					}
					if (!empty($contact["email2"])){
						$line = "\"".$contact["name"]."\" <".$contact["email2"].">";
						echo "<option>".htmlspecialchars($line)."\n";
					}
				}
				echo "</select>"; 
				echo "<input type=\"submit\" name=\"add_contacts\" value=\"".$composeStrings[8]."\"><br>\n";
				echo "<input type=\"hidden\" name=\"new_show_contacts\" value=0>\n";
				echo "<input type=\"submit\" name=\"change_contacts\" value=\"".$composeStrings[6]."\">\n";
				//if (!empty($to)) echo "<input type=text name=\"to\" value=\"".stripslashes($to)."\" size=40>";
				echo "</td></tr>\n";
			}else{
				echo "<input type=\"hidden\" name=\"new_show_contacts\" value=0>\n";
				echo "<input type=\"submit\" name=\"change_contacts\" value=\"".$composeStrings[6]."\">\n";
				echo "</td></tr>\n";
			}
		}else{
			echo "<input type=\"hidden\" name=\"new_show_contacts\" value=1>\n";
			echo "<input type=\"submit\" name=\"change_contacts\" value=\"".$composeStrings[5]."\">\n";
			echo "</td></tr>\n";
		}
		
		// display cc and bcc boxes
		if (strlen($to) < 60)
            echo "<tr><td align=right>".$composeHStrings[2].":</td><td><input type=text name=\"to\" value=\"".stripslashes($to)."\" size=60></td></tr>\n";
        else
            echo "<tr><td align=right>".$composeHStrings[2].":</td><td><textarea name=\"to\" cols=\"60\" rows=\"3\">".stripslashes($to)."</textarea></td></tr>\n";

        if (strlen($cc) < 60)
            echo "<tr><td align=right>".$composeHStrings[3].":</td><td><input type=text name=\"cc\" value=\"".stripslashes($cc)."\" size=60></td></tr>\n";
        else
            echo "<tr><td align=right>".$composeHStrings[3].":</td><td><textarea name=\"cc\" cols=\"60\" rows=\"3\">".stripslashes($cc)."</textarea></td></tr>\n";

        if (strlen($bcc) < 60)
            echo "<tr><td align=right>".$composeHStrings[4].":</td><td><input type=text name=\"bcc\" value=\"".stripslashes($bcc)."\" size=60></td></tr>";
		else
            echo "<tr><td align=right>".$composeHStrings[4].":</td><td><textarea name=\"bcc\" cols=\"60\" rows=\"3\">".stripslashes($bcc)."</textarea></td></tr>";

        echo "</table>";
	?>
	<br><?=$composeStrings[7]?><br>
	<TEXTAREA NAME=message ROWS=20 COLS=77 WRAP=virtual><? echo htmlspecialchars(stripslashes($message)); ?></TEXTAREA>
	<br><input type=checkbox name="attach_sig" value=1 <? echo ($my_prefs["show_sig1"]==1?"CHECKED":""); ?> > 
		<? echo $composeStrings[3]; ?>
	<?
	if ($attachments>0){
		for ($i=0;$i<$attachments;$i++){
			$var="attachment_path_".$i;
			$a_path=${$var};
			$var="attach_".$i;
			$a_attach=${$var};
			$var="attachment_name_".$i;
			$a_name=${$var};
			$var="attachment_type_".$i;
			$a_type=${$var};
			$var="attachment_size_".$i;
			$a_size=${$var};
			echo "<br><input type=\"checkbox\" name=\"attach_$i\" value=1 ".($a_attach==1?"CHECKED":"").">".stripslashes($a_name).":".$a_size."Bytes,".$a_type."\n";
			echo "<input type=\"hidden\" name=\"attachment_path_$i\" value=\"".$a_path."\">\n";
			echo "<input type=\"hidden\" name=\"attachment_name_$i\" value=\"".stripslashes($a_name)."\">\n";
			echo "<input type=\"hidden\" name=\"attachment_type_$i\" value=\"".stripslashes($a_type)."\">\n";
			echo "<input type=\"hidden\" name=\"attachment_size_$i\" value=\"".stripslashes($a_size)."\">\n";
		}
	}
	if (isset($upload)){
		if (($userfile)&&($userfile!="none")){
			$i=$attachments;
			$newpath="../uploads/".$loginID.".".$host."/".$user."-".urlencode($userfile_name);
			if (copy($userfile, $newpath)){
				echo "<br><input type=\"checkbox\" name=\"attach_$i\" value=1 CHECKED>".stripslashes($userfile_name).":".$userfile_size."Bytes,".$userfile_type."\n";
				echo "<input type=\"hidden\" name=\"attachment_path_$i\" value=\"".$newpath."\">\n";
				echo "<input type=\"hidden\" name=\"attachment_name_$i\" value=\"".stripslashes($userfile_name)."\">\n";
				echo "<input type=\"hidden\" name=\"attachment_type_$i\" value=\"".stripslashes($userfile_type)."\">\n";
				echo "<input type=\"hidden\" name=\"attachment_size_$i\" value=\"".stripslashes($userfile_size)."\">\n";
				$attachments++;
			}else{
				echo $userfile_name." : ".$composeErrors[3];
			}
		}else{
			echo $composeErrors[4];
		}
	}
	?>
	<input type="hidden" name="attachments" value="<? echo $attachments; ?>">

	<br><? echo $composeStrings[4]; ?>: <INPUT NAME="userfile" TYPE="file">
	<INPUT TYPE="submit" NAME="upload" VALUE="<? echo $composeStrings[2]; ?>">
</form>
<?
?>
</BODY></HTML>

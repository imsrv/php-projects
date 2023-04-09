<?
/////////////////////////////////////////////////////////
//	
//	source/main.php
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
	FILE: source/main.php
	PURPOSE:
		1.  List specified number of messages in specified order from given folder.
		2.  Provide interface to read messages (link subjects to source/read_message.php)
		3.  Provide interface to send messasge to senders (link "From" field to source/compose.php)
		4.  Provide interface to move or delete messages
		5.  Provide interface to view messages not currently listed.
		6.  Provide functionality to move, delete messages and expunge folders.
	PRE-CONDITIONS:
		$user - Session ID
		$folder - Folder name
		[$sort_field] - Field to sort by {"subject", "from", "to", "size", "date"}
		[$sort_order] - Order, "ASC" or "DESC"
		[$start] - Show specified number of messages starting with this index

********************************************************/

$exec_start_time = microtime();

include("../include/super2global.inc");
include("../include/header_main.inc");
include("../include/ryosdates.inc");
include("../include/icl.inc");
include("../include/main.inc");

if (isset($folder)){
	include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
	include("../lang/".$my_prefs["lang"]."main.inc");
	include("../lang/".$my_prefs["lang"]."dates.inc");

	if (!isset($hideseen)) $hideseen=0;
	if (!isset($showdeleted)) $showdeleted=0;
	if (strcmp($folder, $my_prefs["trash_name"])==0) $showdeleted=1;
	
	$conn = iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if (!$conn)
		echo "Connection failed: $iil_error";
	else{
		echo "\n<!-- MODE: $AUTH_MODE USED:".$conn->message."-->\n";
		if (isset($submit)){
			$messages="";
			
			/* compose an IMAP message list string including all checked items */
			if (is_array($checkboxes)){
                $messages = implode(",", $checkboxes);
                $num_checked = count($checkboxes);
			}
			
			/* "Move to trash" is same as "Delete" */
			if (($submit=="File") && (strcmp($moveto, $my_prefs["trash_name"])==0)) $submit="Delete";
            
			/*  delete all */
			if ($delete_all == 2 ){
				$messages .= "1:".$delete_all_num;
			}
						
			/* delete items */
			if (($submit=="Delete")||(strcmp($submit,$mainStrings[10])==0)){
				if (iil_C_Delete($conn, $folder, $messages) > 0){	
                    if ($ICL_CAPABILITY["folders"]){
                        if (strcmp($folder, $my_prefs["trash_name"])!=0){
                            if (!empty($my_prefs["trash_name"])){
                                if (iil_C_Move($conn, $messages, $folder, $my_prefs["trash_name"]) >= 0){
                                    $report =  formatStatusString($num_checked, "", "delete");
                                }else{
                                    $report = $mainErrors[2].":".$messages;
                                }
                            }else{
                                $report = formatStatusString($num_checked, "", "delete")."<br>".$mainErrors[5];
                            }
                        }else{
                            $report = $mainErrors[3].":".$messages;
                        }
                    }else{
                        $report =  formatStatusString($num_checked, "", "delete");
                    }
				}
			}
			
			/*  move items */
			if (($submit=="File")||(strcmp($submit,$mainStrings[12])==0)){
				if (strcasecmp($folder, $my_prefs["trash_name"])==0){
					iil_C_Undelete($conn, $folder, $messages);
				}
				if (iil_C_Move($conn, $messages, $folder, $moveto) >= 0){
					$report = formatStatusString($num_checked, $moveto, "move");
					if (strcasecmp($folder, $my_prefs["trash_name"])==0){
						iil_C_Delete($conn, $folder, $messages);
					}
				}else{
					$report = $mainErrors[4];
				}
			}
			
			
			/* empty trash  command */
			if ((strcasecmp($submit, $mainStrings[11])==0) && ($expunge==1)){
				if (iil_C_Expunge($conn, $folder) < 0){
					echo $mainErrors[6]." (".$conn->error.")<br>\n";
				}
				//echo "<p>Expunged!!";
			}
	
			/* expunge non-trash folders automatically */
			if (strcasecmp($folder,$my_prefs["trash_name"])!=0){
				iil_C_Expunge($conn, $folder);
			}
			
			/* mark as unread */
			if ($submit=="Unread"){
				iil_C_Unseen($conn, $folder, $messages);
			}
		}
	
	/* If search results were moved or deleted, stop execution here. */
	if (isset($search_done)){
		echo "<p>Request completed.\n";
		echo "</body></html>";
		exit;
	}
	
	/* initialize sort field and sort order 
		(set to default prefernce values if not specified */
	
	if (empty($sort_field)) $sort_field=$my_prefs["sort_field"];
	if (empty($sort_order)) $sort_order=$my_prefs["sort_order"];

	
	/* figure out which/how many messages to fetch */
	if ((empty($start)) || (!isset($start))) $start = 0;
	$num_show=$my_prefs["view_max"];
	if ($num_show==0) $num_show=50;
	$next_start=$start+$num_show;
	$prev_start=$start-$num_show;
	if ($prev_start<0) $prev_start=0;
	//echo "<p>Start: $start";
	
	/* flush, so the browser can't start renderin and user sees some feedback */
	flush();

	/* retreive message list (search, or list all in folder) */
	if (!empty($search)){
		include("../lang/".$my_prefs["lang"]."search_errors.inc");
		$criteria="";
		$error="";
		$date = $month."/".$day."/".$year;
		// check criteria
		if ($date_operand=="ignore"){
			if ($field=="-"){
				$error=$searchErrors["field"];
			}
			if (empty($string)){
				$error=$searchErrors["empty"];
			}
		}else if ((empty($date))||($date=="mm/dd/yyyy")){
			$error=$searchErrors["date"];
		}
		if (!empty($date)){
			$date_a=explode("/", $date);
			$date=iil_FormatSearchDate($date_a[0], $date_a[1], $date_a[2]);
		}
		if ($error==""){
			// format search string
			$criteria="ALL";
			if ($field!="-") $criteria.=" $field \"$string\"";
			if ($date_operand!="ignore") $criteria.=" $date_operand $date";
			echo "Searching \"$criteria\" in $folder<br>\n"; flush();
			// search
			$messages_a=iil_C_Search($conn, $folder, $criteria);
			$total_num=count($messages_a);
			if (is_array($messages_a)) $messages_str=implode(",", $messages_a);
			else $messages_str="";
			echo "found: {".$messages_str."} <br>\n"; flush();
		}else{
			$headers=false;
		}
	}else{
		$total_num=iil_C_CountMessages($conn, $folder);
		if ($total_num > 0) $messages_str="1:".$total_num;
		else $messages_str="";
		$index_failed = false;		
	}
	
	/* if there are more messages than will be displayed,
	 		create an index array, sort, 
	 		then figure out which messages to fetch 
	*/
	if (($total_num - $num_show) > 0){
		$index_a=iil_C_FetchHeaderIndex($conn, $folder, $messages_str, $sort_field);
		if ($index_a===false){
			//echo "iil_C_FetchHeaderIndex failed<br>\n";
            if (strcasecmp($sort_field,"date")==0){
                if (strcasecmp($sort_order, "ASC")==0){
                    $messages_str = $start.":".($start + $num_show);
                }else{
                    $messages_str = ($total_num - $start - $num_show).":".($total_num - $start);
                }
                //echo $messages_str; flush();
                $index_failed = false;
            }else{
                $index_failed = true;
            }
		}else{
			if (strcasecmp($sort_order, "ASC")==0) asort($index_a);
			else if (strcasecmp($sort_order, "DESC")==0) arsort($index_a);
			
			reset($index_a);
			$i=0;
			while (list($key, $val) = each ($index_a)){
				if (($i >= $start) && ($i < $next_start)) $id_a[$i]=$key;
				$i++;
			}
			$messages_str=implode(",", $id_a);
		}
	}


	/* fetch headers */
	if ($messages_str!=""){
		//echo "Messages: $messages_str <br>\n";
		$headers=iil_C_FetchHeaders($conn, $folder, $messages_str);
		$headers=iil_SortHeaders($headers, $sort_field, $sort_order);  //if not from index array
	}else{
		$headers=false;
	}
	
	/* if indexing failed, we need to get messages within range */
	if ($index_failed){
		$i = 0;
		$new_header_a=array();
		reset($headers);
		while ( list($k, $h) = each($headers) ){
			if (($i >= $start) && ($i < $next_start)){
				$new_header_a[$k] = $headers[$k];
				//echo "<br>Showing $i : ".$h->id;
			}
			$i++;
		}
		$headers = $new_header_a;
	}
	
	/* Show folder name, num messages, page selection pop-up */
	
	if ($headers==false) $headers=array();
	echo "<table width=\"100%\"><tr>\n";
	echo "<td align=left valign=bottom>\n";
		$disp_folderName = $defaults[$folder];
		if (empty($disp_folderName)) $disp_folderName = $folder;
		if (empty($search)) echo "<h2><b>".urldecode($disp_folderName)."</b></h2>\n";
	echo " </td>";
	echo "<td align=\"right\" valign=\"bottom\">";
		if (strcasecmp("INBOX", $folder)==0)
			echo "<font size=\"-1\">[<a href=\"?user=$user&folder=$folder\">".$mainStrings[17]."</a>]</font>";
        if (strcmp($folder,$my_prefs["trash_name"])!=0)
            echo "<font size=\"-1\">[<a href=\"?user=$user&folder=$folder&delete_all=1\">".$mainStrings[18]."</a>]</font>";		
	echo "</td>\n";
	echo "</tr></table>";
	
	/* Confirm "delete all" request */
	if ($delete_all==1){
		echo "<p>".str_replace("%f", $folder, $mainErrors[7]);
		echo "<font size=\"-1\">[<a href=\"?user=$user&folder=$folder&delete_all=2&delete_all_num=$total_num&submit=Delete\">";
			echo $mainStrings[18]."</a>]</font>";
		echo "<font size=\"-1\">[<a href=\"?user=$user&folder=$folder\">".$mainStrings[19]."</a>]</font>";
	}
	
	
	/* Show error messages, and reports */
	if (!empty($error)) echo "<p><center><font color=red>$error</font></center>";
	if (!empty($report)) echo $report;
	if ((empty($error)) && (empty($report))) echo "<p>";


	$c_date["day"]=GetCurrentDay();
	$c_date["month"]=GetCurrentMonth();
	$c_date["year"]=GetCurrentYear();

	if (count($headers)>0) {
		if (!isset($start)) $start=0;
		$i=123;

		if (sizeof($headers)>0){			
			/*  show "To" field or "From" field? */
			if ($folder==$my_prefs["sent_box_name"]){
				$showto=true;
				$fromheading=$mainStrings[7];
			}else{
				$fromheading=$mainStrings[8];
			}			

			/*  start form */
			echo "\n<form name=\"messages\" method=\"POST\" action=\"main.php\">\n";			

			/*  if required, show page controls */

			$num_items=$total_num;
			echo "<table width=\"100%\"><tr>";
			echo "<td align=\"left\"><font size=-1>";

			echo str_replace("%p", ($num_show>$total_num?$total_num:$num_show), str_replace("%n", $total_num, $mainStrings[0]))."&nbsp;";
			
			echo "</font</td>";
			echo "<td align=right><font size=-1>";
			if ($num_items > $num_show){
				if ($prev_start < $start){
					echo "[<a href=\"main.php?user=$sid&folder=".urlencode($folder)."&sort_field=$sort_field&sort_order=$sort_order&start=$prev_start\">".$mainStrings[2]." $num_show".$mainStrings[3]."</a>]";
				}

				if ($next_start<$num_items){
					$num_next_str = $num_show;
					if (($num_items - $next_start) < $num_show) $num_next_str = $num_items - $next_start;
					echo "[<a href=\"main.php?user=$sid&folder=".urlencode($folder)."&sort_field=$sort_field&sort_order=$sort_order&start=$next_start\">".$mainStrings[4]." $num_next_str".$mainStrings[5]."</a>]";
				}
				//echo "</font></td>\n";

				//echo "<td align=right>\n";
				echo "<font size=-1>\n";
				echo "<select name=start>\n";
					$c=0;
					while ($c < $total_num){
						$c2=($c + $num_show);
						if ($c2 > $total_num) $c2=$total_num;
						echo "<option value=".$c.($c==$start?" SELECTED":"").">".($c+1)."-".$c2."\n";
						$c = $c + $num_show;
					}
				echo "</select>";
				echo "<input type=submit value=\"".$mainStrings[16]."\">";
				
				echo "</font>\n";
			}
			echo "</td>\n";
			echo "</tr></table>\n";



			/* main list */

			echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"1\"><tr>";
				$check_link="<SCRIPT type=\"text/javascript\" language=JavaScript1.2><!-- Make old browsers think this is a comment.\n";
				$check_link.="document.write(\"<a href=javascript:SelectAllMessages()><b>+</b>|<b>-</b></a>\")";
				$check_link.="\n--></SCRIPT><NOSCRIPT>";
				$check_link.="<a href=\"main.php?folder=".urlencode($folder)."&start=$start&user=$user&sort_field=$sort_field&sort_order=$sort_order&check_all=1\"><b>+</b></a>|";
 				$check_link.="<a href=\"main.php?folder=".urlencode($folder)."&start=$start&user=$user&sort_field=$sort_field&sort_order=$sort_order&uncheck_all=1\"><b>-</b></a>";
				$check_link.="</NOSCRIPT>";
				echo "\n<td>$check_link</td>";
				echo "\n<td>".FormFieldHeader($user, $folder, $start, "subject", $mainStrings[6], $sort_field, $sort_order, $textc)."</td>";
				if ($showto)
					echo "\n<td>".FormFieldHeader($user, $folder, $start, "to", $fromheading, $sort_field, $sort_order, $textc)."</td>";
				else
					echo "\n<td>".FormFieldHeader($user, $folder, $start, "from", $fromheading, $sort_field, $sort_order, $textc)."</td>";
				echo "\n<td>".FormFieldHeader($user, $folder, $start, "date", $mainStrings[9], $sort_field, $sort_order, $textc)."</td>";
				if ($my_prefs["show_size"])
					echo "\n<td>".FormFieldHeader($user, $folder, $start, "size", $mainStrings[14], $sort_field, $sort_order, $textc)."</td>";
				echo "<td></td>";
			echo "\n</tr>\n";
			$display_i=0;
			$prev_id = "";
			while (list ($key,$val) = each ($headers)) {
				//$next_id = $headers[key($headers)]->id;
				$header=$headers[$key];
				$id=$header->id;
				$seen=($header->seen?"Y":"N");
				$deleted=($header->deleted?"D":"");
				if ((($showdeleted==0)&&($deleted!="D")) || ($showdeleted)){
					if (($hideseen==0)||($seen=="N")){
						$display_i++;
						echo "<tr ".(($i % 2)==0?"bgcolor=\"$hilitec\"":"").">";
						echo "<td><input type=\"checkbox\" name=\"checkboxes[]\" value=\"$id\" ";
							if (isset($check_all)) echo "CHECKED";
							else if (!isset($uncheck_all)) echo (($spam) && (isSpam($header->Subject)>0) ? "CHECKED":"");
						echo "></td>";
						$subject=trim(chop($header->subject));
						if (empty($subject)) $subject=$mainStrings[15];
						echo "<td><a href=\"read_message.php?user=$user&folder=".urlencode($folder)."&id=$id&muid=".$header->uid."&num_msgs=$total_num\" ";
							echo ($my_prefs["view_inside"]!=1?"target=\"scr".$user.urlencode($folder).$id."\"":"").">".($seen=="N"?"<B>":"");
							echo LangDecodeSubject($subject, $my_prefs["charset"]).($seen=="N"?"</B>":"")."</a></td>";
						if ($showto) echo "<td>".LangDecodeAddressList($header->to, $my_prefs["charset"], $user)."</td>";
						else echo "<td>".LangDecodeAddressList($header->from, $my_prefs["charset"], $user)."</td>";
						$timestamp = $header->timestamp;
						$timestamp = $timestamp + ((int)$my_prefs["timezone"] * 3600);
						echo "<td><nobr>".ShowShortDate($timestamp, $lang_datetime)."&nbsp;</nobr></td>"; 
						if ($my_prefs["show_size"]==1) echo "<td><nobr>".ShowBytes($header->size)."</nobr></td>";
						echo "<td>".($header->deleted?"D":"").($header->answered?"A":"")."</td>";
						echo "</tr>\n";
					}
				}
				$i++;
			}
			echo "</table>";

			flush();
			
			echo "<input type=\"hidden\" name=\"user\" value=\"$user\">\n";
			echo "<input type=\"hidden\" name=\"folder\" value=\"$folder\">\n";
			echo "<input type=hidden name=\"sort_field\" value=\"".$sort_field."\">\n";
			echo "<input type=hidden name=\"sort_order\" value=\"".$sort_order."\">\n";
			if (isset($search)) echo "<input type=hidden name=search_done value=1>\n";
			echo "<input type=\"hidden\" name=\"max_messages\" value=\"".$display_i."\">\n";
			echo "<table width=\"100%\"><tr>";
			echo "<td>";
			if (strcmp($folder,$my_prefs["trash_name"])==0){
				echo "<input type=\"hidden\" name=\"expunge\" value=\"1\">\n";
				echo "<input type=\"submit\" name=\"submit\" value=\"".$mainStrings[11]."\">\n";
				//echo '[<a href="main.php?user='.$user.'&folder='.$folder.'&sort_field='.$sort_field.'&sort_order='.$sort_order.'&expunge=1">'.$mainStrings[11].'</a>]';
			}else{
				echo "<input type=\"submit\" name=\"submit\" value=\"".$mainStrings[10]."\">";
			}
			echo "</td><td align=\"right\">";
			if ($ICL_CAPABILITY["folders"]){
				echo "<select name=\"moveto\">";
				if (!is_array($folderlist))
					$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
				FolderOptions3($folderlist, $defaults);
				echo "</select>";
				echo "<input type=submit name=\"submit\" value=\"".$mainStrings[12]."\">";
			}
			echo "</td></tr></table>\n";
			echo "</form>\n";
			if (($folder=="INBOX")&&($ICL_CAPABILITY["radar"])){
				/*** THIS JavaScript code does NOT run reliably!! ***/
				echo "\n<script language=\"JavaScript\">\n";
				echo "if (parent.radar)";
				echo "  parent.radar.location=\"radar.php?user=".$user."\";\n";
				echo "</script>\n";
			}
		}else{
			if (!empty($search)) echo "<p><center>".$mainErrors[0]."</center>";
			else echo "<p><center>".$mainErrors[1]."</center>";
		}
	}else{
		if (!empty($search)) echo "<p><center>".$mainErrors[0]."</center>";
		else echo "<p><center>".$mainErrors[1]."</center>";
	}
	
	iil_Close($conn);
	}
}
$exec_finish_time = microtime();
echo '<!-- execution time: '.$exec_start_time.' ~ '.$exec_finish_time.' -->';
?>
</BODY></HTML>

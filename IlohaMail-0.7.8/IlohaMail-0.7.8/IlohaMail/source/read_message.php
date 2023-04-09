<?
/////////////////////////////////////////////////////////
//	
//	source/read_message.php
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
	FILE: source/read_message.php
	PURPOSE:
		1.  Display important message headers
		2.  Display message structure (i.e. attachments, multi-parts)
		3.  Display message body (text, images, etc)
		4.  Provide interfaces to delete/undelete or move messages
		5.  Provide interface to view/download message parts (i.e. attachments)
		6.  Provide interface to forward/reply to message
	PRE-CONDITIONS:
		$user - Session ID
		$folder - Folder in which message to open is in
		$id - Message ID (not UID)
		[$part] - IMAP (or MIME?) part code to view.
	COMMENTS:
		This message should interpret and display mime messages correctly.
		Since it is my goal to make this file as RFC822 compliant as possible, please
		notify me for any violations or errors.
		
********************************************************/

include("../include/super2global.inc");
include("../include/header_main.inc");
include("../include/icl.inc");
include("../include/mime.inc");

if (isset($folder)){
	$folder_ulr = urlencode($folder);
	$conn=iil_Connect($host, $loginID, $password, $AUTH_MODE);
	if (!$conn)
		echo "failed";
	else{
		$this_folder=$folder;

		$folder=$this_folder;
		
		if ($undelete){
			iil_C_Undelete($conn, $folder, $id);
		}
		if (isset($id)){
			if ($header){
			}else{
				include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
				
				include("../lang/".$my_prefs["lang"]."read_message.inc");
				include("../lang/".$my_prefs["lang"]."main.inc");
				
				
				//get message info
				$header = iil_C_FetchHeader($conn, $folder, $id);
				$structure_str=iil_C_FetchStructureString($conn, $folder, $id);
				echo "\n<!-- ".$structure_str."-->\n"; flush();
				$structure=iml_GetRawStructureArray($structure_str);
				$num_parts=iml_GetNumParts($structure, $part);
                				
                //flag as seen
                iil_C_Flag($conn, $folder, $id, "SEEN");
				
				echo "<table width=\"100%\" bgcolor=\"".$my_colors["main_hilite"]."\">\n";

				//show toolbar
				echo "<tr><td>\n";
				include("../include/read_message_tools.inc");
				echo "</td></tr><tr><td>\n";
				flush();
				
				
				//show header info
				echo "\n<b>".LangDecodeSubject($header->subject, $my_prefs["charset"])."</b><br><br>\n";
				echo "<table border=\"0\" width=\"100%\"><tr><td valign=\"top\">\n";
					echo "<b>".$mainStrings[9].":  </b>".$header->date."<br>\n"; 
					echo "<b>".$mainStrings[8].":  </b>".LangDecodeAddressList($header->from,  $my_prefs["charset"], $user)."<br>\n";
					echo "<b>".$mainStrings[7].": </b>".LangDecodeAddressList($header->to,  $my_prefs["charset"], $user)."<br>\n";
					if (!empty($header->cc)) echo "<b>CC: </b>".LangDecodeAddressList($header->cc,  $my_prefs["charset"], $user)."<br>\n";
					if (!empty($header->replyto)) echo "<b>Reply-To:  </b>".LangDecodeAddressList($header->replyto,  $my_prefs["charset"], $user)."<br>\n";
					echo  "<b>$rmStrings[10]: </b>".ShowBytes($header->size)."<br>\n";
				echo "</td><td valign=\"top\">\n";
					echo "<form method=\"POST\" action=\"main.php\">";
					echo "<input type=\"hidden\" name=\"user\" value=\"".$user."\">\n";
					echo "<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n";
					echo "<input type=\"hidden\" name=\"checkboxes[]\" value=\"".$id."\">\n";
					echo "<input type=\"hidden\" name=\"max_messages\" value=\"".($id+1)."\">\n";
					/********* Show Folders Menu *******/
					if ($ICL_CAPABILITY["folders"]){
						$folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
						echo "<select name=moveto>";
						FolderOptions3($folderlist, $defaults);
						echo "</select>";
						echo "<input type=submit name=\"submit\" value=\"".$rmStrings[5]."\">";
					}
					/************************/
					echo "</form>";
				echo "</td></tr></table>\n";
				

				
				//show attachments/parts
				if ($num_parts > 0){
					//echo "<b>".$rmStrings[6].": </b>\n";
					echo "<table size=100%><tr valign=top><tr>\n";
					echo "<td valign=\"top\"><b>".$rmStrings[6].": </b>\n";
					echo "<td valign=\"top\"><b>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>\n";
					$icons_a = array("text.gif", "multi.gif", "multi.gif", "application.gif", "music.gif", "image.gif", "movie.gif", "unknown.gif");

					for ($i=1;$i<=$num_parts;$i++){
						//get attachment info
						$code=$part.(empty($part)?"":".").$i;
						$type=iml_GetPartTypeCode($structure, $code);
						$name=iml_GetPartName($structure, $code);
						$typestring=iml_GetPartTypeString($structure,$code);
						$bytes=iml_GetPartSize($structure,$code);
						$encoding=iml_GetPartEncodingCode($structure, $code);
                        $disposition = iml_GetPartDisposition($structure, $code);
						
						//format href
						if ($type == 1) $href = "read_message.php?user=$user&folder=$folder_url&id=$id&part=".$code;
						else $href = "view.php?user=$user&folder=$folder_url&id=$id&part=".$code;
						
						//show icon, file name, size
						echo "<td align=\"center\">";
						echo "<a href=\"".$href."\" ".($type==1?"":"target=_blank").">";
						echo "<img src=\"images/".$icons_a[$type]."\" border=0><br>";
						echo "<font size=\"-1\">".LangConvert($name, $my_charset)."<br>[".ShowBytes($bytes)."]";
                        echo "<br>".$typestring."</font>";
						echo "</a>";
						echo "</td>\n";
                        if (($i % 4) == 0) echo "</tr><tr><td></td><td></td>";
					}
					echo "</tr></table>\n";
				}

				echo "</td></tr><tr><td>\n";
				
				echo "<table width=\"100%\" bgcolor=\"".$my_colors["main_bg"]."\"><tr><td>\n";

				/*** Show source/header links ***/
				echo "<table align=\"right\"><tr><td>";
				echo "<font size=\"-1\">";
				echo "[<a href=\"view.php?user=$user&folder=$folder_url&id=$id&source=1\" target=\"_blank\">".$rmStrings[9]."</a>]\n";
				echo "[<a href=\"view.php?user=$user&folder=$folder_url&id=$id&show_header=1\" target=\"_blank\">".$rmStrings[12]."</a>]\n";
				if ($report_spam_to){
					echo "[<a href=\"compose.php?user=$user&folder=$folder_url&forward=1&id=$id&show_header=1&to=".urlencode($report_spam_to);
					echo "\" target=\"_blank\">".$rmStrings[13]."</a>]\n";
				}
				echo "</font>";
				echo "</td></tr></table>";
				/***************/	
				

				
				$typeCode=iml_GetPartTypeCode($structure, $part);
				
				if ($typeCode==0){
					// major type is "TEXT"
					$typestring=iml_GetPartTypeString($structure, $part);
					list($type, $subtype) = explode("/", $typestring);
					
					if (strcasecmp($subtype, "HTML")==0){
						// type is "TEXT/HTML"
						if ($my_prefs["html_in_frame"]){
							$part = $structure->pathcode;
							include("../include/read_message_print.inc");
						}else{
							echo "<p>".$rmStrings[7];
							echo '<a href="view.php?user='.$user.'&folder='.$folder_url.'&id='.$id.'&part='.$structure->pathcode.'" target=_blank>'.$rmStrings[8].'</a>';
						}
					}else{
						// type "TEXT/PLAIN"
						include("../include/read_message_print.inc");
					}
				}else if ($typeCode==1){
					// multipart message
					$typestring=iml_GetPartTypeString($structure, $part);
					list($type, $subtype) = explode("/", $typestring);
					
                    $mode=0;
                    if ((strcasecmp($subtype, "mixed")==0) || (strcasecmp($subtype, "signed")==0) || (strcasecmp($subtype, "related")==0)){ 
						$mode=1;
					}else if (strcasecmp($subtype, "alternative")==0){
						$mode=2;
					}

					if ($mode > 0){
						$originalPart=$part;
						for ($i=1;$i<=$num_parts;$i++){
							//get part info
							$part=$originalPart.(empty($originalPart)?"":".").$i;
							$typestring=iml_GetPartTypeString($structure, $part);
							list($type, $subtype) = explode("/", $typestring);
							$typeCode=iml_GetPartTypeCode($structure, $part);
							$disposition=iml_GetPartDisposition($structure, $part);
							
							//if NOT attachemnt...
                            if (strcasecmp($disposition, "attachment")!=0){
                                if (($mode==1) && ($typeCode==0)){
                                    //if "mixed" and type is "text" then show
                                    include("../include/read_message_print.inc");
                                }else if (($mode==2)&&(strcasecmp($subtype, "plain")==0)){
                                    //if "alternative" and type is "text/plain" then show
                                    include("../include/read_message_print.inc");
                                }else if (($typeCode==5) && (strcasecmp($disposition, "inline")==0)){
                                    //if type is image and disposition is "inline" show
                                    echo "<img src=\"view.php?user=$user&folder=$folder_url&id=$id&part=".$part."\">";
                                }else if ($typeCode==1){
                                    $part = iml_GetFirstTextPart($structure, $part);
                                    include("../include/read_message_print.inc");
                                }
                            }else{
								if (($typeCode==5) && ($my_prefs["show_images_inline"])){
									echo "<img src=\"view.php?user=$user&folder=$folder_url&id=$id&part=".$part."\"><br>\n";
								}
							}
						}
					}else{
						//echo "<p>This is a multi-part MIME message.";
                        $part = iml_GetFirstTextPart($structure, "");
                        include("../include/read_message_print.inc");
					}
				}
				
			}
	
		}
		//echo "<center><blockquote><hr></blockquote></center>";
		echo "</td></tr></table>\n";
		echo "</td></tr><tr><td>\n";
	/********* Show Folders Menu *******/
					echo "<form method=\"POST\" action=\"main.php\">";
					echo "<input type=\"hidden\" name=\"user\" value=\"".$user."\">\n";
					echo "<input type=\"hidden\" name=\"folder\" value=\"".$folder."\">\n";
					echo "<input type=\"hidden\" name=\"checkboxes[]\" value=\"".$id."\">\n";
					echo "<input type=\"hidden\" name=\"max_messages\" value=\"".($id+1)."\">\n";
					/********* Show Folders Menu *******/
					if ($ICL_CAPABILITY["folders"]){
						echo "<select name=moveto>";
						FolderOptions3($folderlist, $defaults);
						echo "</select>";
						echo "<input type=submit name=\"submit\" value=\"".$rmStrings[5]."\">";
					}
					/************************/
					echo "</form>";
	/************************/
		echo "</td></tr></table>\n";
		iil_Close($conn);

	}
}


?>
</BODY></HTML>

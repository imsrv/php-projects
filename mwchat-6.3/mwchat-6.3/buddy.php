<?PHP
  require_once("./libs/requires.php"); require_once("$CONFIG[MWCHAT_Libs]/security.php"); TimeStamp($Username); $STATUS[Silentheader] = "true"; $MetaHeaders .= "  <META HTTP-EQUIV=\"Refresh\" CONTENT=\"$CONFIG[Chat_Refresh_Time] ; URL=buddy.php?Username=$Username&Sequence_Check=$Sequence_Check&Lang=$Lang&Resolution=$Resolution&Room=$Room\">\n"; $MetaHeaders .= "  <SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/JavaScript\">\n"; $MetaHeaders .= "    <!--\n"; $MetaHeaders .= "       if (window == top) top.location.href = 'index.php?Logout=$Username&Username=$Username&Lang=$Lang';\n"; $MetaHeaders .= "    //-->\n"; $MetaHeaders .= "  </SCRIPT>\n"; require_once("$CONFIG[MWCHAT_Libs]/header.php"); echo "  <U><FONT COLOR=\"$CONFIG[Color_Foreground]\" SIZE=\"-1\"><B>$LOCALE[BUDDY_Room_List]</B></FONT SIZE></U>(" . HelpLink('Buddylist', 1) . ")\n"; echo "  </CENTER>\n"; echo "  <TABLE BORDER=0 WIDTH=100%>\n"; echo "   <TR>\n"; echo "    <TD VALIGN=TOP ALIGN=CENTER>\n"; $rgRegdBuddies = array(); $rgLobby_SELECT = db_query(Validate(30), $CONN); while($rgLobby = db_fetch($rgLobby_SELECT)) { $rgRegdBuddies[$rgLobby[username]] = $rgLobby[registered]; } $rgIconBuddies = array(); $rgRegistered_SELECT = db_query(Validate(47), $CONN); while($rgIcons = db_fetch($rgRegistered_SELECT)) { $rgIconBuddies[$rgIcons[username]] = $rgIcons[icon]; } $rgAll_Buddy = array(); $rgUsers_SELECT = db_query(Validate(9), $CONN); while($rgUsers = db_fetch($rgUsers_SELECT)) { $rgAllUsers[$rgUsers[username]] = $rgUsers[username]; if ($rgUsers[room] != $Room) { continue; } array_push($rgAll_Buddy, $rgUsers[username]); $szBuddyTag = "$LOCALE[BUDDY_Online]"; $szRealUsername = $rgUsers[username]; if ($rgRegdBuddies[$szRealUsername] == "yes") { $rgUsers[username] = $rgUsers[username] . "+"; $szBuddyTag .= ", $LOCALE[BUDDY_Registered](+)"; } if ($rgUsers[operator] == "yes") { $rgUsers[username] = "@$rgUsers[username]"; $szBuddyTag .= ", $LOCALE[BUDDY_Operator](@)"; } if ($rgUsers[away] == "yes") { $szBColor = $CONFIG[Color_Away]; $szBuddyTag .= ", $LOCALE[BUDDY_Away]"; } else { $szBColor = $CONFIG[Color_RoomList]; } $rgAllDisplay[$szRealUsername] = "<A HREF=\"#\" TITLE='TITLEALT_TAG' ALT_='TITLEALT_TAG' OnClick=\"window.open('whois.php?Username=$Username&Sequence_Check=$Sequence_Check&Lang=$Lang&Resolution=$Resolution&Room=$Room&Query=$szRealUsername&Status=TITLEALT_Status', 'WHOIS$Username', 'width=600,height=460,scrollbars,resizable=no');\"><FONT COLOR=\"$szBColor\">$rgUsers[username]</FONT COLOR></A>"; if (!empty($rgIconBuddies[$szRealUsername]) and isset($rgIconBuddies[$szRealUsername])) { $rgAllDisplay[$szRealUsername] = "<IMG SRC='$CONFIG[MWCHAT_Images]/smiles/$rgIconBuddies[$szRealUsername]'>&nbsp;" . $rgAllDisplay[$szRealUsername]; } $rgAllDisplayTAGS[$szRealUsername] = "$szBuddyTag"; } if ($STATUS[Registered] == "yes") { $rgBuddy_SELECT = db_query(Validate(1000), $CONN); while($rgBuddies = db_fetch($rgBuddy_SELECT)) { if (!isset($rgAllUsers[$rgBuddies[buddy]])) { continue; } array_push($rgAll_Buddy, $rgBuddies[buddy]); if (isset($rgAllDisplay[$rgBuddies[buddy]])) { $rgAllDisplay[$rgBuddies[buddy]] = $rgAllDisplay[$rgBuddies[buddy]] . " *"; $rgAllDisplayTAGS[$rgBuddies[buddy]] = $rgAllDisplayTAGS[$rgBuddies[buddy]] . ", $LOCALE[BUDDY_Buddy](*)"; } else { $rgAllDisplay[$rgBuddies[buddy]] = "<A HREF=\"#\" TITLE='TITLEALT_TAG' ALT='TITLEALT_TAG'  OnClick=\"window.open('whois.php?Username=$Username&Sequence_Check=$Sequence_Check&Lang=$Lang&Resolution=$Resolution&Room=$Room&Query=$rgBuddies[buddy]&Status=TITLEALT_Status', 'WHOIS$Username', 'width=600,height=460,resizable=no');\"><FONT COLOR=\"$CONFIG[Color_BuddyList]\">$rgBuddies[buddy]</FONT COLOR></A> *"; $rgAllDisplayTAGS[$rgBuddies[buddy]] = "$LOCALE[BUDDY_Buddy](*)"; if (!empty($rgIconBuddies[$rgBuddies[buddy]]) and isset($rgIconBuddies[$rgBuddies[buddy]])) { $rgAllDisplay[$rgBuddies[buddy]] = "<IMG SRC='$CONFIG[MWCHAT_Images]/smiles/" . $rgIconBuddies[$rgBuddies[buddy]] . "'>&nbsp;" . $rgAllDisplay[$rgBuddies[buddy]]; } } } } $rgBuddyList = array_unique($rgAllDisplay); while (list($szBuddyIndex, $szBuddy) = each($rgBuddyList)) { reset($CONFIG[System_Admins]); while (list($szNull, $szAdmins) = each($CONFIG[System_Admins])) { $AdminEntries = explode(":", $szAdmins); $AdminEntries[0] = Clean_Variable("$AdminEntries[0]", "lowercase"); if ($AdminEntries[0] == $szBuddyIndex) { $szBuddy = "[$szBuddy]"; $rgAllDisplayTAGS[$szBuddyIndex] = $rgAllDisplayTAGS[$szBuddyIndex] . ", $LOCALE[BUDDY_Admin]([])"; } } if (preg_match("/\*$szBuddyIndex\*/", $STATUS[Ignored])) { $rgAllDisplayTAGS[$szBuddyIndex] = $rgAllDisplayTAGS[$szBuddyIndex] . ", $LOCALE[BUDDY_Ignored](---)"; $szBuddy = "<STRIKE>" . $szBuddy . "</STRIKE>"; } $szBuddy = ereg_replace("TITLEALT_TAG", $rgAllDisplayTAGS[$szBuddyIndex], $szBuddy); $rgAllDisplayTAGS[$szBuddyIndex] = rawurlencode($rgAllDisplayTAGS[$szBuddyIndex]); $szBuddy = ereg_replace("TITLEALT_Status", $rgAllDisplayTAGS[$szBuddyIndex], $szBuddy); if (preg_match("/\@/", $szBuddy)) { $szCompleteList = "    $szBuddy<BR>\n" . $szCompleteList; } else { $szCompleteList = $szCompleteList . "    $szBuddy<BR>\n"; } } echo "    $szCompleteList\n"; echo "    </TD>\n"; echo "   </TR>\n"; echo "  </TABLE>\n"; require_once("$CONFIG[MWCHAT_Libs]/footer.php"); ?>
<?PHP
  require_once("./libs/requires.php"); require_once("$CONFIG[MWCHAT_Libs]/security.php"); Update_TimeStamp($Username); $STATUS[Silentheader] = "true"; $MetaHeaders .= "  <SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/JavaScript\">\n"; $MetaHeaders .= "   <!--\n"; $MetaHeaders .= "    function scrolldown()\n"; $MetaHeaders .= "    {\n"; $MetaHeaders .= "        window.scroll(0,5000);\n"; $MetaHeaders .= "    }\n"; $MetaHeaders .= "   //-->\n"; $MetaHeaders .= "  </SCRIPT>\n"; $MetaHeaders .= "  <SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/JavaScript\">\n"; $MetaHeaders .= "    <!--\n"; $MetaHeaders .= "       if (window == top) top.location.href = 'index.php?Logout=$Username&Username=$Username&Lang=$Lang';\n"; $MetaHeaders .= "    //-->\n"; $MetaHeaders .= "  </SCRIPT>\n"; if ($BROWSER_AGENT == "OTHER") { $MetaHeaders .= "  <META HTTP-EQUIV=\"Refresh\" CONTENT=\"3 ; URL=window.php?Username=$Username&Sequence_Check=$Sequence_Check&Lang=$Lang&Resolution=$Resolution&Room=$Room\">\n"; } require_once("$CONFIG[MWCHAT_Libs]/header.php"); echo "  </CENTER>\n"; ob_end_flush(); flush(); $szLastMsg = "0"; $rgText_SELECT = db_query(Validate(4), $CONN); while($rgTexts = db_fetch($rgText_SELECT)) { if (preg_match("/\*$rgTexts[from_username]\*/", $STATUS[Ignored])) { continue; } $rgChatMsg = Encryption("decode", $rgTexts[message], $Username, $rgTexts[encrypt_vector]); include("$CONFIG[MWCHAT_Libs]/generate_from.php"); echo "$szMessageLine\n"; $szLastMsg = $rgTexts[id]; } echo "    <SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/JavaScript\">\n"; echo "      <!--\n"; echo "         scrolldown();\n"; echo "      //-->\n"; echo "    </SCRIPT>\n"; if ($BROWSER_AGENT != "OTHER") { require_once("$CONFIG[MWCHAT_Libs]/push.php"); } else { include("$CONFIG[MWCHAT_Libs]/process_task.php"); if ($CONFIG[Chat_Operator] == "true") { $rgUsers_SELECT = db_query(Validate(5), $CONN); $szOperators = db_numrows($rgUsers_SELECT); if ($szOperators == "0") { $rgUsers_SELECT = db_query(Validate(6), $CONN); while($rgOperators = db_fetch($rgUsers_SELECT)) { $rgUsers_UPDATE = db_query("UPDATE chat_users SET operator='yes' WHERE id='$rgOperators[id]'", $CONN); Post_System("$rgOperators[username] $LOCALE[COMMON_Operator]", "local", $Room); break; } } } if ($STATUS[Registered] == "yes" and $STATUS[Away] == "yes") { Update_TimeStamp($Username); } } require_once("$CONFIG[MWCHAT_Libs]/footer.php"); ?>

<?PHP
  require_once("./libs/requires.php"); require_once("./$CONFIG[MWCHAT_Libs]/db_open.php"); $STATUS[Silentheader] = "true"; $MetaHeaders .= "  <SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/JavaScript\">\n"; $MetaHeaders .= "    <!--\n"; $MetaHeaders .= "       if (window != top) top.location.href = 'license.php';\n"; $MetaHeaders .= "    //-->\n"; $MetaHeaders .= "  </SCRIPT>\n"; require_once("$CONFIG[MWCHAT_Libs]/header.php"); if ($Action == "GO") { ChatLog($LOCALE[LOG_License]); if ($KEY == "" or !$KEY) { Error("ERROR_NoData"); } $fcontents = file ("http://www.appindex.net/products/license/?SerialNumber=$KEY&product=mwchat&version=$CONFIG[System_Version]"); while (list ($szNull, $szLine) = each ($fcontents)) { $rgLicense = explode(":", $szLine); if ($rgLicense[0] == "Error") { $rgLicense[1] = trim($rgLicense[1]); Error($rgLicense[1]); break; } if (!$rgLicense[0] or !$rgLicense[1] or !$rgLicense[2] or !$rgLicense[3]) { continue; } $szLicenseT = $rgLicense[3]; if (!isset($szDeleteExiting)) { $rgLicense_DELETE = db_query("DELETE FROM chat_license", $CONN); } $rgLicense_INSERT = db_query("INSERT INTO chat_license VALUES(NULL, '$rgLicense[0]', '$rgLicense[1]', '$rgLicense[2]')", $CONN); $szDeleteExiting = "TRUE"; } $szTmpLocale = "LICENSE_Complete_" . trim($szLicenseT); $szMsg = $LOCALE[$szTmpLocale]; } else { $szMsg = $LOCALE[$ErrorMessage]; } echo "  <FORM NAME='License' ACTION=\"license.php?Action=GO\" AUTOCOMPLETE=\"OFF\" METHOD=POST>\n"; echo "  <H2>\n"; echo "    $LOCALE[LICENSE_Title]\n"; echo "  </H2>\n"; echo "  <HR>\n"; echo "  </CENTER>\n"; echo "  <B>$LOCALE[LICENSE_Info]</B><BR><br><I>$szMsg</I><BR><br>\n"; echo "  <B>$LOCALE[LICENSE_Key](" . HelpLink('Serial_Number') . "):</B> <INPUT TYPE='TEXT' NAME='KEY' TABINDEX='1' MAXLENGTH='200' SIZE='50' VALUE='$KEY'><BR><BR>\n"; echo "  <A HREF='http://www.appindex.net/products/upgrade/?product=mwchat&version=$CONFIG[System_Version]' TARGET=_MWChatUpgrade><U><B>$LOCALE[LICENSE_Upgrade]</B></U></A><BR>\n"; echo "<BR><TABLE>\n"; echo " <TR>\n"; echo "   <TD>\n"; echo "     <INPUT TYPE=SUBMIT VALUE=\"$LOCALE[LICENSE_Submit]\" TABINDEX='3'>\n"; echo "   </TD>\n"; echo "  </FORM> <FORM ACTION=\"index.php?Lang=$Lang\" METHOD=POST>\n"; echo "   <TD>\n"; echo "     <INPUT TYPE=SUBMIT VALUE=\"$LOCALE[LICENSE_LoginButton]\" TABINDEX='4'>\n"; echo "   </TD>\n"; echo " </TR>\n"; echo "</TABLE>\n"; echo "  <CENTER>\n"; require_once("$CONFIG[MWCHAT_Libs]/footer.php"); ?>

<?PHP
  if ($STATUS[Registered] == "yes") { $rgRegistered_DELETE = db_query(Validate(32), $CONN); $rgBuddy_DELETE = db_query(Validate(1009), $CONN); $rgLobby_UPDATE = db_query(Validate(1010), $CONN); if (is_dir("$CONFIG[System_Root]/$CONFIG[MWCHAT_Upload]/$Username")) { $szHandle = opendir("$CONFIG[System_Root]/$CONFIG[MWCHAT_Upload]/$Username"); while($szFile = readdir($szHandle)) { if ($szFile != "." && $szFile != "..") { unlink("$CONFIG[System_Root]/$CONFIG[MWCHAT_Upload]/$Username/$szFile"); } } closedir($szHandle); rmdir("$CONFIG[System_Root]/$CONFIG[MWCHAT_Upload]/$Username"); } $rgProcess_INSERT = db_query(Validate(34), $CONN); $rgProcess_INSERT = db_query(Validate(39), $CONN); $rgProcess_INSERT = db_query(Validate(40), $CONN); Post_System("<I>$Username $LOCALE[DIALOG_Unregistered]</I>", "syntax", $Room); } else { Post_System("<B>$LOCALE[DIALOG_Syntax_Error]</B> - /$rgMatches[1] $LOCALE[COMMON_Registered_Only]", "syntax", $Room); } ?>
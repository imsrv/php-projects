<?PHP
  function ChatLog($szLogMessage) { global $CONFIG; global $CONN; global $Username; if ($CONFIG[System_Log] == "true") { $szRemoteAddr = getenv('REMOTE_ADDR'); $szRemoteAgent = getenv('HTTP_USER_AGENT'); $szTimeStamp = date("F j, Y, g:i a"); require_once("./$CONFIG[MWCHAT_Libs]/db_open.php"); if ($Username == "") { $Username = "NULL"; } $INSERT_log = db_query("INSERT INTO chat_log VALUES(NULL, '$Username', '$szRemoteAddr', '$szRemoteAgent', '$szTimeStamp', '$szLogMessage')", $CONN); } return(TRUE); } ?>

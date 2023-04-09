<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: index.php3,v 1.7 2000/07/06 15:08:47 prenagha Exp $
# ---------------------------------------------------------------
# test for proper PHP config
if (!isset($HTTP_GET_VARS)) {
  $phpE = "<br>Turn on track_vars in your php or apache config file.";
}
if (get_magic_quotes_gpc() == 1) {
  $phpE .= "<br>Turn magic_quotes_gpc OFF in your php or apache config file.";
}
if (get_magic_quotes_runtime() == 1) {
  $phpE .= "<br>Turn magic_quotes_runtime OFF in your php or apache config file.";
}
if (!empty($phpE)) {
  print("<html><head><title>bookmarker PHP Configuration Error</title></head><body
bgcolor=white><h1>bookmarker PHP Configuration Error</h1><p><font color=red><strong>$phpE</strong></font></body></html>");
  exit;
}

function pop_login () {
 global $pop3, $auth, $error_msg, $count;

 # connect to the pop server
 if ( ! $pop3->connect($auth->auth["server"], $auth->auth["port"]) ) {
  $error_msg .= sprintf("Failed to connect to POP server %s on port %s.<br><small>%s</small>", $auth->auth["server"], $auth->auth["port"], $pop3->ERROR);
 }

 # login to the POP server
 $count = $pop3->apop($auth->auth["uname"], $auth->auth["passwd"]);
 if ( $count < 0 ) {
  $error_msg .= "Failed to login to POP server<br><small>$pop3->ERROR</small>";
 }
}

include(dirname(__FILE__)."/lib/poprepend.inc");
page_open(array( "sess" => "pop_sess",
                 "auth" => "pop_auth"));

pop_login();

$tpl->set_file(array(
 standard   => "common.standard.tpl",
 body       => "index.body.tpl",
 msg_list   => "index.msglist.tpl",
 msg         => "common.message.tpl",
 error_msg   => "common.error_message.tpl"
));

set_standard("list", &$tpl);

## Check if there was a submission
$relogin = false;
while ( is_array($HTTP_POST_VARS) 
     && list($key, $val) = each($HTTP_POST_VARS)) {
  if (eregi('delete_msg_([0-9]+)' ,$key, $match)) {
    $id = $match[1];
  ## delete selected msgs
  
# delete the message
    if ( $pop3->delete($id) ) {
      $msg .= sprintf("<br>Message %s deleted successfully.", $id);
      $relogin = true;
    } else {
      $error_msg .= "<br>Failed to delete message number $id. <br><small>$pop3->ERROR</small>";
    }

 }
}

if ($relogin) {
# need to close and re-open to refresh msg list?
  $pop3->quit();
  pop_login();
}

for ( $i = 1; $i <= $count; $i++ ){
# get the size of this message
  $size = $pop3->pop_list($i);
  
# get the headers and zero lines of body
  $body_lines = 0;
  $header_array = $pop3->top($i, $body_lines);
  $show_msg = TRUE;

# reset header variables
  $from = $subject = $date = "&nbsp;";

# loop through the headers and look for the stuff
# we are interested in...
  while ( list ($linenbr, $line) = each ($header_array) ) {

    if ( eregi ("^From:(.*)", $line, $match) ) {
      $from = trim ( $match[1] );

    } elseif ( eregi ("^Subject:(.*)", $line, $match) ) {
      $subject = trim ( $match[1] );
      
# skip pine generated internal messages      
      if ( ereg ("DON\'T DELETE THIS MESSAGE -- FOLDER INTERNAL DATA", $subject) ) {
        $show_msg = FALSE;
      }
    
    } elseif ( eregi ("^Date:(.*)", $line, $match) ) {
      $date = trim ( $match[1] );
    }
  } # for each line in the message header

  if ( $show_msg ) {
    $tpl->set_var(array(
      FORM_ACTION => $sess->self_url(),
      FROM        => $from,
      SUBJECT     => $subject,
      DATE        => $date,
      MSGNBR      => $i,
      MSGURL      => $sess->url("msg.php3?id=$i")
    ));

    $tpl->parse(MSG_LIST, "msg_list", TRUE);
  }

} # for each message

# assign messages if any found
if (isset ($error_msg)) {
  $tpl->set_var(ERROR_MSG_TEXT, $error_msg);
  $tpl->parse(ERROR_MSG, "error_msg");
}
if (isset ($msg)) {
  $tpl->set_var(MSG_TEXT, $msg);
  $tpl->parse(MSG, "msg");
}

$tpl->parse(BODY, "body");
$tpl->parse(MAIN, "standard");
$tpl->p(MAIN);
  
$pop3->quit();
page_close();
?>

<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: msg.php3,v 1.7 2000/07/06 15:08:47 prenagha Exp $
# ---------------------------------------------------------------
include(dirname(__FILE__)."/lib/poprepend.inc");
page_open(array( "sess" => "pop_sess",
                 "auth" => "pop_auth"));

# connect to the pop server
 # connect to the pop server
 if ( ! $pop3->connect($auth->auth["server"], $auth->auth["port"]) ) {
  $error_msg .= sprintf("Failed to connect to POP server %s on port %s.<br><small>%s</small>", $auth->auth["server"], $auth->auth["port"], $pop3->ERROR);
 }

 # login to the POP server
 $count = $pop3->apop($auth->auth["uname"], $auth->auth["passwd"]);
#if ( (!$count) or ($count == -1) ) {
 if ( $count < 0 ) {
  $error_msg .= "Failed to login to POP server<br><small>$pop3->ERROR</small>";
 }

$tpl->set_file(array(
 standard   => "common.standard.tpl",
 body       => "msg.body.tpl",
 msg_display => "msg.msgdisplay.tpl",
 msg        => "common.message.tpl",
 error_msg  => "common.error_message.tpl"
));

set_standard("message", &$tpl);

switch ($action) {
  ## delete message
  case "D":

# delete the message
    if ( $pop3->delete($id) ) {
      $msg .= "Message $id deleted successfully.";
#     reset the id var so that the message is NOT displayed below
      $id = 0;
    } else {
      $error_msg .= "Failed to delete message number $id. <br><small>$pop3->ERROR</small>";
    }

# reset the id var so that the message is NOT displayed below
  $id = 0;
  break;
  
  default:
  break;
}

# if we have an msg ID set, then display that
# message. Delete resets the msg ID after it has
# deleted the msg.
if ( $id > 0 ) {
# get the entire message
  $msg_array = $pop3->get($id);
  
# loop through the headers and look for the stuff
# we are interested in...
  $in_body = false;
  while ( list ($linenbr, $line) = each ($msg_array) ) {

    if ( (!$from) and (eregi ("^From:(.*)", $line, $match)) ) {
      $from = htmlentities(trim ( $match[1] ));

    } elseif ( (!$subject) and (eregi ("^Subject:(.*)", $line, $match)) ) {
      $subject = htmlentities(trim ( $match[1] ));
    
    } elseif ( (!$date) and (eregi ("^Date:(.*)", $line, $match)) ) {
      $date = htmlentities(trim ( $match[1] ));

    } elseif ( (!$cc) and (eregi ("^cc:(.*)", $line, $match)) ) {
      $cc = htmlentities(trim ( $match[1] ));

    } elseif ( (!$to) and (eregi ("^To:(.*)", $line, $match)) ) {
      $to = htmlentities(trim ( $match[1] ));

    } elseif ( eregi ("^\r", $line) ) {
      $in_body = true;

    } elseif ( $in_body ) {
      $body .= "<br>" . htmlentities($line);
    }
  } # for each line in the message header
  $space = "&nbsp;";
  if (empty($from)) $from = $space;
  if (empty($subject)) $subject = $space;
  if (empty($date)) $date = $space;
  if (empty($cc)) $cc = $space;
  if (empty($to)) $to = $space;

# replace URLs in the message body with HTML anchor tags
# Note that this regular expression allows for URL's to extend over more
# than one line (\n).  In some cases you might like to remove this
# capability since if the URL finishes exactly at the end of a line and 
# there are no spaces before the next word that word will be enabled.
  $body = eregi_replace(
    "(http|https|ftp)://([[:alnum:]/\n+-=%&:_.~?]+[#[:alnum:]+]*)",
    "<a href=\"\\1://\\2\" target=\"_blank\">\\1://\\2</a>",
    $body);

# replace email addresses in message body with anchor tags to 
# send.php3 page with the clicked address as the TO:
  $body = eregi_replace(
    "([\._a-z0-9-]+)@([\._a-z0-9-]+)",
    "<a href=\"send.php3?newto=\\1@\\2\" target=\"_blank\">\\1@\\2</a>",
    $body);

  $tpl->set_var(array(
    DEL_URL     => $sess->url("msg.php3?id=$id&action=D"),
    REPLY_URL   => $sess->url("send.php3?id=$id&action=R"),
    FWD_URL     => $sess->url("send.php3?id=$id&action=F"),
    FROM        => $from,
    TO          => $to,
    CC          => $cc,
    SUBJECT     => $subject,
    DATE        => $date,
    MSGNBR      => $id,
    MSGBODY     => $body
  ));
  $tpl->parse(MSG_DISPLAY, "msg_display");
  
} # if ID > 0


# close the POP session
$pop3->quit();

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
  
page_close();
?>

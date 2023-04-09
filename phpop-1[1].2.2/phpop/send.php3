<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: send.php3,v 1.11 2000/07/06 15:08:47 prenagha Exp $
# ---------------------------------------------------------------
include(dirname(__FILE__)."/lib/poprepend.inc");
page_open(array( "sess" => "pop_sess",
                 "auth" => "pop_auth"));

if ($phpop->allow_send_attachment) {
  $body_tpl = "send.mimebody.tpl";
} else {
  $body_tpl = "send.body.tpl";
}

$tpl->set_file(array(
 standard    => "common.standard.tpl",
 body        => $body_tpl,
 msg         => "common.message.tpl",
 error_msg   => "common.error_message.tpl"
));

set_standard("send", &$tpl);

# do we need to get the message
$get_msg = TRUE;

## Check if there was a submission
while ( is_array($HTTP_POST_VARS) 
     && list($key, $val) = each($HTTP_POST_VARS)) {
  switch ($key) {

  ## send the message
  case "phpop_send":
    $get_msg = FALSE;

    $email = new email_class;

		if (! $email->setFrom($from)) {
      $error_msg .= "<br>Missing or invalid from address.";
    }
		if (! $email->setTo($to)) {
      $error_msg .= "<br>Missing or invalid To address(es). Only the email address part is permitted (e.g. &quot;pop@linux.com&quot;, not &quot;Bob Smith &lt;pop@linux.com&gt;&quot)";
    }
		if (!empty($cc)) {
      if (! $email->setCC($cc)) {
        $error_msg .= "<br>Invalid CC address(es).";
      }
    }
		if (!empty($bcc)) {
      if (! $email->setCC($bcc)) {
        $error_msg .= "<br>Invalid BCC address(es).";
      }
    }
		if (! $email->setSubject($subject)) {
      $error_msg .= "<br>Missing Subject.";
    }
		if (! $email->setText($body)) {
      $error_msg .= "<br>Missing body.";
    }
#
# setAttachmentMaxSize
# in email.inc then check each one.
#
		if (!empty($phpop->site_headers)) {
      if (! $email->setAddlHdrs($phpop->site_headers)) {
        $error_msg .= "<br>Invalid additional headers.";
      }
    }
# stuping MSIE puts a "none" in the filename
		if ($attachment != "none"
    &&  !empty($attachment) 
    &&  $phpop->allow_send_attachment) {
      if (! $email->setAttachments($attachment, $attachment_name)) {
        $error_msg .= "<br>Invalid attachment.";
      }
    }

    if (isset ($error_msg)) {
		  break;
		}

    if ($email->send()) {
      $msg .= "<br>Message sent to $to.";
    } else {
      $error_msg .= "<BR>ERROR sending message to $to.";
    }

  break;

  ## reset the form
  case "phpop_reset":

  break;
  
  default:
  break;
 }
}


if ( $get_msg ) {
  $from = sprintf("%s@%s", $auth->auth["uname"], $auth->auth["server"]);

  unset ($body);
  unset ($msg_from);
  unset ($reply_to);
  unset ($sender);
  unset ($to);
  unset ($subject);
  unset ($cc);
  
  if ( $id > 0 ) {
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

# get the entire message
    $msg_array = $pop3->get($id);
	
# loop through the headers and look for the stuff
# we are interested in...
	
    $in_body = false;
    while ( list ($linenbr, $line) = each ($msg_array) ) {

      if ( (!$msg_from) and (ereg ("@", $line)) and (eregi ("^From:(.*)", $line, $match)) ) {
		    $msg_from = htmlentities(trim ( $match[1] ));

		  } elseif ( (!$reply_to) and (ereg ("@", $line)) and (eregi ("^Reply-To:(.*)", $line, $match)) ) {
		    $reply_to = htmlentities(trim ( $match[1] ));

		  } elseif ( (!$sender) and (ereg ("@", $line)) and (eregi ("^Sender:(.*)", $line, $match)) ) {
		    $sender = htmlentities(trim ( $match[1] ));

		  } elseif ( (!$subject) and (eregi ("^Subject:(.*)", $line, $match)) ) {

		    # if replying, then put RE: at the begining of the subject
			  if ( $action == "R" ) {
		      $subject = "RE: " . htmlentities(trim ( $match[1] ));
			  } else {
		      $subject = "FW: " . htmlentities(trim ( $match[1] ));
			  }
		
		  } elseif ( eregi ("^\r", $line) ) {

		    # if forward then add two blank lines, then a fwd line
			  if ( ($action == "F") and (!$in_body) ) {
		      $body .= "\n\n----- Forwarded Message ------\n";
			  $body .= "From: $msg_from\n";
        }

		    $in_body = true;
			 
		  } elseif ( $in_body ) {
		
		    # if replying, then put a ">" before each line
			  if ( $action == "R" ) {
		      $body .= "&gt;" . htmlentities($line);
			  } else {
		      $body .= htmlentities($line);
			  }
		  }
    } # for each line in the message header

  # to is first found of reply-to, from, sender headers
    if ( $action == "F" ) {
	    $to = "";
    } elseif ( $reply_to ) {
	    $to = $reply_to;
	  } elseif ( $msg_from ) {
	    $to = $msg_from;
	  } elseif ( $sender ) {
	    $to = $sender;
	  } else {
	    $to = "";
		  $msg .= "<br>No return address found in message headers!";
	  }
    if (!empty($to)) {
      if (eregi("([\._a-z0-9-]+)@([\._a-z0-9-]+)", $to, $match)) {
        $to = $match[1] . "@" . $match[2];
      } else {
        $msg .= "<br>Unable to parse return address";
      }
    }

  # close the POP session
  $pop3->quit();

  } else {
# if we get here we are in NEW mode
# nothing to do since all fields except from are blank
# except set the TO if passed in URL as ...?newto=pad@jkfdsjk.com
    $to = $newto;
  } # id > 0
} # if get msg

$tpl->set_var(array(
  FORM_ACTION => $sess->self_url(),
  FROM        => $from,
  CC          => $cc,
  TO          => $to,
  SUBJECT     => $subject,
  MSGBODY     => $body
));

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

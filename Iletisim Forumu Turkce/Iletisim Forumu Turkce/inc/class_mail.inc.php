<?php


class mailClass {

                 //-------------------------
                 //FUNCTION: MAILCLASS()
                 //Constructor
                 //-------------------------

                 function mailClass($name,$email,$subject,$comments)
                 {
                      $this->name      = $name;
                      $this->email     = $email;
                      $this->subject   = $subject;
                      $this->comments  = $comments;
                 }

                 //----------------------------
                 //FUNCTION: IS_NAME_VALID()
                 //Checks Name Field
                 //----------------------------

                 function is_name_valid()
                 {
                      if ($this->name=="")
                      {
                           return true;
                      }
                      else
                      {
                           return false;
                      }
                 }

                 //----------------------------
                 //FUNCTION: IS_EMAIL_VALID()
                 //Checks E-Mail Field
                 //----------------------------

                 function is_email_valid()
                 {
                      if (!eregi("^([a-z]|[0-9]|\.|-|_)+@([a-z]|[0-9]|\.|-|_)+\.([a-z]|[0-9]){2,4}$", $this->email))
                      {
                           return true;
                      }
                      else
                      {
                           return false;
                      }
                 }

                 //-----------------------------
                 //FUNCTION: IS_SUBJECT_VALID
                 //Checks Subject Field
                 //-----------------------------

                 function is_subject_valid()
                 {
                      if ($this->subject=="")
                      {
                           return true;
                      }
                      else
                      {
                           return false;
                      }
                 }

                 //------------------------------
                 //FUNCTION: IS_COMMENTS_VALID()
                 //Checks Comments Field
                 //------------------------------

                 function is_comments_valid()
                 {
                      if ($this->comments=="")
                      {
                           return true;
                      }
                      else
                      {
                           return false;
                      }
                 }

                 //------------------------------
                 //FUNCTION: IS_EMAIL_BANNED()
                 //Checks if email is banned
                 //------------------------------

                 function is_email_banned($email=array())
                 {
                      if (in_array($this->email, $email))
                      {
                           return true;
                      }
                      else
                      {
                           return false;
                      }
                 }

                 //-------------------------
                 //FUNCTION: TIDY_UP()
                 //Code tidy up
                 //-------------------------

                 function tidy_up()
                 {
                      if (get_magic_quotes_gpc())
                      {
                           $this->name      = stripslashes($this->name);
                           $this->subject   = stripslashes($this->subject);
                           $this->comments  = stripslashes($this->comments);
                      }
                 }

                 //------------------------------
                 //FUNCTION: REPLACE_TAGS()
                 //Replaces email message tags
                 //------------------------------

                 function replace_tags($tags)
                 {
                      $tags  = str_replace("{NAME}", $this->name, $tags);
                      $tags  = str_replace("{EMAIL}", $this->email, $tags);
                      $tags  = str_replace("{SUBJECT}", $this->subject, $tags);
                      $tags  = str_replace("{COMMENTS}", $this->comments, $tags);
                      $tags  = str_replace("{DATE}", date("j F Y"), $tags);

                      return $tags;
                 }

                 //-----------------------------------
                 //FUNCTION: EMAIL_MESSAGE()
                 //Reads email message and formats
                 //-----------------------------------

                 function email_message($txt)
                 {
                      $email_string = @file_get_contents('templates/email/' . $txt);

                      if ($email_string)
                      {
                           $this->tidy_up();
                           $send_string = $this->replace_tags($email_string);

                           return $send_string;
                      }
                      else
                      {
                           die("An error occured opening the <b>'$txt'</b> file. Check that this file exists in the 'templates/email' folder!");
                      }
                 }

                 //-------------------------
                 //FUNCTION: SHOW_ERROR()
                 //Displays error page
                 //-------------------------

                 function show_error($tempclass,$charset,$error,$error_string=array(),$return)
                 {
                      $tempclass->assign('CHARSET', $charset);
                      $tempclass->assign('ERROR', $error);

                      foreach($error_string as $stop)
                      {
                           $assign_error .= $stop . "<br>\n";
                      }

                      $tempclass->assign('ERRORSTRING', $assign_error);
                      $tempclass->assign('RETURN', $return);
                      $tempclass->display('templates/error.tpl.php');

                      return $tempclass;
                 }

                 //-----------------------------
                 //FUNCTION: SHOW_THANK_YOU()
                 //Displays thank you page
                 //-----------------------------

                 function show_thank_you($tempclass,$charset,$thanks,$thanksmessage,$continue)
                 {
                      $tempclass->assign('CHARSET', $charset);
                      $tempclass->assign('THANKYOU', $thanks);
                      $tempclass->assign('THANKYOUMESSAGE', $thanksmessage);
                      $tempclass->assign('CLICKHERE', $continue);
                      $tempclass->display('templates/thanks.tpl.php');

                      return $tempclass;
                 }

                 //---------------------------
                 //FUNCTION: MAIL_HEADERS()
                 //Displays Mail headers
                 //---------------------------

                 function mail_headers($name,$email)
                 {
                      $headers = "From: $name<" . $email . ">\n";
                      $headers .= "X-Sender: $name<" . $email . ">\n";
                      $headers .= "X-Mailer: PHP\n";
                      $headers .= "X-Priority: 3\n";
                      $headers .= "X-Sender-IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
                      $headers .= "Return-Path: $name<" . $email . ">\n";
                      $headers .= "Reply-To: $name<" . $email . ">\n";

                      return $headers;
                 }

                 //----------------------------------
                 //FUNCTION: SEND_WEBMASTER_MAIL()
                 //Send message to webmaster
                 //----------------------------------

                 function send_webmaster_mail($email)
                 {
                      if (get_magic_quotes_gpc())
                      {
                           $this->subject = stripslashes($this->subject);
                      }

                      mail($email, $this->subject, $this->email_message('webmaster.txt'), $this->mail_headers($this->name,$this->email));
                 }

                 //---------------------------------
                 //FUNCTION: SEND_VISITOR_MAIL()
                 //Send message to visitor
                 //---------------------------------

                 function send_visitor_mail($site,$email,$subject)
                 {
                      mail($this->email, $subject, $this->email_message('auto_responder.txt'), $this->mail_headers($site,$email));
                 }
}

?>
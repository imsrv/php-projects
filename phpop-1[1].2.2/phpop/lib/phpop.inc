<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: phpop.inc,v 1.15 2000/05/13 21:28:35 prenagha Exp $
# ---------------------------------------------------------------
class phpop_class {
  var $version        = "1.2.2";

#------------
# mail servers that are displayed on the login page.

# -to allow any server (an open text field), set this to FALSE.
#  var $login_servers = false;

# -to allow one server (a closed text field), set this to the server name.
   var $login_servers = array ("renaghan.com");

# -to allow more than one server (a select control), set this
#  to the names of the servers. the first server in the array
#  becomes the default.
#  var $login_servers = array ("mail.domain.com", "mail2.domain.com");
#------------


#------------
# pop port to default login to.

# if you don't want to present the port option on the login
# page, but still want to show the port on the login, 
# then set this to false. this will force the port to 110.
#  var $login_port = false;

# if you don't want to present the port option on the login
# page, but DO want to show the port on the login,
# then set this to -1. this will force the port to 110.
  var $login_port = -1;

# if you want to give the user an open text field to enter
# the port number in during login, then enter the port to
# default the textfield to here - usually 110.
#  var $login_port = 110;
#------------

# allow sending up to ONE file attachment in a message?
  var $allow_send_attachment = true;

# image URL - string added to the begining of an image file
# (for example, I set this to "../images/" which makes phpop
# build image URLs like <img src="../images/mailto.gif"...)
  var $image_url_prefix = "./images/";

# determine if the FastTemplate intepretation is strict or
# not strict. Strict shows the {VAR_NAME} in the output HTML
# if a value is not substituted - this is useful for debugging
# and testing
  var $FastTemplate_strict = FALSE;

# class constructor
  function phpop_class () {
    global $SERVER_NAME, $REMOTE_ADDR;

  # this var controls the headers that are added to the mail-this-link
  # email message. You may choose to bcc: yourself, record the senders IP...
  # the headers should be separated by a newline ("\n")
    $this->site_headers = sprintf("X-Sender: phpop at %s\nX-Sender-IP: %s"
                                ,$SERVER_NAME, $REMOTE_ADDR);
  }
}

# extend the POP3 class to our liking.
# the POP3 class is from http://www.thewebmasters.net/php/
class my_pop3 extends POP3 {

# Default POP port
  var $PORT = 110;

# set to true to echo pop3
# commands and responses to error_log
# this WILL log passwords!
	var $DEBUG		= false;

#	Allow or disallow apop()
#	This must be set to true manually.
	var $ALLOWAPOP	= false;

# Set to true if using VMailMgr
	var $VMAILMGR	= false;

# class constructor
  function my_pop3 () {
  }
}

# instantiate the phpop class
$phpop = new phpop_class ();

# every phpop page uses the template class
# to generate HTML.
$tpl = new pop_Template;

# create an instance of the data validation class
$validate = new Validator ();

# create an instance of the pop server access class
$pop3 = new my_pop3 ();

# -------------------------------
# SHARED FUNCTIONS
# -------------------------------
function  set_standard($title, &$p_tpl)  {
  global $sess, $phpop, $auth, $SERVER_NAME;

  $p_tpl->set_var(array(
  TITLE            => $title,
  SERVER_NAME      => $SERVER_NAME,
  USER_NAME        => $auth->auth["uname"],
	LIST_URL         => $sess->url("index.php3"),
	NEW_URL          => $sess->url("send.php3"),
	LOGOUT_URL       => $sess->url("logout.php3"),
	VERSION          => $phpop->version
  ));
}
?>

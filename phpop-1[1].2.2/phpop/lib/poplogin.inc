<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: poplogin.inc,v 1.6 2000/05/13 21:28:35 prenagha Exp $
# ---------------------------------------------------------------
global $phpop, $username, $sess, $pop3, $popserver, $popport;

# every phpop page uses the template class
# to generate HTML.
$login_tpl = new pop_Template;

$login_tpl->set_file(array(
    standard    => "common.standard.tpl",
	  body        => "poplogin.body.tpl",
	  invalid_msg => "poplogin.invalid.tpl"
));

set_standard("login", &$login_tpl);

if (isset($this->auth["uname"])) {
  $default_username = $this->auth["uname"];
}

if (! isset($default_username)) {
  $default_username = "";
}

if (!$phpop->login_servers) {
 $server_html = sprintf("<input type=\"text\" name=\"popserver\" value=\"%s\" size=15 maxlength=75>", $popserver);
} else {
  if (sizeof($phpop->login_servers) == 1) {
     $server_html = sprintf("<strong>%s</strong>", $phpop->login_servers[0]);
  } else {
    $server_html = "<select name=\"popserver\">\n";
    reset($phpop->login_servers);
    while (list($index, $server) = each ($phpop->login_servers)) {
      $server_html .= sprintf("  <option value=\"%s\">%s\n"
        ,$server,$server);
    }
    $server_html .= "</select>\n";
  }

}


if ($phpop->login_port) {
 if ($phpop->login_port > 0) {
    if (isset($popport)) {
      $def_port = $popport;
    } else {
      $def_port = $phpop->login_port;
    }
    $port_html = sprintf("<tr valign=center align=left>\n<td>POP Port:</td>\n<td><input type=\"text\" name=\"popport\" value=\"%s\" size=15 maxlength=15></td></tr>", $def_port);
  }
} else {
  $port_html = sprintf("<tr valign=center align=left>\n<td>POP Port:</td>\n<td><strong>%s</strong></td>\n</tr>\n", $pop3->PORT);
}

$login_tpl->set_var(array(
  FORM_ACTION            => $sess->self_url(),
  SERVER_HTML            => $server_html,
  PORT_HTML              => $port_html,
  DEFAULT_USERNAME       => $default_username
));

if (isset($username)) {
  $login_tpl->parse("INVALID_MSG", "invalid_msg");
}

$login_tpl->parse("BODY", "body");
$login_tpl->parse("MAIN", "standard");
$login_tpl->p("MAIN");
?>

<?php
/*
+-------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000 Murat Arslan <arslanm@cyberdude.com> |
+-------------------------------------------------------------------+
*/

// Launcher file
// ------------------------------------------------------------------
// -- master config file
require("/usr/local/basilix/conf/basilix.conf");

// -- other config files
require("$BSX_CONFDIR/global.conf");
require("$BSX_CONFDIR/db.conf");
require("$BSX_CONFDIR/request.conf");
require("$BSX_CONFDIR/lang.conf");
require("$BSX_CONFDIR/domain.conf");
require("$BSX_CONFDIR/theme.conf");

// -- utilities
require("$BSX_LIBDIR/error.inc");
require("$BSX_LIBDIR/folder.inc");
require("$BSX_LIBDIR/imap.inc");
require("$BSX_LIBDIR/lang.inc");
require("$BSX_LIBDIR/session.inc");
require("$BSX_LIBDIR/util.inc");
require("$BSX_DBSETDIR/$BSX_USE_DB_SETFILE");

// -- classes
require("$BSX_LIBDIR/imap.class");
require("$BSX_LIBDIR/$BSX_USE_DB_FILE");

// -- settings
require("$BSX_LIBDIR/settings.inc");

// ---------------- here we go ----------------
if($is_ssl) $BSX_BASEHREF = ereg_replace("http://", "https://", $BSX_BASEHREF);

// -- cookie test
if(!$BSX_TestCookie && !$is_nocookie && !$SESSID) url_redirect();

// if the browser is not cookie capable
if($SESSID) {
	$BSX_SESSID = $SESSID;
	$is_nocookie = 1;
}

// -- theme (css)
if($BSX_Theme) $BSX_THEMEDIR = $bsx_theme[$BSX_Theme]["dir"];
else $BSX_THEMEDIR = $bsx_theme[$BSX_DEFAULT_THEME]["dir"];
// --

// -- username and domain
if($username == "") $username = $BSX_User;
if($domain == "") $domain = domain2index($BSX_Domain);
// --

if(empty($RequestID)) { // -- login procedure
   if(!empty($username) || $relogin) {
	$RELOGIN_MSG = $lng->p(54);
        $BODY_ONLOAD="onLoad='document.loginForm.password.focus();'";
	$incfile = "login-relogin.htx";
   } else if(!$is_alldomains && (($this_bsxdomain_id = check_desired_domain()) >= 0)) {
        $BODY_ONLOAD="onLoad='document.loginForm.username.focus();'";
	$incfile = "login-desired_domain.htx";
   } else {
        $BODY_ONLOAD="onLoad='document.loginForm.username.focus();'";
	$incfile = "login-new.htx";
   }
   include("$BSX_HTXDIR/header.htx");
   include("$BSX_HTXDIR/$incfile");
   include("$BSX_HTXDIR/footer.htx");
   exit();
}

// -- launch the desired file
$file = ereg_replace("\.\.|\/", "", $request_id["$RequestID"]); 
if($file == "") exit();
include($BSX_FILESDIR . "/" . $file);
// --
?>

<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Login procedure
// -----------------------------------------------------------------------

$username = decode_strip($username);
$password = decode_strip($password);

// some checks
if(!$username && !$password) {
   $LOGIN_ERR = $lng->p(58);
   $BODY_ONLOAD = "onLoad='document.loginForm.username.focus();'";
   $err=1;
   $domain--;
} else if(!$username) { // if the username is empty
   $LOGIN_ERR = $lng->p(59);
   $BODY_ONLOAD = "onLoad='document.loginForm.username.focus();'";
   $err=1; 
   $domain--;
} else if($domain == "0") { // no domain selected
   $LOGIN_ERR = $lng->p(59);
   $BODY_ONLOAD = "onLoad='document.loginForm.domain.focus();'";
   $err=1;
   $domain--;
} else if(!$password) { // if the password is empty
   $LOGIN_ERR = $lng->p(60);
   $BODY_ONLOAD = "onLoad='document.loginForm.password.focus();'";
   $err=1;
   $domain--;
}

if($err) {
   if($relogin) {
      $BODY_ONLOAD = "onLoad='document.loginForm.password.focus();'";
      $incfile = "login-relogin.htx";
   } else if(!$is_alldomains && (($this_bsxdomain_id = check_desired_domain()) >= 0)) {
      $incfile = "login-desired_domain.htx";
   } else {
      $incfile = "login-new.htx";
   }
   include("$BSX_HTXDIR/header.htx");
   include("$BSX_HTXDIR/$incfile");
   include("$BSX_HTXDIR/footer.htx");
}
// --

// ok let's connect
// ---
$domain--;
require("$BSX_LIBDIR/imap2.inc");
// ---

// go create/update a/the session for the user
$sql = new MySQL;
$sql->open();
$stime = time();
$sessionid = md5(uniqid("$username:$domain:$stime"));
$last_values = session_create($username, $domain, $password, $sessionid, &$customerID);
$last_host = $last_values["LastHost"];
$last_addr = $last_values["LastAddr"];
$last_time = $last_values["LastTime"];
$push_lastinfo = true;

// reload/set the theme
if($user_set["theme"] != $BSX_Theme) {
   $BSX_THEMEDIR = $bsx_theme[$user_set["theme"]]["dir"];
   SetCookie("BSX_Theme", $user_set["theme"], time() + 63072000); // 2 yrs
}

// create attachment directory
$atch_dir = $BSX_ATTACH_DIR . "/" .  "$IMAP_DOMAIN" . "/" . "$username";
if(!is_dir($atch_dir)) {
    $mkdcmd="/bin/mkdir -p $atch_dir";
    @sexec($mkdcmd);
}

// --
if($user_set["lang"] != $BSX_Lang) {
   SetCookie("BSX_Lang", $user_set["lang"], time() + 63072000);
   $BSX_Lang = $user_set["lang"];
}

// --
require("$BSX_LIBDIR/mbox.inc");

// update user folders
$menu_folders = getbsxmboxes("init");
update_user_folders($customerID, $menu_folders);
// --

// first time login?
if(empty($last_addr)) {
	// then launch settings
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=SETTINGS");
	exit();	
}

$mbox = "Inbox";
$charset = lang_start($BSX_Lang);
lang_load("mboxlst");

$domain_name = $IMAP_DOMAIN;
$pagehdr_msg = $mbox;

push_mboxlist();
// --
?>

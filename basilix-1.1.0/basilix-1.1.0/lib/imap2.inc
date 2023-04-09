<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

$IMAP_DOMAIN = $bsx_domains["$domain"]["domain"];
$IMAP_ISVIRTUAL = $bsx_domains["$domain"]["isvirtual"];
$IMAP_HOST = $bsx_domains["$domain"]["imap_host"];
$IMAP_PORT = $bsx_domains["$domain"]["imap_port"];
$SMTP_HOST = $bsx_domains["$domain"]["smtp_host"];
$IMAP_STYPE = $bsx_domains["$domain"]["imap_stype"];

// here decide what to do
if($IMAP_STYPE == 3) $BSX_MDIR = "Inbox.";

// virtual or non-virtual connection
if($IMAP_ISVIRTUAL) {
   $virtual_username = $username . "@" . $IMAP_DOMAIN;
   $imap_ok = imap_connect($virtual_username, $password, $IMAP_HOST, $IMAP_PORT);
} else
   $imap_ok = imap_connect($username, $password, $IMAP_HOST, $IMAP_PORT);
if($imap_ok == false) {
   if($relogin) {
      $incfile = "login-relogin.htx";
   } else {
      $incfile = "login-new.htx";
   }
   $LOGIN_ERR = $lng->p(61);
   $BODY_ONLOAD = "onLoad='document.loginForm.password.focus();'";
   include("$BSX_HTXDIR/header.htx");
   include("$BSX_HTXDIR/$incfile");
   include("$BSX_HTXDIR/footer.htx");
   my_exit();
}
?>

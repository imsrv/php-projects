<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Logout procedure
// -----------------------------------------------------------------------
//
// Zero the session of the user
$sql = new MySQL;
$sql->open();
$sql->session_zero($BSX_SESSID);
$sql->close();

// Expire the cookie 
SetCookie("BSX_SESSID", "", 1);
SetCookie("BSX_TestCookie");

// Prepare the message
$lng->sb(1001); 
$lng->sr("%b", $BSX_BASEHREF);
$lng->sr("%l", $BSX_LAUNCHER);
$logout_msg = $lng->sp();

include("$BSX_HTXDIR/header.htx");
include("$BSX_HTXDIR/logout.htx");
include("$BSX_HTXDIR/footer.htx");
?>

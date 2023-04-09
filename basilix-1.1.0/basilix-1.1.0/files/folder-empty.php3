<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Empty the desired folder
// -----------------------------------------------------------------------
if($mbox == "") $mbox = "Inbox";

$mbox = imap_utf7_encode(decode_strip($mbox));

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

// connect to the imap server
require("$BSX_LIBDIR/imap2.inc");

// --
require("$BSX_LIBDIR/mbox.inc");

// -- templates
include("$BSX_HTXDIR/header.htx");
include("$BSX_HTXDIR/menu.htx");

// empty the folder
if($is_js || $confirmed) {
   if(empty_folder($mbox)) $info_msg = $lng->p(178);
   else $err_msg = $lng->p(179);
   include("$BSX_HTXDIR/folders-empty.htx");
}
if(!$is_js && !$confirmed) {
   include("$BSX_HTXDIR/folders-empty-askconfirmation.htx");
}
include("$BSX_HTXDIR/footer.htx");
?>

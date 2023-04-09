<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Give a brief info about the folders, and del/add/modify
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");

include("$BSX_HTXDIR/header.htx");
// --

$mboxes = folder_list($total, $mbox_cnt, $IMAP_STYPE);
$sql->open();
$bsx_mboxes = getbsxmboxes();
update_user_folders($customerID, $bsx_mboxes);
// --
$pagehdr_msg = $lng->p(102);
include("$BSX_HTXDIR/menu.htx");

// and the templates of course
include("$BSX_HTXDIR/folders-list.htx");
include("$BSX_HTXDIR/folders-modify.htx");
include("$BSX_HTXDIR/footer.htx");
// --
?>

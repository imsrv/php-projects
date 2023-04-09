<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Delete a folder
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");

// --
$del_folder = decode_strip($folderName);
if(!$del_folder) $err_msg = $lng->p(164); // no folder selected

// --
if($err_msg == "") {
    // ok now lets delete the folder
    $del_folder_enc = imap_utf7_encode($BSX_MDIR . $del_folder);
    $rc = del_mbox($del_folder_enc);
    if($rc == false) $err_msg = $lng->p(165);
    else $info_msg = $lng->p(166);
}

include("$BSX_HTXDIR/header.htx");

$mboxes = folder_list($total, $mbox_cnt, $IMAP_STYPE);
$bsx_mboxes = getbsxmboxes();
$sql->open();
update_user_folders($customerID, $bsx_mboxes);
// --

lang_load("menu");

$pagehdr_msg = $lng->p(102);

// htx files
include("$BSX_HTXDIR/menu.htx");
include("$BSX_HTXDIR/folders-list.htx");
include("$BSX_HTXDIR/folders-modify.htx");
include("$BSX_HTXDIR/footer.htx");
?>

<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Create the user specified folder
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/imap2.inc");
require("$BSX_LIBDIR/mbox.inc");

// --
$new_folder = decode_strip($newFolderName);
$old_folder = decode_strip($oldFolderName);

if(!$old_folder) $err_msg = $lng->p(172);
else if(!$new_folder) $err_msg = $lng->p(173);
// --

// Courier does not reject mailboxes having ".", but we better reject.
if(eregi("\.", $new_folder)) $err_msg = $lng->p(174);

// --
if($err_msg == "") {
    // ok now lets rename the folder
    $old_folder_enc = imap_utf7_encode($BSX_MDIR . $old_folder);
    $new_folder_enc = imap_utf7_encode($BSX_MDIR . $new_folder);
    $rc = rename_mbox($old_folder_enc, $new_folder_enc);
    if($rc == false) $err_msg = $lng->p(174);
    else $info_msg = $lng->p(175);
}

include("$BSX_HTXDIR/header.htx");
// --
$mboxes = folder_list($total, $mbox_cnt, $IMAP_STYPE);
$bsx_mboxes = getbsxmboxes();
$sql->open();
update_user_folders($customerID, $bsx_mboxes);
$imap->close();
// --

$pagehdr_msg = $lng->p(102);

// htx files
include("$BSX_HTXDIR/menu.htx");
include("$BSX_HTXDIR/folders-list.htx");
include("$BSX_HTXDIR/folders-modify.htx");
include("$BSX_HTXDIR/footer.htx");
?>

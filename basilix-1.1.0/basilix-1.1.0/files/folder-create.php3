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

$new_folder = decode_strip($folderName);

// check if its ok now
$err_msg = "";
if(!$new_folder) $err_msg = $lng->p(158); // empty foldername or "0"
if(strtoupper($new_folder) == "INBOX") $err_msg = $lng->p(159); // Inbox

// Courier does not reject mailboxes having ".", but we better reject.
if(eregi("\.", $new_folder)) $err_msg = $lng->p(177);

// --
require("$BSX_LIBDIR/mbox.inc");
if($err_msg == "") {
    // retrieve the basilix folder names
    $bsx_mboxes = getbsxmboxes();
    for($i = 0 ; $i < count($bsx_mboxes) ; $i++) {
      if(strtoupper($new_folder) == strtoupper($bsx_mboxes[$i])) {
	$err_msg = $lng->p(159);
	break;
      }
    }
}

// --
if($err_msg == "") {
    // ok now lets create this guys new folder
    $new_folder_enc = imap_utf7_encode($BSX_MDIR . $new_folder);
    $rc = create_mbox($new_folder_enc);
    if($rc == false) $err_msg = $lng->p(177);
    else $info_msg = $lng->p(160);
}

// --
include("$BSX_HTXDIR/header.htx");
// --
$bsx_mboxes = getbsxmboxes();
$mboxes = folder_list($total, $mbox_cnt, $IMAP_STYPE);
$sql->open();
update_user_folders($customerID, $bsx_mboxes);
// --

lang_load("menu");

$pagehdr_msg = $lng->p(102);

// html files
include("$BSX_HTXDIR/menu.htx");
include("$BSX_HTXDIR/folders-list.htx");
include("$BSX_HTXDIR/folders-modify.htx");
include("$BSX_HTXDIR/footer.htx");

?>

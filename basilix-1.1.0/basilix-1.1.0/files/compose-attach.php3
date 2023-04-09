<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Attach file(s) to the e-mail
// -----------------------------------------------------------------

require("$BSX_LIBDIR/getvals.inc");
require("$BSX_LIBDIR/compose.inc");

// init
$atch_dir = $BSX_ATTACH_DIR . "/" .  "$domain_name" . "/" . "$username";
$atch_exceeded = 0;
$atch_samefile = 0;
$atch_limitreached = 0;

$sql->open();

// handle the attachments
if(!empty($cmps_myattach)) { // attaching a file
	$total_atchs = load_atchs($customerID, $premail);
	if($cmps_myfile_size != 0) {
		$total_size = $cmps_myfile_size;
		if(!empty($total_atchs)) {
			$tmp_arr = explode(chr(2), $total_atchs);
			for($i = 0 ; $i < count($tmp_arr) ; $i++) {
				$tmp_arr2 = explode(chr(3), $tmp_arr[$i]);
				$total_size += $tmp_arr2[2];
			}
		}
		if(is_already_attached($cmps_myfile_name, $total_atchs)) {
			$err_msg = $lng->p(426);
			$cmps_atchs = $total_atchs;
		} else if($total_size > $BSX_ATTACH_TOTAL) {
			$atch_exceeded = convert_size($cmps_myfile_size);
			$atch_filebytes = convert_size($total_size - $cmps_myfile_size);
			$atch_exceedfile = $cmps_myfile_size;
			$lng->sb(420); $lng->sr("%f", $atch_exceedfile); $lng->sr("%l", $atch_exceeded);
			$lng->sr("%a", $atch_filebytes);
			$err_msg = $lng->sp();
			$cmps_atchs = $total_atchs;
		} else {
			$cmd = "/bin/mkdir -p $atch_dir";
			@sexec($cmd);
			copy($cmps_myfile, $atch_dir . "/" . $cmps_myfile_name);
			if(empty($total_atchs))
				$cmps_atchs = $cmps_myfile_name . chr(3) . $cmps_myfile_type . chr(3) . $cmps_myfile_size;
			else
				$cmps_atchs = $total_atchs . chr(2) . $cmps_myfile_name . chr(3) . $cmps_myfile_type . chr(3) . $cmps_myfile_size;
			update_atchs($customerID, $premail, $cmps_atchs);
		}
	} else {
		$lng->sb(454); $lng->sr("%s", convert_size($BSX_ATTACH_TOTAL)); $err_msg = $lng->sp();
		$cmps_atchs = $total_atchs;
		update_atchs($customerID, $premail, $cmps_atchs);
	}
}
if(!empty($cmps_myunattach)) {	// unattaching a file
	if(!empty($cmps_myunattachfile)) {
		$cmps_myunattachfile = base64_decode($cmps_myunattachfile);
		$total_atchs = load_atchs($customerID, $premail);
		unlink($atch_dir . "/" . $cmps_myunattachfile);
		$cmps_atchs = remove_atchfile($total_atchs, $cmps_myunattachfile);
		update_atchs($customerID, $premail, $cmps_atchs);
	} else {
		$err_msg = $lng->p(466);
	}
}

// push the attachment form
$pagehdr_msg = $lng->p(433);
if(!check_premail($customerID, $premail)) {
	$sql->close();
	url_redirect("$BSX_BASEHREF/$BSX_LAUNCHER?RequestID=MBOXLST");
	exit();
}
$cmps_atchs = load_atchs($customerID, $premail);
include("$BSX_HTXDIR/header.htx");
include("$BSX_HTXDIR/menu.htx");
include("$BSX_HTXDIR/compose-attachment.htx");
include("$BSX_HTXDIR/footer.htx");
?>

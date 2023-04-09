<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// -----------------------------------------------------------------------
// load the settings of the user

function settings_load($cid) {
	global $BSX_Lang;
	global $user_set, $sql;

	$data = $sql->settings_load($cid);

	if(empty($data)) { // if no settings found
		$rc = $sql->settings_init($cid);
		$data = $sql->settings_load($cid);
	}

	list($key, $val) = each($data);
	$user_set["cid"] = $val["CUSTOMERID"];
	$user_set["id"] = $val["ROWID"];
	$user_set["name"] = $val["NAME"];
	$user_set["replyto"] = $val["REPLYTO"];
	$user_set["sign"] = $val["SIGN"];
	$user_set["lang"] = $val["LANG"] 		+ 0;	// int
	$user_set["sort"] = $val["SORT"] 		+ 0;	// int
	$user_set["rsort"] = $val["RSORT"] 		+ 0;	// int
	$user_set["savesent"] = $val["SAVESENT"];	+ 0;	// int
	$user_set["movetrash"] = $val["MOVETRASH"];	+ 0;	// int
	$user_set["theme"] = $val["THEME"];		+ 0; 	// int
	$user_set["psize"] = $val["PSIZE"];		+ 0;	// int
	$user_set["ifexpand"] = $val["IFEXPAND"];	+ 0;	// int
	$user_set["prevnext"] = $val["PREVNEXT"];	+ 0;	// int
	
	// if BSX_Lang is not the user's lang then set it
	if($BSX_Lang != $user_set["lang"]) 
	    SetCookie("BSX_Lang", $user_set["lang"], time() + 63072000); // 2 years life time
}

// save settings
function settings_save() {
	global $customerID, $sql;

	global $set_lang, $set_name, $set_sign, $set_sort, $set_rsort, $set_replyto;
	global $set_sent, $set_trash, $set_psize, $set_theme, $set_ifexpand, $set_prevnext;
	
	global $err_msg, $info_msg;

	// --
	if($set_psize > 100) $set_psize = 100;
	if($set_psize < 20) $set_psize = 20;
	// --

	$rc = $sql->settings_save($customerID, $set_lang, $set_name, $set_sign, $set_sort,
				  $set_rsort, $set_sent, $set_trash, $set_psize, $set_theme, 
				  $set_ifexpand, $set_prevnext, $set_replyto);

	$t = time();
	SetCookie("BSX_Lang", $set_lang, $t + 63072000); // 2 years life time
	SetCookie("BSX_Theme", $set_theme, $t + 63072000); // 2 years life time

        return $rc;
}

// push settings form
function settings_form() {
	global $customerID, $RequestID, $sql, $lng;
	global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_VERSION;
	global $BSX_BASEHREF, $BSX_LAUNCHER;
	global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
	global $SESSID, $BODY_ONLOAD, $is_js, $is_ssl;

	global $user_set, $bsx_theme;

	global $set_lang, $set_name, $set_sign, $set_sort, $set_rsort, $set_replyto;
	global $set_sent, $set_trash, $set_psize, $set_theme, $set_ifexpand, $set_prevnext;
	global $save_sets;

	global $err_msg, $info_msg;

	$sql->open();

	if(!empty($save_sets)) {
		$GLOBALS["charset"] = lang_init($set_lang);
		lang_load("global");
		lang_load("menu");
		lang_load("settings");
		$GLOBALS["pagehdr_msg"] = $lng->p(106);
		$set_replyto = decode_strip($set_replyto);
		$set_name = decode_strip($set_name);
		$set_sign = decode_strip($set_sign);
		if(settings_save() == false) $err_msg = $lng->p(501);
		else $info_msg = $lng->p(502);
		settings_load($customerID);
		$BSX_THEMEDIR = $bsx_theme[$set_theme]["dir"];
	} else {
		// loaded before (lib/getvals.inc)
		$set_name = decode_strip($user_set["name"]);
		$set_sign = decode_strip($user_set["sign"]);
		$set_replyto = decode_strip($user_set["replyto"]);
		$set_lang = $user_set["lang"];
		$set_sort = $user_set["sort"];
		$set_rsort = $user_set["rsort"];
		$set_sent = $user_set["savesent"];
		$set_trash = $user_set["movetrash"];
		$set_psize = $user_set["psize"];
		$set_theme = $user_set["theme"];
		$set_ifexpand = $user_set["ifexpand"];
		$set_prevnext = $user_set["prevnext"];
	}

	include("$BSX_HTXDIR/header.htx");
	include("$BSX_HTXDIR/menu.htx");
	include("$BSX_HTXDIR/settings.htx");
	include("$BSX_HTXDIR/footer.htx");
}

function theme_usage() {
	global $sql;
	$data = $sql->settings_theme_usage();
	if(empty($data)) return array();
	while(list($k, $v) = each($data)) {
		$cnt = $v["CNT"];
		$thid = $v["THEME"];
		$theme_stats[$thid] = $cnt;
	}
	return $theme_stats;
}
?>

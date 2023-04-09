<?
/********************************************************
	include/super2global.inc
	
	(C)Ryo Chijiiwa <Ryo@IlohaMail.org> 2002 

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Convert super globals (in PHP > 4.1) to globals.

********************************************************/

error_reporting(0);

if (isset($_GET)){
	while ( list($var, $val) = each($_GET) ) if (!isset($$var)) $$var = $val;
}

if (isset($_POST)){
	while ( list($var, $val) = each($_POST) ) if (!isset($$var)) $$var = $val;
}

if (isset($_FILES)){
	while ( list($n, $val) = each($_FILES) ){
		$$n = $_FILES[$n]['tmp_name'];
		$var = $n."_name";
		$$var = $_FILES[$n]['name'];
		$var = $n."_size";
		$$var = $_FILES[$n]['size'];
		$var = $n."_type";
		$$var = $_FILES[$n]['type'];
	}
}

// validate $lang, set to default
// auth_session should set it to $my_prefs["lang"]
include_once("../include/langs.inc");
if (empty($languages[$lang])){
	if (isset($int_lang)) $lang = $int_lang;
	else $lang = "eng/";
}
?>
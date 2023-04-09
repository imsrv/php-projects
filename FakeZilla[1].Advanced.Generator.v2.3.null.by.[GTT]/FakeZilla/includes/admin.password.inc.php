<?php
// ------------------------------------------------------------------
// admin.password.inc.php
// ------------------------------------------------------------------


// function adminPassword() 
 function adminPassword() {
  global $PARAM;
  global $html;

	$html->define('password', 'password.htmlt');
	$html->extract('password');
	$html->assign('cmd', $PARAM['cmd']);

	//get the account file
	if ($PARAM['U'] || $PARAM['P']) {
		//list($A_user, $A_pass) = file(get_Setting('AUTH_FILE'));
		$AUTH = file(get_Setting('AUTH_FILE'));
		array_walk($AUTH, create_function('&$v,$k','$v = trim($v);'));
		$A_user = $AUTH[0];
		$A_pass = $AUTH[1];
		}

	// change username
 	if ($PARAM['U']) {

		if (md5($PARAM[password]) != trim($A_pass)) {

			// write to audit log
			if ($fp = @fopen (get_Setting('AUDIT_LOG'),'a')) {
				fwrite ($fp, date('[l, j F Y, H.i:s] [B]')."\r\n");
				fwrite ($fp, "Address: $_SERVER[REMOTE_ADDR]\r\n");
				fwrite ($fp, "Referer: $_SERVER[HTTP_REFERER]\r\n");
				fwrite ($fp, "User Agent: $_SERVER[HTTP_USER_AGENT]\r\n");
				fwrite ($fp, "Username: ".$_SESSION[adminAlias]."\r\n");
				fwrite ($fp, "Password: ".$PARAM['password']."\r\n");
				fwrite ($fp, "\r\n");
				fclose ($fp);
				}
			
			$html->assign('command', "logout&err=error_wrong" );	//wrong password
			printPage('done');
			return;
			}

		// empty username
		if ($PARAM['new']=='') {
			$html->message('error', 'error_empty');
			}

		if ($html->get_subs('error') == '') {
			
			// write new username
			if (!$fp = @fopen (get_Setting('AUTH_FILE'),'w')) {				
				$err = 'error_save';
				} else {
				
				$AUTH[0] = md5($PARAM['new']);
				$AUTH[1] = trim($A_pass);
				
				fwrite($fp, join("\n", $AUTH));
				fclose($fp);
				
				$_SESSION[adminAlias] = $PARAM['new'];
				$err = 'success_user';
				}

			$html->assign('command', $PARAM['cmd']."&err=$err" );
			printPage('done');
			return;

			} else {
			$html->parse('error');
			$html->assign('password_error', $html->fetch('error'));
			}
 		}

	// change password
 	if ($PARAM['P']) {

		if (md5($PARAM[password]) != trim($A_pass)) {

			// write to audit log
			if ($fp = @fopen (get_Setting('AUDIT_LOG'),'a')) {
				fwrite ($fp, date('[l, j F Y, H.i:s] [B]')."\r\n");
				fwrite ($fp, "Address: $_SERVER[REMOTE_ADDR]\r\n");
				fwrite ($fp, "Referer: $_SERVER[HTTP_REFERER]\r\n");
				fwrite ($fp, "User Agent: $_SERVER[HTTP_USER_AGENT]\r\n");
				fwrite ($fp, "Username: ".$_SESSION[adminAlias]."\r\n");
				fwrite ($fp, "Password: ".$PARAM['password']."\r\n");
				fwrite ($fp, "\r\n");
				fclose ($fp);
				}
			
			$html->assign('command', "logout&err=error_wrong" );	//wrong password
			printPage('done');
			return;
			}

		// passwords do not match
		if ($PARAM['password1'] != $PARAM['password2']) {
			$html->message('error', 'error_match');
			}

		if ($html->get_subs('error') == '') {
			
			// write new password
			if (!$fp = @fopen (get_Setting('AUTH_FILE'),'w')) {				
				$err = 'error_save';
				} else {
				

				$AUTH[0] = trim($A_user);
				$AUTH[1] = md5($PARAM['password1']);
				
				fwrite($fp, join("\n", $AUTH));
				fclose($fp);
				
				$err = 'success_pass';
				}

			$html->assign('command', $PARAM['cmd']."&err=$err" );
			printPage('done');
			return;

			} else {
			$html->parse('error');
			$html->assign('password_error', $html->fetch('error'));
			}
 		}



	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('password_error', $html->fetch('error'));
		}

	printPage('password');
 	}
?>
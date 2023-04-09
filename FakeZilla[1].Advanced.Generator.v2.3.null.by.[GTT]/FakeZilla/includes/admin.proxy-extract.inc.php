<?php
// ------------------------------------------------------------------
// admin.proxy-extract.inc.php
// ------------------------------------------------------------------

// function adminProxyExtract() 
 function adminProxyExtract() {
  global $PARAM;
  global $_FILES;
  global $html;

	$html->define('proxy-extract', 'proxy-extract.htmlt');
	$html->extract('proxy-extract');
	$html->assign('cmd', $PARAM['cmd']);

	// show result page
	if ($PARAM['d']) {
		$html->parse('upload_done');
		} else {
		$html->parse('upload_form');
		}

	// do the upload
 	if ($PARAM['U']) {

		set_time_limit(0);

		$failed = 0;
		$uploaded = 0;

		// walk the file array
		for ($i=0; $i<count($_FILES['new']); $i++) {
			$__file__ = strip_tags(@join('', @file($_FILES['new']['tmp_name'][$i])));

			$PROXY = array();

			// extract proxy servers
			while(preg_match('~\s*\d+\s*\.\s*\d+\s*\.\s*\d+\s*\.\s*\d+\s*:\d+\s*~is', $__file__, $R)) {

				$PROXY[] = trim($R[0]);
				$__file__ = substr($__file__, strpos($__file__, $R[0])+strlen($R[0]));
				}

			while(preg_match('~\s*(\.?[a-z0-9-]{3,}){2,}\s*:\d+\s*~is', $__file__, $R)) {

				$PROXY[] = trim($R[0]);
				$__file__ = substr($__file__, strpos($__file__, $R[0])+strlen($R[0]));
				}

			// write results
			if (!empty($PROXY) && ($fp = fopen(
				get_setting('PROXY_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-PROXY.txt", 'w+'))) {

				sort($PROXY);
				fwrite($fp, join("\n", $PROXY));
				fclose($fp);
				chmod(get_setting('PROXY_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-PROXY.txt", 0666);
				
				$uploaded++;
				} else {
				
				$failed++;
				}
			}

		// reload result page
		if(!$failed) {
			$err = 'success_all';
			} else {
			$err = 'error_fail';
			}
		
		// got uploaded ?
		if ($uploaded) {
			$html->assign('command', $PARAM['cmd']."&d=".md5(microtime())."&err=$err" );
			} else {
			$html->assign('command', $PARAM['cmd']."&err=$err");
			}

		printPage('done');
		return;
 		}

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('proxyextract_error', $html->fetch('error'));
		}

	printPage('proxy-extract');
 	}
?>
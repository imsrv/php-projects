<?php
// ------------------------------------------------------------------
// admin.log-extract.inc.php
// ------------------------------------------------------------------

// function adminLogExtract() 
 function adminLogExtract() {
  global $PARAM;
  global $_FILES;
  global $html;

	$html->define('log-extract', 'log-extract.htmlt');
	$html->extract('log-extract');
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

			$USERAGENT = array();
			$REFERER = array();
			$ok = 0;

			if ($fp = fopen($_FILES['new']['tmp_name'][$i], 'r')) {

				$iis = 0;	// IIS Logs Flag

				while(!feof($fp)) {
					$__line__ = fgets($fp);
					
					// check for IIS logs
					if (!$iis && strstr($__line__,"Microsoft Internet Information Services")) {
						$iis = 2;
						break;
						} else {
						$iis = 1;
						}
					
					// extract APACHE referers & user-agents
					if (preg_match('~^[^ ]+\s+[^ ]+\s+[^ ]+\s+\[.*]\s+\".*\"\s+[^ ]+\s+[^ ]+\s+(\"([^"]+)\"\s+)?(\"([^"]+)\"\s+)?$~Uis', $__line__, $R)) {
						if($R[2]!='-'){
							$REFERER[$R[2]] = 1;
							}
						if($R[4]!='-'){
							$USERAGENT[$R[4]] = 1;
							}
						}
					}

				while (($iis==2) && !feof($fp)) {
					$__line__ = fgets($fp);

					// check for the log fields
					if (preg_match('~^#Fields:\s+(.*)\s*$~Uis', $__line__, $R)) {
						
						$_FIELDS = array_flip(preg_split('~\s+~', $R[1]));
						$_index_Referer = $_FIELDS['cs(Referer)'];
						$_index_UserAgent = $_FIELDS['cs(User-Agent)'];

						continue;
						}

					// skip comments
					if (preg_match('~^#~Uis', $__line__)) {
						continue;
						}

					// parse log rows
					$_R = preg_split("~\s+~", $__line__);
					if($_R[$_index_Referer]!='-'){
						$REFERER[$_R[$_index_Referer]] = 1;
						}
					if($_R[$_index_UserAgent]!='-'){
						$USERAGENT[urlDecode($_R[$_index_UserAgent])] = 1;
						}
					}

				fclose($fp);
				chmod($_FILES['new']['tmp_name'][$i], 0666);
				}
			ksort($USERAGENT);
			ksort($REFERER);

			// write results
			if (!empty($USERAGENT) && ($fp = fopen(
				get_setting('USERAGENT_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-USERAGENT.txt", 'w+'))) {

				fwrite($fp, join("\n", array_keys($USERAGENT)));
				fclose($fp);
				chmod(get_setting('USERAGENT_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-USERAGENT.txt", 0666);
				
				$ok = 1;
				}

			if (!empty($REFERER) && ($fp = fopen(
				get_setting('REFERER_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-REFERER.txt", 'w+'))) {

				fwrite($fp, join("\n", array_keys($REFERER)));
				fclose($fp);
				chmod(get_setting('REFERER_DIR')
					. date('Ymd-His')
					. "-[extracted-from "
					. $_FILES['new']['name'][$i]
					. "]-REFERER.txt", 0666);
				
				$ok = 1;
				}
			
			if ($ok) {
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
		$html->assign('logextract_error', $html->fetch('error'));
		}

	printPage('log-extract');
 	}
?>
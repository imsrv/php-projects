<?php
// ------------------------------------------------------------------
// admin.upload.inc.php
// ------------------------------------------------------------------


// function adminUpload() 
 function adminUpload() {
  global $PARAM;
  global $_FILES;
  global $html;

	$html->define('upload', 'upload.htmlt');
	$html->extract('upload');
	$html->assign('cmd', $PARAM['cmd']);

	// show result page
	if ($PARAM['d']) {
		$html->parse('upload_done');
		} else {
		$html->parse('upload_form');
		}

	// do the upload
 	if ($PARAM['U']) {

		$failed = 0;
		$uploaded = 0;
		$_PATH = array(
			'proxy' => get_setting('PROXY_DIR'),
			'referer' => get_setting('REFERER_DIR'),
			'useragent' => get_setting('USERAGENT_DIR')
			);

		// walk the type array
		for ($i=0; $i<count($_POST[type]); $i++) {
			
			if ($_FILES['new'][size][$i] == 0) {
				continue;
				}
			
			if (in_array($_POST[type][$i], array_keys($_PATH))) {
				
				//check overwrite
				if (file_exists($_PATH[$_POST[type][$i]].$_FILES['new'][name][$i])) {
					if (ereg('^(.*)\.([^.]*)$', $_FILES['new'][name][$i], $R)) {
						$_FILES['new'][name][$i] = $R[1].date('(Ymd-His)').".$R[2]";
						} else {
						$_FILES['new'][name][$i] .= date('(Ymd-His)');
						}
					}

				chmod($_FILES['new'][tmp_name][$i], 0666);
				if (!@rename($_FILES['new'][tmp_name][$i],
					$_PATH[$_POST[type][$i]].$_FILES['new'][name][$i])) {
					
					$failed++;
					} else {
					
					$uploaded++;
					chmod($_PATH[$_POST[type][$i]].$_FILES['new'][name][$i], 0666);
					}
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
			$html->assign('command', $PARAM['cmd']);
			}
		
		printPage('done');
		return;
 		}

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('upload_error', $html->fetch('error'));
		}

	printPage('upload');
 	}
?>
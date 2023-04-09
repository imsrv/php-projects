<?php
// ------------------------------------------------------------------
// admin.proxy.inc.php
// ------------------------------------------------------------------

//function adminProxy()
 function adminProxy() {
   global $PARAM;
   global $html;

	$html->define('proxy', 'proxy.htmlt');
	$html->extract('proxy');
	$html->assign('cmd', $PARAM['cmd']);

	// delete
	if ($PARAM[e]) {
		if (!file_exists(get_setting('PROXY_DIR') . $PARAM[e]) || is_dir(get_setting('PROXY_DIR') . $PARAM[e])) {
			$html->message('error', 'error_notfound');
			
			$html->parse('error');
			$html->assign('proxy_error', $html->fetch('error'));
			} else {
			
			chmod(get_setting('PROXY_DIR') . $PARAM[e], 0666);
			if (!@rename(get_setting('PROXY_DIR').$PARAM[e],
				get_setting('TEMPORARY_DIR') 
					.'DELETED_proxy_'
					.$PARAM[e])) {
						@unlink(get_setting('PROXY_DIR').$PARAM[e]);
						}
			$html->assign('command', $PARAM['cmd']."&err=success_deleted" );
			printPage('done');
			return;
			}
		}

	// view
	if ($PARAM[v]) {
		if (!file_exists(get_setting('PROXY_DIR') . $PARAM[v]) || is_dir(get_setting('PROXY_DIR') . $PARAM[v])) {
			$html->parse('not_found');
			print ($html->fetch('not_found'));
			
			halt();
			} else {
			$html->define('list', 'list.htmlt');
			$html->extract('list');
	
			$html->assign('filename', $PARAM[v]);
			$html->assign('date', date('Y-m-d H:i:s', filemtime(get_setting('PROXY_DIR').$PARAM[v])));
			$html->assign('size', sprintf('%02.2f', filesize(get_setting('PROXY_DIR').$PARAM[v])/1024));

			if ($fp = fopen(get_setting('PROXY_DIR').$PARAM[v], 'rb')) {
				while(!feof($fp)) {
					$content .= fgets($fp, 128);
					}
				fclose($fp);
				}
			$html->assign('content', $content);

			$html->parse('list');
			print ($html->fetch('list'));
			halt();
			}
		}

	// download
	if ($PARAM[d]) {
		if (!file_exists(get_setting('PROXY_DIR') . $PARAM[d]) || is_dir(get_setting('PROXY_DIR') . $PARAM[d])) {
			$html->message('error', 'error_notfound');
			
			$html->parse('error');
			$html->assign('proxy_error', $html->fetch('error'));
			} else {
			$fp=@fopen(get_setting('PROXY_DIR') . $PARAM[d], "rb");
			header("Content-Type: application/octet-stream\n");
			header("Content-Disposition: attachment; filename=".baseName($PARAM[d]));
			header("Content-Transfer-Encoding: binary");
			set_time_limit(0);
			@fpassthru($fp);
			halt();
			}
		}

	// all
	if ($_files = opendir(get_setting('PROXY_DIR'))) {
		while (false !== ($file = readdir($_files))) { 
			if (in_array($file, array('.', '..')) || is_dir(get_setting('PROXY_DIR') . $file)) {
				continue;
				}
			
			$html->assign('filename', $file);
			$html->assign('filemd5', md5($file));
			$html->assign('date', date('Y-m-d H:i:s', filemtime(get_setting('PROXY_DIR').$file)));
			$html->assign('size', sprintf('%02.2f', filesize(get_setting('PROXY_DIR').$file)/1024));
			
			$html->parse('proxy_row');
			
			//rows found
			$found = true;
			
			//reset mod
			@chmod(get_setting('PROXY_DIR').$file, 0666);
			}
		closedir($_files); 
		}
	if (!$found) {
		$html->parse('proxy_none');
		}

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('proxy_error', $html->fetch('error'));
		}

	printPage ('proxy');
	}
?>
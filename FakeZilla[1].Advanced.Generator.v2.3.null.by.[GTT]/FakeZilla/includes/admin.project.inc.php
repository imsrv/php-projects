<?php
// ------------------------------------------------------------------
// admin.project.inc.php
// ------------------------------------------------------------------

//function adminProject()
 function adminProject() {
   global $PARAM;
   global $html;

	$html->define('project', 'project.htmlt');
	$html->extract('project');
	$html->assign('cmd', $PARAM['cmd']);

	// delete
	if ($PARAM[e]) {
		if (!file_exists(get_setting('PROJECT_DIR') . $PARAM[e]) || is_dir(get_setting('PROJECT_DIR') . $PARAM[e])) {
			$html->message('error', 'error_notfound');
			
			$html->parse('error');
			$html->assign('project_error', $html->fetch('error'));
			} else {
			if (!@rename(get_setting('PROJECT_DIR').$PARAM[e],
				get_setting('TEMPORARY_DIR') 
					.'DELETED_project_'
					.$PARAM[e])) {
						@unlink(get_setting('PROJECT_DIR').$PARAM[e]);
						}
			$html->assign('command', $PARAM['cmd']."&err=success_deleted" );
			printPage('done');
			return;
			}
		}

	// view
	if ($PARAM[v]) {
		if (!file_exists(get_setting('PROJECT_DIR') . $PARAM[v]) || is_dir(get_setting('PROJECT_DIR') . $PARAM[v])) {
			$html->parse('not_found');
			print ($html->fetch('not_found'));
			
			halt();
			} else {
			$html->define('list', 'list.htmlt');
			$html->extract('list');
	
			$html->assign('filename', $PARAM[v]);
			$html->assign('date', date('Y-m-d H:i:s', filemtime(get_setting('PROJECT_DIR').$PARAM[v])));
			$html->assign('size', sprintf('%02.2f', filesize(get_setting('PROJECT_DIR').$PARAM[v])/1024));

			if ($fp = fopen(get_setting('PROJECT_DIR').$PARAM[v], 'rb')) {
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

	// all
	if ($_files = opendir(get_setting('PROJECT_DIR'))) {
		while (false !== ($file = readdir($_files))) { 
			if (in_array($file, array('.', '..')) || is_dir(get_setting('PROJECT_DIR') . $file)) {
				continue;
				}
			
			$html->assign('filename', $file);
			$html->assign('filemd5', md5($file));
			$html->assign('date', date('Y-m-d H:i:s', filemtime(get_setting('PROJECT_DIR').$file)));
			$html->assign('size', sprintf('%02.2f', filesize(get_setting('PROJECT_DIR').$file)/1024));
			
			$html->parse('project_row');
			
			//rows found
			$found = true;
			
			//reset mod
			@chmod(get_setting('PROJECT_DIR').$file, 0666);
			}
		closedir($_files); 
		}
	if (!$found) {
		$html->parse('project_none');
		}

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('project_error', $html->fetch('error'));
		}

	printPage ('project');
	}
?>
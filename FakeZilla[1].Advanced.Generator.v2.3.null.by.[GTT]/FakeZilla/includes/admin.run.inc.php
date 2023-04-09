<?php
// ------------------------------------------------------------------
// admin.run.inc.php
// ------------------------------------------------------------------


// function adminRun() 
 function adminRun() {
  global $PARAM;
  global $html;

	require('./includes/common/project.inc.php');

	$html->define('run', 'run.htmlt');
	$html->extract('run');
	$html->assign('cmd', $PARAM['cmd']);

	// activate project
	if ($PARAM[tmp]) {
		$html->assign('err', $PARAM[err]);
		$html->assign('tmp', $PARAM[tmp]);
		$html->parse('activate_project');
		
		echo $html->fetch('activate_project');
		return;
		}

	// check safe_mode
	if (ini_get('safe_mode')) {
		$html->assign('max_execution_time',ini_get('max_execution_time'));
		$html->parse('safe_mode');
		}

	$PROJECT = new Project();

	// check parameters
	if ($PARAM[R]) {
		
		// load project
		$PROJECT->Load($_POST);

		// check URL
		if (($html->get_subs('error') == '') && ($PROJECT->Get('URL')=='')) {
			$html->message('error', 'error_url');
			}

		// run the generator
		if ($html->get_subs('error') == '') {
			
			// save project
			if ($PARAM['Save-project']) {
				$PROJECT->Save();
				}
			
			//generate tmp file
			$tmp_data = serialize($PROJECT);
			$tmp_name = urlEncode(tmp_file($tmp_data));
			
			$html->assign('command', $PARAM[cmd]."&err=project_run&tmp=$tmp_name" );
			printPage('done');
			return;

			} else {
			$html->parse('error');
			$html->assign('run_error', $html->fetch('error'));
			}
		} else {

		// read project file
		$PROJECT->Read(get_setting('PROJECT_DIR') . $PARAM[p]);
		}

	// load proxies
	$PROXY = folder2array(get_setting('PROXY_DIR'));
	for ($i=0; $i<count($PROXY); $i++) {
		$html->assign('proxy', $PROXY[$i]);
		$html->parse('proxy_list');
		}

	// load referer
	$REFS = folder2array(get_setting('REFERER_DIR'));
	for ($i=0; $i<count($REFS); $i++) {
		$html->assign('referer', $REFS[$i]);
		$html->parse('referer_list');
		}

	// load user-agents
	$UA = folder2array(get_setting('USERAGENT_DIR'));
	for ($i=0; $i<count($UA); $i++) {
		$html->assign('useragent', $UA[$i]);
		$html->parse('useragent_list');
		}

	// load project form
	$html->assign('title', $PROJECT->Title);
	$html->assign('url', $PROJECT->Get('URL'));
	$html->assign('total', $PROJECT->Get('Total-hits-sent'));
	$html->assign('per_hour', $PROJECT->Get('Hits-per-hour'));
	if ($PROJECT->Get('Sim-Proxy')) {
		$html->parse('sim_proxy');
		}
	$html->assign('per_hour', $PROJECT->Get('Hits-per-hour'));
	$html->assign('proxy', $PROJECT->Get('Proxy'));
	$html->assign('method', $PROJECT->Get('Method'));

	$POST_PARAM = $PROJECT->Get('Param');	// load params
	if(!$post_count = @count($POST_PARAM)) {
		$post_count = 1;
		}
	$html->assign('field_count', $post_count);

	for ($i=0; $i<$post_count; $i++) {
		$html->assign('param_index', $i);
		$html->assign('param_next', $i+1);
		$html->assign('param_key', $POST_PARAM[$i][key]);
		$html->assign('param_value', $POST_PARAM[$i][value]);
		$html->parse('post_param');
		}

	$html->assign('useragent', $PROJECT->Get('User-Agent'));
	$html->assign('useragent_list', $PROJECT->Get('UserAgent-List'));
	$html->assign('useragent_exact', $PROJECT->Get('UserAgent-Exact'));

	$html->assign('referer', $PROJECT->Get('Referer'));
	$html->assign('referer_list', $PROJECT->Get('Referer-List'));
	$html->assign('referer_url', $PROJECT->Get('Referer-Url'));

	if ($PARAM['Save-project']) {	// save project checkbox
		$html->parse('save_project');
		}

	if (($PARAM['err'] != '') && ($html->get_subs('error')=='')) {
		$html->message('error', $PARAM['err']);
		$html->parse('error');
		$html->assign('run_error', $html->fetch('error'));
		}
	printPage('run');
 	}
?>
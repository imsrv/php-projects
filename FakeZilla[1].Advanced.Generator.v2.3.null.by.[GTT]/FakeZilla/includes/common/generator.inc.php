<?php
// ------------------------------------------------------------------
// generator.inc.php
// ------------------------------------------------------------------

function Generate() {
 global $html;

	@set_time_limit(0);

	// check tmp file
	tmp_file($data, $_GET['tmp']);
	if (!$PROJECT = unserialize($data)) {
		$html->parse('close');
		echo $html->fetch('close');
		return;
		}

	// check referer
	if (dirname(ereg_replace('^https?://', '', $_SERVER[HTTP_REFERER])) != dirname($_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI])) {
		$html->parse('close');
		echo $html->fetch('close');
		return;
		}

	// contruct project
	$html->assign('title', get_setting('SITE_TITLE'));
	$html->assign('url', $PROJECT->Get('URL'));
	if ($PROJECT->Get('Referer')=='URL') {
		$html->assign('referer', $PROJECT->Get('Referer-Url'));
		$html->parse('referer_url');
		} else {
		$html->assign('referer', $PROJECT->Get('Referer-List'));
		$html->parse('referer_list');
		}
	if ($PROJECT->Get('User-Agent')=='Exact') {
		$html->assign('useragent', $PROJECT->Get('UserAgent-Exact'));
		$html->parse('useragent_exact');
		} else {
		$html->assign('useragent', $PROJECT->Get('UserAgent-List'));
		$html->parse('useragent_list');
		}
	$html->assign('proxy', $PROJECT->Get('Proxy'));
	if ($PROJECT->Get('Sim-Proxy')) {
		$html->parse('sim_proxy');
		}
	if ($PROJECT->Get('Total-hits-sent')) {
		$html->assign('total', $PROJECT->Get('Total-hits-sent'));
		$html->parse('total_hits');
		}
	if ($PROJECT->Get('Hits-per-hour')) {
		$html->assign('hour', $PROJECT->Get('Hits-per-hour'));
		$html->parse('hour_hits');
		}
	if ($PROJECT->Get('Method') == 'POST') {
		$_PARAMS = $PROJECT->Get('Param');
		for($i=0; $i<count($_PARAMS); $i++) {
			$html->assign('post_key', $_PARAMS[$i]['key']);
			$html->assign('post_value', $_PARAMS[$i]['value']);
			$html->parse('post_params');
			}
		$html->parse('post_param');
		}

	// start the session
	$html->parse('generator');
	echo $html->fetch('generator');

	// initiate session params
	require('./includes/common/reader-const.inc.php');
	require('./includes/common/reader-list.inc.php');
	if ($PROJECT->Get('Referer')=='URL'){
 		$Referer = new ReaderConst();
 		$Referer->Set($PROJECT->Get('Referer-Url'));
 		} else {
 		$Referer = new ReaderList();
 		$Referer->Set(get_setting('REFERER_DIR') . $PROJECT->Get('Referer-List'), TRUE);	// rewind
 		}
	if ($PROJECT->Get('User-Agent')=='Exact'){
 		$UserAgent = new ReaderConst();
 		$UserAgent->Set($PROJECT->Get('UserAgent-Exact'));
 		} else {
 		$UserAgent = new ReaderList();
 		$UserAgent->Set(get_setting('USERAGENT_DIR') . $PROJECT->Get('UserAgent-List'), TRUE);	// rewind
 		}
	$Proxy = new ReaderList();
	if ($Proxy->Set(get_setting('PROXY_DIR') . $PROJECT->Get('Proxy'))) {

		// create generator
		$GEN = new Fakezilla($PROJECT->Get('URL'),
			$PROJECT->Get('Sim-Proxy'),
			$PROJECT->Get('Total-hits-sent'),
			$PROJECT->Get('Hits-per-hour'),
			(($PROJECT->Get('Method') == 'POST')?$PROJECT->Get('Param'):NULL));
	
		while(($__proxy__ = $Proxy->Get()) && $GEN->Run()) {
			$__referer__ = $Referer->Get();
			$__useragent__ = $UserAgent->Get();
			$GEN->Connect($__proxy__, $__referer__, $__useragent__);
			$stats = $GEN->Stats();
	
			$html->assign('date', date('Y-M-d H:i:s', $stats[time]));
			$html->assign('proxy', $__proxy__);
			$html->message('connected', 'connected_' . intval($stats[connected]));
			$html->clear('status_0');
			$html->clear('status_1');
			$html->parse('status_' . intval((boolean) $stats[error]));
	
			$html->clear('stat_row');
			$html->parse('stat_row');
			echo $html->fetch('stat_row');
			flush();
			}
		}

	$UserAgent->Close();
	$Referer->Close();

	$html->parse('final');
	echo $html->fetch('final');
	}
?>
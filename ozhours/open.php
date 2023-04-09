<?php
$oc_closed = TRUE;



if (!file_exists(dirname(__FILE__).'/open_closed.ini.php')) {
	$oc_closed = TRUE;
} else {
	$oc_config = parse_ini_file(dirname(__FILE__).'/open_closed.ini.php', TRUE);
	if (isset($oc_config['time_offset']) && is_numeric($oc_config['time_offset'])) {
		$oc_current_date = (time() + ($oc_config['time_offset'] * 3600));
	} else {
		$oc_current_date = time();
	}

	$oc_weekday = strtolower(date("D", $oc_current_date));
	$oc_month = strtolower(date("M", $oc_current_date));
	$oc_day = strtolower(date("j", $oc_current_date));
	$oc_hour = strtolower(date("Hi", $oc_current_date));

	if (isset($oc_config['days_open']['days']) && ereg($oc_weekday, $oc_config['days_open']['days'])) {
		if (isset($oc_config['holidays'][$oc_month]) && ereg($oc_day, $oc_config['holidays'][$oc_month])) {
			$oc_closed = TRUE;
		} else {
			if (isset($oc_config['hours_open']['open']) && isset($oc_config['hours_open']['close']) && $oc_hour >= $oc_config['hours_open']['open'] && $oc_hour < $oc_config['hours_open']['close']) {
				$oc_closed = FALSE;
			} else {
				$oc_closed = TRUE;
			}
		}
	}
}
if(isset($oc_config['use']) && $oc_config['use'] == 'TEXT') {
	if (isset($oc_closed) && $oc_closed == FALSE) {
		echo $oc_config['text']['open'];
	} else {
		echo $oc_config['text']['close'];
	}
} else if(isset($oc_output) && $oc_output == 'TEXT') {
	if (isset($oc_closed) && $oc_closed == FALSE) {
		echo $oc_config['text']['open'];
	} else {
		echo $oc_config['text']['close'];
	}
} else {
	if (isset($oc_closed) && $oc_closed == FALSE) {
		header("Location: ".$oc_config['images']['open']);
	} else {
		header("Location: ".$oc_config['images']['close']);
	}
}

?>

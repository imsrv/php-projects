<?
// here you could insert the page_close() function for phplib..

if (STORE_PAGE_PARSE_TIME == '1')
{
	$parse_end_time = microtime();
	$time_start = explode(' ', $parse_start_time);
	$time_end = explode(' ', $parse_end_time);
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	
	if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != "")
	{
		$IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		$proxy = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		$host = @gethostbyaddr($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]);
	}
	else
	{
		$IP = $REMOTE_ADDR;
		$host = @gethostbyaddr($REMOTE_ADDR);
	}

	error_log($IP.' - '.$host.' - '.getenv(HTTP_USER_AGENT).' - ' .strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv(REQUEST_URI) . ' (' . $parse_time . 'ms)' . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
}
?>
<?
// ------------------------------------------------------------------
// fakezilla.inc.php
// ------------------------------------------------------------------

class Fakezilla {

	var $URL;
	var $Host;
	var $SimulateProxy = false;
	var $Total;
	var $PerHour;
	var $PostParams;

	var $timeStarted;

	var $LastError;
	var $LastDateTime;
	var $CountProcessed = 0;
	var $CountErrors = 0;

// constr
 function Fakezilla($_url, $_sim=NULL, $_total=NULL, $_per_hour=NULL, $_PARAM=null) {

 	$this->URL = $_url;
	$this->Host = preg_replace('~^http://([^/]+)(/.*)?$~Uis', '\\1', $this->URL);	// extract host

 	$this->timeStarted = time();
 	$this->SimulateProxy = (boolean)$_sim;
 	if(is_numeric($_total)) {
 		$this->Total = $_total;
 		}
 	if(is_numeric($_per_hour)) {
 		$this->PerHour = $_per_hour;
 		}
 	if (is_array($_PARAM)) {
 		for($i=0; $i<count($_PARAM); $i++){
 			$_PARAM[$i] = urlEncode($_PARAM[$i][key]).'='.urlEncode($_PARAM[$i][value]);
 			}
		$this->PostParams = join('&', $_PARAM);
 		}
 	}

//function Connect()
 function Connect($_proxy, $_ref=NULL, $_useragent=NULL){
 	
 	$this->CountProcessed++;

	// parse proxy
	list($_proxy_server, $_proxy_port) = explode(':', preg_replace("~\s+~",'',$_proxy));

	// construct header
	$header = (($this->PostParams)?'POST ':'GET ') . $this->URL . " HTTP/1.1\r\n";
	$header .= "Host: $this->Host\r\n";
	$header .= "Accept: */*\r\n"; /*~*/
	//$header .= "Accept-Language: en-us,en;q=0.5\r\n";
	//$header .= "Accept-Encoding: gzip,deflate\r\n";
	//$header .= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
	$header .= ($_useragent)?"User-Agent: $_useragent\r\n":"";
	$header .= ($_ref)?"Referer: $_ref\r\n":"";
	$header .= (($this->SimulateProxy)?("X-Forwarded-For: "
		.(rand()%256)
		."."
		.(rand()%256)
		."."
		.(rand()%256)
		."."
		.(rand()%256)
		."\r\n"):"");
	if ($this->PostParams){
		$header .= "Connection: keep-alive\r\n";
		//$header .= "Keep-Alive: 300\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen ($this->PostParams) . "\r\n\r\n";
		$header .= $this->PostParams;
		} else {
		
		$header .= "Connection: close\r\n\r\n";
		}

	// connect to proxy
	$fp = @fsockopen ($_proxy_server, $_proxy_port,
		$errno, $errstr,
		get_setting('CONNECT_TIMEOUT'));
	
	// failed to connect
	if (!$fp) {
		$_last_error = '01';	// error flag
		}

	// send request
	if ($_last_error == '') {
		@fputs ($fp, $header);
		while (!@feof($fp)) {
			$_output .= @fgets ($fp, 128);
			}
		@fclose($fp);
		}

	// parse response
	if (!$_last_error && preg_match("~^HTTP/1\.(0|1)\s(\d+)\s(\w+)\s~Uis", $_output, $R)) {

		switch ($R[2]) {
			case '200' :	// OK
				$_last_error = 0;
				break;
			
			case '301':	// moved permanently
			case '302':	// found
			
			case '400':	// bad request
			case '403':	// forbidden
			case '404':	// nor found
			
			case '502': 	// proxy error
				$_last_error = $R[2];

			default:
				if (!$_last_error) {
					$_last_error = 615;
					}
				break;
			}
		} else {
		$_last_error = 616;
		}

		
 	// calculate per-hour
 	if ($this->PerHour) {
		$Ps = $this->PerHour / 3600;
		$N = $this->CountProcessed - $this->CountErrors;
		$Tx = ($N / $Ps) - time() + $this->timeStarted;;

 		if ($Tx>0) {
 			sleep(floor($Tx));
 			}
 		}

	$this->LastError=$_last_error;

	$this->CountErrors += intval($this->LastError==0);
	
	$this->LastDateTime = time();

// ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
// DEBUG only
	if (@include_once('debug.php')) {
		debug_response($_proxy_server, $_proxy_port, $header, $_output);
		}
// ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
 	}

//function Stats()
 function Stats(){
 	return array(
 		'time'=>$this->LastDateTime,
 		'connected'=>(($this->LastError == '01')?1:0),	// O1 is the error code for "FAIL-2-CONNECT"
 		'error'=>$this->LastError
 		);
 	}

//function Run()
 function Run(){
 	return (($this->Total)?(($this->CountProcessed - $this->CountErrors)<$this->Total):(1));
 	}
 }
?>
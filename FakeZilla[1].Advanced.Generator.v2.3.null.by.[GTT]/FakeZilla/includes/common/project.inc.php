<?php
// ------------------------------------------------------------------
// project.inc.php
// ------------------------------------------------------------------

class Project {
	var $Title;
	
	var $PROJECT;
	
 // function Read()
 function Read($__file = NULL) {
 	if (file_exists($__file) && is_file($__file)) {
 		$this->Title = urlDecode(basename($__file));
 		
 		// read file
 		$_FILE = @file($__file);
 		for($i=0; $i<count($_FILE); $i++) {
 			if (preg_match('~^\s*(;.*)?$~Uis', $_FILE[$i])) {
 					continue;	// comments
 					}
 			if (preg_match('~^\s*([a-z][a-z0-9-]+)\s*=\s*(.*)\s*$~Uis', $_FILE[$i], $R)) {
 				$this->PROJECT[$R[1]] = ($_arr = unserialize($R[2]))?$_arr:$R[2];
 				}
 			}
 		}
 	}

 // function Load
 function Load($_CNTNR) {

	$KEYS = array(
		'URL',
		'Referer',
		'Referer-Url',
		'Referer-List',
		'User-Agent',
		'UserAgent-Exact',
		'UserAgent-List',
		'Method',
		'Param',
		'Proxy',
		'Sim-Proxy',
		'Hits-per-hour',
		'Total-hits-sent'
		);	

	$NUMERIC = array(
		'Sim-Proxy',
		'Hits-per-hour',
		'Total-hits-sent'
		);

	for ($i=0; $i<count($KEYS); $i++) {

		// valid number
		if (in_array($KEYS[$i], $NUMERIC)) {

			if (is_numeric($_CNTNR[$KEYS[$i]])) {
				$this->PROJECT[$KEYS[$i]] = $_CNTNR[$KEYS[$i]];
				} else {
				$this->PROJECT[$KEYS[$i]] = '';
				}
			
			} else {
			
			$this->PROJECT[$KEYS[$i]] = $_CNTNR[$KEYS[$i]];
			}
		}
	$this->Title = $_CNTNR['Project-title'];


	// reduce post params
	$_REDUCED = array();
	for ($i=0; $i<@count($this->PROJECT['Param']); $i++) {

		if (trim($this->PROJECT['Param'][$i][key])) {
			$_REDUCED[] = $this->PROJECT['Param'][$i];
			}

		}

	$this->PROJECT['Param'] = $_REDUCED;
	}


 // function Save
 function Save() {
 	
	// check title
	if (!$this->Title) {
		$this->Title = date('Y-m-d~His') . '~project.txt';
		}

	// generate file
	$data = ";" . str_repeat('~', 2 + strlen(get_setting('SITE_TITLE'))) . "\n";
	$data .= ";\n";
	$data .= "; " . get_setting('SITE_TITLE') . "\n";
	$data .= "; " . date('D, Y-M-d H:i:s') . "\n";
	$data .= ";\n";
	$data .= ";" . str_repeat('~', 2 + strlen(get_setting('SITE_TITLE'))) . "\n\n";

	while(list($k,$v)=each($this->PROJECT)){
		if (!is_array($v)) {
			$data .= "$k=$v\n";
			} else {
			$data .= "$k=" . serialize($v) . "\n"; 
			}
		}

	// check filename
	if (file_exists(get_setting('PROJECT_DIR') . $this->Title)) {
		@rename(get_setting('PROJECT_DIR') . $this->Title,
			get_setting('TEMPORARY_DIR') . 'OVERWRITEN_project_' . $this->Title);
		}


	// save project file
	if ($fp = fopen(get_setting('PROJECT_DIR') . $this->Title, 'w')) {
		fwrite($fp, $data);
		fclose($fp);
		chmod(get_setting('PROJECT_DIR') . $this->Title, 0666);
		} 
 	}

 // function Get
 function Get($__key__) {
 	return $this->PROJECT[$__key__];
 	}
 }
?>
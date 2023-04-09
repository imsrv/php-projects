<?

class stopwatch{
	var $entries;
	
	function stopwatch(){
		$this->entries = array();
	}
	
	function register($message){
		$entry_a["time"] = microtime();
		$entry_a["message"] = $message;
		array_push($this->entries, $entry_a);
	}
	
	function dump(){
		reset($this->entries);
		while ( list($k, $blah) = each($this->entries) ){
			$a = $this->entries[$k];
			echo $a["time"].":".$a["message"]."<br>\n";
		}
	}
}

?>
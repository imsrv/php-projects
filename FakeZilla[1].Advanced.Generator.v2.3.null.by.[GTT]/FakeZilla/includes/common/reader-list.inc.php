<?
// ------------------------------------------------------------------
// reader-list.inc.php
// ------------------------------------------------------------------

 class ReaderList {

	var $fp;
	var $rewind;

// function Set()
 function Set($var, $_rewind=NULL) {
 	$this->rewind = (boolean) $_rewind;
 	return ($this->fp = @fopen($var, 'r'));
 	}

// function Get()
 function Get() {

 	if(@feof($this->fp)) {
 		if ($this->rewind) {
 			if (@rewind($this->fp)){
 				return $this->Get();
 				}
 			} else {
 			@fclose($this->fp);
 			return false;
 			}

 		} else {
		do {	$__line__ = trim(@fgets($this->fp));
			} while (!$__line__ && (!@feof($this->fp)));

		return $__line__;
		};

 	}

// function Close()
 function Close() {
 	if ($this->fp) {
 		@fclose($this->fp);
 		}
 	}
 }
?>
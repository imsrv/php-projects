<?
// ------------------------------------------------------------------
// reader-const.inc.php
// ------------------------------------------------------------------

 class ReaderConst {

	var $Const;

// function Set()
 function Set($var) {
 	$this->Const = $var;
 	}

// function Get()
 function Get() {
 	return $this->Const;
 	}

// function Close()
 function Close() {
 	// compatibility dummy
 	}
 }
?>
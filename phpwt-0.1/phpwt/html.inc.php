<?php
// (c) 2005 Paolo Ardoino < paolo.ardoino@gmail.com >

include_once("misc.inc.php");



function getTagField($tag, $fieldname) {
	$field = "";
	$ttag = substr($tag, 1, strpos($tag, '>') - 1);
	if(($pos = strposi($ttag, $fieldname)) !== false) {
		$tmpfield = substr($ttag, $pos + strlen($fieldname));
		if($tmpfield[0] == '"' || $tmpfield[0] == "'") {
			if($tmpfield[0] == '"') {
				$tmpfield = substr($tmpfield, 1);
				$field = substr($tmpfield, 0, strpos($tmpfield, '"'));
			}
			if($tmpfield[0] == "'") {
				$tmpfield = substr($tmpfield, 1);
				$field = substr($tmpfield, 0, strpos($tmpfield, "'"));
			}
		}
		else {
			if(strpos($tmpfield, ' ') > 0)
				$field = substr($tmpfield, 0, strpos($tmpfield, ' '));
			else
				$field = $tmpfield;
		}
	}
	return $field;
}

function getTags($source, $start, $end) {
	$tmp = $source;
	for($i = 0; strlen($tmp) > 0; $i++) {
		if(($postagst = strposi($tmp, $start)) == false) 
			break;
		$tmp = substr($tmp, $postagst);
		$postagend = strposi($tmp, $end);
		if($postagend > 0)
			$tags[$i] = substr($tmp, 0, $postagend + strlen($end));
		else {
			$tags[$i] = $tmp;
		}
		$tmp = substr($tmp, strlen($tags[$i]));
	}
	return $tags;
}

?>

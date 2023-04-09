<?
/////////////////////////////////////////////////////////
//	
//	include/read_contacts.FS.inc
//
//	(C)Copyright 2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Read contact list, return array of associative arrays as $contacts
		Each record must contain at least 4 fields: id, name, email, group
	PRE-CONDITIONS:
		Assume session_auth.inc has been included at this point, and any variables
		initialized by said include may be assumed.
	POST-CONDITIONS:
	COMMENTS:
		Default version uses file based system.
		May be replaced by DB based one.

********************************************************/

include_once("../include/sort2darray.inc");

$filePath = $userPath."/contacts.dat";

$fp = fopen($filePath, "a");		//force create file
if ($fp) fclose($fp);

$lines = file($filePath);

if (is_array($lines)){
	$i=0;
	while ( list($key, $line) = each ($lines) ){
		$a = explode(",", chop($line));
		while ( list($k2, $data) = each($a) ){
			list($type, $string) = explode(":", $data);
			if ($type!="id") $string = base64_decode($string);
			$contacts[$i][$type] = $string;
		}
		$i++;
	}
}else{
		$contacts = array();
}

if (empty($sort_field)) $sort_field = "grp,name";
if (empty($sort_order)) $sort_order = "ASC";

$sort_a = explode(",", $sort_field);
$num_fields = count($sort_a);
for ($i=$num_fields;$i>0;$i--){
	$contacts = sort2darray($contacts, $sort_a[$i-1], $sort_order);
}
?>
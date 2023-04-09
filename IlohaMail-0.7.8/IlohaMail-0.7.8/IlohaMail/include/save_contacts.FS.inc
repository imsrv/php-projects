<?
/////////////////////////////////////////////////////////
//	
//	include/save_contacts.FS.inc
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
		Save contacts list to data source.
		Also delete records if so specified.
	PRE-CONDITIONS:
		$contacts - 2D array containing contacts info
		[$delete] - Set if item needs to be deleted
		[$delete_item] - "id" of record to be deleted
	COMMENTS:
		Currently for file-based backend.
		Ironically, for DB-based backends, the only functionality that needs to be implemented
		here is the delete feature, as all INSERT and UPDATE operations should be performed
		on the fly by "include/add_contacts.inc"
		
********************************************************/

$filePath = $userPath."/contacts.dat";

$fp = fopen($filePath, "w+");
if ($fp){
	reset($contacts);
	$i=0;
	while ( list($key, $foo) = each($contacts)){
		if ((!isset($delete)) || ($delete_item != $contacts[$key]["id"] )){
			$line="id:".$i;
			while ( list($k2, $val)= each($contacts[$key])) if ($k2!="id") $line .= ",".$k2.":".base64_encode($val);
			fputs($fp, $line."\n");
			$i++;
		}
	}
	fclose($fp);
}

?>
<?
/////////////////////////////////////////////////////////
//	
//	include/add_contacts.FS.inc
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
		Add/update contact data.
	PRE-CONDITIONS:
		$contacts - array of contacts
		$edit - ID (-1 for new, >= 0 for update)
		POST'd data from "source/edit_contact.php"
	COMMENTS:
		For DB based backends, simply run INSERT to UPDATe querries, and make sure
		$contacts is also updated appropriately.
		
********************************************************/

$k = -1;

if ($edit >= 0){
	reset($contacts);
	while ( list($key, $foobar) = each($contacts)){
		if ($contacts[$key]["id"]==$edit) $k = $key;
	}
}else{
	$k = $numContacts;
}

if ($k >= 0){
    $new_contact_array["id"] = $k;
    $contacts[$k] = $new_contact_array;
}

include("../include/save_contacts.inc");
$contacts = array();
include("../include/read_contacts.inc");

?>
<?
/////////////////////////////////////////////////////////
//	
//	include/add_contacts.inc
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
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
    $backend_array = $new_contact_array;
    $backend_table = $mysql_contacts;
    $backend_dataID = $edit;
    $backend_operation = ($edit >= 0 ? "UPDATE":"INSERT");
    
    include("../include/backend.MySQL.inc");
	
	include("../include/read_contacts.inc");
?>
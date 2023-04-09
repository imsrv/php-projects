<?
/////////////////////////////////////////////////////////
//	
//	include/save_contacts.MySQL.inc
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
if ((!isset($delete)) || ($delete_item>0)){
    $backend_table = $mysql_contacts;
    $backend_operation = "DELETE";
    $backend_dataID = $delete_item;
    
    include("../include/backend.MySQL.inc");
    
	include("../include/read_contacts.inc");
}
?>
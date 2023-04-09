<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
function BannedList($GroupID){
	$Groups=mysql_query("SELECT * FROM banned_emails WHERE BannedGroup='$GroupID'");
	while($Group=mysql_fetch_array($Groups)){
		$i++;
		$All_Banned[$i][ID]=$Group[BannedID];
		$All_Banned[$i][Email]=$Group[BannedEmail];
		$All_Banned[$i]["BannedDate"]=PrintableDate($Group["BannedDate"]);
	}
	return $All_Banned;
}

function NumberofBanned($GroupID){
	return mysql_num_rows(mysql_query("SELECT * FROM banned_emails WHERE BannedGroup='$GroupID'"));
}


function AddBannedGroup($NewGroupName){
	mysql_query("INSERT INTO banned_groups SET BannedGroupName='$NewGroupName'");
}

function AddBanned($GroupID,$Email){
	  if(mysql_num_rows(mysql_query("SELECT * FROM banned_emails WHERE BannedGroup='$GroupID' && BannedEmail LIKE '$Email'"))<1){
			mysql_query("INSERT INTO banned_emails SET BannedGroup='$GroupID', BannedEmail='$Email', BannedDate='".time()."'");	
		}
}

function BannedGroup($BannedID){
	$info=mysql_fetch_array(mysql_query("SELECT * FROM banned_emails WHERE BannedID='$BannedID'"));
	return $info[BannedGroup];
}

function DeleteBanned($BannedID){
	mysql_query("DELETE FROM banned_emails WHERE BannedID='$BannedID'");
}


function UpdateBannedGroupName($GroupID,$NewName){
	mysql_query("UPDATE banned_groups SET BannedGroupName='$NewName' WHERE BannedGroupID='$GroupID'");
}

function BannedGroupName($GroupID){
	$GroupInfo=mysql_fetch_array(mysql_query("SELECT * FROM banned_groups WHERE BannedGroupID='$GroupID'"));
	return $GroupInfo[BannedGroupName];
}

function DeleteBannedGroup($GroupID){
	mysql_query("DELETE FROM banned_emails WHERE BannedGroup='$GroupID'");
	mysql_query("DELETE FROM banned_groups WHERE BannedGroupID='$GroupID'");	
}

?>
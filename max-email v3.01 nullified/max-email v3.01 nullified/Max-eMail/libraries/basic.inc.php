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
//date stuff!
function PrintableDate($TimeStamp){
	return date("j M Y",$TimeStamp);
}



//error codes
$error["Error101"]="Not a list.";
$error["Error202"]="Database error.";
$error["Error203"]="Datafile error.";
$error["Error204"]="Unique key error!";
$error["Error205"]="List has errors, please run list auditor to correct these!";
$error["Error401"]="Unable to edit list data.";
$error["Error402"]="You are not authorised to perform that action.<BR><BR> Please contact the System Manager for access to this component.";
$error["Error403"]="Form input error..";

function HandleError($ErrorCode,$is_fatal=0){
global $error;
	if($is_fatal==1){
		echo $error[$ErrorCode];
		exit;
	}elseif($is_fatal==2){
		return $error[$ErrorCode];
	}else{
		echo $error[$ErrorCode];	
	}
}
?>
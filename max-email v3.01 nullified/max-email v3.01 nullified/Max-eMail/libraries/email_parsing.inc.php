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

function SendEmail($RecipientEmail, $Body, $Headers, $SendID, $Subject){

	if($RecipientEmail){

$SendInfo=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
			if($SendInfo[Method]=="normal"){
			if(mail($RecipientEmail, $Subject, $Body, $Headers)){
					return 1;
				}else{
					return 0;
				}
			}	
		
	}else{
		return 0;
	}



}


function ParseFields($ListID, $Email, $member_data){

if($ListID!="NONE"){
$list_info=list_info($ListID);

//list fields!
$list_fields=list_fields($ListID);
	foreach($list_fields as $field){
		$Email=str_replace("%LISTFIELD:$field%", $member_data[$field], $Email);
	}
}
	
//autofill fields!
$autofill=mysql_query("SELECT * FROM autofill_fields");
	while($af=mysql_fetch_array($autofill)){
		if(CanPerformAction("use|autofill|".$af[AutoFillGroupID])){
			if($af[Type]=="basic"){
				$Email=str_replace($af[AutoFillField], $af[ReplaceWith], $Email);
			}elseif($af[Type]=="date"){
				$Email=str_replace($af[AutoFillField], date($af[ReplaceWith]), $Email);		
			}
		}
	}
	
//extra content!
$content=mysql_query("SELECT * FROM content_items");
while($co=mysql_fetch_array($content)){
	if(CanPerformAction("use|content|".$co[ContentCatID])){
		$concat=mysql_fetch_array(mysql_query("SELECT * FROM content_cats WHERE ContentCatID='".$co[ContentCatID]."'"));
		$fi=mysql_query("SELECT * FROM content_fields WHERE ContentCatID='".$co[ContentCatID]."'");
						$ThisText=$concat[TextFormat];
						$ThisHTML=$concat[HTMLFormat];
						while($if=mysql_fetch_array($fi)){
							$dat=mysql_fetch_array(mysql_query("SELECT * FROM content_data WHERE ContentID='".$co[ContentID]."' && FieldID='".$if[FieldID]."'"));
							$ThisText=str_replace("%".$if[FieldName]."%", $dat[Data], $ThisText);
							$ThisHTML=str_replace("%".$if[FieldName]."%", $dat[Data], $ThisHTML);
						}
		$Email=str_replace("%HTMLCONTENT:".$co[ContentID]."%", $ThisHTML, $Email);
		$Email=str_replace("%TextCONTENT:".$co[ContentID]."%", $ThisText, $Email);
	}
}


return $Email;
}






?>
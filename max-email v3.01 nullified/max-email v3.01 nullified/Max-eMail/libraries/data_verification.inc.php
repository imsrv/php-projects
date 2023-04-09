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

function DV_Valid_And_Unique_Email($data,$FormID){
	$form=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"));	
	$Lists=explode(",",$form[Lists]);
	foreach($Lists as $ListID){
	if($ListID){
		$members_array2=filter_members(list_info($ListID),"x-email == $data", parse_member_list(list_info($ListID),get_list_members($ListID)));
		if(sizeof($members_array2)>=1){
			$bad=1;
		}
	}
	}
	
	if(!$bad){
		return DV_Valid_Email_Format;
	}else{
		return 0;
	}
}

//////////////////////////////////////////////////////


function DV_Valid_Email_Address($data,$FormID){
   if (eregi("^[a-z0-9]+([\.%!][_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$",$data)){ 
      return 1; 
    }else{ 
      return 0; 
    }
}






?>
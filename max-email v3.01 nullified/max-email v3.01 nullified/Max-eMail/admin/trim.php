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
include "../config.inc.php";


if($action){
			if(CanPerformAction("use|trim|$ListID")!=1){

				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "use":
		TrimList();
		break;
			
	}
}else{
	TrimMain();
}

/////////////////////////////////////////////////////////////

function DuplicateEmails(){
	GLOBAL $FULL_OUTPUT, $ListID;
	
	$members_array=parse_member_list(list_info($ListID),get_list_members($ListID)); 
	
		$dune[]='';
	if($members_array){foreach($members_array as $member){
		if($member["x-email"] && !in_array($member["x-email"], $dune)){
			$dune[]=$member["x-email"];
		$members_array2=filter_members(list_info($ListID),"x-email == ".$member["x-email"], parse_member_list(list_info($ListID),get_list_members($ListID)));
			if(sizeof($members_array2)>=2){
				$BO.='The email address <B>'.$member["x-email"].'</B> is replicated in this list '.sizeof($members_array2).' times. You need to select which one below to keep!<P>';
				foreach($members_array2 as $member2){
					$x++;
					$BO.='<B>Member '.$x.' with email address:</B><BR>Unique Key: '.$member2["x-unique"].'<BR>'.MakeLink("trim.php?action=use&ListID=$ListID&TrimMethod=duplicates&stage=one&RemoveUnique=".$member2["x-unique"], "Remove this one",1).'<P>';
				}
				break;
				$one=1;
			}
		}
	}}
	
	if(!$one){
		$BO.='No more duplicates found on this list!<P>'.MakeLink("trim.php", "Return to trim main");
	}
	
	$FULL_OUTPUT.=MakeBox("Duplicated email addresses!", $BO);

}

/////////////////////////////////////////////////////////////

function BouncedList(){
	GLOBAL $ListID, $FULL_OUTPUT;
	
	$BO.='<table width=100%>
	<TR><TD><span class="admintext">Email</span></td><TD><span class="admintext">Times</span></td><TD><span class="admintext">Options</span></td></tr><tr height="1" bgcolor="#cccccc"><td colspan="3"></td></tr>';
	$emails=mysql_query("SELECT * FROM bounced_emails");
		while($e=mysql_fetch_array($emails)){
			$members_array=filter_members(list_info($ListID),"x-email == ".$e[Email], parse_member_list(list_info($ListID),get_list_members($ListID)));
			$dune[]='';
			if($members_array && !in_array($e[Email], $dune)){
				$dune[]=$e[Email];
				$mem=current($members_array);
				$times=mysql_num_rows(mysql_query("SELECT * FROM bounced_emails WHERE Email LIKE '".$mem["x-email"]."'"));
				$BO.='<tr><td><span class="admintext">'.$mem["x-email"].'</span></td><td><span class="admintext">'.$times.'</span></td><td><span class="admintext">'.MakeLink("trim.php?action=use&ListID=$ListID&stage=one&TrimMethod=bounced&RemoveUnique=".$mem["x-unique"], "Remove").'</span></td></tr>';
			}
		}
		$BO.='</table><P>';
	
	$BO.=MakeLink(MakePopup("check_bounces.php?ListID=$ListID",50,50,"BouncesCheck"), "Check for bounced emails").' | '.MakeLink("trim.php", "Back to trim main");
	
	$FULL_OUTPUT.=MakeBox("Bounced Emails", $BO);
	
}	

/////////////////////////////////////////////////////////////

function TrimList(){
	GLOBAL $ListID, $TrimMethod, $stage, $FULL_OUTPUT, $RemoveUnique;
		
	if($RemoveUnique){
		remove_member($ListID, $RemoveUnique);
	}	
		
	//check that the list is ok audit wise!
	$errors=audit_list($ListID);
	if($errors){
		$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error205",2));
		FinishOutput();
	}
	
	
	if($stage=="one"){
		if($TrimMethod=="bounced"){
			BouncedList();
		}
		if($TrimMethod=="duplicates"){
			DuplicateEmails();
		}
	}
	

}

/////////////////////////////////////////////////////////////

function TrimMain(){
	GLOBAL $FULL_OUTPUT;
	
	$lists=mysql_query("SELECT * FROM lists");
		while($l=mysql_fetch_array($lists)){
			if(CanPerformAction("use|trim|".$l[ListID])==1){
				$alllists.=$l[ListID].'->'.$l[ListName].';';
			}
		}
			$FORM_ITEMS["Select list"]="select|ListID:1:$alllists";
			$FORM_ITEMS["Trim method"]="select|TrimMethod:1:bounced->Bounced Addresses;duplicates->Duplicate Emails";
			$FORM_ITEMS[-1]="submit|Continue";
		
				//make the form
				$FORM=new AdminForm;
				$FORM->title="LinkReports";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="trim.php?action=use&stage=one";
				$FORM->MakeForm();
				$BO.=$FORM->output;
				
				
	$FULL_OUTPUT.=MakeBox("Trim options", $BO);

}


FinishOutput();

?>
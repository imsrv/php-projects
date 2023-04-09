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


	if($Lists){
		foreach($Lists as $list){
			//check if the list is valid!
			if(!$list_info=list_info($list)){
				$FULL_OUTPUT=MakeBox("ERROR OCCURRED!",HandleError("Error101",2));
				FinishOutput();
			}
		
			if(CanPerformAction("$action|members|$list")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURRED!",HandleError("Error402",2));
				FinishOutput();
			}
		}
	}elseif($action=="view"){
		$FULL_OUTPUT=MakeBox("ERROR OCCURRED!",HandleError("Error403",2));
		FinishOutput();
	}else{
		//check if the list is valid!
		if(!$list_info=list_info($ListID)){
			$FULL_OUTPUT=MakeBox("ERROR OCCURRED!",HandleError("Error101",2));
			FinishOutput();
		}
		
		if(CanPerformAction("$action|members|$ListID")!=1){
			$FULL_OUTPUT=MakeBox("ERROR OCCURRED!",HandleError("Error402",2));
			FinishOutput();
		}		
	}
	
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "edit":
		EditMembers();
		break;
		
		case "view":
		ViewMembers();
		break;
		
		case "main":
		MembersMain();
		break;
			
	}
}else{
	MembersMain();
}


/////////////////////////////////////////////////////////////





function MembersMain(){
	GLOBAL $FULL_OUTPUT;

//CREATE SEARCH FOR MEMBERS BOX!
	//define the objects of the main search form!
	$FORM_ITEMS["Filter String"]="textfield|FilterString:200:50::";
	$FORM_ITEMS[-2]="spacer|".MakeLink(MakePopup('filterstring_popup.php',600,400,"FilterBy"),"Filter String Wizard");
	$FORM_ITEMS["Lists to view"]="checkboxes|Lists:".AllListsInList("ListID->ListName;","view");
	$FORM_ITEMS["Records per page"]="textfield|PerPage:4:4:10:";
	$FORM_ITEMS[-1]="submit|Search Now";
	//make the form
	$FORM=new AdminForm;
		$FORM->title="MemberSearch";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="members.php?action=view";
		$FORM->MakeForm();
	$THIS_OUTPUT=$FORM->output;
	
	$FULL_OUTPUT.=MakeBox("Search/View/Manage Members",$THIS_OUTPUT);
	
}
/////////////////////////////////////////////////////////////


function ViewMembers(){
GLOBAL $PerPage, $OffSet, $Lists,$FULL_OUTPUT, $FilterString;


	if($MemberID){
		//the user wants to view the members complete details!
		
	}else{
	
	foreach($Lists as $List){
		$bl++;
		$ListCarry.='<input type="hidden" name="Lists['.$bl.']" value="'.$List.'">';
		if($FilterString){
		$FilterString=trim($FilterString);
		$tempmembers=filter_members(list_info($List), $FilterString, parse_member_list(list_info($List), get_list_members($List)));
		}else{
			$tempmembers=parse_member_list(list_info($List), get_list_members($List));
		}	
			if($tempmembers){
				foreach($tempmembers as $member){
					$f++;
					$members[$f]=$member;
				}
			}
	}
		
	
		//get field names for this list!
		$All_Fields["Email"]="x-email";
		$All_Fields["Receiving Status"]="x-receiving";
		$All_Fields["Format"]="x-format";
		$All_Fields["Unique Key"]="x-unique";
		$All_Fields["List"]="x-listname";
		
		$Table='<TABLE width="100%" cellpadding="4" cellspacing="0"><TR>';
		
		foreach($All_Fields as $title=>$syskey){
			$Table.='<TD><span class="admintext"><U>'.$title.'</U></span></TD>';
		}
		
		$Table.='</TR>';
		
		if($members){
			if(!$OffSet){$OffSet=0;}
		
		foreach($members as $mem_key=>$member){
		  if($member["x-unique"]){
		  $TotalMembers++;
		  }
		}
		reset($members);
		$members=array_slice($members, $OffSet, $PerPage);
		
		foreach($members as $mem_key=>$member){
		  if($member["x-unique"]){
		  $Table.='<TR>';	
			foreach($All_Fields as $title=>$syskey){
				$Table.='<TD><span class="admintext">'.$member[$syskey].'</span></TD>';
			}
			$Table.='<TD>'.MakeLink('members.php?action=edit&PerPage='.$PerPage.'&OffSet='.$OffSet.'&ListID='.$member["x-listid"].'&MemberUnique='.$member["x-unique"].'"', "More..").'</TD>';
		  $Table.='</TR>'."\n\n";
		  }
		
		}
		$Table.='</TABLE><BR>';
		
//next and prev buttons + stats on list display!		
		//is the next button disabled?!
		if($TotalMembers<=$OffSet+$PerPage){
			$NextDis="disabled";
		}
		
		if($OffSet==0){
			$PrevDis="disabled";
		}
		
		
		$Table.='<HR size="1" color="#006699" width="90%"><TABLE width="100%" cellpadding="4" cellspacing="0"><TR>
		<TD width="70%"><span class="admintext">Currently displaying record '.$OffSet.' to  '.($OffSet+$PerPage).
		' of '.$TotalMembers
		.' records!</span></TD>
		<TD align="right">
		<FORM action="members.php?action=view" method="post">
		<input type="hidden" name="PerPage" value="'.$PerPage.'">
		<input type="hidden" name="OffSet" value="'.($OffSet-$PerPage).'">
		<input type="hidden" name="FilterString" value="'.$FilterString.'">';
		$Table.=$ListCarry;			
		$Table.='
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" '.$PrevDis.' value="<<Previous '.$PerPage.' Results" class="inputfields">
		</FORM>
		</td>
		<TD align="right">		
		<FORM action="members.php?action=view" method="post">
		<input type="hidden" name="PerPage" value="'.$PerPage.'">
		<input type="hidden" name="OffSet" value="'.($OffSet+$PerPage).'">
		<input type="hidden" name="FilterString" value="'.$FilterString.'">';
		$Table.=$ListCarry;			
		$Table.='
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" '.$NextDis.' value="Next '.$PerPage.' Results>>" class="inputfields">
		</FORM>
		</TD></TR></TABLE>';		
		
		}else{
			$Table="No records found suiting your criteria<BR><BR>";
		}
		
		$FULL_OUTPUT.=MakeBox("View Members", $Table);
		
	}
}
/////////////////////////////////////////////////////////////



function EditMembers(){
GLOBAL $FULL_OUTPUT,$FilterString, $OffSet, $PerPage, $ListID,$MemberUnique,$EditedFields,$DeleteUnique, $RemoveUnique;

//audit the lists!
$ListErrors=audit_list($ListID);
if($ListErrors){
	$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error205",2));
	FinishOutput();
}

	if($RemoveUnique){
		remove_member($ListID, $RemoveUnique);
		$FULL_OUTPUT.=MakeBox("Member removed", 'The member has been permenantely removed from the list');
		MembersMain();
		FinishOutput();
	}


	if($EditedFields){
		if($error=edit_member($ListID,$EditedFields,"AdminEdit")){
			$FULL_OUTPUT.=MakeBox("Error Occured", $error);
		}else{
			$FULL_OUTPUT.=MakeBox("Edit Successful", "User was edited successfully");		
		}
	}
	
		$list_info=list_info($ListID);
		//print a form for admin to enter editing options!
		$FilterString="x-unique == $MemberUnique";
		$tempmembers=filter_members($list_info, $FilterString, parse_member_list($list_info, get_list_members($ListID)));
		
		$member=current($tempmembers);
		$All_Fields["Email"]="x-email";
		$All_Fields["Receiving Status"]="x-receiving";
		$All_Fields["Format"]="x-format";
		$All_Fields["Unique Key"]="x-unique";
		$All_Fields["List"]="x-listname";
		$All_Fields["ListID"]="x-listid";
		$All_Fields["UNIQUEKEY"]=$list_info[UniqueField];
				
			$EditForm='<B><center>Unique Key ('.$list_info[UniqueField].'): '.$member[$list_info[UniqueField]].'</center></b>';
			
			foreach($member as $name=>$item){
				if($name==$list_info[UniqueField]){
					$FORM_ITEMS[-2]="hidden|EditedFields[$name]:$item";
				}else{
					if(!in_array($name,$All_Fields)){
						//decide what sort of field this should be!
						   if($name==$list_info["ReceivingField"]){
								list($recval,$nrecval)=explode("/", $list_info["ReceivingValues"]);
								$FORM_ITEMS["$name"]="select|EditedFields[$name]:1:".$recval."->Receiving;".$nrecval."->Not Receiving:$item";						   	
						   }elseif($name==$list_info["FormatField"]){
						   		list($html,$text)=explode("/", $list_info["FormatValues"]);
								$FORM_ITEMS["$name"]="select|EditedFields[$name]:1:".$html."->HTML;".$text."->Text:$item";						   	
						   }else{
								$FORM_ITEMS["$name"]="textfield|EditedFields[$name]:200:50:$item:";
							}
					}
				}
			}
		
		
		$FORM_ITEMS[-1]="submit|Save Changes";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="My Form";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="members.php?action=edit&ListID=$ListID&MemberUnique=$MemberUnique";
		$FORM->MakeForm();
		$EditForm.=$FORM->output;

		
	     $FULL_OUTPUT.=MakeBox("Edit Member of '".$list_info[ListName]."'", $EditForm.'<P>'.MakeLink("members.php?action=edit&ListID=$ListID&RemoveUnique=$MemberUnique&OffSet=$OffSet&PerPage=$PerPage", "Remove Member",1));
		
		reset($member);
		$MemberInfo='
		<BR><B>Email:</B> '.$member["x-email"].'
		<BR><B>Unique Value:</B> '.$member["x-unique"].' 
		<BR><B>Receiving:</B> '.$member["x-receiving"].'
		<BR><B>Format:</B> '.$member["x-format"].'
		<BR><B>ListName:</B> '.$member["x-listname"].'';
		
		
		 $FULL_OUTPUT.=MakeBox("Info on this member", $MemberInfo);		
		
	


}





/////////////////////////////////////////////////////////////




		


FinishOutput();

?>



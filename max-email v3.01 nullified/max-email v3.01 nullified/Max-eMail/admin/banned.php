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

	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "edit":
		EditBanned();
		break;
		
		case "view":
		ViewBanned();
		break;
		
		case "groups":
		BannedGroups();
		break;
				
		case "main":
		BannedMain();
		break;
			
	}
}else{
	BannedMain();
}


/////////////////////////////////////////////////////////////

function BannedMain(){
	GLOBAL $FULL_OUTPUT;
	
	$Groups=mysql_query("SELECT * FROM banned_groups");
	$AllGroups='->-- SELECT ONE --;';
	while($Group=mysql_fetch_array($Groups)){
		if(CanPerformAction("view|banned|".$Group[BannedGroupID])){
			$THIS_OUT.="<BR><BR>".MakeLink("banned.php?action=view&BannedGroupID=".$Group[BannedGroupID],"View '".$Group[BannedGroupName]."' which has ".NumberofBanned($Group[BannedGroupID])." emails on it!");
		}
	}
	
	$THIS_OUT.="<BR><BR>";
	
	$FULL_OUTPUT.=MakeBox("View Banned Emails",$THIS_OUT);
	
	
	if(CanPerformAction("groups|banned|*")){
		  $Groups=mysql_query("SELECT * FROM banned_groups");
			$AllGroups='->-- SELECT ONE --;';
			while($Group=mysql_fetch_array($Groups)){
				$AllGroups.=$Group[BannedGroupID]."->".$Group[BannedGroupName].";";
			}
			
				$FORM_ITEMS["Edit a Group"]="select|GroupID:1:$AllGroups::onChange=\"submit()\"";
				$FORM_ITEMS[-1]="spacer|&nbsp;";
	//make the form
	$FORM=new AdminForm;
		$FORM->title="My Form";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="banned.php?action=groups";
		$FORM->MakeForm();
	$BannedGroups=$FORM->output;
			
			$BannedGroups.='<HR size="1" width="80%">';
			
				$FORM_ITEMS2["Add a group called"]="textfield|NewGroupName";
				$FORM_ITEMS2[-1]="submit|Add Now";
	//make the form
	$FORM2=new AdminForm;
		$FORM2->title="My Form";
		$FORM2->items=$FORM_ITEMS2;
		$FORM2->action="banned.php?action=groups";
		$FORM2->MakeForm();
	$BannedGroups.=$FORM2->output;
		  
		  
		  
		$FULL_OUTPUT.=MakeBox("Manage Banned Groups",$BannedGroups);
	}
}

/////////////////////////////////////////////////////////////

function ViewBanned(){
GLOBAL $FULL_OUTPUT,$BannedGroupID,$Page,$BannedPerPage;

$PerPage=$BannedPerPage;

if(CanPerformAction("view|banned|$BannedGroupID")){
	$All_Banned=BannedList($BannedGroupID);
		
		$TABLE='<TABLE width="100%" cellpadding="4" cellspacing="0">
		<TR><TD><span class="admintext"><B>Email Address</B></span></TD><TD><span class="admintext"><B>Date Banned</B></span></TD></TR>
		
		';
		

		
		
		if($All_Banned){
		$All_Banned_Backup=$All_Banned;
		$All=sizeof($All_Banned_Backup);
		$Pages=round($All/$PerPage);
				if(!$Page){$Page=0;}
				
			
			$All_Banned=array_splice($All_Banned,($Page*$PerPage),$PerPage);
			foreach($All_Banned as $Banned){
				if($Banned[Email]){
					$TABLE.='<TR><TD><span class="admintext">'.$Banned[Email].'</span></TD><TD><span class="admintext">'.$Banned["BannedDate"].'</span></TD>';
						if(CanPerformAction("edit|banned|$BannedGroupID")){
							$TABLE.='<TD><span class="admintext">'.MakeLink("banned.php?action=edit&OffSet=$OffSet&DeleteBannedID=".$Banned[ID],"Delete").'</span></TD>';
						}
					$TABLE.='</TR>';
				
				}
			}
		}
		$TABLE.='</TABLE>';
		
		
		

		
		$TABLE.='<HR width="80%" size="1"><CENTER>';
		if($Page>0){
			$TABLE.=MakeLink("banned.php?action=view&BannedGroupID=$BannedGroupID&Page=".($Page-1),"Prev Page");
		}
				
				if($Pages==0){$DPages=1;}else{$DPages=$Pages;}
		$TABLE.="&nbsp;| Currently displaying page ".($Page+1)." of $DPages, there are $All records total |&nbsp;";
		
		
		if(($Page+1)<$Pages){
			$TABLE.=MakeLink("banned.php?action=view&BannedGroupID=$BannedGroupID&Page=".($Page+1),"Next Page");
		}
		
		$FULL_OUTPUT.=MakeBox("Banned Emails (Page ".($Page+1).")",$TABLE);

}else{
	$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
	FinishOutput();
}

				if(CanPerformAction("edit|banned|$BannedGroupID")){
						$FORM_ITEMS["Banned Email Address"]="textfield|BannedEmail:65:40";
						$FORM_ITEMS[-4]="hidden|BannedGroupID:$BannedGroupID";
						$FORM_ITEMS["Tip"]="spacer|Use * for wildcards! Eg: *@hotmail.com bans everyone on a hotmail account.";
						$FORM_ITEMS[-3]="spacer|&nbsp;";
						$FORM_ITEMS[-1]="submit|Add Now";
						
						$FORM=new AdminForm;
						$FORM->title="My Form";
						$FORM->items=$FORM_ITEMS;
						$FORM->action="banned.php?action=edit";
						$FORM->MakeForm();
						
						$FULL_OUTPUT.=MakeBox("Add Banned Email to Group..", $FORM->output);
				}
		
}

function EditBanned(){
GLOBAL $FULL_OUTPUT,$BannedEmail,$DeleteBannedID,$BannedGroupID,$Page;
	
	if($BannedEmail && $BannedGroupID){
		if(CanPerformAction("edit|banned|$BannedGroupID")){
			AddBanned($BannedGroupID,$BannedEmail);
			$FULL_OUTPUT=MakeBox("Added","That email address is now in the banned group!");	
			$Page="LastPage";
			ViewBanned();		
		}else{
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			BannedMain();
		}
	
	}elseif($DeleteBannedID){
	    $BannedGroupID=BannedGroup($DeleteBannedID);
		if(CanPerformAction("edit|banned|$BannedGroupID")){
			DeleteBanned($DeleteBannedID);
			$FULL_OUTPUT=MakeBox("Deleted","The banned email was deleted successfully..");	
			ViewBanned();		
		}else{
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			BannedMain();
		}
		
	
	}else{
		BannedMain();
	}
	
	
	
}


function BannedGroups(){
GLOBAL $GroupID,$NewGroupName,$DeleteGroupID,$GroupIDChange,$GroupsNewName,$FULL_OUTPUT;

		if($GroupID){
				$FORM_ITEMS["Groups New Name"]="textfield|GroupsNewName";
				$FORM_ITEMS[-2]="hidden|GroupIDChange:$GroupID";
				$FORM_ITEMS[-1]="spacer|&nbsp;";
				$FORM_ITEMS[-3]="submit|Save Changes";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="My Form";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="banned.php?action=groups";
				$FORM->MakeForm();
				$FULL_OUTPUT.=MakeBox("Edit Banned Group","Groups Name: ".BannedGroupName($GroupID).$FORM->output.'<BR>'.MakeLink("banned.php?action=groups&DeleteGroupID=$GroupID","Delete Banned Group",1));
		}elseif($GroupsNewName){
			UpdateBannedGroupName($GroupIDChange,$GroupsNewName);
			BannedMain();
		}elseif($DeleteGroupID){
			DeleteBannedGroup($DeleteGroupID);
			BannedMain();
		}elseif($NewGroupName){
			AddBannedGroup($NewGroupName);
			BannedMain();
		}else{
			BannedMain();
		}


}



		


FinishOutput();

?>



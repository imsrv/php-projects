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

//config!
$AutoFillTypes["basic"]="Basic";
$AutoFillTypes["date"]="Date";

if($action){

			if(CanPerformAction("$action|autofill|$AutoFillGroupID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "manage":
		ManageAutoFill();
		break;
		
		case "groups";
		AutoFillGroups();
		break;
			
	}
}else{
	AutoFillMain();
}

/////////////////////////////////////////////////////////////

function ManageAutoFill(){
	GLOBAL $Delete, $AddNew, $AutoFillGroupID, $FULL_OUTPUT, $AutoFillID, $AutoFillTypes, $Type, $AutoFillName, $AutoFillField, $ReplaceWith;
	
	if($Delete){
		mysql_query("DELETE FROM autofill_fields WHERE AutoFillID='$Delete' && AutoFillGroupID='$AutoFillGroupID'");
	}	
	
	if($AddNew=="Yes"){
		$g=mysql_fetch_array(mysql_query("SELECT * FROM autofill_groups WHERE AutoFillGroupID='$AutoFillGroupID'"));
		if($g[FieldLimit]>mysql_num_rows(mysql_query("SELECT * FROM autofill_fields WHERE AutoFillGroupID='$AutoFillGroupID'"))){
		mysql_query("INSERT INTO autofill_fields SET AutoFillGroupID='$AutoFillGroupID', AutoFillField='%NEWFIELD%'");
		$AutoFillID=mysql_insert_id();
		}else{
			$FULL_OUTPUT.=MakeBox("Too many fields in group!", "The maximum number of fields in this group has been exceeded!");
		}
	}
	
	if($AutoFillID){
		$field=mysql_fetch_array(mysql_query("SELECT * FROM autofill_fields WHERE AutoFillGroupID='$AutoFillGroupID' && AutoFillID='$AutoFillID'"));
		
		if($field){
		
			if($AutoFillName && $AutoFillField && $ReplaceWith){
				//save!
				//check that the field is unique
					if(mysql_num_rows(mysql_query("SELECT * FROM autofill_fields WHERE AutoFillField LIKE '$AutoFillField'"))){
						$FULL_OUTPUT.=MakeBox("Sorry field name is already in use", "The field value you entered is already in use!");
					}else{
						mysql_query("UPDATE autofill_fields SET AutoFillName='$AutoFillName', AutoFillField='$AutoFillField', ReplaceWith='$ReplaceWith', Type='$Type' WHERE AutoFillID='$AutoFillID' && AutoFillGroupID='$AutoFillGroupID'");
						$field=mysql_fetch_array(mysql_query("SELECT * FROM autofill_fields WHERE AutoFillGroupID='$AutoFillGroupID' && AutoFillID='$AutoFillID'"));
					}
			}
			
			//print the edit form!
					
				$FORM_ITEMS["Field Name"]="textfield|AutoFillName:30:30:".$field[AutoFillName];
				$FORM_ITEMS["Replace"]="textfield|AutoFillField:30:30:".$field[AutoFillField];				
				$FORM_ITEMS["Replace with"]="textfield|ReplaceWith:30:30:".$field[ReplaceWith];
				$FORM_ITEMS["Type"]="select|Type:1:date->Date;basic->Basic:".$field[Type];
				$FORM_ITEMS[-2]="hidden|AutoFillGroupID:$AutoFillGroupID";
				$FORM_ITEMS[-3]="hidden|AutoFillID:$AutoFillID";
				$FORM_ITEMS[-1]="submit|Save Changes";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="ManageAutoFillField";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="autofill.php?action=manage";
				$FORM->MakeForm();
				
				$FULL_OUTPUT.=MakeBox("Edit field..", $FORM->output."<P>".MakeLink("autofill.php?action=manage&AutoFillGroupID=$AutoFillGroupID","Back to group main"));
				
$datelist='<font size="1">
a - "am" or "pm" 
A - "AM" or "PM" 
B - Swatch Internet time 
d - day of the month, 2 digits with leading zeros; i.e. "01" to "31" 
D - day of the week, textual, 3 letters; i.e. "Fri" 
F - month, textual, long; i.e. "January" 
g - hour, 12-hour format without leading zeros; i.e. "1" to "12" 
G - hour, 24-hour format without leading zeros; i.e. "0" to "23" 
h - hour, 12-hour format; i.e. "01" to "12" 
H - hour, 24-hour format; i.e. "00" to "23" 
i - minutes; i.e. "00" to "59" 
I (capital i) - "1" if Daylight Savings Time, "0" otherwise. 
j - day of the month without leading zeros; i.e. "1" to "31" 
l (lowercase L) - day of the week, textual, long; i.e. "Friday" 
L - boolean for whether it is a leap year; i.e. "0" or "1" 
m - month; i.e. "01" to "12" 
M - month, textual, 3 letters; i.e. "Jan" 
n - month without leading zeros; i.e. "1" to "12" 
r - RFC 822 formatted date; i.e. "Thu, 21 Dec 2000 16:01:07 +0200" (added in PHP 4.0.4) 
s - seconds; i.e. "00" to "59" 
S - English ordinal suffix, textual, 2 characters; i.e. "th", "nd" 
t - number of days in the given month; i.e. "28" to "31" 
T - Timezone setting of this machine; i.e. "MDT" 
U - seconds since the epoch 
w - day of the week, numeric, i.e. "0" (Sunday) to "6" (Saturday) 
Y - year, 4 digits; i.e. "1999" 
y - year, 2 digits; i.e. "99" 
z - day of the year; i.e. "0" to "365" 
				</font>';
				
				$FULL_OUTPUT.=MakeBox("Information on AutoFill Fields..",'There are two types of AutoFill fields you can use!<P><B>Basic</B><BR>Basic fields will replace the replacement string with exactly what you type in the Replace With box. This is useful for inserting your company motto, address, etc into mailings without typing them out fully each time!<P><B>Date</B><BR>Date fields allow you to predetermine a date format for use in your mailings. A number of letters can be used and they will be replaced with items when the date is inserted and the mailing sent.. <BR>These letters are..<BR>'.nl2br($datelist));
				
		}else{
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();	
		}
	
	}else{
		
		$res=mysql_query("SELECT * FROM autofill_fields WHERE AutoFillGroupID='$AutoFillGroupID' ORDER BY AutoFillName");
				
		$BoxOut='There are currently '.mysql_num_rows($res).' fields in this group!<P><center><table width="80%"><tr><Td><span class="admintext">Field Name</td><td><span class="admintext">Field String</td><td><span class="admintext">Type</td><td><span class="admintext"></td></tr><tr height="1"><td colspan="4" bgcolor="#cccccc"></td></tr>';
		
			while($r=mysql_fetch_array($res)){
				$BoxOut.='<tr><Td><span class="admintext">'.$r[AutoFillName].'</td><td><span class="admintext">'.$r[AutoFillField].'</td><td><span class="admintext">'.$AutoFillTypes[$r[Type]].'</td><td>'.MakeLink("autofill.php?action=manage&AutoFillGroupID=$AutoFillGroupID&AutoFillID=".$r[AutoFillID],"Edit").' <span class="admintext">-</span> '.MakeLink("autofill.php?action=manage&AutoFillGroupID=$AutoFillGroupID&Delete=".$r[AutoFillID],"Delete").'</td></tr>';
			}
			
			$BoxOut.='</table></center><P>';
			$BoxOut.=MakeLink("autofill.php?action=manage&AutoFillGroupID=$AutoFillGroupID&AddNew=Yes", "Add Field to group")." | ".MakeLink("autofill.php?","Back to AutoFill main");
			
			
			$FULL_OUTPUT.=MakeBox("Fields in this Group..", $BoxOut);
			
	}
	
}

/////////////////////////////////////////////////////////////

function AutoFillGroups(){
	GLOBAL $FULL_OUTPUT, $AutoFillGroupID, $AutoFillGroupName, $FieldLimit, $Delete, $Create;
			
			if($Create){
				mysql_query("INSERT INTO autofill_groups SET AUtoFillGroupName='NewGroup', FieldLimit='100'");
				$AutoFillGroupID=mysql_insert_id();
			}
			
			if($Delete==1){
				mysql_query("DELETE FROM autofill_fields WHERE AutoFillGroupID='$AutoFillGroupID'");
				mysql_query("DELETE FROM autofill_groups WHERE AutoFillGroupID='$AutoFillGroupID'");
				AutoFillMain();
				FinishOutput();
				exit;
			}
			
			if($AutoFillGroupName && $FieldLimit){
				mysql_query("UPDATE autofill_groups SET AutoFillGroupName='$AutoFillGroupName', FieldLimit='$FieldLimit' WHERE AutoFillGroupID='$AutoFillGroupID'");
				AutoFillMain();
				FinishOutput();
				exit;
			}
			
			$g=mysql_fetch_array(mysql_query("SELECT * FROM autofill_groups WHERE AutoFillGroupID='".$AutoFillGroupID."'"));
	
				$FORM_ITEMS["Group Name"]="textfield|AutoFillGroupName:30:30:".$g[AutoFillGroupName];
				$FORM_ITEMS["Maximum Fields"]="textfield|FieldLimit:10:10:".$g[FieldLimit];				
				$FORM_ITEMS[-2]="hidden|AutoFillGroupID:$AutoFillGroupID";
				$FORM_ITEMS[-1]="submit|Save Changes";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="ManageAutoFillGroup";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="autofill.php?action=groups";
				$FORM->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Edit Group!", $FORM->output.'<P>'.MakeLink("autofill.php?action=groups&AutoFillGroupID=$AutoFillGroupID&Delete=1", "Delete Group",1)." | ".MakeLink("autofill.php?", "Back to AutoFill main"));
}

/////////////////////////////////////////////////////////////

function AutoFillMain(){
	GLOBAL $FULL_OUTPUT;
	
	$res=mysql_query("SELECT * FROM autofill_groups");
	while($r=mysql_fetch_array($res)){
					if(CanPerformAction("manage|autofill|".$r[AutoFillGroupID])==1){
						$list.=$r[AutoFillGroupID]."->".$r[AutoFillGroupName].";";
					}
	}
	
				$FORM_ITEMS["AutoFill Group"]="select|AutoFillGroupID:1:$list";
				$FORM_ITEMS[-1]="submit|Manage Group";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="ManageAutoFillGroup";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="autofill.php?action=manage";
				$FORM->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Manage a group of AutoFill fields", $FORM->output);
	
				$FORM_ITEMS="";
				$FORM_ITEMS["AutoFill Group"]="select|AutoFillGroupID:1:$list";
				$FORM_ITEMS[-1]="submit|Edit Group";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="ManageAutoFillGroup";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="autofill.php?action=groups";
				$FORM->MakeForm();
				
			if(CanPerformAction("groups|autofill|99")==1){
					$FULL_OUTPUT.=MakeBox("Manage AutoFill Groups", $FORM->output.MakeLink("autofill.php?action=groups&Create=1", "Add Group"));
			}

}

FinishOutput();

?>
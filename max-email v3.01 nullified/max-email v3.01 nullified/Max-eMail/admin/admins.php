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

function AddAdmin(){
	GLOBAL $FULL_OUTPUT, $AdminRealName, $LicenceDomain, $ROOT_URL, $AddAdminGroupID, $AdminEmail, $AdminUsername, $AdminID;
	
	if($AdminUsername && $AdminEmail && $AdminRealName){
		if(mysql_num_rows(mysql_query("SELECT * FROM admins WHERE AdminEmail LIKE '$AdminEmail' OR AdminUsername LIKE '$AdminUsername'"))>0){
			$FULL_OUTPUT.=MakeBox("Error..", 'The Username or Email Address you entered are already in use by another administrator on this sytem!');
			AdminsMain();
			FinishOutput();
		}else{
			$ad=AdminInfo($AdminID);
			//generate an identity key!
			$nums=range(0,9);
			srand ((double) microtime() * 1000000);
			for($i=0;$i<6;$i++){
			$IdentityKey.=$nums[rand(0,sizeof($nums))];
			}
			mysql_query("INSERT INTO admins SET IdentityKey='$IdentityKey', AdminRealName='$AdminRealName', AdminUsername='$AdminUsername', AdminEmail='$AdminEmail', AdminGroupID='$AddAdminGroupID', AdminPassword='0214n324032409usdndsf092340u324n'");
			$the_email="Hello $AdminRealName,\nYour administrators account for the Max-eMail install at $LicenceDomain is now ready.\n\nPlease go to $ROOT_URL/admin/index.php?NEWADMIN to complete you first login. You will be prompted to enter your username and identity key. This information is contained below.\n\nUsername: $AdminUsername\nIdentity Key: $IdentityKey\n\nIf you have any questions please contact ".$ad[AdminRealName]." on email ".$ad[AdminEmail]."\nThanks!";
			mail($AdminEmail,"Your Max-eMail Administrators Account",$the_email);
			$FULL_OUTPUT.=MakeBox("Admin account created", '<B>Admin account created! </B><P>The admin has been sent an email explaining how to setup their password and login to Max-eMail.<P>'.MakeLink("admins.php", "Back to admins main"));
		}
	}else{
		$FULL_OUTPUT.=MakeBox("Error..", 'You need to supply a Username, Email Address, and Real Name to create a new administrator.');
			AdminsMain();
			FinishOutput();
	}


	
}

function DeleteAdmin(){
	GLOBAL $FULL_OUTPUT, $DeleteAdminID, $AdminID;
	if($DeleteAdminID==$AdminID){
		$FULL_OUTPUT.=MakeBox("Error..","You cannot delete your own administration account, sorry!");
	}else{
		mysql_query("DELETE FROM admins WHERE AdminID='$DeleteAdminID'");
		$FULL_OUTPUT.=MakeBox("Admin deleted", "The administrator was deleted from the system!");
	}
			AdminsMain();
			FinishOutput();

}

function EditAdmin(){
	GLOBAL $AdminID, $Active, $EditAdminID, $FULL_OUTPUT, $AdminRealName, $AdminGroupID, $AdminEmail, $AdminUsername;
	
	if($AdminUsername && $AdminEmail){
		if(mysql_num_rows(mysql_query("SELECT * FROM admins WHERE AdminEmail LIKE '$AdminEmail' OR AdminUsername LIKE '$AdminUsername'"))>1){
			$FULL_OUTPUT.=MakeBox("Error..", 'The Username or Email Address you entered are already in use by another administrator on this sytem!');
		}elseif($EditAdminID==$AdminID){
			$FULL_OUTPUT.=MakeBox("Error..", 'An administrator cannot edit themselves. To change your basic details please use the My Account section of the admin panel.');
		}else{
			mysql_query("UPDATE admins SET Active='$Active', AdminRealName='$AdminRealName', AdminUsername='$AdminUsername', AdminEmail='$AdminEmail', AdminGroupID='$AdminGroupID' WHERE AdminID='$EditAdminID'");
		}
	}
	
	$ad=AdminInfo($EditAdminID);
	
			$FORM_ITEMS["Real Name"]="textfield|AdminRealName:30:30:".$ad[AdminRealName];
			$FORM_ITEMS["Email Address"]="textfield|AdminEmail:30:30:".$ad[AdminEmail];
			$FORM_ITEMS["Username"]="textfield|AdminUsername:15:30:".$ad[AdminUsername];
			$FORM_ITEMS["Active"]="select|Active:1:0->No;1->Yes:".$ad[Active];
				$gr=mysql_query("SELECT * FROM admin_groups ORDER BY AdminGroupName");
					while($g=mysql_fetch_array($gr)){
						$allgroups.=$g[AdminGroupID]."->".$g[AdminGroupName].";";
					}
			$FORM_ITEMS["Admin Group"]="select|AdminGroupID:1:$allgroups:".$ad[AdminGroupID];
			$FORM_ITEMS[-1]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="ManageAdminGroup";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="admins.php?action=editadmin&EditAdminID=$EditAdminID";
			$FORM->MakeForm();
			$BO.=$FORM->output.'<P>'.MakeLink("admins.php", "Back to admins main");
	
	
	$FULL_OUTPUT.=MakeBox("Edit administrator", $BO);
	
}



function AdminsMain(){
	GLOBAL $FULL_OUTPUT, $AdminGroupID, $AdminRealName, $AddAdminGroupID, $AdminEmail, $AdminUsername;
	
	if($AdminGroupID){
		$admins=mysql_query("SELECT * FROM admins WHERE AdminGroupID='$AdminGroupID' ORDER BY AdminRealName
		");
	}else{
		$admins=mysql_query("SELECT * FROM admins ORDER BY AdminRealName");
	}
	
		GroupsMain();
	
	$BO='<TABLE width="100%">
	<TR>
		<TD><span class="admintext">Real Name</span></TD>
		<TD><span class="admintext">Username</span></TD>
		<TD><span class="admintext">Group</span></TD>
		<TD><span class="admintext">Status</span></TD>
		<TD><span class="admintext"></span></TD>
	</TR>
	<TR height="1" bgcolor="#cccccc"><TD colspan="5"></TD></TR>';
	while($r=mysql_fetch_array($admins)){
		$AdG=AdminGroupInfo($r[AdminID]);
		$issuper="";if($AdG[SuperUser]==1){$issuper=' (S)';}
		if($r[Active]==1){$Active="Active";}else{$Active="In-Active";}
		$BO.='<TR>
		<TD><span class="admintext">'.$r[AdminRealName].'</span></TD>
		<TD><span class="admintext">'.$r[AdminUsername].'</span></TD>
		<TD><span class="admintext">'.$AdG[AdminGroupName].'</span></TD>
		<TD><span class="admintext">'.$Active.$issuper.'</span></TD>
		<TD><span class="admintext">'.MakeLink("admins.php?action=editadmin&EditAdminID=".$r[AdminID]."","Edit").' | '.MakeLink("admins.php?action=deleteadmin&DeleteAdminID=".$r[AdminID], "Delete",1).'</span></TD>
		</TR>';
	
	}
	$BO.='<TR height="1" bgcolor="#cccccc"><TD colspan="5"></TD></TR></TABLE><BR>
	* (S) = SuperUser';
	
	$FULL_OUTPUT.=MakeBox("Current Admins", $BO);

	
			$FORM_ITEMS3["Real Name"]="textfield|AdminRealName:30:30:$AdminRealName";
			$FORM_ITEMS3["Email Address"]="textfield|AdminEmail:30:30:$AdminEmail";
			$FORM_ITEMS3["Username"]="textfield|AdminUsername:15:30:$AdminUsername";
				$gr=mysql_query("SELECT * FROM admin_groups ORDER BY AdminGroupName");
					while($g=mysql_fetch_array($gr)){
						$allgroups.=$g[AdminGroupID]."->".$g[AdminGroupName].";";
					}
			$FORM_ITEMS3["Admin Group"]="select|AddAdminGroupID:1:$allgroups:$AddAdminGroupID";
			$FORM_ITEMS3[-1]="submit|Continue";
			//make the form
			$FORM3=new AdminForm;
			$FORM3->title="AddAdmin";
			$FORM3->items=$FORM_ITEMS3;
			$FORM3->action="admins.php?action=addadmin";
			$FORM3->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Add new admin", $FORM3->output);


}


function GroupsMain(){
	GLOBAL $FULL_OUTPUT;

			$BO.='<TABLE width="100%">
			<TR><TD><span class="admintext">Group Name</span></TD><TD><span class="admintext">SuperUser</span></TD><TD><span class="admintext">Admins in Group</span></TD><TD><span class="admintext"></span></TD></TR>
			<TR height="1" bgcolor="#cccccc"><TD colspan="4"></td></tr>';
			$groups=mysql_query("SELECT * FROM admin_groups");
				while($group=mysql_fetch_array($groups)){
					$BO.='<TR>
					<TD><span class="admintext">'.$group[AdminGroupName].'</span></TD>';
						if($group[SuperUser]==1){$SU="Yes";}else{$SU="No";}
					$BO.='<TD><span class="admintext">'.$SU.'</span></TD>
					<TD><span class="admintext">'.mysql_num_rows(mysql_query("SELECT * FROM admins WHERE AdminGroupID='".$group[AdminGroupID]."'")).'</span></TD>
					<TD><span class="admintext">'.MakeLink("admins.php?action=editgroup&AdminGroupID=".$group[AdminGroupID], "Edit").' | '.MakeLink("admins.php?action=editgroup&DeleteGroupID=".$group[AdminGroupID], "Delete", 1).' | '.MakeLink("admins.php?AdminGroupID=".$group[AdminGroupID], "Admins").'</span></TD>
					</TR>';
				}
				
				$BO.='</table><P>'.MakeLink("admins.php?action=editgroup&AddAdminGroup=yes", "Add new admin group");
	
	$FULL_OUTPUT.=MakeBox("Current Admin Groups", $BO);
	
	//now the add admin group box!
	

	
}

function EditAdminGroup(){
	GLOBAL $DeleteGroupID, $AddAdminGroup, $FULL_OUTPUT, $AdminGroupName, $PasswordChangeGap, $SuperUser, $AdminGroupID, $section, $ADMIN_LIST_SECTIONS, $PRIV, $Grant;

			if($DeleteGroupID){
				if(mysql_num_rows(mysql_query("SELECT * FROM admins WHERE AdminGroupID='$DeleteGroupID'"))!=0){
					$FULL_OUTPUT.=MakeBox("Error..", 'Cannot delete an admin group when it has admins in it!');
				}else{
					mysql_query("DELETE FROM admin_groups WHERE AdminGroupID='$DeleteGroupID'");
					$FULL_OUTPUT.=MakeBox("Admin group deleted", 'The admin group was removed permenantely from the system');
				}
				$AdminGroupID="";
				GroupsMain();
				FinishOutput();
			}
			
			if($AddAdminGroup){
				mysql_query("INSERT INTO admin_groups SET AdminGroupName='NewAdminGroup', PasswordChangeGap='28'");
				$AdminGroupID=mysql_insert_id();
			}
	
			if($AdminGroupName){
				//check that there will still be superusers!
					if($SuperUser!=1){
						$groups=mysql_query("SELECT * FROM admin_groups");
							while($group=mysql_fetch_array($groups)){
									if($group[SuperUser]==1 && $group[AdminGroupID]!=$AdminGroupID){
										$Asuper=1;
									}
							}
							if(!$Asuper){
								$SuperUser=1;
								$FULL_OUTPUT.=MakeBox("Error..", "There must be atleast one Admin Group with SuperUser status in the Max-eMail system!!");
							}
					}
					
				mysql_query("UPDATE admin_groups SET AdminGroupName='$AdminGroupName', SuperUser='$SuperUser', PasswordChangeGap='$PasswordChangeGap' WHERE AdminGroupID='$AdminGroupID'");
			}	
	
			foreach($ADMIN_LIST_SECTIONS as $key=>$name){
				$allsections.=$key."->".$name.";";
			}
			
			$FORM_ITEMS["Section"]="select|section:1:$allsections:$section";
			$FORM_ITEMS[-1]="submit|Modify/Grant Privelages";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="ManageAdminGroup";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="admins.php?action=editgroup&AdminGroupID=$AdminGroupID";
			$FORM->MakeForm();
			$sections=$FORM->output;
			
		$FULL_OUTPUT.=MakeBox("Overview", "You can grant privelages to this admin group in all section, please choose a section to grant privelages in that section! Some sections (eg List Setup, Form Setup) and some parts of section (eg group setup) are for superusers only.<P>$sections<P>".MakeLink("admins.php?", "Back to Admins main"));
		
		if($section!=""){
				if($Grant){
					mysql_query("DELETE FROM admin_group_privelages WHERE Action LIKE '%|$section|%' && AdminGroupID='$AdminGroupID'");
					foreach($Grant as $Priv){
						$Priv=str_replace(">##<","|",$Priv);
						mysql_query("INSERT INTO admin_group_privelages SET Action='$Priv', AdminGroupID='$AdminGroupID'");
					}
				}
				
				$b=0;$this=$PRIV[$section];
				list($them,$other)=explode(";",$this["section"]);
					if($other){
						if(mysql_num_rows(mysql_query("SELECT * FROM admin_group_privelages WHERE action LIKE '$other|$section|%'"))){$sel="CHECKED";}else{$sel="";}
						$b--;$FORM_ITEMS2[$b]='spacer|<BR>Grant overall privelages for '.$ADMIN_LIST_SECTIONS[$section];
						$b--;$FORM_ITEMS2[$b]="checkbox|Grant[$x]:$other>##<$section>##<:$other:$sel";
					
					}
				$each=explode(",", $them);
				list($from,$fkey,$fname)=explode(";", $this["lists"]);
				$res=mysql_query($from);
				while($r=mysql_fetch_array($res)){
					$tid=$r[$fkey];
					$tname=$r[$fname];
					$b--;
					$FORM_ITEMS2[$b]='spacer|<BR>Grant privelages for '.$ADMIN_LIST_SECTIONS[$section].' group/list/item "'.$tname.'"';
						reset($each);foreach($each as $pri){
							$b--;$x++;
							//check if this one is already checked!
								if(mysql_num_rows(mysql_query("SELECT * FROM admin_group_privelages WHERE action LIKE '$pri|$section|$tid'"))){$sel="CHECKED";}else{$sel="";}
							$FORM_ITEMS2[$b]="checkbox|Grant[$x]:$pri>##<$section>##<$tid:$pri:$sel";
						}	
				}
				
			$b--;$FORM_ITEMS2[$b]="spacer|&nbsp;";		
			$b--;$FORM_ITEMS2[$b]="submit|Modify/Grant Privelages";
			//make the form
			$FORM2=new AdminForm;
			$FORM2->title="ManageAdminGroup";
			$FORM2->items=$FORM_ITEMS2;
			$FORM2->action="admins.php?action=editgroup&AdminGroupID=$AdminGroupID&section=$section";
			$FORM2->MakeForm();
			$BO.=$FORM2->output;

				
				$FULL_OUTPUT.=MakeBox("Modify privelages for section",$BO);
		}
			
					

			
		
	
	//now the modify admin group box!
		$ag=mysql_fetch_array(mysql_query("SELECT * FROM admin_groups WHERE AdminGroupID='$AdminGroupID'"));
		$FORM_ITEMS3["Group Name"]="textfield|AdminGroupName:30:30:".$ag[AdminGroupName];		
		$FORM_ITEMS3["Change PWord every __ days"]="textfield|PasswordChangeGap:10:10:".$ag[PasswordChangeGap];		
		$FORM_ITEMS3["SuperUser"]="select|SuperUser:1:0->No;1->Yes:".$ag[SuperUser];				
		$FORM_ITEMS3[-1]="submit|Save Changes";
			//make the form
			$FORM3=new AdminForm;
			$FORM3->title="ModifyAdminGroup";
			$FORM3->items=$FORM_ITEMS3;
			$FORM3->action="admins.php?action=editgroup&AdminGroupID=$AdminGroupID";
			$FORM3->MakeForm();
			$BO2.=$FORM3->output;
			$FULL_OUTPUT.=MakeBox("Modify details of admin group!",$BO2);
}




/////////////////////////////
if(CanPerformAction("CONTROLADMINS")){

	switch($action){
		case "":
		AdminsMain();
		break;
		
		case "editgroup":
		EditAdminGroup();
		break;
		
		case "editadmin":
		EditAdmin();
		break;
		
		case "addadmin":
		AddAdmin();
		break;
		
		case "deleteadmin":
		DeleteAdmin();
		break;
	
	}












}else{
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			FinishOutput();
}


FinishOutput();





?>
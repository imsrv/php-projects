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


$ad=AdminInfo($AdminID);
$AdminID=$ad[AdminID];

if($action=="savechanges"){
	mysql_query("UPDATE admins SET AdminTemplateId='$AdminTemplateID', AdminRealName='$AdminRealName', AdminEmail='$AdminEmail' WHERE AdminID='$AdminID'");
	$ad=AdminInfo($AdminID);
	$AdminID=$ad[AdminID];
}
		
		$temps=mysql_query("SELECT * FROM admin_templates");
		while($t=mysql_fetch_array($temps)){
			$alltemplates.=$t[AdminTemplateID]."->".$t[AdminTemplateName].";";
		}

			$FORM_ITEMS["Real Name"]="textfield|AdminRealName:30:30:".$ad[AdminRealName];
			$FORM_ITEMS["Email Address"]="textfield|AdminEmail:30:30:".$ad[AdminEmail];		
			$FORM_ITEMS["Template"]="select|AdminTemplateID:1:$alltemplates:".$ad[AdminTemplateID];	
			
			$FORM_ITEMS[-1]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="MyAccount";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="admin_account.php?action=savechanges";
			$FORM->MakeForm();

$FULL_OUTPUT.=MakeBox("Edit you account details", $FORM->output);

$AdGroup=AdminGroupInfo($AdminID);
$BO.='Hello '.$ad[AdminUsername].',<P>
You are currently a member of the admin group "'.$AdGroup[AdminGroupName].'"';
if($AdGroup[SuperUser]){
$BO.="<P>You have SuperUser status on this Max-eMail System";
}

//password info!
		$timestampgap=time()-$ad[LastChangedPassword];
		$days=round($timestampgap/86400);

$BO.='<P>You last changed your admin password '.$days.' days ago, it will expire in '.($AdGroup[PasswordChangeGap]-$days).' days.<BR>'.MakeLink("index.php?CHANGEPW", "Click here to change your admin password");

if($QuickMsg=="all" || $QuickMsg=="group"){
$BO.='<P><B>You have '.mysql_num_rows(mysql_query("SELECT * FROM admin_messages WHERE ToAdminID='$AdminID' && Received='0'")).' new messages, and '.mysql_num_rows(mysql_query("SELECT * FROM admin_messages WHERE ToAdminID='$AdminID'")).' messages total! </B><P>'.MakeLink("admin_messages.php?action=readnew", "Read new messages").' | '.MakeLink("admin_messages.php?", "Read all messages");
}

$FULL_OUTPUT.=MakeBox("Your account..", $BO);

if($QuickMsg=="all" || $QuickMsg=="group"){

		if($ToAdminID && $action=="sendmessage"){
			mysql_query("INSERT INTO admin_messages SET Subject='$Subject', Body='$MessageText', ToAdminID='$ToAdminID', FromAdminID='$AdminID', Date='".time()."'");
			$Subject="";$Body="";$ToAdminID="";
		}

		if($QuickMsg=="group"){
			$res=mysql_query("SELECT * FROM admins WHERE AdminGroupID='".$AdGroup[AdminGroupID]."'");
		}else{
			$res=mysql_query("SELECT * FROM admins");
		}
		$admins="0-> ## Select Admin ##;";
		while($r=mysql_fetch_array($res)){
				$gr=AdminGroupInfo($r[AdminID]);
				$s="";if($gr[SuperUser]==1){$s=" (S)";}
				$admins.=$r[AdminID]."->".$r[AdminRealName]." (".$r[AdminUsername].")$s;";
		}

			$FORM_ITEMS2["Message to"]="select|ToAdminID:1:$admins:".$ToAdminID;
			$FORM_ITEMS2["Subject"]="textfield|Subject:30:30:".$Subject;		
			$FORM_ITEMS2["Message"]="textarea|MessageText:60:6:".$Body;	
					
			$FORM_ITEMS2[-1]="submit|Send Message";
			
			//make the form
			$FORM2=new AdminForm;
			$FORM2->title="ManageAdminGroup";
			$FORM2->items=$FORM_ITEMS2;
			$FORM2->action="admin_account.php?action=sendmessage";
			$FORM2->MakeForm();
$FULL_OUTPUT.=MakeBox("Send a message to another admin", $FORM2->output);
}



FinishOutput();


?>
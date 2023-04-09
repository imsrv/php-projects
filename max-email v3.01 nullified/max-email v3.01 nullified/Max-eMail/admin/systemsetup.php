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

$ad=AdminGroupInfo($AdminID);
if($ad[SuperUser]!=1){
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			FinishOutput();
}


///////////////////////////

function SystemSetupMain(){
	GLOBAL $FULL_OUTPUT;

	$BO.='<table width="100%">
	<TR><TD width="40" valign=top><span class="admintext">General: </span></TD><TD valign=top><span class="admintext">Setup general variables for the system.<BR>'.MakeLink("systemsetup.php?action=general", "Edit Now").'</span></TD></TR>
	<TR bgcolor="#cccccc" height="1"><td colspan="2"></td></tr>
	<TR><TD width="20" valign=top><span class="admintext">Admin: </span></TD><TD valign=top><span class="admintext">Customise the admin design of Max-eMail, you can change colors, fonts, logo, etc!<BR>'.MakeLink("systemsetup.php?action=admindesign", "Edit Now").'</span></TD></TR>
	<TR bgcolor="#cccccc" height="1"><td colspan="2"></td></tr>
	<TR><TD width="20" valign=top><span class="admintext">Bounce Emails: </span></TD><TD valign=top><span class="admintext">Manage the addresses that can be used for bounced emails on the lists!<BR>'.MakeLink("systemsetup.php?action=bounceaddresses", "Edit Now").'</span></TD></TR>

	</table>';
	
	$FULL_OUTPUT.=MakeBox("Options..", $BO);
	

}


function AdminDesign(){
	GLOBAL $FULL_OUTPUT, $AdminTemplateID, $SetDefault, $DeleteID, $Fields, $Create, $AdminTemplate;

	if($SetDefault){
		mysql_query("UPDATE admin_templates SET IsDefault='0'");
		mysql_query("UPDATE admin_templates SET IsDefault='1' WHERE AdminTemplateID='$SetDefault'");
	}
	
	if($Create){
		$Fields=$AdminTemplate;
		mysql_query("INSERT INTO admin_templates SET AdminTemplateName='NewTemplate'");
		$AdminTemplateID=mysql_insert_id();
		$Fields[IsDefault]=0;
		$Fields[AdminTemplateName]="NewTemplate";
	}
	
	if($DeleteID){
		mysql_query("DELETE FROM admin_templates WHERE AdminTemplateID='$DeleteID'");
	}
	
	if($AdminTemplateID){
		
		if($Fields){
			foreach($Fields as $name=>$value){
				mysql_query("UPDATE admin_templates SET $name='$value' WHERE AdminTemplateID='$AdminTemplateID'");
			}
		}
		
		$temp=mysql_fetch_array(mysql_query("SELECT * FROM admin_templates WHERE AdminTemplateID='$AdminTemplateID'"));
		
				$FORM_ITEMS["Template Name"]="textfield|Fields[AdminTemplateName]:100:40:".$temp[AdminTemplateName];
				$FORM_ITEMS["Logo URL"]="textfield|Fields[LogoURL]:100:100:".$temp[LogoURL];
				$FORM_ITEMS["Top Bar Image URL"]="textfield|Fields[TopBarImageURL]:100:100:".$temp[TopBarImageURL];
				$FORM_ITEMS["Color One"]="textfield|Fields[ColorOne]:100:100:".$temp[ColorOne];
				$FORM_ITEMS["Color Two"]="textfield|Fields[ColorTwo]:100:100:".$temp[ColorTwo];
				$FORM_ITEMS["Page Title"]="textfield|Fields[PageTitle]:100:100:".$temp[PageTitle];
				$FORM_ITEMS["sidebarlinks style"]="textfield|Fields[sidebarlinks]:200:100:".str_replace(":",'$$COLON$$',$temp[sidebarlinks]);
				$FORM_ITEMS["sidebarlinks hover"]="textfield|Fields[sidebarlinkshover]:200:100:".str_replace(":",'$$COLON$$',$temp[sidebarlinkshover]);				
				$FORM_ITEMS["formtext style"]="textfield|Fields[formtext]:200:100:".str_replace(":",'$$COLON$$',$temp[formtext]);
				$FORM_ITEMS["smalltext style"]="textfield|Fields[smalltext]:200:100:".str_replace(":",'$$COLON$$',$temp[smalltext]);
				$FORM_ITEMS["admintext style"]="textfield|Fields[admintext]:200:100:".str_replace(":",'$$COLON$$',$temp[admintext]);
				$FORM_ITEMS["adminlink style"]="textfield|Fields[adminlink]:200:100:".str_replace(":",'$$COLON$$',$temp[adminlink]);
				$FORM_ITEMS["adminlink hover"]="textfield|Fields[adminlinkhover]:200:100:".str_replace(":",'$$COLON$$',$temp[adminlinkhover]);
				$FORM_ITEMS["inputfields style"]="textfield|Fields[inputfields]:200:100:".str_replace(":",'$$COLON$$',$temp[inputfields]);
				$FORM_ITEMS[-1]="submit|Save Changes";
				
				//make the form
			$FORM=new AdminForm;
			$FORM->title="EditAdminTemplate";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="systemsetup.php?action=admindesign&AdminTemplateID=$AdminTemplateID";
			$FORM->MakeForm();
			$BO.=$FORM->output.'<P>'.MakeLink("systemsetup.php?action=admindesign", "Admin Templates main");
	
			$FULL_OUTPUT.=MakeBox("Editing admin panel template", $BO);
	}else{
		//admin design templates
		$BO.='<table width="100%">
		<TR><TD><span class="admintext">Template Name</span></TD><TD><span class="admintext">Default</span></TD><TD><span class="admintext">Options</span></TD></TR>
		<tr height="1" bgcolor="#cccccc"><td colspan="3"></td></tr>';
		$temps=mysql_query("SELECT * FROM admin_templates ORDER BY IsDefault DESC");
		while($t=mysql_fetch_array($temps)){
			if($t[IsDefault]==1){$t[IsDefault]="Yes";}else{$t[IsDefault]="No";}
			$BO.='<TR><TD><span class="admintext">'.$t[AdminTemplateName].'</span></TD><TD><span class="admintext">'.$t[IsDefault].'</span></TD><TD><span class="admintext">'.MakeLink("systemsetup.php?action=admindesign&SetDefault=".$t[AdminTemplateID], "Make Default").' | '.MakeLink("systemsetup.php?action=admindesign&AdminTemplateID=".$t[AdminTemplateID], "Edit").' | '.MakeLink("systemsetup.php?action=admindesign&DeleteID=".$t[AdminTemplateID], "Delete",1).'</span></TD></TR>';
		}
		$BO.='</TABLE><P>'.MakeLink("systemsetup.php?action=admindesign&Create=yes", "Create New").' | '.MakeLink("systemsetup.php", "System Setup Main");
		$FULL_OUTPUT.=MakeBox("Edit an admin panel template", $BO);
	}
	

}

function GeneralVars(){
	GLOBAL $FULL_OUTPUT,$SaveThese,$ROOT_URL,$ROOT_DIR,$QuickMsg,$AdminAuthType,$AdminLoginTime,$BannedPerPage,$MinPassLength ;

	if($SaveThese){
		foreach($SaveThese as $name=>$var){
			mysql_query("DELETE FROM system_setup WHERE Name Like '$name'");
			mysql_query("INSERT INTO system_setup SET Value='$var', Name='$name'");
		}
		$FULL_OUTPUT.=MakeBox("Changes saved!", '<script language="javascript">window.location="systemsetup.php?action=general"</script>The changes have been updated to the system.<P>'.MakeLink("systemsetup.php?action=general", "Click here to view the settings"));
		FinishOutput();
	}
	
	$FORM_ITEMS["Root URL"]="textfield|SaveThese[ROOT_URL]:300:60:".str_replace(":", '$$COLON$$',$ROOT_URL);
	$FORM_ITEMS["Root Dir"]="textfield|SaveThese[ROOT_DIR]:300:60:".str_replace(":", '$$COLON$$',$ROOT_DIR);
	$FORM_ITEMS["Admin Authentication Type"]="select|SaveThese[AdminAuthType]:1:htaccess->HTACCESS Type;cookies->Form Based Login:$AdminAuthType";
	$FORM_ITEMS["Maintain login (Seconds)"]="textfield|SaveThese[AdminLoginTime]:10:10:$AdminLoginTime";
	$FORM_ITEMS["Admin Messaging"]="select|SaveThese[QuickMsg]:1:none->None;group->To own group only;all->Full messaging:$QuickMsg";
	$FORM_ITEMS["Banned items per page"]="textfield|SaveThese[BannedPerPage]:10:10:$BannedPerPage";
	$FORM_ITEMS["Minimum password length"]="textfield|SaveThese[MinPassLength]:10:10:$MinPassLength";	
	
	$FORM_ITEMS[-1]="submit|Save Changes";
			//make the form
			$FORM=new AdminForm;
			$FORM->title="ManageAdminGroup";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="systemsetup.php?action=general";
			$FORM->MakeForm();
			$BO.=$FORM->output.'<P>'.MakeLink("systemsetup.php", "System Setup Main");
	
	$FULL_OUTPUT.=MakeBox("General system variables!", $BO);
	
}


function BounceAds(){
	GLOBAL $FULL_OUTPUT;
	
	$BO='<TABLE width="100%">
	<TR><TD><span class="admintext">Email Address</span></td><TD><span class="admintext">Mail Server</span></td><TD><span class="admintext">Options</span></td></tr>
	<tr height="1" bgcolor="#cccccc"><td colspan="3"></td></tr>';
	
	$bas=mysql_query("SELECT * FROM bounce_addresses ORDER BY EmailAddress");
		
		while($ba=mysql_fetch_array($bas)){
			$BO.='<TR><TD><span class="admintext">'.$ba[EmailAddress].'</span></td><TD><span class="admintext">'.$ba[Mail_Server].'</span></td><TD><span class="admintext">'.MakeLink("systemsetup.php?action=editbounce&BounceAddressID=".$ba[BounceAddressID], "Edit").' | '.MakeLink("systemsetup.php?action=editbounce&Delete=1&BounceAddressID=".$ba[BounceAddressID], "Delete",1).'</span></td></tr>';
		}
	
	$BO.='</table><P>';
	$BO.=MakeLink("systemsetup.php?action=editbounce&createnew=1", "Add new bounce address").' | '.MakeLink("systemsetup.php", "Systems Setup main");
	
	$FULL_OUTPUT.=MakeBox("Current bounce addresses", $BO);
	
}

function EditBounceAd(){
	GLOBAL $FULL_OUTPUT, $createnew,$BounceAddressID, $Delete, $EmailAddress, $Mail_Server,$Username,$Password;
	
	if($createnew){
		mysql_query("INSERT INTO bounce_addresses SET EmailAddress='you@youemail.com'");
		$BounceAddressID=mysql_insert_id();
	}
	
	if($Delete){
		mysql_query("DELETE FROM bounce_addresses WHERE BounceAddressID='$BounceAddressID'");
		BounceAds();
		FinishOutput();
	}
	
	if($EmailAddress && $Mail_Server){
		mysql_query("UPDATE bounce_addresses SET EmailAddress='$EmailAddress', Mail_Server='$Mail_Server', Username='$Username', Password='$Password' WHERE BounceAddressID='$BounceAddressID'");
		BounceAds();
		FinishOutput();
	}
	
	$ba=mysql_fetch_array(mysql_query("SELECT * FROM bounce_addresses WHERE BounceAddressID='$BounceAddressID'"));
	
			$FORM_ITEMS["Email Address"]="textfield|EmailAddress:100:40:".$ba[EmailAddress];
			$FORM_ITEMS["Mail Server"]="textfield|Mail_Server:100:40:".$ba[Mail_Server];
			$FORM_ITEMS["Username"]="textfield|Username:100:40:".$ba[Username];
			$FORM_ITEMS["Password"]="textfield|Password:100:40:".$ba[Password];
			$FORM_ITEMS[-1]="submit|Save Changes";
	
			$FORM=new AdminForm;
			$FORM->title="EditBounceAddress";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="systemsetup.php?action=editbounce&BounceAddressID=".$BounceAddressID;
			$FORM->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Edit bounce address", $FORM->output.'<P>'.MakeLink("systemsetup.php?action=bounceaddresses", "Back to bounce addresses main"));
	
	
}


switch($action){

	case "":
	SystemSetupMain();
	break;
	
	case "editbounce":
		EditBounceAd();
	break;
	
	case "bounceaddresses":
		BounceAds();
	break;
	
	case "general":
	GeneralVars();
	break;
	
	case "admindesign":
	AdminDesign();
	break;

}




FinishOutput();


?>
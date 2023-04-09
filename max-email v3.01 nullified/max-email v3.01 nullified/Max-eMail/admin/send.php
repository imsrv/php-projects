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
			if(CanPerformAction("use|send|$ListID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
			SendOptions();
}elseif($SendID){
	$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$SendID'"));
		if($send[AdminID]!=$AdminID){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
		}
		mysql_query("UPDATE sends SET FromName='$FromName', FromEmail='$FromEmail', Method='$Method', PerExec='$PerExec' WHERE SendID='$SendID'");
		$FULL_OUTPUT.=MakeBox("Notes!", 'A new window will have opened! This window is doing the sending. Do not close it until you are promted to do so, or until you feel it may have crashed.. in which close it and return to the send main page where you will select the Send ID from a list and click continue. The send will then resume where it left off.');
		$FULL_OUTPUT.='<script language="javascript">'.str_replace("javascript:", "", MakePopup("send_emails.php?SendID=$SendID",400,300,"SendEmails")).'</script>';
		
}elseif($ReDoSendID){
			$send=mysql_fetch_array(mysql_query("SELECT * FROM sends WHERE SendID='$ReDoSendID'"));
		if($send[AdminID]!=$AdminID){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
		}
		$FULL_OUTPUT.=MakeBox("Notes!", 'A new window will have opened! This window is doing the sending. Do not close it until you are promted to do so, or until you feel it may have crashed.. in which close it and return to the send main page where you will select the Send ID from a list and click continue. The send will then resume where it left off.');
		$FULL_OUTPUT.='<script language="javascript">'.str_replace("javascript:", "", MakePopup("send_emails.php?SendID=$ReDoSendID",400,300,"SendEmails")).'</script>';
}else{
	SendMain();
}

/////////////////////////////////////////////////////////////

function SendOptions(){
	GLOBAL $FULL_OUTPUT, $SendTo, $ListID, $FilterString, $ComposeID, $AdminID, $SendMethods, $Multipart;
	
	//build the new send!
	mysql_query("INSERT INTO sends SET ListID='$ListID', AdminID='$AdminID', ComposeID='$ComposeID'");
	$SendID=mysql_insert_id();
	
	//first of all load all the recipients into the send_recipients table!
		if($FilterString){
		$FilterString=trim($FilterString);
		$tempmembers=filter_members(list_info($ListID), $FilterString, parse_member_list(list_info($ListID), get_list_members($ListID)));
		}else{
		$tempmembers=parse_member_list(list_info($ListID), get_list_members($ListID));
		}	
		if($tempmembers){
				foreach($tempmembers as $member){
					if(($member["x-receiving"]=="yes" || $SendTo=="all") && $member["x-unique"]){
					$Unique=$member["x-unique"];
						//work out what format this user will receive!
						$comp=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
							if($Multipart){
								$Format="multi";
							}else{
								if($comp[Format]=="texthtml"){
									$Format=$member["x-format"];
								}elseif($comp[Format]=="text"){
									$Format="text";
								}elseif($comp[Format]=="html"){
									$Format="html";
								}
							}
							mysql_query("INSERT INTO send_recipients SET SendID='$SendID', UniqueKey='".$member["x-unique"]."', Format='$Format'");
					}
				}
		}
	//now print info and final options on send!
	$BO='This sends ID is: '.$SendID.'. The send has '.mysql_num_rows(mysql_query("SELECT * FROM send_recipients WHERE SendID='$SendID'")).' recipients.';
	
		$FORM_ITEMS["Emails per execution"]="textfield|PerExec:100:10:15";
		$FORM_ITEMS["Send Method"]="select|Method:1:$SendMethods";
		$ai=mysql_fetch_array(mysql_query("SELECT * FROM admins WHERE AdminID='$AdminID'"));
		$FORM_ITEMS["From name"]="textfield|FromName:100:30:".$ai[AdminRealName];
		$FORM_ITEMS["From email"]="textfield|FromEmail:100:30:".$ai[AdminEmail];		
		$FORM_ITEMS[-1]="submit|Continue";
		
		$FORM=new AdminForm;
		$FORM->title="MemberSearch";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="send.php?SendID=$SendID";
		$FORM->MakeForm();
		$BO.=$FORM->output;
	
	$FULL_OUTPUT.=MakeBox("Send options screen two", $BO);
}

/////////////////////////////////////////////////////////////

function SendMain(){
	GLOBAL $FULL_OUTPUT, $AdminID;

		//lists that can be sent to.
		$lists=mysql_query("SELECT * FROM lists");
		while($l=mysql_fetch_array($lists)){
			if(CanPerformAction("use|send|".$l[ListID])){
				$alllists.=$l[ListID]."->".$l[ListName].";";
			}
		}
		
		//composed emails!
		$ce=mysql_query("SELECT * FROM composed_emails");
		while($c=mysql_fetch_array($ce)){
			if(CanPerformAction("use|compose|".$c[ComposeID]) || $c[AdminID]==$AdminID){
				$allemails.=$c[ComposeID]."->".$c[ComposeName].";";		
			}
		
		}
		
		
		$FORM_ITEMS["List to send to"]="select|ListID:1:$alllists";
		$FORM_ITEMS["Filter String"]="textfield|FilterString:200:50::";
		$FORM_ITEMS[-2]="spacer|".MakeLink(MakePopup('filterstring_popup.php',600,400,"FilterBy"),"Filter String Wizard");
		$FORM_ITEMS["Email to send"]="select|ComposeID:1:$allemails";
		$FORM_ITEMS["Send as Multipart?"]="select|Multipart:1:0->No;1->Yes";
		$FORM_ITEMS["Send to"]="select|SendTo:1:receiving->Only those receiving;all->All Members";
		$FORM_ITEMS[-1]="submit|Continue";
		
		$FORM=new AdminForm;
		$FORM->title="MemberSearch";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="send.php?action=use";
		$FORM->MakeForm();
		
		$BO.=$FORM->output;
	
	$FULL_OUTPUT.=MakeBox("Send options screen one", $BO);
	
		$sends=mysql_query("SELECT * FROM sends WHERE AdminID='$AdminID' && PerExec>'0' && Completed='0'");
			while($s=mysql_fetch_array($sends)){
				$allsends.=$s[SendID]."->Send #".$s[SendID].";";
			}
		$FORM_ITEMS2["Email to send"]="select|ReDoSendID:1:$allsends";
		$FORM_ITEMS2[-1]="submit|Restart Send";
		
		$FORM2=new AdminForm;
		$FORM2->title="MemberSearch";
		$FORM2->items=$FORM_ITEMS2;
		$FORM2->action="send.php?";
		$FORM2->MakeForm();
		
		$BO2.='This is used if a send you were attempting crashed or did not complete<P>'.$FORM2->output;
	
	$FULL_OUTPUT.=MakeBox("Continue another send!", $BO2);
}











FinishOutput();

?>
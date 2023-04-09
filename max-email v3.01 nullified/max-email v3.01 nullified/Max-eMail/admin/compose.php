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

$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
			if(CanPerformAction("$action|compose|$ComposeID")!=1 && $c[AdminID]!=$AdminID){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
		switch($action){
			case "create":
			ComposeAdd();
			break;
			
			case "edit":
			EditEmailMain();
			break;
			
			case "edit";
			EditHTML();
			break;
		}
}else{
	ComposeMain();
}

/////////////////////////////////////////////////////////////

function EditEmailMain(){
	GLOBAL $FULL_OUTPUT, $ComposeID, $type;
	
	if($type=="html"){
		EditHTML();
	}elseif($type=="text"){
		EditText();
	}elseif($type=="delete"){
		mysql_query("DELETE FROM composed_emails WHERE ComposeID='$ComposeID'");
		$FULL_OUTPUT.=MakeBox("Deleted..", "The composed email was deleted");
		ComposeMain();
		FinishOutput();
	}
	
	$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
	
	$BoxOut.='Below are the options you have for editing the email.<P>';
	
	if($c[Format]==text){
		$BoxOut.=MakeLink("compose.php?action=edit&ComposeID=$ComposeID&type=text", "Edit text version")." (".MakeLink(MakePopup('view_composed.php?Version=Text&ComposeID='.$c[ComposeID],600,600,"PreviewText"),"Preview").")";
	}elseif($c[Format]==HTML){
		$BoxOut.=MakeLink("compose.php?action=edit&ComposeID=$ComposeID&type=html", "Edit HTML version")." (".MakeLink(MakePopup('view_composed.php?Version=HTML&ComposeID='.$c[ComposeID],600,600,"PreviewHTML"),"Preview").")";
	}elseif($c[Format]==texthtml){
		$BoxOut.=MakeLink("compose.php?action=edit&ComposeID=$ComposeID&type=text", "Edit text version")." (".MakeLink(MakePopup('view_composed.php?Version=Text&ComposeID='.$c[ComposeID],600,600,"PreviewText"),"Preview").") | ".MakeLink("compose.php?action=edit&ComposeID=$ComposeID&type=html", "Edit HTML version")." (".MakeLink(MakePopup('view_composed.php?Version=HTML&ComposeID='.$c[ComposeID],600,600,"PreviewHTML"),"Preview").")";
	}
	$BoxOut.=' | '.MakeLink("compose.php","Back to compose main");
	
	$FULL_OUTPUT.=MakeBox("Edit composed email '".$c[ComposeName]."'", $BoxOut);
}

/////////////////////////////////////////////////////////////
function EditText(){
	GLOBAL $FULL_OUTPUT, $ComposeID, $HTTP_POST_VARS, $save, $subject, $emailintext;
	$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
		
	if($save){
		if($c[TemplateID] && CanPerformAction("use|template|".$c[TemplateID])){
			$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID=".$c[TemplateID]));
			$fields=TemplateFields($t[Text_Version]);
			$et=$t[Text_Version];
			if($fields){foreach($fields as $f){
				$et=str_replace("####start####$f####end####",$HTTP_POST_VARS[$f]."\n",$et);
			}}
			mysql_query("UPDATE composed_emails SET Text_Version='$et', Text_Subject='$subject' WHERE ComposeID='$ComposeID'");
		}else{
			//easy save!
			mysql_query("UPDATE composed_emails SET Text_Version='$emailintext', Text_Subject='$subject' WHERE ComposeID='$ComposeID'");	
		}
		
	$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
	}
	
	
	if($c[TemplateID] && CanPerformAction("use|template|".$c[TemplateID])){
		$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID=".$c[TemplateID]));
		$fields=TemplateFields($t[Text_Version]);
		$rem=$t[Text_Version];
		$fi=-1;
		if($fields){foreach($fields as $f){
			list($this,$rem)=explode("####start####$f####end####",$rem);
			$FORM_ITEMS[$fi]="spacer|".nl2br($this);$fi--;
			$f=str_replace("
", '', $f);
			$f=strip_tags($f);
			$FORM_ITEMS[$fi]="raw|".Text_Compose_Form("$f","EditForm", str_replace(":", '$$COLON$$',$f));$fi--;
		}}
	}else{
		$FORM_ITEMS[-1]="raw|".Text_Compose_Form("emailintext","EditForm", str_replace(":", '$$COLON$$', $c[Text_Version]));$fi--;
	}	
		
		$FORM_ITEMS["Email subject"]="textfield|subject:30:30:".$c[Text_Subject];
		$FORM_ITEMS[-1000]="submit|Save Changes";
			//make the form
	$FORM=new AdminForm;
		$FORM->title="EditForm";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="compose.php?action=edit&ComposeID=$ComposeID&type=text&save=yes";
		$FORM->MakeForm();
		
		$BoxOut.=$FORM->output;
		
	$FULL_OUTPUT.=MakeBox("Edit text version", $BoxOut);	

}

/////////////////////////////////////////////////////////////

function EditHTML(){
	GLOBAL $FULL_OUTPUT, $ComposeID, $HTTP_POST_VARS, $save, $subject, $emailinhtml;
	$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
		
	if($save){
		if($c[TemplateID] && CanPerformAction("use|template|".$c[TemplateID])){
			$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID=".$c[TemplateID]));
			$fields=TemplateFields($t[HTML_Version]);
			$et=$t[HTML_Version];
			if($fields){foreach($fields as $f){
				$et=str_replace("####start####$f####end####",$HTTP_POST_VARS[$f]."\n",$et);
			}}
			mysql_query("UPDATE composed_emails SET HTML_Version='$et', HTML_Subject='$subject' WHERE ComposeID='$ComposeID'");
		}else{
			//easy save!
			mysql_query("UPDATE composed_emails SET HTML_Version='$emailinhtml', HTML_Subject='$subject' WHERE ComposeID='$ComposeID'");	
		}
		
	$c=mysql_fetch_array(mysql_query("SELECT * FROM composed_emails WHERE ComposeID='$ComposeID'"));
	}
	
	
	if($c[TemplateID] && CanPerformAction("use|template|".$c[TemplateID])){
		$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID=".$c[TemplateID]));
		$fields=TemplateFields($t[HTML_Version]);
		$rem=$t[HTML_Version];
		$fi=-1;
		if($fields){foreach($fields as $f){
			list($this,$rem)=explode("####start####$f####end####",$rem);
			$FORM_ITEMS[$fi]="spacer|$this";$fi--;
			$f=str_replace("
", '', $f);
			$f=strip_tags($f);
				if($t[AllowFormating]==1){
				$FORM_ITEMS[$fi]="raw|".HTML_Compose_Form("$f","EditForm", str_replace(":", '$$COLON$$',$f), $f);$fi--;
				}else{
				$FORM_ITEMS[$fi]="raw|".Text_Compose_Form("$f","EditForm", str_replace(":", '$$COLON$$',$f));$fi--;
				}
		}}
	}else{
		$FORM_ITEMS[-1]="raw|".HTML_Compose_Form("emailinhtml","EditForm", str_replace(":", '$$COLON$$',$c[HTML_Version]));$fi--;
	}	
		
		$FORM_ITEMS["Email subject"]="textfield|subject:30:30:".$c[HTML_Subject];
		$FORM_ITEMS[-1000]="submit|Save Changes";
			//make the form
	$FORM=new AdminForm;
		$FORM->title="EditForm";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="compose.php?action=edit&ComposeID=$ComposeID&type=html&save=yes";
		$FORM->MakeForm();
		
		$BoxOut.=$FORM->output;
		
	$FULL_OUTPUT.=MakeBox("Edit html version", $BoxOut);	

}

/////////////////////////////////////////////////////////////

function ComposeAdd(){
GLOBAL $FULL_OUTPUT, $ComposeName, $Format, $TemplateID, $Global, $AdminID, $ComposeID;
	
	//need to setup the email!
	mysql_query("INSERT INTO composed_emails SET ComposeName='$ComposeName', Format='$Format', TemplateID='$TemplateID', AdminID='$AdminID'");
	$ComposeID=mysql_insert_id();
	
	EditEmailMain();
}

/////////////////////////////////////////////////////////////

function ComposeMain(){
GLOBAL $FULL_OUTPUT, $AdminID;

//print composed emails this admin can edit!
$com=mysql_query("SELECT * FROM composed_emails");
$EC='<center><Table width="60%">
<tr><td><span class="admintext">Composed Name</td><td><span class="admintext">Options</td></tr>
<TR height="1" bgcolor="#cccccc"><td colspan="2"></td></tr>';
while($c=mysql_fetch_array($com)){
	if(CanPerformAction("edit|compose|".$c[ComposeID]) || $c[AdminID]==$AdminID){
		$EC.='<tr><td><span class="admintext">'.$c[ComposeName].'</td><td><span class="admintext">'.MakeLink("compose.php?action=edit&ComposeID=".$c[ComposeID], "Edit").' | '.MakeLink("compose.php?action=edit&ComposeID=".$c[ComposeID]."&type=delete", "Delete",1).'</td></tr>';
	}
}
$EC.='</TABLE>';

$FULL_OUTPUT.=MakeBox("Edit a composed email", $EC);

//put an add compose box in if the admin is allowed to!
	if(CanPerformAction("create|compose|")){
	$res=mysql_query("SELECT * FROM templates");
	$alllists='-> NO TEMPLATE;';
	while($r=mysql_fetch_array($res)){
		if(CanPerformAction("use|template|".$r[TemplateID])){
			$alllists.=$r[TemplateID]."->".$r[TemplateName].";";
		}	
	}
		$FORM_ITEMS["Template"]="select|TemplateID:1:$alllists";		
		$FORM_ITEMS["Format"]="select|Format:1:text->Only Text;HTML->Only HTML;texthtml->Text and HTML";	
		$FORM_ITEMS["Email Name"]="textfield|ComposeName:30:30:NewEmail";			
		$FORM_ITEMS[-1]="submit|Continue";
	//make the form
	$FORM=new AdminForm;
		$FORM->title="My Form";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="compose.php?action=create";
		$FORM->MakeForm();
	$FULL_OUTPUT.=MakeBox("Compose a new email", $FORM->output);
	}
}

FinishOutput();

?>
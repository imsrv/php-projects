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

	
			if(CanPerformAction("$action|templates|$TemplateID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "edit":
		EditTemplate();
		break;
		
		case "view":
		ViewTemplate();
		break;
		
		case "create":
		CreateNewTemplate();
		break;
			
	}
}else{
	TemplatesMain();
}

/////////////////////////////////////////////////////////////

function EditTemplate(){
	GLOBAL $FULL_OUTPUT, $TemplateID, $TextEmail, $TextSubject, $HTMLEmail, $HTMLSubject;
		
		if($TextEmail && $TextSubject){
			mysql_query("UPDATE templates SET Text_Version='$TextEmail', Text_Subject='$TextSubject', DateModified='".time()."' WHERE TemplateID='$TemplateID'");
			$FULL_OUTPUT.=MakeBox("Text changes saved", 'Your changes to the text template were saved!');
		}
		
		if($HTMLEmail && $HTMLSubject){
			mysql_query("UPDATE templates SET HTML_Version='$HTMLEmail', HTML_Subject='$HTMLSubject', DateModified='".time()."' WHERE TemplateID='$TemplateID'");
			$FULL_OUTPUT.=MakeBox("HTML changes saved", 'Your changes to the HTML template were saved!');
		}
		
		$FULL_OUTPUT.=MakeBox('Editing template', 'Enter a Text, HTML or both version for the template below.<P>Editable regions are in the format <font color="green">####start####DEFAULT_VALUE####end####</font> where DEFAULT_VALUE is the default value for the editable region.<P>AutoFill fields can also be used in these fields! '.MakeLink(MakePopup('autofillfields.php',400,400,"AutoFillFields"),"View current AutoFill fields!").'<P>'.MakeLink("templates.php", "Back to templates main"));
		
		$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID='$TemplateID'"));	
			
	//Text version box!
				$FORM_ITEMS["Text Email"]="textarea|TextEmail:64:8:".str_replace(":", '$$COLON$$', $t[Text_Version]);
				$FORM_ITEMS["Text subject"]="textfield|TextSubject:50:30:".$t[Text_Subject];
				$FORM_ITEMS[-1]="submit|Save Changes";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="My Form";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="templates.php?action=edit&TemplateID=$TemplateID";
				$FORM->MakeForm();
				
					if(CanPerformAction("view|templates|".$t[TemplateID])){
						$Out=MakeLink(MakePopup('view_template.php?Version=Text&TemplateID='.$t[TemplateID],600,600,"TextTemplate"),"View Saved Version");
					}
				
				$FULL_OUTPUT.=MakeBox("Text Version", $FORM->output.$Out);
				$FORM_ITEMS="";
				
	//HTML version box!
				//$FORM_ITEMS["HTML Email"]="textarea|HTMLEmail:64:8:".$t[HTML_Version];
				$FORM_ITEMS[-2]="raw|".HTML_Compose_Form("HTMLEmail", "MyForm", str_replace(":", '$$COLON$$', $t[HTML_Version]));
				$FORM_ITEMS["HTML subject"]="textfield|HTMLSubject:50:30:".$t[HTML_Subject];
				
				$FORM_ITEMS[-1]="submit|Save Changes";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="MyForm";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="templates.php?action=edit&TemplateID=$TemplateID";
				$FORM->MakeForm();
				
					if(CanPerformAction("view|templates|".$t[TemplateID])){
						$Out=MakeLink(MakePopup('view_template.php?Version=HTML&TemplateID='.$t[TemplateID],600,600,"HTMLTemplate"),"View Saved Version");
					}
				
				$FULL_OUTPUT.=MakeBox("HTML Version", $FORM->output.$Out);
}


/////////////////////////////////////////////////////////////

function ViewTemplate(){
	GLOBAL $FULL_OUTPUT, $TemplateID;
		
	$t=mysql_fetch_array(mysql_query("SELECT * FROM templates WHERE TemplateID='$TemplateID'"));
	
	$BoxOut.='This template was last modified on '.PrintableDate($t[DateModified]).'.<P>';
	
	if($t[HTML_Version]){
		$BoxOut.='<B><P>HTML Version</B><BR>
		Subject: '.$t[HTML_Subject].'<BR>';
		$BoxOut.=MakeLink(MakePopup('view_template.php?Version=HTML&TemplateID='.$t[TemplateID],600,600,"HTMLTemplate"),"View Entire HTML Version");
	}
	
	if($t[Text_Version]){
		$BoxOut.='<B><P>Text Version</B><BR>
		Subject: '.$t[Text_Subject].'<BR>';
		$BoxOut.=MakeLink(MakePopup('view_template.php?Version=Text&TemplateID='.$t[TemplateID],600,600,"TextTemplate"),"View Entire Text Version");
	}
	
	$BoxOut.='<P>'.MakeLink("templates.php", "Back to templates main");
	
						if(CanPerformAction("edit|templates|".$t[TemplateID])){
							$BoxOut.='<P>'.MakeLink('templates.php?action=edit&TemplateID='.$t[TemplateID].'"', "Edit this template!");
						}
	
	$FULL_OUTPUT.=MakeBox($t[TemplateName]." info..", $BoxOut);
	
}

/////////////////////////////////////////////////////////////

function TemplatesMain(){
	GLOBAL $FULL_OUTPUT;
	
	$BoxOut='<center><TABLE width="70%"><TR>
	<TD><span class="admintext">Template Name</span></TD>
	<TD colspan="2"><span class="admintext">Options</span></TD>
	</tr>';
	
	$BoxOut.='<center><TR height="1" bgcolor="#cccccc"><TD></TD><TD></TD><TD></TD><TD></TD></tr>';
	
	//find which templates the admin has access to!
	$res=mysql_query("SELECT * FROM templates");
	
	while($r=mysql_fetch_array($res)){
			if(CanPerformAction("edit|templates|".$r[TemplateID]) || CanPerformAction("view|templates|".$r[TemplateID])){
					$BoxOut.='<center><TR>
					<TD><span class="admintext">'.$r[TemplateName].'</span></TD>
					<TD><span class="admintext">';
						if(CanPerformAction("edit|templates|".$r[TemplateID])){
							$BoxOut.=MakeLink('templates.php?action=edit&TemplateID='.$r[TemplateID].'"', "Edit");
						}
					$BoxOut.='</span></TD>
					<TD><span class="admintext">';
						if(CanPerformAction("view|templates|".$r[TemplateID])){
							$BoxOut.=MakeLink('templates.php?action=view&TemplateID='.$r[TemplateID].'"', "View");
						}
					$BoxOut.='</span></TD>
						<TD><span class="admintext">';
						if(CanPerformAction("create|templates|".$r[TemplateID])){
							$BoxOut.=MakeLink('templates.php?action=create&DeleteTemplateID='.$r[TemplateID], "Delete",1);
						}
					$BoxOut.='</span></TD>
					</tr>';
			}
	}
	
	$BoxOut.='</TABLE></center>';
	
	$FULL_OUTPUT.=MakeBox("Templates available to you!", $BoxOut);
	
	if(CanPerformAction("create|templates|")){
		//create new template form!
				$FORM_ITEMS["New template name"]="textfield|NewTemplateName:50:30:";
				$FORM_ITEMS["Allow formatting in editable regions"]="select|AllowFormating:1:0->No;1->Yes";		
				$FORM_ITEMS[-1]="submit|Create new template";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="My Form";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="templates.php?action=create";
				$FORM->MakeForm();
				$FULL_OUTPUT.=MakeBox("Create new template", $FORM->output);
	}
}

function CreateNewTemplate(){
	GLOBAL $FULL_OUTPUT, $NewTemplateName, $DeleteTemplateID, $TemplateID, $AllowFormating;
	if($NewTemplateName){
	mysql_query("INSERT INTO templates SET TemplateName='$NewTemplateName', DateModified='".time()."', AllowFormating='$AllowFormating'");
		$TemplateID=mysql_insert_id();
		EditTemplate();
	}elseif($DeleteTemplateID){
		mysql_query("DELETE FROM templates WHERE TemplateID='$DeleteTemplateID'");
		TemplatesMain();
	}else{	
	TemplatesMain();
	}

}


FinishOutput();

?>



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


function EditFormFields(){
	GLOBAL $FULL_OUTPUT, $FormID;
	$form=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"));
	
	$BO.='The following List Fields are available to this form!<BR>';
	$Lists=explode(",", $form[Lists]);
		foreach($Lists as $List){
			$li=list_info($List);
			if($li[ListName]){
			$BO.='<P><B>'.$li[ListName].'..</B><BR>';
			$fields=list_fields($List);
				foreach($fields as $f){
						$x="";if(mysql_num_rows(mysql_query("SELECT * FROM form_fields WHERE ListID='$List' && FormID='$FormID' && ListField='$f'"))){$x=" [SET]";}
					$BO.='- '.MakeLink("inputforms.php?action=editfield&FormID=$FormID&ListField=$f&ListID=$List", "$f$x").'<BR>';
				}
			}
		}

		$BO.='<P>'.MakeLink("inputforms.php?action=editform&FormID=$FormID", "Back to form edit main");

	$FULL_OUTPUT.=MakeBox("Editing form..", $BO);


}


function EditField(){
	GLOBAL $FULL_OUTPUT,$FormID,$FieldValue,$FieldType,$ListField,$ListID, $delete,$save, $IsIndex,$Verification,$FormFieldName;
		
		if($save){
			mysql_query("DELETE FROM form_fields WHERE FormID='$FormID' && ListID='$ListID' && ListField='$ListField'");
			if(!$delete){
			mysql_query("INSERT INTO form_fields SET FormID='$FormID', ListID='$ListID', ListField='$ListField', Verification='$Verification',FormFieldName='$FormFieldName', FieldType='$FieldType', FieldData='$FieldValue'");
			}
			EditFormFields();
			FinishOutput();
		}
		
		$form=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"));
		$field=mysql_fetch_array(mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID' && ListID='$ListID' && ListField='$ListField'"));
	
		
		$FORM_ITEMS["Field Name"]="textfield|FormFieldName:40:40:".$field[FormFieldName];
	
		//get verification functions!
			$funcs=get_defined_functions();
				foreach($funcs[user] as $func){
					if(substr($func,0,2)=="dv"){
						$allverfuncs.=trim($func)."->".ucwords(str_replace("dv", "", str_replace("_", " ", $func))).";";
					}
				}
		$FORM_ITEMS["Verification Routine"]="select|Verification:1:->None;$allverfuncs:".$field[Verification];
		$FORM_ITEMS["Field Type"]="select|FieldType:1:input->Input;date->Date;value->Value;unique->Unique:".$field[FieldType];
		$FORM_ITEMS["Value"]="textfield|FieldValue:100:30:".$field[FieldData];
		$isindex="";if($field[IsIndex]==1){$isindex="CHECKED";}
		$FORM_ITEMS[-1]="submit|Save Changes";
		
				$FORM=new AdminForm;
				$FORM->title="EditFormField";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="inputforms.php?action=editfield&save=yes&ListID=$ListID&FormID=$FormID&ListField=$ListField";
				$FORM->MakeForm();
				$BO.=$FORM->output;
				$BO.='<P>'.MakeLink("inputforms.php?action=editfield&ListID=$ListID&FormID=$FormID&ListField=$ListField&delete=yes&save=yes", "Delete field from form",1);
	$FULL_OUTPUT.=MakeBox("Editing form field..", $BO);
}


function EditForm(){
	GLOBAL $FULL_OUTPUT, $save, $FormID, $FormName, $Lists, $FormType,$IndexField, $ROOT_URL;
	
	if($save){
			foreach($Lists as $Li){$al.="$Li,";}
		mysql_query("UPDATE forms SET FormName='$FormName', Lists='$al', IndexField='$IndexField', FormType='$FormType' WHERE FormID='$FormID'");
	}
	
	
	$form=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$FormID'"));
	
	//introduction box!
	$FULL_OUTPUT.=MakeBox("Max-eMail Input Forms Info", 'Max-eMail uses a very powerful form engine that enables you to create forms for almost any purpose. The form engine can be slightly complicated to understand to begin with and we suggest you read over the relevant support material before using the form engine. We assure you that once you become used to it, which will not take long, you will appreciate how useful its power is.');
	
	$usedlists=explode(",", $form[Lists]);
	$lists=mysql_query("SELECT * FROM lists");
		while($l=mysql_fetch_array($lists)){
			$alllists.=$l[ListID]."->".$l[ListName];
				if(in_array($l[ListID],$usedlists)){
					$alllists.="/CHECKED";
				}
				$alllists.=";";
		}
	
	$FORM_ITEMS["Form Name"]="textfield|FormName:30:30:".$form[FormName];
	$FORM_ITEMS["Lists to use"]="checkboxes|Lists:$alllists";
	$FORM_ITEMS["Form Type"]="select|FormType:1:insert->Insert;update->Update;delete->Delete:".$form[FormType];
	
	//do we need an index field!
		$FF=mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID'");
			while($f=mysql_fetch_array($FF)){
				$allfields.=$f[FormFieldName]."->".$f[FormFieldName].";";
			}
		
		if($form[FormType]=="update" || $form[FormType]=="delete"){
			$FORM_ITEMS["Index Field"]="select|IndexField:1:$allfields:".$form[IndexField];
		}
	
		$FORM_ITEMS[-1]="submit|Save Changes";
		
	//now the form management form!
				$FORM=new AdminForm;
				$FORM->title="EditFormField";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="inputforms.php?action=editform&save=yes&FormID=$FormID";
				$FORM->MakeForm();
				$BO.=$FORM->output;
	
				$BO.='<P>'.MakeLink("inputforms.php?action=editformfields&FormID=$FormID","Edit Fields");
				$BO.=' | '.MakeLink("inputforms.php?action=editactions&FormID=$FormID","Edit Response Actions");
				$BO.=' | '.MakeLink("inputforms.php?","Back to forms main");
				$BO.=' | '.MakeLink("$ROOT_URL/form.php?FormID=$FormID","Preview Form");
				
	$FULL_OUTPUT.=MakeBox("Edit form", $BO);
	
	GLOBAL $ParentID;
	$ParentID=$FormID;
	InputFormsMain();
}

function EditActions(){
	GLOBAL $FULL_OUTPUT, $FormID;

	$fields=mysql_query("SELECT * FROM form_fields WHERE FormID='$FormID'");
		while($f=mysql_fetch_array($fields)){
			$Errors[$f[Verification]]=1;
		}
	if($Errors){
		foreach($Errors as $E=>$e){
			if($E){
			$BO.='<P>'.MakeLink("inputforms.php?action=editresponse&FormID=$FormID&response=Error:$E", "Failed ".ucwords(str_replace("dv", "", str_replace("_", " ", $E)))." Response");
			}
		}
	}
	
	$BO.='<P>'.MakeLink("inputforms.php?action=editresponse&FormID=$FormID&response=success", "Successful Response");
	$BO.='<P>'.MakeLink("inputforms.php?action=editresponse&FormID=$FormID&response=failed", "Unknown Failure Response");
	$BO.='<P><BR>'.MakeLink("inputforms.php?action=editform&FormID=$FormID", "Back to edit form main");
	
	$FULL_OUTPUT.=MakeBox("Actions to edit", $BO);
}


function EditResponse(){
	GLOBAL $FULL_OUTPUT, $FormID, $response, $save, $SendEmailTo,$EmailSubject,$EmailFrom,$EmailBody,$DisplayURL,$DisplayText,$ReDisplayForm;

	if($save){
		mysql_query("DELETE FROM form_actions WHERE FormID='$FormID' && Response='$response'");
		mysql_query("INSERT INTO form_actions SET DisplayURL='$DisplayURL',DisplayText='$DisplayText',ReDisplayForm='$ReDisplayForm',EmailFrom='$EmailFrom',EmailBody='$EmailBody',FormID='$FormID', Response='$response', SendEmailTo='$SendEmailTo', EmailSubject='$EmailSubject'");
		EditActions();
		FinishOutput();		
	}
	
	$resp=mysql_fetch_array(mysql_query("SELECT * FROM form_actions WHERE FormID=$FormID && Response='$response'"));
	$BO.='If you do not want to use a particular action leave it blank and it will not be run! Remember you can use form fields in all of these boxes by using %FORMFIELDNAME%.';
	
			$FORM_ITEMS[-2]="spacer|Complete this if you want to send an email..";
			$FORM_ITEMS["Send email to"]="textfield|SendEmailTo:70:40:".$resp[SendEmailTo];		
			$FORM_ITEMS["Email Subject"]="textfield|EmailSubject:70:40:".$resp[EmailSubject];
			$FORM_ITEMS["Email From"]="textfield|EmailFrom:70:40:".$resp[EmailFrom];
			$FORM_ITEMS["Message"]="textarea|EmailBody:60:5:".str_replace(":", '$$COLON$$',$resp[EmailBody]);
			$FORM_ITEMS[-3]="spacer|&nbsp;";		
			$FORM_ITEMS["Forward to URL"]="textfield|DisplayURL:70:40:".str_replace(":", '$$COLON$$',$resp[DisplayURL]);		
			$FORM_ITEMS["Display HTML"]="textarea|DisplayText:60:5:".$resp[DisplayText];	
			
			$FORM_ITEMS["Display Form again"]="select|ReDisplayForm:1:0->No;1->Yes:".$resp[ReDisplayForm];
			
			$FORM_ITEMS[-1]="submit|Save Changes";
		
	//now the form management form!
		$FORM=new AdminForm;
		$FORM->title="EditFormField";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="inputforms.php?action=editresponse&save=yes&FormID=$FormID&response=$response";
		$FORM->MakeForm();
		$BO.=$FORM->output;
		
		$FULL_OUTPUT.=MakeBox("Edit response actions",$BO);
	
}


function InputFormsMain(){
	GLOBAL $FULL_OUTPUT, $ParentID;

	if(!$ParentID){
	$parentf[FormName]="Top Level";
	}else{
	$parentf=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE FormID='$ParentID'"));
	}
	
	$BO.='<TABLE width="100%">
	<tr><td><span class="admintext">Form Name</span></td><td><span class="admintext">Form Type</span></td><td><span class="admintext">Parent Form</span></td></tr>
	<tr height="1" bgcolor="#cccccc"><td colspan="4"></td></tr>';
	$forms=mysql_query("SELECT * FROM forms WHERE ParentFormID='$ParentID'");
		while($f=mysql_fetch_array($forms)){
			$parent=mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE ParentFormID='".$f[FormID]."'"));
			$BO.='<TR><TD><span class="admintext">'.$f[FormName].'</span></TD><TD><span class="admintext">'.$f[FormType].'</span></TD><TD><span class="admintext">'.$parent[FormName].'</span></TD><TD><span class="admintext">'.MakeLink("inputforms.php?action=editform&FormID=".$f[FormID], "Edit").' | '.MakeLink("inputforms.php?ParentID=".$f[FormID], "Forms Under").' | '.MakeLink("inputforms.php?action=delete&DeleteID=".$f[FormID], "Delete",1).'</span></TD></TR>';
		}
	$BO.='</TABLE>';
	$FULL_OUTPUT.=MakeBox("Edit existing forms under '".$parentf[FormName]."'", $BO);
	
	
	//now the add form form!
	
		$lists=mysql_query("SELECT * FROM lists");
			while($l=mysql_fetch_array($lists)){
			$alllists.=$l[ListID]."->".$l[ListName].";";
		}
		
	$FORM_ITEMS["Form Name"]="textfield|FormName:30:30:".$form[FormName];
	$FORM_ITEMS["Lists to use"]="checkboxes|Lists:$alllists";
	$FORM_ITEMS["Form Type"]="select|FormType:1:insert->Insert;update->Update;delete->Delete:".$form[FormType];
	$FORM_ITEMS[-2]="hidden|ParentID:$ParentID";
	$FORM_ITEMS[-1]="submit|Add Form";
		$FORM=new AdminForm;
		$FORM->title="EditFormField";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="inputforms.php?action=addform";
		$FORM->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Add form under '".$parentf[FormName]."'", $FORM->output);
}


function AddForm(){
	GLOBAL $FULL_OUTPUT,$FormName,$Lists,$FormType, $ParentID;
		foreach($Lists as $Li){$al.="$Li,";}
		mysql_query("INSERT INTO forms SET ParentFormID='$ParentID',FormName='$FormName', Lists='$al', FormType='$FormType'");
		GLOBAL $FormID;
		$FormID=mysql_insert_id();	
		EditForm();
}

function DeleteForm(){
	GLOBAL $FULL_OUTPUT,$DeleteID;
	
	mysql_query("DELETE FROM form_fields WHERE FormID='$DeleteID'");
	mysql_query("DELETE FROM form_actions WHERE FormID='$DeleteID'");
	mysql_query("DELETE FROM forms WHERE FormID='$DeleteID'");
	InputFormsMain();

}

switch($action){
	case "":
		InputFormsMain();
	break;
	
	case "delete":
		DeleteForm();
	break;
	
	case "addform":
		AddForm();
	break;
	
	case "editresponse":
		EditResponse();
	break;
	
	case "editactions":
		EditActions();
	break;
	
	case "editform":
	 	EditForm();
	break;
	
	case "editformfields":
		EditFormFields();
	break;
	
	case "editfield":
		EditField();
	break;
	
}


FinishOutput();

?>
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

function NewTextFile($stage){
	GLOBAL $FULL_OUTPUT, $CreateFrom, $ROOT_DIR;

	//do we have a list template!
		if($CreateFrom!="custom"){
			$f=fopen("$ROOT_DIR/data/list_templates/$CreateFrom.tmp", "r");
			while(!feof($f)){
				$data.=fgets($f,1024);
			}
			$lines=explode("\n",$data);
			foreach($lines as $line){
				list($name,$value)=explode("=", $line);
				$Template[$name]=$value;
			}
		}
	
if($stage=="make"){
	GLOBAL $ListName, $ListFields, $ListLocation, $FieldDelim,$RecordDelim,$Headers,$AllowEdits,$FileExits;
	
	if($Headers){
		$FILEDATA=str_replace(",", $FieldDelim,$ListFields).str_replace("NEWLINE","\n",$RecordDelim);
		$HeadersDB=1;
	}else{
		$FILEDATA="";
		$HeadersDB=str_replace(",", $FieldDelim,$ListFields);
	}
	
	$ListSource="$ListLocation/#$FieldDelim/#$RecordDelim/#$Headers/#$AllowEdits";
	
	if(!$FileExists){
		@$f=fopen($ListLocation, "w");
		fputs($f,$FILEDATA);
	}

	//now check the file exists!
	if(is_file($ListLocation)){
		mysql_query("INSERT INTO lists SET ListName='$ListName', ListSource='$ListSource', ListSourceType='textfile'");
		GLOBAL $ListID;
		$ListID=mysql_insert_id();
		$BO.="List created successfully!";
	}else{
		$FULL_OUTPUT.=MakeBox("Error..", 'File did not exist or could not be created!');
		$error=1;
	}

}elseif($stage=="options" || $error){
//we need to get the datasource
	$FORM_ITEMS["List Name"]="textfield|ListName:30:30:NewList";
	$FORM_ITEMS["List Fields (, seperated)"]="textfield|ListFields:1000:100:".$Template[Fields];
	$FORM_ITEMS["List File Path"]="textfield|ListLocation:1000:70:".str_replace(":", '$$COLON$$', $ROOT_DIR."/NewList.txt");
	$FORM_ITEMS["Field Delimeter"]="textfield|FieldDelim:10:10:".$Template[FieldDelim];
	$FORM_ITEMS["Record Delimeter"]="textfield|RecordDelim:10:10:".$Template[RecordDelim];
	$FORM_ITEMS["Headers in file"]="checkbox|Headers:1:Yes:CHECKED";
	$FORM_ITEMS["Can be edited"]="checkbox|AllowEdits:1:Yes:CHECKED";
	$FORM_ITEMS["File Exists"]="checkbox|FileExists:1:Yes:";
	$FORM_ITEMS[-1]="submit|Make List";
	
	//make the form
	$FORM=new AdminForm;
	$FORM->title="CreateList";
	$FORM->items=$FORM_ITEMS;
	$FORM->action="listsetup.php?action=createnew&ListType=textfile&stage=make&CreateFrom=$CreateFrom";
	$FORM->MakeForm();
	
	$BO.=$FORM->output;

	$FULL_OUTPUT=MakeBox("Define new list", $BO);
	FinishOutput();
}


	$FULL_OUTPUT=MakeBox("List created", $BO.'<P>'.MakeLink("listsetup.php?ListID=$ListID&action=editlist", "Edit this list"));
	FinishTemplating($ListID, $CreateFrom);
	


}

/////////////////////////

function NewExternal(){
	GLOBAL $FULL_OUTPUT,$stage, $ROOT_DIR, $CreateFrom, $ListName, $AllowEdits;
	GLOBAL $LServer,$LPort,$LUser,$LPass,$LDatabase,$LTable;
	
	if($stage=="make"){
		//insert the new list entry!
		$ListSource="$LServer/#$LPort/#$LUser/#$LPass/#$LDatabase/#$LTable/#$AllowEdits";
		mysql_query("INSERT INTO lists SET ListSourceType='mysqldatabase', ListName='$ListName', ListSource='$ListSource'");
		GLOBAL $ListID;
		$ListID=mysql_insert_id();
			
			$FULL_OUTPUT=MakeBox("List created", 'List created successfully!');
			FinishTemplating($ListID, $CreateFrom);
			EditList();
	
	}else{
		
	$FORM_ITEMS["List Name"]="textfield|ListName:30:30:NewList";
	$FORM_ITEMS["Database Server"]="textfield|LServer:100:30:localhost";
	$FORM_ITEMS["Database Port"]="textfield|LPort:10:10:";
	$FORM_ITEMS["Database Username"]="textfield|LUser:100:30:";
	$FORM_ITEMS["Database Password"]="textfield|LPass:100:30:";
	$FORM_ITEMS["Database Name"]="textfield|LDatabase:100:30:";
	$FORM_ITEMS["Table Name"]="textfield|LTable:100:30:";
	$FORM_ITEMS["Can be edited"]="checkbox|AllowEdits:1:Yes:CHECKED";
	
	$FORM_ITEMS[-1]="submit|Make List";
	//make the form
	$FORM=new AdminForm;
	$FORM->title="CreateList";
	$FORM->items=$FORM_ITEMS;
	$FORM->action="listsetup.php?action=createnew&ListType=externaldb&stage=make&CreateFrom=$CreateFrom";
	$FORM->MakeForm();
	
	$BO.=$FORM->output;
		$FULL_OUTPUT=MakeBox("Define new list", $BO);
		FinishOutput();
	}
}

/////////////////////////

function NewMaxList(){
	GLOBAL $FULL_OUTPUT,$stage, $ROOT_DIR, $CreateFrom, $ListName, $ListFields;
	GLOBAL $MySQLServer,$MySQLPort,$MySQLUser,$MySQLPass,$MySQLDatabase;
	
		//do we have a list template!
		if($CreateFrom!="custom"){
			$f=fopen("$ROOT_DIR/data/list_templates/$CreateFrom.tmp", "r");
			while(!feof($f)){
				$data.=fgets($f,1024);
			}
			$lines=explode("\n",$data);
			foreach($lines as $line){
				list($name,$value)=explode("=", $line);
				$Template[$name]=$value;
			}
		}
	
	if($stage=="make"){
		//insert the new list entry!
		$TableName="MaxList".time();
		$ListSource="$MySQLServer/#$MySQLPort/#$MySQLUser/#$MySQLPass/#$MySQLDatabase/#$TableName/#1";
		mysql_query("INSERT INTO lists SET ListSourceType='mysqldatabase', ListName='$ListName', ListSource='$ListSource'");
		GLOBAL $ListID;
		$ListID=mysql_insert_id();
		$Fields=explode(",", $ListFields);
		foreach($Fields as $f){
			if($f){
			if($f==$Template[UniqueField]){
			$query.="$f INT not null AUTO_INCREMENT,";
			$end=",PRIMARY KEY ($f), Unique ($f)";
			}else{
			$query.="$f TEXT not null,";
			}
			}
		}
		$fr=strlen($query);
		$query=substr($query,0,$fr-1);
			$query="CREATE TABLE $TableName ($query $end)";
			mysql_query($query);
			
			$FULL_OUTPUT=MakeBox("List created",  'List created successfully!');
			FinishTemplating($ListID, $CreateFrom);
			EditList();
	
	}else{
	
		
	$FORM_ITEMS["List Name"]="textfield|ListName:30:30:NewList";
	$FORM_ITEMS["List Fields (, seperated)"]="textfield|ListFields:1000:100:".$Template[Fields];
	
	$FORM_ITEMS[-1]="submit|Make List";
	//make the form
	$FORM=new AdminForm;
	$FORM->title="CreateList";
	$FORM->items=$FORM_ITEMS;
	$FORM->action="listsetup.php?action=createnew&ListType=maxlist&stage=make&CreateFrom=$CreateFrom";
	$FORM->MakeForm();
	
	$BO.=$FORM->output;
		$FULL_OUTPUT=MakeBox("Define new list", $BO);
		FinishOutput();
	}
}

/////////////////////////

function FinishTemplating($ListID, $CreateFrom){
	GLOBAL $ROOT_DIR;
		if($CreateFrom!="custom"){
			$f=fopen("$ROOT_DIR/data/list_templates/$CreateFrom.tmp", "r");
			while(!feof($f)){
				$data.=fgets($f,1024);
			}
			$lines=explode("\n",$data);
			foreach($lines as $line){
				list($name,$value)=explode("=", $line);
				$Template[$name]=$value;
			}
			
			$vars=array(EmailField,ReceivingField,ReceivingValues,DateField,FormatField,FormatValues,DefaultFormat,DefaultReceiving,UniqueField);
			foreach($vars as $var){
				mysql_query("UPDATE lists SET $var='".$Template[$var]."', Active='1' WHERE ListID='$ListID'");
			}
			
			
		}
}


/////////////////////////

function EditList(){
	GLOBAL $ListID, $FULL_OUTPUT, $Updates, $savechanges;
	
	if($savechanges){
		$Updates[FormatValues]=$Updates[FormatHTML].'/'.$Updates[FormatText];
		$Updates[ReceivingValues]=$Updates[ReceivingYes].'/'.$Updates[ReceivingNo];
		foreach($Updates as $name=>$val){
			mysql_query("UPDATE lists SET $name='$val' WHERE ListID='$ListID'");
		}
	}
	
	$BO='Below are the settings for this list that you can modify! Not all settings for a list can be modifed..<P>';
	$li=list_info($ListID);	
	$Fields=list_fields($ListID);
		foreach($Fields as $f){
			$alllistfields.=$f."->".$f.";";
		}
	
	$FORM_ITEMS["Email Field"]="select|Updates[EmailField]:1:$alllistfields:".$li[EmailField];
	$FORM_ITEMS["Unique Field"]="select|Updates[UniqueField]:1:$alllistfields:".$li[UniqueField];
	$FORM_ITEMS["Receiving Field"]="select|Updates[ReceivingField]:1:$alllistfields:".$li[ReceivingField];
	$FORM_ITEMS["Format Field"]="select|Updates[FormatField]:1:$alllistfields:".$li[FormatField];	
	$FORM_ITEMS["Date Field"]="select|Updates[DateField]:1:->None;$alllistfields:".$li[DateField];	
	$FORM_ITEMS[-1]="spacer|&nbsp;";
	$FORM_ITEMS[-2]="spacer|Format Values";
	list($html,$text)=explode("/",$li[FormatValues]);
	$FORM_ITEMS["HTML"]="textfield|Updates[FormatHTML]:100:15:$html";		
	$FORM_ITEMS["Text"]="textfield|Updates[FormatText]:100:15:$text";			

	$FORM_ITEMS[-3]="spacer|&nbsp;";
	$FORM_ITEMS[-4]="spacer|Receiving Values";
	list($yes,$no)=explode("/",$li[ReceivingValues]);
	$FORM_ITEMS["Yes"]="textfield|Updates[ReceivingYes]:100:15:$yes";		
	$FORM_ITEMS["No"]="textfield|Updates[ReceivingNo]:100:15:$no";	
	
	$FORM_ITEMS[-5]="spacer|&nbsp;";
	$FORM_ITEMS[-6]="spacer|Defaults";
	$FORM_ITEMS["Receiving"]="select|Updates[DefaultReceiving]:1:".$yes."->Receiving;".$no."->Not Receiving:".$li[DefaultReceiving];		
	$FORM_ITEMS["Format"]="select|Updates[DefaultFormat]:1:".$html."->HTML;".$text."->Text:".$li[DefaultFormat];	
	$FORM_ITEMS[-7]="spacer|&nbsp;";

		$ba=mysql_query("SELECT * FROM bounce_addresses");
			while($b=mysql_fetch_array($ba)){
				$bouncads.=$b[BounceAddressID]."->".$b[EmailAddress].";";
			}	
	
	$FORM_ITEMS["Bounce to address"]="select|Updates[BounceAddressID]:1:->None;$bouncads:".$li[BounceAddressID];
	$FORM_ITEMS[-8]="spacer|&nbsp;";
	$FORM_ITEMS[-9]="submit|Save Changes";
	
		//make the form
			$FORM=new AdminForm;
			$FORM->title="EditList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="listsetup.php?action=editlist&ListID=$ListID&savechanges=yes";
			$FORM->MakeForm();
			$BO.=$FORM->output.'<P>'.MakeLink("listsetup.php?", "Back to List Setup main");
			
	$FULL_OUTPUT.=MakeBox("Editing list", $BO);
}


/////////////////////////

function CreateNew(){
	GLOBAL $FULL_OUTPUT, $ROOT_DIR, $CreateFrom, $ListType, $stage;
	
	
	if(!$stage){$stage="options";}
	
	if($ListType=="textfile"){
		NewTextFile($stage);
	}elseif($ListType=="maxlist"){
		NewMaxList($stage);
	}elseif($ListType=="externaldb"){
		NewExternal($stage);
	}
	

}


/////////////////////////
function ListSetupMain(){
	GLOBAL $FULL_OUTPUT, $ROOT_DIR;

		if(is_dir($ROOT_DIR."/data/list_templates")){
		$handle=opendir($ROOT_DIR."/data/list_templates");
		while (($file = readdir($handle))!==false) {
   		 list($name,$ext)=explode(".", $file);
		 	if($ext=="tmp"){
				$alllisttemps.=$name."->".str_replace("_"," ",$name)." Template;";
			}
		}
		}
	
		$FORM_ITEMS["Create from"]="select|CreateFrom:1:custom->Custom List;$alllisttemps";
		$FORM_ITEMS["List Type"]="select|ListType:1:maxlist->Max-eMail List;externaldb->External Database;textfile->TextFile";
		$FORM_ITEMS[-1]="submit|Continue";
		
		//make the form
			$FORM=new AdminForm;
			$FORM->title="CreateList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action="listsetup.php?action=createnew";
			$FORM->MakeForm();
	
	$FULL_OUTPUT.=MakeBox("Create a new list!", $FORM->output);
	
	$BO.='<TABLE width="100%"><TR><TD><span class="admintext">List Name</span></td><TD><span class="admintext">List Type</span></td><TD><span class="admintext">Options</span></td></tr>
	<tr height="1" bgcolor="#cccccc"><td colspan="3"></td></tr>';
		
		$lists=mysql_query("SELECT * FROM lists ORDER BY ListName DESC");
			while($l=mysql_fetch_array($lists)){
			$BO.='<TR><TD><span class="admintext">'.$l[ListName].'</span></td><TD><span class="admintext">'.$l[ListSourceType].'</span></td><TD><span class="admintext">'.MakeLink("listsetup.php?action=editlist&ListID=".$l[ListID], "Edit").' | '.MakeLink("listsetup.php?action=deletelist&ListID=".$l[ListID], "Delete",1).' | '.MakeLink("listsetup.php?action=deletelist&all=yes&ListID=".$l[ListID], "Delete (inc. datasource)",1).'</span></td></tr>';
			}
		
	$BO.='</TABLE>';
	
	$FULL_OUTPUT.=MakeBox("Current lists", $BO);
	

	
}


function DeleteList($ListID){
	GLOBAL $FULL_OUTPUT, $all;
	if($all){
		$li=list_info($ListID);
		if($li[ListSourceType]=="mysqldatabase"){
			list($server,$port,$user,$pass,$database,$table,$allowedits)=explode("/#",$li[ListSource]);
			$MySQLLink=@mysql_connect("$server:$port",trim($user),trim($pass));
			if(mysql_select_db($database,$MySQLLink)){
				mysql_query("DROP TABLE $table");
			}
		}elseif($li[ListSourceType]=="textfile"){
			list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);
				@unlink($filename);
		}
	}
	
	mysql_query("DELETE FROM lists WHERE ListID='$ListID'");
	$FULL_OUTPUT.=MakeBox("List deleted!..", 'The list was deleted');
	ListSetupMain();
}




if($action){
	switch($action){
		
		case "createnew":
			CreateNew();
		break;
	
		case "deletelist":
			DeleteList($ListID);
		break;
		
		case "editlist":
			EditList($ListID);
		break;
	
	}

}else{
	ListSetupMain();
}




FinishOutput();

?>
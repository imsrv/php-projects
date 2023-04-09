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
function edit_unique($ListID,$email,$new_unique,$member_data){

	$list_info=list_info($ListID);



if($list_info[ListSourceType]=="textfile"){
	list($filename,$field_delim,$record_delim,$headers,$allow_edits)=explode("/#",$list_info[ListSource]);

			
		if(@$f=fopen($filename,"r+")){
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		}

			//split up the file into records!
		$record_delim=str_replace('\n', "\n", $record_delim);
		$records=explode($record_delim,$data);
		
		
		if($headers==1){
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($field_delim, $the_headers);
		}else{
			$fields=explode(",", $headers);
		}
		
		$the_line="";
		$gt=0;
		$et=0;
		foreach($fields as $field){
							if($field==$list_info[UniqueField]){
								$unique_num=$gt;
							}
							$gt++;
							
							if($field==$list_info[EmailField]){
								$efield=$et;
							}
							$et++;

		}

		
		foreach($records as $line){
			if($line){
			$newline="";
			$fi=explode($field_delim,$line);
			if($fi[$efield]==$email){
				$fi[$unique_num]=$new_unique;
			}
				foreach($fi as $f){
					$newline.=$f.$field_delim;
				}
						$fr=strlen($newline);
						$newline=substr($newline,0,$fr-1);
			$alldat.=$newline.$record_delim;
			}
		}	
			
			if($the_headers){
				$alldat=$the_headers.$record_delim.$alldat;
			}
			
			$f=fopen($filename,"w+");
			fputs($f,$alldat);
			
}elseif($list_info[ListSourceType]=="mysqldatabase"){
	

}

}




/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
////////////////////// ENDS IMPORTANT \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
///////////////////////// FUNCTIONS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\




include "../config.inc.php";

if($action){

			if(CanPerformAction("$action|audit|$ListID")!=1){
				$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
				FinishOutput();
			}
	//now go to the relevant section of the script to execute the desired objectives!
	switch($action){
		case "report":
		AuditReport();
		break;
		
		case "fix";
		AuditFix();
		break;
			
	}
}else{
	AuditMain();
}

/////////////////////////////////////////////////////////////

function AuditFix(){
	GLOBAL $FULL_OUTPUT, $ListID, $change;
	
	if($change){
		foreach($change as $email=>$new_unique){
			//echo "$email $new_unique";
			edit_unique($ListID,$email,$new_unique,$member_data);
		}	
	}
	
	$Errors=audit_list($ListID);
	$list_info=list_info($ListID);
	
	if($Errors[duplications]){
		list($Val,$Repeated)=each($Errors[duplications]);
			$BoxOut.="The value $Val is repeated ".($Repeated+1)." times in this list. You need to set new values for $Repeated of those.<P>";
				$members=filter_members(list_info($ListID),"x-unique == $Val",parse_member_list(list_info($ListID),get_list_members($ListID)));
			foreach($members as $member){
				$FORM_ITEMS["Where email address is ".$member["x-email"]]="textfield|change[".$member["x-email"]."]:300:30:".$member["x-unique"];
			}
			
			$FORM_ITEMS[-1]="submit|Continue";
		$FORM=new AdminForm;
		$FORM->title="AuditFixField";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="audit.php?action=fix&ListID=$ListID";
		$FORM->MakeForm();
		$BoxOut.=$FORM->output;
			$FULL_OUTPUT.=MakeBox("Fixing list",$BoxOut);
	
			
	}else{
		$FULL_OUTPUT.=MakeBox("Unique key errors fixed!", 'The unique key problems of this list are fixed!<P>'.MakeLink("audit.php", "Return to audit main"));
	}
	
	
	

	
}

function AuditReport(){
	GLOBAL $FULL_OUTPUT, $ListID;

	$Errors=audit_list($ListID);
	$list_info=list_info($ListID);
	
	//data source errors!
	if($Errors[datasource]=="Unavailable"){
		$BoxOut.="<P><font color=\"red\"><B>PROBLEM: </B>You have data source errors. You need to use List Setup to configure the list correctly!</font>";
	}else{
		$BoxOut.="<P>Your datasource has no detectable problems.";	
	}
	
	//unique key duplications!
	if($Errors[nounique]){
		$BoxOut.="<P><font color=\"red\"><B>PROBLEM: </B>The list has no unique field, please use List Setup to reconfigure the list and edit list data if neccesary to establish a unique field.</font>";	
	}else{
	$BoxOut.="<P>This list has a valid unique key field!";	
	}
	
	if($Errors[duplications]){
		$BoxOut.="<P><font color=\"red\"><B>PROBLEM: </B>The unique key in this list has duplications. To fix this you will need to redefine the values of some of the unique fields. </font>";	
			if(CanPerformAction("fix|audit|".$ListID)==1){
				$BoxOut.=MakeLink("audit.php?action=fix&ListID=$ListID", "Fix unique key duplications now");
			}
	}else{
		$BoxOut.="<P>The unique key in this field is a true unique field.</font>";	
	}
	
	$FULL_OUTPUT.=MakeBox("Audit report on".$list_info[ListName],$BoxOut.'<P>'.MakeLink("audit.php", "Back to Audit main"));
	
}

/////////////////////////////////////////////////////////////

function AuditMain(){
	GLOBAL $FULL_OUTPUT;
	
	//display form to select a list to get a report on!
	$lists=mysql_query("SELECT * FROM lists");
	while($l=mysql_fetch_array($lists)){
			if(CanPerformAction("report|audit|".$l[ListID])==1){
				$alllists.=$l[ListID]."->".$l[ListName].";";
			}
	}
	
						
  				$FORM_ITEMS["List"]="select|ListID:1:$alllists:".$ListID;
				$FORM_ITEMS[-1]="submit|Generate report now";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="AuditReport";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="audit.php?action=report";
				$FORM->MakeForm();
				
				$FULL_OUTPUT.=MakeBox("Select a list to get an audit report on!", $FORM->output);
	
}

/////////////////////////////////////////////////////////////

FinishOutput();

?>
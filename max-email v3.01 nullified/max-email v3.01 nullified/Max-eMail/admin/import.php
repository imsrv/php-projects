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

if($action=="use"){

	//now go to the relevant section of the script to execute the desired objectives!
	switch ($stage){
		case "datasource":
		ImportSource();
		break;
	
		case "textfile":
		UseTextfile();
		break;
		
		case "fromlist":
		OtherList();
		break;
		
		case "specialfields":
		SpecialFields();
		break;
		
		case "import":
		Import();
		break;
	
	
	}
	
	
}else{
	ImportMain();
}

/////////////////////////////////////////////////////////////

function ImportInfo($ImportID){
	$ImportInfo=mysql_fetch_array(mysql_query("SELECT * FROM imports WHERE ImportID='$ImportID'"));
	return $ImportInfo;
}

/////////////////////////////////////////////////////////////

function RandomUnique($Method,$ListID){
	$letters=range('a','z');
	$numbers=range(0,9);
	
	if($Method=="randomalpha"){
		$chars=array_merge($letters,$numbers);
	}else{
		$chars=$numbers;
	}
	
	
	while(!UniqueInList($Unique,$ListID) || !isset($Unique)){
		for($i=0;$i<10;$i++){
			srand ((double) microtime() * 1000000);
			$randval = rand(0,sizeof($chars));
      		$Unique.=$chars[$randval];
		}
	}
	return $Unique;
	
}

/////////////////////////////////////////////////////////////

function Import(){
GLOBAL $FULL_OUTPUT,$ImportID,$LINKAGES,$fielddelim,$recorddelim,$replicateemails,$UniqueValues;
		//now grab all the data from the import data file and put it into an array!
		$f=fopen("../temp/$ImportID-headed.txt","r");
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$recdel2=$recorddelim;
		$recorddelim=str_replace('NEWLINE', "\n", $recorddelim);
		$records=explode($recorddelim,$data);
		
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($fielddelim, $the_headers);

		foreach($records as $record){
			if($record){
				$i=0;
				$rn++;
				$datafields=explode($fielddelim,$record);
				foreach($fields as $field){
					$members[$rn][$field]=$datafields[$i];
					$i++;
				}
			}
		}
		//end grabbing data!
		
		$ImportInfo=ImportInfo($ImportID);
		$list_info=list_info($ImportInfo[ListID]);
			$UsedUns[]="";
			foreach($members as $member){
					$emailok=0;
					$UniqueOk=0;
					$uniqueok=0;
					
					//check if there is actually a member here!
					foreach($LINKAGES as $ImpField=>$ListField){
							if($member[$ImpField]){
								$YESMEMBER=1;
							}
					}
					if($YESMEMBER!=1){
						break;
					}
					reset($LINKAGES);					
			
					//check if the email is ok!
					foreach($LINKAGES as $ImpField=>$ListField){
						if($ListField==$list_info[EmailField]){
							if(IsUniqueEmail($member[$ImpField],$list_info[ListID]) || $replicateemails!="dontimport"){
								$emailok=1;
							}
						}
						
						if($replicateemails!="dontimport"){
							$emailok=1;
						}
					}
					reset($LINKAGES);
					
					//get the unique id for this insert!
					//do we need to bother or is this an auto-increment field?
					if($UniqueValues=="nothing"){
						//yes its auto-inc
						$UnKey="";
					}else{
					//its not auto-inc
						//do we have a unique field?
						foreach($LINKAGES as $ImpField=>$ListField){
							if($ListField==$list_info[UniqueField]){
								if($member[$ImpField]){
									//yes we do have a unique
									$theunique=$member[$ImpField];
									$unique=1;
										//is the unique unique?
										if(UniqueInList($member[$ImpField],$list_info[ListID]) && !in_array($member[$ImpField],$UsedUns)){
											$uniqueok=1;
										} 
								}
							}
						}
						
						if($unique!=1){
							//we dont have a unique! need to gen one
								if($UniqueValues!="dontimport"){
									$UniqueOk=1;
									$UnKey=RandomUnique($UniqueValues,$list_info[ListID]);								
								}

						}else{
							if($uniqueok!=1){
								//unique isnt ok need to gen one
								if($UniqueValues!="dontimport"){
									$UniqueOk=1;
									$UnKey=RandomUnique($UniqueValues,$list_info[ListID]);								
								}
							}else{
								//unique is ok!
								$UniqueOk=1;
								$UnKey=$theunique;
							}
						}
						
					}
									
					reset($LINKAGES);
					
					if($emailok==1 && $UniqueOk==1){
							$UsedUns[]=$UnKey;
						foreach($LINKAGES as $ImpField=>$ListField){
							if($ListField==$list_info[UniqueField]){
								$MEMBERDATA[$ListField]=$UnKey;
							}elseif($ListField==$list_info[ReceivingField] && !isset($ImField)){
							
							}elseif($ListField!="DONTIMPORT"){
								$MEMBERDATA[$ListField]=$member[$ImpField];
							}
						}			
					
					add_member($list_info[ListID],$MEMBERDATA,"IMPORT-$ImportID");
					$totalimported++;
					}		
			}
			

			
			//now print an import report!
			$ImpRep='Your import was completed!<P>';
			$ImpRep.="$totalimported records where imported to the list '".$list_info[ListName]."'";
			
			mysql_query("UPDATE imports SET Completed='1', NumberOfRecords='$totalimported' WHERE ImportID='$ImportID'");
			
			$FULL_OUTPUT.=MakeBox("Import Completed..",$ImpRep);


}

/////////////////////////////////////////////////////////////

function SpecialFields(){
GLOBAL $FULL_OUTPUT,$ImportID,$ImportFields,$NewFields,$recorddelim,$fielddelim;
		$ImportInfo=ImportInfo($ImportID);
		$list_info=list_info($ImportInfo[ListID]);
		
		$FULL_OUTPUT.=MakeBox("Import...", "Current Import ID: $ImportID<P>We just need to setup special fields for the list!");
		
		//find which field they want to use as the unique field!
		while (list ($ImpField, $ListField) = each ($ImportFields)) {
   			 if($ListField==$list_info[UniqueField]){
			 	$UniqueField=$ImpField;
			 }
		}
		
		reset($ImportFields);
		//find which field they want to use as the receiving field!
		while (list ($ImpField, $ListField) = each ($ImportFields)) {
   			 if($ListField==$list_info[ReceivingField]){
			 	$ReceivingField=$ImpField;
			 }
		}
		
		reset($ImportFields);
		//find which field they want to use as the format field!
		while (list ($ImpField, $ListField) = each ($ImportFields)) {
   			 if($ListField==$list_info[FormatField]){
			 	$FormatField=$ImpField;
			 }
		}
		
		//now grab all the data from the import data file and put it into an array!
		$f=fopen("../temp/$ImportID-headed.txt","r");
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$recdel2=$recorddelim;
		$recorddelim=str_replace('NEWLINE', "\n", $recorddelim);
		$records=explode($recorddelim,$data);
		
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($fielddelim, $the_headers);

		foreach($records as $record){
			if($record){
			$i=0;
			$rn++;
			$datafields=explode($fielddelim,$record);
			foreach($fields as $field){
				$members[$rn][$field]=$datafields[$i];
				$i++;
			}
			}
		}
		//end grabbing data!


		
		$BoxOut='The field linkings and import data will now be examined and any problems reported so they can be corrected!<P>';
		
		//unique field evaluation!
		$BoxOut.='<B>Unique Field:</B><BR>';
		if($UniqueField){
			$BoxOut.="You have selected to use the $UniqueField to import into this lists unique field.";
			//check that all values are different and not already in use!
					$UniqueVals[]="";
					foreach($members as $member){						
						if($member[$UniqueField] && (in_array($member[$UniqueField],$UniqueVals) || UniqueInList($member[$UniqueField],$ImportInfo[ListID])==0)){
							$RepeatedUniques=1;
						}
						$UniqueVals[]=$member[$UniqueField];
					}
					if($RepeatedUniques){
						$BoxOut.="<font color=\"red\"><BR>We have detected repeated unique values.</font><BR>Either edit the data and start the import again, or select Use random values in Unique Keys dropdown below.<P>";
					}else{
						$BoxOut.="<BR>Your unique values are fine!";
					}
		
		}else{
			$BoxOut.="You have selected not to import into the Unique Key of this list. <BR>You will need to make a selection in the unique keys dropdown below.";		
			$NoUnique=1;
		}
		reset($members);
		
		//now check that all the format values fit the format!
		$BoxOut.='<P><B>Format Field:</B><BR>';
		if($FormatField){
			$BoxOut.="You have decided to import into this lists format field.<BR>";
			list($html,$text)=explode("/",$list_info[FormatValues]);
			foreach($members as $member){
				$formatvalue=$member[$FormatField];
				if($formatvalue!=$html && $formatvalue!=$text && $formatvalue){
					$BadFormat=1;
				}
			}
			
			if($BadFormat){
				$BoxOut.="<font color=\"red\">Some of your format values do not fit the lists current format.</font><BR>";
				$BoxOut.='You need to run the format fitter, not doing so could corrupt your list!<BR>';
				$BoxOut.=MakeLink(MakePopup("fiximportdata.php?FormatField=$FormatField&recorddelim=$recdel2&fielddelim=$fielddelim&type=format&ImportID=$ImportID",400,400,"FormatFitter"),"<B><I>Run the format fitter now!</B></I>");
			}else{
				$BoxOut.="Your format values are all ok!";		
			}
		}else{
			$BoxOut.="You arent importing into the format field, default value will be used!";
		}
		
		//now check that all the format values fit the format!
		$BoxOut.='<P><B>Receiving Field:</B><BR>';
		$BadFormat=0;
		if($ReceivingField){
			$BoxOut.="You have decided to import into this lists receiving field.<BR>";
			list($yes,$no)=explode("/",$list_info[FormatValues]);
			foreach($members as $member){
				$formatvalue=$member[$ReceivingField];
				if($formatvalue!=$yes && $formatvalue!=$no && $formatvalue){
					$BadFormat=1;
				}
			}
			
			if($BadFormat){
				$BoxOut.="<font color=\"red\">Some of your receiving values do not fit the lists current data format.</font><BR>";
				$BoxOut.='You need to run the format fitter, not doing so could corrupt your list!<BR>';
				$BoxOut.=MakeLink(MakePopup("fiximportdata.php?FormatField=$ReceivingField&recorddelim=$recdel2&fielddelim=$fielddelim&type=receiving&ImportID=$ImportID",400,400,"FormatFitterReceiving"),"<B><I>Run the format fitter now!</B></I>");
			}else{
				$BoxOut.="Your receiving values are all ok!";
			}
		}else{
			$BoxOut.="You arent importing into the receiving field, default value will be used!";
		}
		
		//general field linkages!
		$BoxOut.='<P><B>Field Linkages:</B><BR>';	
		$BoxOut.='This is where each of your import fields will be imported into this lists data!<P>';
		
		$bb=-6;
		foreach($ImportFields as $ImpField=>$ListField){
			$BoxOut.=$ImpField;
			if($ListField=="DONTIMPORT"){
				$BoxOut.=" -> Not Imported";
				$listfield="DONTIMPORT";
			}elseif($ListField=="EXTRAFIELD"){
				$BoxOut.=" -> ".$NewFields[$ImpField]." [EXTRA FIELD]";
				$listfield=$NewFields[$ImpField];
			}else{
				$BoxOut.=" -> $ListField [LIST FIELD]";
				$listfield=$ListField;
			}
			$bb--;
			$FORM_ITEMS[$bb]="hidden|LINKAGES[$ImpField]:$listfield";
			$BoxOut.="<BR>";
			
			
		}
		
		
		$FULL_OUTPUT.=MakeBox("Linkages and Field examination report!",$BoxOut);
		
		////////////////////
		// END THE REPORT //
		////////////////////
		
		//now print the final import options form!
			$FORM_ITEMS[-1]="hidden|ImportID:$ImportID";
			$FORM_ITEMS[-4]="hidden|recorddelim:$recdel2";
			$FORM_ITEMS[-5]="hidden|fielddelim:$fielddelim";
			$FORM_ITEMS[-2]="hidden|stage:import";

			if($RepeatedUniques){
				$FORM_ITEMS["Unique Values"]="select|UniqueValues:1:randomnumbers->Use random values if the values replicate or are blank (numbers only);randomalpha->Use random values if the values replicate or are blank (numbers and letters);dontimport->Dont import record if the unique already exists";			
			}elseif($NoUnique){
				$FORM_ITEMS["Unique Values"]="select|UniqueValues:1:randomnumbers->Use random values if the values replicate or are blank (numbers only);randomalpha->Use random values if the values replicate or are blank (numbers and letters);nothing->The field is an auto-increment";
			}
			
			$FORM_ITEMS["Replicate Emails"]="checkbox|replicateemails:dontimport:Dont import if the email is in the list";
			$FORM_ITEMS["&nbsp;"]="submit|Do the import (THIS IS PERMENANT!)";
			
		//make the form
		$FORM=new AdminForm;
		$FORM->title="FinalImportOptions";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="import.php?action=use";
		$FORM->MakeForm();
		$FULL_OUTPUT.=MakeBox("Final import options..",$FORM->output);
		

		
			
}

/////////////////////////////////////////////////////////////

function LinkFieldsBox($headers,$ListID,$recorddelim,$fielddelim){
GLOBAL $ImportID;
		$list_fields=list_fields($ListID);
			foreach($list_fields as $lfield){
				$allfields.=$lfield."->".$lfield.";";
			}
			
			$allfields="DONTIMPORT->-- Dont Import;EXTRAFIELD-> -- Extra Field (Below);".$allfields;
			
			$gg=-5;
			foreach($headers as $header){
				$gg--;
				$FORM_ITEMS[$header." ->"]="select|ImportFields[$header]:1:$allfields";
				$FORM_ITEMS[$gg]="textfield|NewFields[$header]:20:20";
			}
			
			$FORM_ITEMS[-1]="hidden|ImportID:$ImportID";
			$FORM_ITEMS[-4]="hidden|recorddelim:$recorddelim";
			$FORM_ITEMS[-5]="hidden|fielddelim:$fielddelim";
			$FORM_ITEMS[-2]="hidden|stage:specialfields";
			$FORM_ITEMS[-3]="submit|Continue>>";	
			
		//make the form
		$FORM=new AdminForm;
		$FORM->title="LinkFields";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="import.php?action=use";
		$FORM->MakeForm();
		return $FORM->output;
}

/////////////////////////////////////////////////////////////

function OtherList(){
GLOBAL $FULL_OUTPUT,$FilterString,$FromListID,$ImportID;
		if($FilterString){
		$tempmembers=filter_members(list_info($FromListID), $FilterString, parse_member_list(list_info($FromListID), get_list_members($FromListID)));
		}else{
			$tempmembers=parse_member_list(list_info($FromListID), get_list_members($FromListID));
		}	
						$list_fields=list_fields($FromListID);
					
					$all_data="";
					reset($list_fields);
					foreach($list_fields as $field){
								$all_data.=$field.",";
								$headers[]=$field;
					}		
					$headers[]="FORMAT";
					$headers[]="RECEIVING";
					$headers[]="LISTNAME";
					$headers[]="UNIQUEKEY";
				
					$all_data.="FORMAT,RECEIVING,LISTNAME,UNIQUEKEY";
					
		
			if($tempmembers){
				foreach($tempmembers as $member){
					if($member["x-unique"]){
					$line="";
					reset($list_fields);
					foreach($list_fields as $field){
								$line.=$member[$field].",";
					}
					$line.=$member["x-format"].",".$member["x-receiving"].",".$member["x-listname"].",".$member["x-unique"];
							$all_data.="\n$line";
					}
				}
			}
			
			$f=fopen("../temp/$ImportID-headed.txt","w");
			fputs($f,$all_data);
			fclose($f);
						
					$ImportInfo=ImportInfo($ImportID);
					$FULL_OUTPUT.=MakeBox("Select field linking!","You need to link each import field (left) to a field in the list (right)".LinkFieldsBox($headers,$ImportInfo[ListID],"NEWLINE",","));
}

/////////////////////////////////////////////////////////////

function UseTextfile(){
GLOBAL $FULL_OUTPUT,$HTTP_POST_FILES,$ImportID, $recorddelim,$fielddelim,$headers;
	
	$ImportInfo=ImportInfo($ImportID);
	
$FULL_OUTPUT.=MakeBox("Import...", "Current Import ID: $ImportID");
		

 $userfile=$HTTP_POST_FILES['TextFileName']['tmp_name'];
 $filename=$HTTP_POST_FILES['TextFileName']['name'];
 
	if(is_file($userfile)){
		copy($userfile,"../temp/".$ImportInfo[ImportID]);
	}
	
	$file="../temp/".$ImportInfo[ImportID];
	
	//now check if the file was copied ok!
	if(is_file($file) && is_file($userfile)){
		//record the data on the file.
		mysql_query("UPDATE imports SET DataSource='textfile',DataSourceInfo='' WHERE ImportID='$ImportID'");
		
		//now we need to open the file and read it contents!
			$f=fopen($file,"r");
			while(!feof($f)){
				$data.=fread($f,1024);
			}
			fclose($f);
			
			//split up the file into records!
				$recdel2=$recorddelim;
				$recorddelim=str_replace('NEWLINE', "\n", $recorddelim);
				$records=explode($recorddelim,$data);
			
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($fielddelim, $the_headers);		
		
		if($headers!="yes"){
			//they are not the actual headers!
			for($i=1;$i<=sizeof($fields);$i++){
				$headers[$i]="Column$i";
				$ADDTOFILE.="Column$i".$fielddelim;
			}
				$fr=strlen($ADDTOFILE);
				$ADDTOFILE=substr($ADDTOFILE,0,($fr-strlen($fielddelim)));
			$ADDTOFILE=$ADDTOFILE.$recorddelim;
		}else{
			$headers=$fields;
		}
	

		
		$data=$ADDTOFILE.$data;
		$f=fopen("../temp/$ImportID-headed.txt","w");
		fputs($f,$data);

		//now prompt the user to select which field of the imported data will go where in the lists fields!
		$FULL_OUTPUT.=MakeBox("Select field linking!","You need to link each import field (left) to a field in the list (right)".LinkFieldsBox($headers,$ImportInfo[ListID],$recdel2,$fielddelim));
			
		
	}else{
		$FULL_OUTPUT.=MakeBox("Error Occured", "File Upload was not successful!");
		ImportSource();	
	}

}

/////////////////////////////////////////////////////////////

function ImportSource(){
GLOBAL $FULL_OUTPUT,$ListID,$ImportID;
		
		//create the new import!
		if(!$ImportID){
		srand ((double) microtime() * 1000000);
		$ImportID=rand(1000,9999);
		mysql_query("INSERT INTO imports SET ImportID='$ImportID', ImportDate='".time()."', ListID='$ListID'");
		}
		
		$FULL_OUTPUT.=MakeBox("Select a data source for your import!",'You need to select a data source and options from one of the below.<P>The id for this import is: '.$ImportID.'. Write this down as you may need this number later.');

		$FORM_ITEMS["File"]="file|TextFileName";		
		$FORM_ITEMS["Contains Headers?"]="checkbox|headers:yes:Yes!:checked";
		$FORM_ITEMS["Field Delimeter"]="textfield|fielddelim:10:10:,";
		$FORM_ITEMS["Record Delim"]="textfield|recorddelim:10:10:NEWLINE";
		$FORM_ITEMS[-2]="hidden|stage:textfile";
		$FORM_ITEMS[-3]="hidden|ImportID:$ImportID";
		$FORM_ITEMS[-1]="submit|Continue with TextFile import>>";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="TextFileImport";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="import.php?action=use";
		$FORM->EXTRA='ENCTYPE="multipart/form-data"';
		$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("TextFile Import",$FORM->output);
		
		
		$FORM_ITEMS2["List"]="select|FromListID:1:".AllListsInList("ListID->ListName;","view");
		$FORM_ITEMS2["Filter String"]="textfield|FilterString:100:60:";
		$FORM_ITEMS2[-2]="hidden|stage:fromlist";
		$FORM_ITEMS2[-3]="hidden|ImportID:$ImportID";
		$FORM_ITEMS2[-1]="submit|Continue with Other List import>>";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="ListImport";
		$FORM->items=$FORM_ITEMS2;
		$FORM->action="import.php?action=use";
		$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("Import from another list",$FORM->output);


}

/////////////////////////////////////////////////////////////

function ImportMain(){
GLOBAL $FULL_OUTPUT;
	//in this stage the admin must select the list to import into!
		$lists=mysql_query("SELECT * FROM lists");

		while($list=mysql_fetch_array($lists)){
			if(CanPerformAction("use|import|".$list[ListID])){
					$alllists.=";".$list[ListID]."->".$list[ListName];			
			}
		
		}
		$FORM_ITEMS["Select List"]="select|ListID:1:$alllists";
		$FORM_ITEMS[-2]="hidden|stage:datasource";
		$FORM_ITEMS[-1]="submit|Continue>>";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="My Form";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="import.php?action=use";
		$FORM->MakeForm();
		
		$FULL_OUTPUT.=MakeBox("Select a list to import into",$FORM->output);
	

}


		


FinishOutput();

?>



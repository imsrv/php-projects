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
		case "exportoptions":
		ExportOptions();
		break;
		
		case "exportnow":
		ExportNow();
		break;
	
	
	}
	
	
}else{
	ExportMain();
}

///////////////////////////////////////////////////////////////////////

function ExportNow(){
	GLOBAL $FULL_OUTPUT, $ListID, $headers, $recordformat, $recorddelim,$FilterString;

		$recorddelim=str_replace('NEWLINE', "\n", $recorddelim);
	
		$list_fields=list_fields($ListID);
		$All_Fields["Email"]="x-email";
		$All_Fields["Receiving Status"]="x-receiving";
		$All_Fields["Format"]="x-format";
		$All_Fields["Unique Key"]="x-unique";
		$All_Fields["List"]="x-listname";
		$list_fields=array_merge($list_fields, $All_Fields);
	
		if($FilterString){
		$tempmembers=filter_members(list_info($ListID), $FilterString, parse_member_list(list_info($ListID), get_list_members($ListID)));
		}else{
			$tempmembers=parse_member_list(list_info($ListID), get_list_members($ListID));
		}	
			if($tempmembers){
				foreach($tempmembers as $member){
					$f++;
					$members[$f]=$member;
				}
			}
			
		foreach($members as $member){
			$line=$recordformat;
			foreach($list_fields as $field){
				$line=str_replace("<$field>",$member[$field],$line);
			}
			$line.=$recorddelim;
			$all_data.=$line;
		}	
		
		$all_data=$headers.$recorddelim.$all_data;
		
		srand ((double) microtime() * 1000000);
		$ExportID=rand(1000,9999);
		
		$f=fopen("../temp/$ExportID.txt", "w");
		fputs($f, $all_data);
		
		$Box='Your export is complete. Click the link below to download the textfile containing your exported data!<P><BR>
		<center><B><a href="../temp/'.$ExportID.'.txt" class="admintext">DOWNLOAD YOUR EXPORT DATA</a></center></B>';
		
		$FULL_OUTPUT.=MakeBox("Export completed!", $Box);
			
}

////////////////////////////////////////////////////////////////////

function ExportOptions(){
	GLOBAL $FULL_OUTPUT, $ListID;
	
		$list_info=list_info($ListID);	
		
		$headers="Export of list ".$list_info[ListName]." from Max-eMail V3..\n";
		
		$list_fields=list_fields($ListID);
		$All_Fields["Email"]="x-email";
		$All_Fields["Receiving Status"]="x-receiving";
		$All_Fields["Format"]="x-format";
		$All_Fields["Unique Key"]="x-unique";
		$All_Fields["List"]="x-listname";
		$list_fields=array_merge($list_fields, $All_Fields);
		
		foreach($list_fields as $field){
			$value.="<$field>,";
			$headers.="$field,";
		}
		$fr=strlen($value);
		$value=substr($value,0,$fr-1);
		$fr=strlen($headers);
		$headers=substr($headers,0,$fr-1);		
		
		
		$FORM_ITEMS["Header"]="textarea|headers:60:4:$headers:wrap=off";
		$FORM_ITEMS["Record Format"]="textarea|recordformat:60:4:$value:wrap=off";
		$FORM_ITEMS[-3]="spacer|Each of the &lt;FIELDNAME&gt; is a field!<BR><BR>";		
		$FORM_ITEMS["Record Delimeter"]="textfield|recorddelim:40:30:NEWLINE";
		$FORM_ITEMS["Filter String"]="textfield|FilterString:800:80:";
	    $FORM_ITEMS[-5]="spacer|".MakeLink(MakePopup('filterstring_popup.php',600,400,"FilterBy"),"Filter String Wizard");	

			
		$FORM_ITEMS[-2]="hidden|stage:exportnow";
		$FORM_ITEMS[-4]="hidden|ListID:$ListID";
		$FORM_ITEMS[-1]="submit|Perform Export (this can take some time on large lists)";
		
		
		//make the form
		$FORM=new AdminForm;
		$FORM->title="MemberSearch";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="export.php?action=use";
		$FORM->MakeForm();
	
	
	$FULL_OUTPUT.=MakeBox("Export options..", $FORM->output);
	
	


}



function ExportMain(){
	GLOBAL $FULL_OUTPUT;
			$lists=mysql_query("SELECT * FROM lists");

		while($list=mysql_fetch_array($lists)){
			if(CanPerformAction("use|export|".$list[ListID])){
					$alllists.=";".$list[ListID]."->".$list[ListName];			
			}
		
		}
		$FORM_ITEMS["Select List"]="select|ListID:1:$alllists";
		$FORM_ITEMS[-2]="hidden|stage:exportoptions";
		$FORM_ITEMS[-1]="submit|Continue>>";
		//make the form
		$FORM=new AdminForm;
		$FORM->title="My Form";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="export.php?action=use";
		$FORM->MakeForm();
		
	
	
	
	$FULL_OUTPUT.=MakeBox("Select a list to export!", $FORM->output);
	
	

}


		


FinishOutput();

?>



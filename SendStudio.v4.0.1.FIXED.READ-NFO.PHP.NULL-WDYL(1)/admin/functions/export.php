<?

	include "../includes$DIRSLASH"."members.inc.php";

	$Action = @$_REQUEST["Action"];
	$ListID = @$_REQUEST["ListID"];
	$ExportID = @$_REQUEST["ExportID"];
	$Status = @$_REQUEST["Status"];
	$Confirmed = @$_REQUEST["Confirmed"];
	$Format = @$_REQUEST["Format"];
	$Fields = @$_REQUEST["Fields"];
	$Email = @$_REQUEST["Email"];
	$HaveClickedLink = @$_REQUEST["HaveClickedLink"];
	$Headers = @$_REQUEST["Headers"];
	$ExportField = @$_REQUEST["ExportField"];

	$alllists = "";
	$alllinks = "";
	$OUTPUT = "";
	$fields = array();
	$LINE = "";
	$ALLDATA = "";
	$MemberCount = 0;

	if($Action=="CreateFile"){

		if($Headers){
				$LINE="";
				foreach($ExportField as $Field){
				if($Field){
					if($Field=="EMAIL"){
						$LINE.="Email".$FieldSep;
					}elseif($Field=="STATUS"){
						$LINE.="Status".$FieldSep;	
					}elseif($Field=="CONFIRM"){
						$LINE.="Confirmation".$FieldSep;
					}elseif($Field=="FORMAT"){
						$LINE.="Format".$FieldSep;
					}else{
						$mv=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='$Field'"));
						$LINE.=$mv["FieldName"].$FieldSep;
					}	
				}
			}
			$LINE=substr($LINE,0,strlen($LINE)-strlen($FieldSep));
			$ALLDATA.=$LINE.str_replace("NEWLINE","\n",$RecordSep);	
		}

		$members=mysql_query("SELECT * FROM " . $TABLEPREFIX . "export_users WHERE ExportID='$ExportID'");
		while($m=mysql_fetch_array($members)){
			$MemberCount++;
			$member=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='".$m["MemberID"]."'"));
			reset($ExportField);
			$LINE="";
			foreach($ExportField as $Field){
				if($Field){
					if($Field=="EMAIL"){
						$LINE.=$member["Email"].$FieldSep;
					}elseif($Field=="STATUS"){
						if($member["Status"]==1){
							$LINE.="Active".$FieldSep;
						}else{
							$LINE.="Inactive".$FieldSep;
						}
					}elseif($Field=="CONFIRM"){
						if($member["Confirmed"]==1){
							$LINE.="Confirmed".$FieldSep;
						}else{
							$LINE.="Uncomfirmed".$FieldSep;
						}
					}elseif($Field=="FORMAT"){
						if($member["Format"]==1){
							$LINE.="HTML".$FieldSep;
						}else{
							$LINE.="TEXT".$FieldSep;
						}
					}else{
						$mv=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='".$m["MemberID"]."' && FieldID='$Field'"));
						$f=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE FieldID='$Field' ORDER BY FieldName ASC"));
						if($f["FieldType"]=="checkbox"){
							if($mv["Value"]=="CHECKED"){
								$mv["Value"]="Yes";
							}else{
								$mv["Value"]="No";
							}
						}
						if($f["FieldType"]=="dropdown"){
							$opts=explode(";",$f["AllValues"]);
							foreach($opts as $opt){
								list($name,$val)=explode("->",$opt);
								if($name==$mv["Value"]){
									$mv["Value"]=$val;
								}
							}
						}
						$LINE.=str_replace("\r","<BR>",str_replace("\n","",$mv["Value"])).$FieldSep;
					}	
				}
			}
			//chop out the last delimeter from the line!
			$LINE=substr($LINE,0,strlen($LINE)-strlen($FieldSep));
			$ALLDATA.=$LINE.str_replace("NEWLINE","\n",$RecordSep);	
		}

		//now create the file!
		$exfile =  "../temp/export-" . $ExportID . ".txt";
		@clearstatcache();

		if(!is_writable("../temp"))
		{
			$Error = "The '" . $ROOTDIR . "temp' folder does not have write permissions. Please CHMOD this folder to 777.";
			$OUTPUT .= MakeErrorBox("An Error Occured", $Error);
		}
		else
		{		
			$f = @fopen($exfile,"w");
			@fputs($f,$ALLDATA);

			$OUTPUT .= MakeSuccessBox("Export Subscribers (Step 4 of 4)", "<br>The export has been completed successfully. $MemberCount members were exported. Click on the button below to download the export file.<br>&nbsp;", $ROOTURL . "temp/export-" . $ExportID . ".txt", "", "", true);
		}
	}

	if($Action=="LogMembers"){
		$export=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "exports WHERE ExportID='$ExportID'"));
		$Members=ReturnMembers($export["ListID"],$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,$Format);
		$numMembers = sizeof($Members);

		if($numMembers > 0)
		{	
			if($Members){foreach($Members as $MemberID){
				mysql_query("DELETE FROM " . $TABLEPREFIX . "export_users WHERE ExportID='$ExportID' && MemberID='$MemberID'");
				mysql_query("INSERT INTO " . $TABLEPREFIX . "export_users SET ExportID='$ExportID', MemberID='$MemberID'");
			}}

			//select fields for export!
			$nf=mysql_num_rows($fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='".$CURRENTADMIN["AdminID"]."' ORDER BY FieldName ASC"));
			$nf+=4;
			
			$allfields='->----- NONE;EMAIL->Users Email;STATUS->Users Status;CONFIRM->Users Confirmation Status;FORMAT->Users Chosen Format;';
				$x=4;
				$af["1"]="EMAIL";
				$af["2"]="STATUS";
				$af["3"]="CONFIRM";	
				$af["4"]="FORMAT";
			while($f=mysql_fetch_array($fields)){
				$x++;
				$allfields.=$f["FieldID"].'->'.$f["FieldName"].';';
				$af[$x]=$f["FieldID"];
			}
			
			$req = "<span class=req>*</span> ";

			for($i=1;$i<=$nf;$i++){
				$FORM_ITEMS[$req . "Field #$i Content"]="select|ExportField[$i]:1:$allfields:".($af[$i]);
				$HELP_ITEMS["ExportField[$i]"]["Title"] = "Field #$i Content";
				$HELP_ITEMS["ExportField[$i]"]["Content"] = "Which subscriber field should be exported into field #$i?";
			}
				
				$FORM_ITEMS[$req . "Include Headers?"]="select|Headers:1:0->No;1->Yes:1";
				$HELP_ITEMS["Headers"]["Title"] = "Include Headers?";
				$HELP_ITEMS["Headers"]["Content"] = "Should this export include field headers? If so, the first line of the file will look something like this: email, status, format.";

				$FORM_ITEMS[$req . "Field Seperator"]="textfield|FieldSep:100:10:,";
				$HELP_ITEMS["FieldSep"]["Title"] = "Field Seperator";
				$HELP_ITEMS["FieldSep"]["Content"] = "Which character should be added to this export file to seperate the contents of each new field in a record?";

				$FORM_ITEMS[$req . "Record Seperator"]="textfield|RecordSep:100:10:NEWLINE";
				$HELP_ITEMS["RecordSep"]["Title"] = "Record Seperator";
				$HELP_ITEMS["RecordSep"]["Content"] = "Which character should be added to this export file to seperate one record from the next?";

				$FORM_ITEMS["-1"]="submit|Continue to Step 4:1-members";
				
				$FORM=new AdminForm;
				$FORM->title="SearchMembers";
				$FORM->items=$FORM_ITEMS;
				$FORM->action=MakeAdminLink("export?ExportID=$ExportID&Action=CreateFile");
				$FORM->MakeForm("Export Field Details");

				$FORM->output = "Complete the form below to choose which subscriber fields will be included in the export." . $FORM->output;
				
				$OUTPUT.=MakeBox("Export Subscribers (Step 3 of 4)",$FORM->output);
				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.RecordSep.value == "")
							{
								alert("Please enter a record seperator for this export.");
								f.RecordSep.focus();
								return false;
							}

							if(f.FieldSep.value == "")
							{
								alert("Please enter a field seperator for this export.");
								f.FieldSep.focus();
								return false;
							}
						}
					
					</script>
				';	
		}
		else
		{
			// No members were found!
			$OUTPUT .= MakeErrorBox("No Subscribers Found", "<br>No subscribers matched the search details that you specified.");
		}	
	}



	if($Action=="SelectMembers"){
			//create the export!
			mysql_query("INSERT INTO " . $TABLEPREFIX . "exports SET ListID='$ListID', DateStarted='$SYSTEMTIME'");
			$ExportID=mysql_insert_id();

			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";

			//search for members form!
			$FORM_ITEMS[$req . "Status"]="select|Status:1:ALL->View All;0->Inactive;1->Active:1";
			$HELP_ITEMS["Status"]["Title"] = "Status";
			$HELP_ITEMS["Status"]["Content"] = "Should active, inactive or all subscribers be exported?";

			$FORM_ITEMS[$req . "Confirmed"]="select|Confirmed:1:ALL->Either;0->Not Confirmed;1->Confirmed:1";
			$HELP_ITEMS["Confirmed"]["Title"] = "Confirmed";
			$HELP_ITEMS["Confirmed"]["Content"] = "Should confirmed, unconfirmed or all subscribers be exported?";

			$FORM_ITEMS[$req . "Format"]="select|Format:1:ALL->Either;0->Text;1->HTML";
			$HELP_ITEMS["Format"]["Title"] = "Format";
			$HELP_ITEMS["Format"]["Content"] = "Should subscribers flagged to receive text, HTML, or all email types be exported?";

			$FORM_ITEMS[$noreq . "Search Email"]="textfield|Email:100:44:";
			$HELP_ITEMS["Email"]["Title"] = "Search Emails";
			$HELP_ITEMS["Email"]["Content"] = "If you only want to export subscribers based on the content of their email address, then enter the complete or partial email address to filter on here.";

			$size = $min = $max = $Width = $Height = 0;

				//extra fields
				$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
				while($f=mysql_fetch_array($fields)){
					switch($f["FieldType"]){
						case "shorttext":
							@list($size,$min,$max)=explode(",",@$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44";
						break;
						
						case "longtext":
							list($Width,$Height)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:500:44";
						break;
						
						case "checkbox":
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:y->Yes;n->No;all->All:all";
						break;
					
						case "dropdown":
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:->All Values;".$f["AllValues"].":";
						break;
					}
				}

			$FORM_ITEMS["-1"]="submit|Continue to Step 3:1-members";
			
			$FORM=new AdminForm;
			$FORM->title="SearchMembers";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("export?ExportID=$ExportID&Action=LogMembers");
			$FORM->MakeForm("Subscriber Details");

			$FORM->output = "Complete the form below to filter subscribers that should be exported." . $FORM->output;
			
			$OUTPUT.=MakeBox("Export Subscribers (Step 2 of 4)", $FORM->output);

			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{				
						return true;
					}
				
				</script>
			';
	}

	if(!$ListID && !$ExportID){

		//select ListID form!
			$lists=mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
			while($l=mysql_fetch_array($lists))
			{
				if(AllowList($l["ListID"]))
				{
					$numSubs = (int)@mysql_result(@mysql_query("select count(MemberID) from " . $TABLEPREFIX . "members where ListID=" . $l["ListID"]), 0, 0);

					if($numSubs == 1)
						$subs = "1 subscriber";
					else
						$subs = $numSubs . " subscribers";

					$alllists.=$l["ListID"]."->".$l["ListName"]." ($subs);";
				}
			}

			$req = "<span class=req>*</span> ";

			$FORM_ITEMS[$req . "Mailing List"]="select|ListID:5:$alllists";
			$FORM_ITEMS["-1"]="submit|Continue to Step 2:1-members";

			$FORM=new AdminForm;
			$FORM->title="SelectList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("export?Action=SelectMembers");
			$FORM->MakeForm("Mailing List Details");

			$FORM->output = "Before you can export subscribers, please choose a mailing list to work with." . $FORM->output;
				
			$OUTPUT.=MakeBox("Export Subscribers (Step 1 of 4)",$FORM->output);
			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.ListID.selectedIndex == -1)
						{
							alert("Please select a list to work with first.");
							f.ListID.focus();
							return false;
						}
					}
				
				</script>
			';
	}

?>
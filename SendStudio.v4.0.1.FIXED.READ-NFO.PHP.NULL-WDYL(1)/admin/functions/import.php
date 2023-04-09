<?

	$Action = @$_REQUEST["Action"];
	$ListID = @$_REQUEST["ListID"];
	$ImportID = @$_REQUEST["ImportID"];
	$TextFileName = @$_REQUEST["TextFileName"];
	$headers = @$_REQUEST["headers"];
	$fielddelim = @$_REQUEST["fielddelim"];
	$recorddelim = @$_REQUEST["recorddelim"];
	$hasHeaders = @$_REQUEST["headers"] == "1" ? 1 : 0;
	$Do = @$_REQUEST["Do"];
	$SAVals = @$_REQUEST["SAVals"];
	$SIVals = @$_REQUEST["SIVals"];
	$FTVals = @$_REQUEST["FTVals"];
	$FHVals = @$_REQUEST["FHVals"];
	$OverrideStatus = @$_REQUEST["OverrideStatus"];
	$AbFormat = @$_REQUEST["AbFormat"];
	$C = @$_REQUEST["C"];
	$OverrideDate = @$_REQUEST["OverrideDate"];
	$OverrideFormat = @$_REQUEST["OverrideFormat"];
	$ConfStatus = @$_REQUEST["ConfStatus"];
	$FTVals = @$_REQUEST["FTVals"];
	$FHVals = @$_REQUEST["FHVals"];
	$DateFormat = @$_REQUEST["DateFormat"];
	$DateSep = @$_REQUEST["DateSep"];
	$Status = @$_REQUEST["Status"];
	$Email = @$_REQUEST["Email"];
	$xEmail = @$_REQUEST["xEmail"];
	$LinkField = @$_REQUEST["LinkField"];

	$alllists = "";
	$data = "";
	$OUTPUT = "";
	$MaxFields = 0;
	$t = 0;
	$ins = "";
	$Error = 0;

	function ParseFile($ImportID)
	{
		GLOBAL $ROOTDIR,$DIRSLASH;
		GLOBAL $data, $MaxFields, $headers, $t;
		GLOBAL $C, $OUTPUT;
		GLOBAL $TABLEPREFIX;

		$imp = mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "imports WHERE ImportID='$ImportID'"));
		$file = "../temp".$DIRSLASH.$ImportID;
		$recdim = str_replace("NEWLINE","\n",$imp["RecordDelim"]);
		$feidim = str_replace("NEWLINE","\n",$imp["FieldDelim"]);
		 
		$f = @fopen($file,"r");

		if(!$f)
		{
			return "";
		}
		else
		{
			while(!feof($f))
			{
				$data .= fread($f,1024);
			}
				
			$lines = explode($recdim,$data);

			foreach($lines as $line)
			{
				if($imp["Headers"]==1 && !$C)
				{
					$C=1;
					$headers=$line;
				}
				else
				{
					$DataLines[]=$line;
				}

				//maximum fields!
				$numf=substr_count($line,$feidim)+1;
				
				if($numf>$MaxFields)
				{
					$MaxFields=$numf;
				}
			}
				
			//headers!
			if(!$headers)
			{
				for($r=1;$r<=$MaxFields;$r++)
				{
					$H[$r]="Field $r";
				}
			}
			else
			{
				$fields=explode($feidim,$headers);
				$x=0;
				
				foreach($fields as $f)
				{
					$x++;
					$f=trim($f);
					$H[$x]=$f;
				}
			}

			//data
			if($DataLines)
			{
				foreach($DataLines as $dl)
				{
					$i=1;
					$t++;
					$fields=explode($feidim,$dl);
				
					foreach($fields as $f)
					{
						@$D[$t][$H[$i]]=trim($f);
						$i++;
					}
				}
			}
				
		$all["Headers"]=$H;
		$all["Data"]=$D;

		return $all;
		}
	}

	if($Action=="VerifyLinkings")
	{
		$imp=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "imports WHERE ImportID='$ImportID'"));
		$ListID=$imp["ListID"];
		$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'"));

		//work out the field linkings!
		foreach($LinkField as $ImpFieldID=>$ListField)
		{
			$ins.="&$ImpFieldID=$ListField";
			$Do[$ListField]=$ImpFieldID;
		}

		mysql_query("UPDATE " . $TABLEPREFIX . "imports SET FieldLinks='$ins' WHERE ImportID='$ImportID'");
		$Action = "DoImport";
	}

	if($Action=="UploadText" && $ImportID)
	{
		 mysql_query("UPDATE " . $TABLEPREFIX . "imports SET Headers='$headers', FieldDelim='$fielddelim', RecordDelim='$recorddelim' WHERE ImportID='$ImportID'");
		 $imp=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "imports WHERE ImportID='$ImportID'"));
		 $ListID=$imp["ListID"];
		 
		 $userfile = $_FILES['TextFileName']['tmp_name'];
		 $filename = $_FILES['TextFileName']['name'];

		 if(is_file($userfile))
		 {
			 if(@!is_writable("../temp"))
			 {
				$OUTPUT .= MakeErrorBox("An error occured", "<br>The '" . $ROOTDIR . "temp' folder is not writable. Please CHMOD this folder to 757.");
			 }
			 else
			 {
				@clearstatcache();
				$impfile = "../temp/" . $ImportID;
				@move_uploaded_file($userfile, $impfile);
				
				$impdat = ParseFile($ImportID);

				// Was the import OK?
				if($impdat == "")
				{
					$OUTPUT .= MakeErrorBox("Invalid Import File", "<br>The file that you have imported is empty or contains invalid data.");
				}
				else
				{
					$headers = $impdat["Headers"];
					$Data = $impdat["Data"];

					$alllistfields = 'None->---- None;E->Email Address;';

					$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");

					while($f=mysql_fetch_array($fields))
					{
						$alllistfields .= $f["FieldID"].'->'.$f["FieldName"].';';
					}

					//field linkings!
					foreach($headers as $ID=>$Field)
					{
						$FORM_ITEMS["Link '".$Field."' To"]="select|LinkField[$ID]:1:$alllistfields";

						if($hasHeaders == 0)
						{
							@$HELP_ITEMS["LinkField[$ID]"]["Title"] = "Field Preview:";
							@$HELP_ITEMS["LinkField[$ID]"]["Content"] = str_replace('\r', '', str_replace('\n', '', str_replace('\'', '\\\'', $impdat["Data"][1]["Field $ID"])));
						}
					}

					$FORM_ITEMS["-1"]="submit|Continue to Step 4:1-members";

					//make the form
					$FORM=new AdminForm;
					$FORM->title="ImportLinkings";
					$FORM->items=$FORM_ITEMS;

					$FORM->action=MakeAdminLink("import?Action=VerifyLinkings&ImportID=$ImportID&ConfStatus=$ConfStatus&Status=$Status&AbFormat=$AbFormat");
					$FORM->MakeForm("Link Import Fields");

					$FORM->output = sizeof($Data) . " possible records were found. Use the form below to define<br>which import fields should map to which subscriber fields." . $FORM->output;

					$OUTPUT.=MakeBox("Import Subscribers (Step 3 of 4)",$FORM->output);
					$OUTPUT .= '

							<script language="JavaScript">

								function CheckForm()
								{
									return true;
								}
							
							</script>
						';
				}	 

			 }
		 }
	}

	if($Action=="DoImport")
	{
		include("../includes$DIRSLASH"."members.inc.php");

 		$imp=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "imports WHERE ImportID='$ImportID'"));
		$ListID=$imp["ListID"];

		//do field linkings breakdown!
		$links=explode("&",$imp["FieldLinks"]);
		 
		foreach($links as $link)
		{
			@list($if,$lf)=explode("=",$link);
			$FieldLinks[$if]=$lf;
		}

		//status's breakdown!
		$acstats=explode(",",$SAVals);
		$iastats=explode(",",$SIVals);

		//formats breakdown
		$textstats=explode(",",$FTVals);
		$htmlstats=explode(",",$FHVals);

		$impdat=ParseFile($ImportID);
		$headers=$impdat["Headers"];
		$Data=$impdat["Data"];

		$SuccessfulImports=0;$DuplicateAttempts=0;$BannedAttempts=0;
		
		if($Data)
		{
			foreach($Data as $Member)
			{
				//defaults!
				$U["Status"]=$OverrideStatus;
				$U["Format"]=$OverrideFormat;
				$U["Email"]="";
				$U["Date"]=mktime(0,0,0,$OverrideDate["mm"],$OverrideDate["dd"],$OverrideDate["yy"]);
				$E="";
				$b=0;

				foreach($Member as $field=>$val)
				{
					$d="x";
					$b++;
					@$LF=$FieldLinks[$b];

					//is it email?
					if($LF=="E")
					{
						$U["Email"]=$val;
						$d=1;
					}

					//is it date?
					$U["Date"] = mktime(0,0,0,date("m"),date("d"),date("y"));

					//is it status?
					$U["Status"] = $Status;

					//is it an extra?
					if($LF!="None" && $d=="x")
					{
						$E[$LF]=$val;
					}
				}

				if($AbFormat=="text")
				{
					$U["Format"]=0;
				}
				elseif($AbFormat=="html")
				{
					$U["Format"]=1;
				}

				//now insert this member!
				if(!@mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE Email = '".$U["Email"]."' && ListID='$ListID' ORDER BY Email ASC")))
				{
					if(Banned($U["Email"], $ListID))
					{
						$BannedAttempts++;
					}
					else
					{
						// Is this a valid email address?
						if( is_numeric(strpos($U["Email"], "@")) && is_numeric(strpos($U["Email"], ".")) )
						{
							// Escape the quotes in all of the fields
							foreach($U as $k=>$v)
							{
								$U[$k] = addslashes($v);
							}

							// We have a valid email address, let's add this email
							mysql_query("INSERT INTO " . $TABLEPREFIX . "members SET ListID='$ListID', ImportID='$ImportID', Email='".$U["Email"]."', Format='".$U["Format"]."', Status='".$U["Status"]."', Confirmed='$ConfStatus', SubscribeDate='".$U["Date"]."'");

							$SuccessfulImports++;
							$UserID=mysql_insert_id();

							if(is_array($E))
							{
								foreach($E as $FieldID=>$FV)
								{
									mysql_query("INSERT INTO " . $TABLEPREFIX . "list_field_values SET FieldID='$FieldID', ListID='$ListID', UserID='$UserID', Value='$FV'");
								}
							}
						}
					}
				}
				else
				{
					$DuplicateAttempts++;
				}
			}
		 }
		 
		 $IR="$SuccessfulImports records imported successfully with $DuplicateAttempts duplicates detected and rejected, and $BannedAttempts emails not added because they are banned!";
		 
		 $OUTPUT .= MakeSuccessBox("Import Completed Successfully", "<br><ul><li>$SuccessfulImports subscribers were imported successfully.</li><li>$DuplicateAttempts duplicate subscribers were detected and were rejected.</li><li>$BannedAttempts subscribers were not added because they are banned.</li></ul>", MakeAdminLink("members?View=ListSummary&ListID=$ListID&Status=ALL&Confirmed=ALL&Format=ALL&PerPage=20"));
	}

	if($Action=="Datasource" && $ListID)
	{
		mysql_query("INSERT INTO " . $TABLEPREFIX . "imports SET ListID='$ListID', TimeStamp='$SYSTEMTIME'");

		$ImportID=mysql_insert_id();
		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS["-3"]="hidden|ImportID:$ImportID";

		$FORM_ITEMS[$req . "Import File"]="file|TextFileName";
		$HELP_ITEMS["TextFileName"]["Title"] = "Import File";
		$HELP_ITEMS["TextFileName"]["Content"] = "Choose a file that contains the subscriber details that you want to import. This should be a plain text file.";

		$list = @mysql_fetch_array(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID ORDER BY ListName ASC"));

		if($list["Formats"] == 1)
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:1:text->Text;html->HTML:" . $list["Formats"];
		}
		else if($list["Formats"] == 2)
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:text:text->Text Only";
		}
		else
		{
			$FORM_ITEMS[$req . "Format"] = "select|AbFormat:html:html->HTML Only";
		}

		$HELP_ITEMS["AbFormat"]["Title"] = "Format";
		$HELP_ITEMS["AbFormat"]["Content"] = "Which newsletter format should these subscribers be \'flagged\' to receive? Text and HTML, text only or HTML only?";

		$FORM_ITEMS[$req . "Status"]="select|Status:1:0->Inactive;1->Active:1";
		$HELP_ITEMS["Status"]["Title"] = "Status";
		$HELP_ITEMS["Status"]["Content"] = "When these subscribers are imported, should they be marked as active or inactive?";

		$FORM_ITEMS[$req . "Confirmed"] = "select|ConfStatus:1:1->All Confirmed;0->All Unconfirmed";
		$HELP_ITEMS["ConfStatus"]["Title"] = "Status";
		$HELP_ITEMS["ConfStatus"]["Content"] = "If a subscriber was to join your list using a normal subscription form with \'Requires Confirmation\' enabled, then they would be marked as unconfirmed until they click on the confirmation link inside the email automatically sent to them.";

		$FORM_ITEMS[$req . "Field Seperator"]="textfield|fielddelim:10:10:,";
		$HELP_ITEMS["fielddelim"]["Title"] = "Field Seperator";
		$HELP_ITEMS["fielddelim"]["Content"] = "What is the character used in your import file that seperates the contents of each new field in a record?";

		$FORM_ITEMS[$req . "Record Seperator"]="textfield|recorddelim:10:10:NEWLINE";
		$HELP_ITEMS["recorddelim"]["Title"] = "Record Seperator";
		$HELP_ITEMS["recorddelim"]["Content"] = "What is the character used in your import file that seperates one record from the next?";

		$FORM_ITEMS[$noreq . "Contains Headers?"]="checkbox|headers:1:Yes!:checked";
		$HELP_ITEMS["headers"]["Title"] = "Contains Header?";
		$HELP_ITEMS["headers"]["Content"] = "Does the first line of your import file contain headers? If so, each header should be seperated with a field seperator, such as: email, name, sex.";

		$FORM_ITEMS["-1"]="submit|Continue to Step 3:1-members";

		//make the form
		$FORM=new AdminForm;
		$FORM->title="TextFileImport";
		$FORM->items=$FORM_ITEMS;
		$FORM->action=MakeAdminLink("import?Action=UploadText");
		$FORM->EXTRA='ENCTYPE="multipart/form-data"';
		$FORM->MakeForm("Import Details");

		$FORM->output = "Complete the form below and then click on the continue button to proceed. <a href='javascript:launchIH()'>For a tutorial on how to import subscribers, click here.</a><br>" . $FORM->output;
		$OUTPUT.=MakeBox("Import Subscribers (Step 2 of 4)",$FORM->output);
		$OUTPUT .= '

				<script language="JavaScript">

					function launchIH()
					{
						window.open("' . $ROOTURL . 'admin/functions/importhelp.php?SID=' . $CURRENTADMIN["LoginString"] . '", "importWin", "left=" + ((screen.availWidth) / 2) - 225 + ", top="+ ((screen.availHeight) / 2) - 300 +", width=450, height=600, toolbar=0, statusbar=0, scrollbars=1");
					}

					function CheckForm()
					{
						var f = document.forms[0];

						if(f.TextFileName.value == "")
						{
							alert("Please choose an import file.");
							f.TextFileName.focus();
							return false;
						}

						if(f.fielddelim.value == "")
						{
							alert("Please enter a field seperator.");
							f.fielddelim.focus();
							return false;
						}

						if(f.recorddelim.value == "")
						{
							alert("Please enter a record seperator.");
							f.recorddelim.focus();
							return false;
						}
					}
				
				</script>
			';	
	}

	if(!$ListID)
	{
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
		$FORM->action=MakeAdminLink("import?Action=Datasource");
		$FORM->MakeForm("Import Details");

		$FORM->output = "Before you can import subscribers, please choose a mailing list to work with." . $FORM->output;

		$OUTPUT.=MakeBox("Import Subscribers (Step 1 of 4)",$FORM->output);
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
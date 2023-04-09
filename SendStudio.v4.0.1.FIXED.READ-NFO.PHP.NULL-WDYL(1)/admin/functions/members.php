<?

	include "../includes$DIRSLASH"."members.inc.php";

	$Action = @$_REQUEST["Action"];
	$SubAction = @$_REQUEST["SubAction"];
	$View = @$_REQUEST["View"];
	$ListID = @$_REQUEST["ListID"];
	$Status = @$_REQUEST["Status"];
	$Confirmed = @$_REQUEST["Confirmed"];
	$Format = @$_REQUEST["Format"];
	$Email = @$_REQUEST["Email"];
	$HaveClickedLink = @$_REQUEST["HaveClickedLink"];
	$PerPage = @$_REQUEST["PerPage"];
	$Save = @$_REQUEST["Save"];
	$OffSet = @$_REQUEST["OffSet"];
	$Page = @$_REQUEST["Page"];
	$Fields = @$_REQUEST["Fields"];
	$UserID = @$_REQUEST["UserID"];

	$alllists = "";
	$alllinks = "";
	$OUTPUT = "";
	$Error = "";
	$URLDATA = "";
	$PrevLink = "";
	$NextLink = "";

	if($Action=="Delete")
	{
		// Delete all subscribers with a matching ListID
		$numMembers = (int)@mysql_result(@mysql_query("SELECT COUNT(MemberID) FROM " . $TABLEPREFIX . "members WHERE ListID='$ListID'"), 0, 0);
		if(@mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE ListID='$ListID'"))
		{
			$OUTPUT .= MakeSuccessBox("$numMembers Subscriber(s) Deleted Successfully", "The selected subscribers have been deleted successfully.", MakeAdminLink("members"));
		}
		else
		{
			$OUTPUT .= MakeErrorBox("An Error Occured", "<br>The selected subscribers couldn't be deleted.");
		}
	}

	if($Action=="EditMember"){

		if($Fields)
		{
			foreach($Fields as $FID=>$FVAL)
			{
				$URLDATA.="Fields[$FID]=$FVAL&";
			}
		}

		$URLDATA.="PerPage=$PerPage&";
		$URLDATA.="Status=$Status&";
		$URLDATA.="Confirmed=$Confirmed&";
		$URLDATA.="Email=$Email&Format=$Format&";

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";
		
		if($Save=="Member"){

			$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
				while($f=mysql_fetch_array($fields))
				{
					if(@$f["Required"] && !@$Fields[$f["FieldID"]])
					{
						$Error.="<li>The field '".$f["FieldName"]."' is required.</li>";
					}
					elseif($f["FieldType"]=="shorttext" || $f["FieldType"]=="longtext")
					{
						if($f["Required"] && $Fields[$f["FieldID"]]==$f["DefaultValue"])
						{
							$Error.="<li>The field '".$f["FieldName"]."' is required.</li>";
						}
					}
				}
			
			//check the email addy is not banned!
			if(Banned($Email, $ListID)){
				$Error.="<li>The email address that you entered is banned.</li>";
			}

			// Is the email address already in the list?
			$isThere = @mysql_num_rows(@mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE ListID = '$ListID' and Email='$Email' and Email <> '$OldEmail'"));

			if($isThere > 0)
				$Error .= "<li>The email address that you entered is already in this list.</li>";
			
			if(!$Error)
			{
				//add the member!
				mysql_query("UPDATE " . $TABLEPREFIX . "members SET Email='$Email', Status='$Status', Format='$Format', Confirmed='$Confirmed' WHERE MemberID='$UserID'");
						mysql_query("DELETE FROM " . $TABLEPREFIX . "list_field_values WHERE UserID='$UserID'");
						$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
						while($f=mysql_fetch_array($fields)){
							mysql_query("INSERT INTO " . $TABLEPREFIX . "list_field_values SET UserID='$UserID', ListID='$ListID', FieldID='".@$f["FieldID"]."', Value='".@$Fields[$f["FieldID"]]."'");
						}
				
				$OUTPUT .= MakeSuccessBox("Subscriber Details Updated Successfully", "The selected subscribers details have been updated successfully.", MakeAdminLink("members"));

			}else
			{
				$OUTPUT .= MakeErrorBox("Update Subscriber Details", "<br>The following errors occured while trying to update this subscribers details:<ul>$Error</ul>");
			}
		}
		else
		{	
			$member=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$UserID' ORDER BY Email ASC"));
			$ListID=$member["ListID"];
			$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID' ORDER BY ListName ASC"));

				//edit a member form!
				if($Save!="Member"){$Format=$member["Format"];$Status=$member["Status"];$Confirmed=$member["Confirmed"];$Email=$member["Email"];}
				$FORM_ITEMS[$req . "Status"]="select|Status:1:0->Inactive;1->Active:$Status";
				$HELP_ITEMS["Status"]["Title"] = "Status";
				$HELP_ITEMS["Status"]["Content"] = "Should this subscriber be active or inactive? Generally, you would set a subscriber to inactive if you want to stop them from receiving your newsletter.";

				$FORM_ITEMS[$req . "Confirmed"]="select|Confirmed:1:0->Not Confirmed;1->Confirmed:$Confirmed";
				$HELP_ITEMS["Confirmed"]["Title"] = "Confirmed";
				$HELP_ITEMS["Confirmed"]["Content"] = "Should this subscriber be marked as confirmed? Generally, if a subscriber is confirmed then it means that they either have a valid email, or have clicked on the link in the subscriber confrirmation email.";

				$FORM_ITEMS[$req . "Format"]="select|Format:1:0->Text Only;1->HTML:".$Format;
				$HELP_ITEMS["Format"]["Title"] = "Format";
				$HELP_ITEMS["Format"]["Content"] = "Which type of newsletters should this subscriber be marked to receive?";

				$FORM_ITEMS[$req . "Email"]="textfield|Email:100:44:$Email";
				$HELP_ITEMS["Email"]["Title"] = "Email";
				$HELP_ITEMS["Email"]["Content"] = "This subscribers email address.";

				$size = $min = $max = $Width = $Height = 0;
					
					//extra fields
					$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
					while($f=mysql_fetch_array($fields)){
						$mval=mysql_fetch_array(mysql_query("SELECT * from " . $TABLEPREFIX . "list_field_values WHERE ListID='$ListID' && UserID='$UserID' && FieldID='".$f["FieldID"]."'"));
						$mval=$mval["Value"];

						if($f["Required"] == 1)
							$n = $req;
						else
							$n = $noreq;

						switch($f["FieldType"]){
							case "shorttext":
							{
								if(@$Fields[$f["FieldID"]]){
									$mval=@$Fields[$f["FieldID"]];
								}
								list($size,$min,$max)=explode(",",$f["AllValues"]);
								$FORM_ITEMS[$n . $f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44:".$mval;
								break;
							}						
							case "longtext":
							{
								if(@$Fields[$f["FieldID"]]){
									$mval=@$Fields[$f["FieldID"]];
								}
								list($Width,$Height)=explode(",",$f["AllValues"]);
								$FORM_ITEMS[$n . $f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:500:44:".$mval;
								break;
							}						
							case "checkbox":
							{
								if(@$Fields[$f["FieldID"]] || $Save=="Member"){
									$mval=@$Fields[$f["FieldID"]];
								}
								$FORM_ITEMS[$n . $f["FieldName"]]="checkbox|Fields[".$f["FieldID"]."]:CHECKED:Yes:".$mval;
								break;
							}					
							case "dropdown":
							{
								if(@$Fields[$f["FieldID"]]){
									$mval=@$Fields[$f["FieldID"]];
								}
								$FORM_ITEMS[$n . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:".$f["AllValues"].":".$mval;
								break;
							}
						}
					}
				
			
				$FORM_ITEMS["-1"]="submit|Save Changes:1-members";
				
				$FORM=new AdminForm;
				$FORM->title="EditMember";
				$FORM->items=$FORM_ITEMS;
				$FORM->action=MakeAdminLink("members?ListID=$ListID&Page=$Page&OldEmail=$Email&Save=Member&UserID=$UserID&Action=EditMember&Status=$Status&Confirmed=$Confirmed&Format=$Format&$URLDATA");
				$FORM->MakeForm("Subscriber Details");

				$FORM->output = "Complete the form below to update this subscribers details." . $FORM->output;
				$OUTPUT.=MakeBox('Edit Existing Subscriber', $FORM->output);
				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.Email.value.indexOf(".") == -1 || f.Email.value.indexOf("@") == -1)
							{
								alert("Please enter a valid email address for this subscriber.");
								f.Email.focus();
								f.Email.select();
								return false;
							}
						}
					
					</script>


				';
			}	
	}
	  
	if($Action=="AddMember"){
		
		if(!$Email){
			$Error.="<BR>Email required";
		}
		
		$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
			while($f=mysql_fetch_array($fields)){
				if($f["Required"] && !$Fields[$f["FieldID"]]){
					$Error.="<BR>".$f["FieldName"]." required";
				}elseif($f["FieldType"]=="shorttext" || $f["FieldType"]=="longtext"){
					if($f["Required"] && $Fields[$f["FieldID"]]==$f["DefaultValue"]){
						$Error.="<BR>".$f["FieldName"]." required";
					}
				}
			}
		
		//check the email addy is not banned!
		if(Banned($Email, $ListID)){
			$Error.="<BR>Email address is banned from list";
		}
		
		if(OnList($Email, $ListID)){
			$Error.="<BR>Email already on list";
		}
		
		if(!$Error){
			//add the member!
			$ConfirmCode=md5(uniqid(rand()));
			mysql_query("INSERT INTO " . $TABLEPREFIX . "members SET ConfirmCode='$ConfirmCode', Email='$Email', ListID='$ListID', Status='$Status', Confirmed='$Confirmed', SubscribeDate='$SYSTEMTIME'");
			$UserID=mysql_insert_id();
			$Email="";
				$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
				while($f=mysql_fetch_array($fields)){
					mysql_query("INSERT INTO " . $TABLEPREFIX . "list_field_values SET UserID='$UserID', ListID='$ListID', FieldID='".$f["FieldID"]."', Value='".@$Fields[$f["FieldID"]]."'");
				}
			$Action="";
			unset($Fields);
		}else{
			$Error="<font color=\"red\"><B><U>Errors Occured!</U></B>".$Error;
		}
		
	}  
	  
	if($View=="Members"){

		if(!is_numeric($ListID))
			$ListName = "All Lists";
		else
			$ListName = "'" . mysql_result(mysql_query("SELECT ListName FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID"), 0, 0) . "'";

		if($OffSet == "")
			$OffSet = 0;

		if($SubAction == "Delete")
		{
			@mysql_query("DELETE FROM " . $TABLEPREFIX . "members WHERE MemberID = '$UserID'");
			@mysql_query("DELETE FROM " . $TABLEPREFIX . "list_field_values WHERE UserID = '$UserID'");
		}

		$Total = @sizeof(ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,$Format));
		$Members=ReturnMembers($ListID,$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,$Format, "LIMIT " .($OffSet).",$PerPage");
		$TotalResult = sizeof($Members);

		if($Page == "")
			$Page = 0;

		if($Total<=$PerPage){
			$Pages=1;
		}else{
			$Pages=ceil($Total/$PerPage);
		}

		if($Members){

			if(!$OffSet)
			{
				$OffSet=0;
			}

			$TotalResults=sizeof($Members);
			$Total = $TotalResults . ($TotalResult == 1 ? " result" : " results");
			$lastOffset = 0;

			$bo = "Your search returned " . $Total . ".Currently displaying page " . ($Page+1) . " of " . $Pages . " pages.<br><br>";

			$bo .= "<input type=button class=button onClick=\"document.location.href='" . MakeAdminLink("members") . "'\" value=\"Start New Search\"> <input type='button' class='button' onClick='document.location.href=\"" . MakeAdminLink("import?Action=Datasource&ListID=$ListID") . "\"' value='Import Subscribers'> <input type='button' class='button' onClick='document.location.href=\"" . MakeAdminLink("export?Action=SelectMembers&ListID=$ListID") . "\"' value='Export Subscribers'> <input type='button' class='button' onClick='ConfirmDeleteAll()' value='Delete All'><br><br>";

			$bo .= '

				<script language="JavaScript">

					function ConfirmDeleteAll()
					{
						if(confirm("WARNING: This will delete ALL subscribers from the selected mailing list.\nAre you sure you want to do this? Click OK to confirm."))
						{
							document.location.href="' . MakeAdminLink("members?Action=Delete&ListID=$ListID") . '";
						}
					}

					function selectOn(trObject)
					{
						for(i = 0; i <= 5; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 5; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>

				<table width=100% border=0 cellspacing=2 cellpadding=2>
			';

			if($Pages > 1)
			{
				if($Fields)
				{
					foreach($Fields as $FID=>$FVAL)
					{
						$URLDATA.="Fields[$FID]=$FVAL&";
					}
				}

				$URLDATA.="PerPage=$PerPage&";
				$URLDATA.="Status=$Status&";
				$URLDATA.="Confirmed=$Confirmed&";
				$URLDATA.="Email=$Email&Format=$Format&";

				$bo .= '

				  <tr>
					<td width=100% colspan=6 class="navtext">
				';

				if($Page > 0)
				{
					$bo .= '
							<a href="' . MakeAdminLink("members?View=Members&Page=0&ListID=$ListID&$URLDATA&OffSet=0") . '" class="navlink">««</a> |';
				}

				if($Page > 0){
					$bo.='
					
							<a href="' . MakeAdminLink("members?View=Members&Page=" . ($Page-1) . "&ListID=$ListID&$URLDATA&OffSet=". ($OffSet-$PerPage)) . '" class="navlink">Prev</a> |';
				}

						$sPos = $Page - 10;

						if($sPos < 0)
							$sPos = 0;

						$ePos = $Page + 10;

						if($ePos > $Pages)
							$ePos = $Pages;

						  for($i = $sPos; $i < $ePos; $i++)
							{
								if($Page != $i)
									$bo .= ' <a href="' . MakeAdminLink("members?View=Members&Page=" . $i . "&ListID=$ListID&$URLDATA&OffSet=".($i*($PerPage))) . '" class="navlink">' . ($i+1) . '</a> |';
								else
									$bo .= ' ' . ($i+1) . ' |';

								$lastOffset = ($i*$PerPage);
							}

				if($Page < $Pages-1){
					$bo.='
					
								<a href="' . MakeAdminLink("members?View=Members&Page=" . ($Page+1) . "&ListID=$ListID&$URLDATA&OffSet=".($OffSet+$PerPage)) . '" class="navlink">Next</a> |';
				}

				if($Pages > 1)
				{
					$bo .= '
							 <a href="' . MakeAdminLink("members?View=Members&Page=" . ($Pages-1) . "&ListID=$ListID&$URLDATA&OffSet=$lastOffset") . '" class="navlink">»»</a>';
				}

				$bo .= '
					  
					  
						</td>
					</tr>
				';
			
			}

			$bo.='
			
				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=30%>
						Email Address
					</td>
					<td class="headbold bevel5" width=21%>
						Date Subscribed
					</td>
					<td class="headbold bevel5" width=10%>
						Status
					</td>
					<td class="headbold bevel5" width=15%>
						Confirmed
					</td>
					<td class="headbold bevel5" width=20%>
						Action
					</td>
				</tr>
			';
			
			$WM=array_splice($Members,$OffSet,$PerPage);
			foreach($Fields as $FID=>$FVAL)
			{
				$URLDATA.="Fields[$FID]=$FVAL&";
			}

			foreach($WM as $UserID){
				
				$member=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$UserID' ORDER BY Email ASC"));

				$bo .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/member.gif" width="16" height="16">
						</td>
						<td class="body bevel4" width=30%>' . $member["Email"] . '</td>
						<td class="body bevel4" width=21%>' . DisplayDate($member["SubscribeDate"]) . '</td>
						<td class="body bevel4" width=10%>';

						if($member["Status"] == 1)
							$bo .= 'Active';
						else
							$bo .= 'Inactive';

				$bo .= '

					</td>
					<td class="body bevel4" width=15%>';

					if($member["Confirmed"] == 1)
						$bo .= 'Yes';
					else
						$bo .= 'No';

				$bo .= '

					<td class="body bevel4" width=20%>';

				$bo .= MakeLink("members?Action=EditMember&Page=0&ListID=$ListID&$URLDATA&UserID=".$member["MemberID"], "Edit") . "&nbsp;&nbsp;&nbsp;";
				$bo .=
				MakeLink("members?View=Members&ListID=$ListID&OffSet=$OffSet&Page=$Page&PerPage=$PerPage&SubAction=Delete&Status=$Status&Confirmed=$Confirmed&Format=$Format&UserID=".$member["MemberID"] . "&$URLDATA", "Delete", 1);

				$bo .= '		
						</td>
					</tr>
				';
			}

			$bo .= '</table>';

					
		}else{
			$bo="No subscribers were found for the selected list. Click on the button below to search again.<br><br><input type=button class=button onClick=\"document.location.href='" . MakeAdminLink("members") . "'\" value='Search Again'> <input type='button' class='button' onClick='document.location.href=\"" . MakeAdminLink("import?Action=Datasource&ListID=$ListID") . "\"' value='Import Subscribers'>";
		}

		$OUTPUT.=MakeBox("Manage Subscribers for $ListName", $bo);

	}


	if($View=="ListSummary"){

		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		if(!is_numeric($ListID))
			$ListName = "All Lists";
		else
			$ListName = "'" . mysql_result(mysql_query("SELECT ListName FROM " . $TABLEPREFIX . "lists WHERE ListID = $ListID"), 0, 0) . "'";

		if(AllowList($ListID)){

			$List=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID=$ListID ORDER BY ListName ASC"));
		
			$FORM_ITEMS[$req . "Status"]="select|Status:1:ALL->View All;0->Inactive;1->Active:1";
			$HELP_ITEMS["Status"]["Title"] = "Status";
			$HELP_ITEMS["Status"]["Content"] = "Search for memebers who are active, inactive or both?";

			$FORM_ITEMS[$req . "Confirmed"]="select|Confirmed:1:ALL->Either;0->Not Confirmed;1->Confirmed:1";
			$HELP_ITEMS["Confirmed"]["Title"] = "Confirmed";
			$HELP_ITEMS["Confirmed"]["Content"] = "Search for members based on their confirmation status.";

			$FORM_ITEMS[$req . "Format"]="select|Format:1:ALL->Either;0->Text;1->HTML";
			$HELP_ITEMS["Format"]["Title"] = "Format";
			$HELP_ITEMS["Format"]["Content"] = "Search for members who are subscribed to receive the text, HTML or both versions of your newsletter?";

			//search for members form!
			$FORM_ITEMS[$noreq . "Search Email"]="textfield|Email:100:44:";
			$HELP_ITEMS["Email"]["Title"] = "Search Emails";
			$HELP_ITEMS["Email"]["Content"] = "If you want to search for a particular email address, then enter the complete or partial email address here.";

				//extra fields
				$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");

				while($f=mysql_fetch_array($fields)){

					switch($f["FieldType"]){
						case "shorttext":
							list($size,$min,$max)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44";
						break;
						
						case "longtext":
							list($Width,$Height)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfields|Fields[".$f["FieldID"]."]:500:44";
						break;
						
						case "checkbox":
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:y->Yes;n->No;all->All:all";
						break;
					
						case "dropdown":
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:->All Values;".$f["AllValues"].":";
						break;
					}
				}
				$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE Status='1' ORDER BY LinkName ASC");
				while($l=mysql_fetch_array($links)){
					$alllinks.=$l["LinkID"].'->'.$l["LinkName"].';';
				}

			$FORM_ITEMS[$noreq . "Members Per Page"]="select|PerPage:1:1->1;10->10;20->20;50->50;100->100:20";
			$HELP_ITEMS["PerPage"]["Title"] = "Members Per Page";
			$HELP_ITEMS["PerPage"]["Content"] = "How many memebers should be shown in the list on the next page?";

			$FORM_ITEMS[-1]="submit|Search List:1-members";
			
			$FORM=new AdminForm;
			$FORM->title="SearchMembers";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("members?View=Members&ListID=$ListID");
			$FORM->MakeForm("Search Subscribers");

			$FORM->output = "Use the form below to search your members list.<br>Once you are done, click on the \"Search List\" button below." . $FORM->output;
			
			$OUTPUT.=MakeBox("Manage Subscribers for $ListName",$FORM->output);

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

	if(!$ListID){

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
			$FORM_ITEMS["-1"]="submit|Continue";

			$FORM=new AdminForm;
			$FORM->title="SelectList";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("members?View=ListSummary");
			$FORM->MakeForm("Mailing List Details");

			$FORM->output = "Before you view and manage members, please choose a mailing list to work with." . $FORM->output;

			$OUTPUT.=MakeBox("Manage Subscribers",$FORM->output);
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
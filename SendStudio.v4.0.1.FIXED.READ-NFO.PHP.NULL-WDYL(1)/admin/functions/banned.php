<?

	global $ROOTURL;

	$Action = @$_REQUEST["Action"];
	$View = @$_REQUEST["View"];
	$Add = @$_REQUEST["Add"];
	$Page = @$_REQUEST["Page"];
	$DontDo = @$_REQUEST["DontDo"];
	$OffSet = @$_REQUEST["OffSet"];
	$x = @$_REQUEST["x"];
	$BannedType = @$_REQUEST["BannedType"];
	$Status = @$_REQUEST["Status"];
	$Search = @$_REQUEST["Search"];
	$ListID = @$_REQUEST["ListID"];
	$PerPage = @$_REQUEST["PerPage"];
	$Email = @$_REQUEST["Email"];

	$OUTPUT = "";
	$alllists = "";

	if($Page == "")
		$Page = 0;

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

	if($Action == "Add")
	{
		//add new banned!
		$req = "<span class=req>*</span> ";
		$noreq = "&nbsp;&nbsp;&nbsp;";

		$FORM_ITEMS2[$req . "Banned Emails"]="textarea|Email:46:5:";
		$HELP_ITEMS["Email"]["Title"] = "Banned Emails/Domains";
		$HELP_ITEMS["Email"]["Content"] = "Enter the list of emails that you wish to ban here. You should seperate each email address with a comma. To ban an entire domain enter @DOMAINNAME. For example, \'@hotmail.com\' would ban everyone using Hotmail.";

		$FORM_ITEMS2[$req . "Ban From"]="select|ListID:1:$alllists";
		$HELP_ITEMS["ListID"]["Title"] = "Ban From";
		$HELP_ITEMS["ListID"]["Content"] = "Which list would you like to ban these emails/domains from?";

		$FORM_ITEMS2[-1]="submit|Add Banned Emails";
		$FORM2=new AdminForm;
		$FORM2->title="AddBanned";
		$FORM2->items=$FORM_ITEMS2;
		$FORM2->action=MakeAdminLink("banned?Add=Banned");
		$FORM2->MakeForm("Banned Email/Domain Details");

		$FORM2->output = "Use the form below to add one or more email addresses to your banned email list.<br>Seperate multiple email addresses with a comma, such as 'user1@host.com, user2@host.com'<br><br><input type=button class=button onClick=\"document.location.href='" . MakeAdminLink("banned") . "'\" value='View Banned Emails'>" . $FORM2->output;

		$OUTPUT.=MakeBox("Add Banned Emails",$FORM2->output);
		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.Email.value == "")
					{
						alert("Please enter at least one email/domain to ban.");
						f.Email.focus();
						return false;
					}
				}
			
			</script>


		';
	}
	else
	{
	if($View=="Banned"){
		
		if(!$OffSet){$OffSet=0;}
		

		if($ListID=="GLOBAL"){
			$x.=" && Global='1'";
		}else{
			$x.=" && ListID='$ListID'";
		}

		//now do activate, deactivate and delete
		if($Action=="StatusD"){
			mysql_query("UPDATE " . $TABLEPREFIX . "banned_emails SET Status='0' WHERE Email='$Email' $x");
		}	
		if($Action=="StatusA"){
			mysql_query("UPDATE " . $TABLEPREFIX . "banned_emails SET Status='1' WHERE Email='$Email' $x");
		}	
		
		if($Action=="Delete"){
			mysql_query("DELETE FROM " . $TABLEPREFIX . "banned_emails WHERE Email='$Email' $x");
		}	
		//end actions!
		
		if($Status!="ALL"){
			$x.="&& Status='$Status'";
		}	
					
		if($BannedType=="domains"){
			$x.="&& Email LIKE '@%'";
		}elseif($BannedType=="addy"){
			$x.="&& Email NOT LIKE '@%'";
		}
			
		$Total=mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "banned_emails WHERE Email LIKE '%$Search%' $x ORDER BY Email ASC"));
		
		$results=mysql_query("SELECT * FROM " . $TABLEPREFIX . "banned_emails WHERE Email LIKE '%$Search%' $x ORDER BY Email LIMIT ".($OffSet*$PerPage).",$PerPage");
		
		if($Total<=$PerPage){
			$Pages=1;
		}else{
			$Pages=ceil($Total/$PerPage);
		}

		
		$RTB='Your search returned '.$Total.' results.';
		
		if($Total > 0)
		{
			$RTB .= 'Currently displaying page '.($Page+1).' of '.$Pages.' pages.';
		}
		else
		{
			$RTB .= ' Click the "Start New Search" button to search again.';
		}
			
		$RTB .= '<br><br><input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("banned") . '\'" value="Start New Search"> <input type=button class=button onClick="document.location.href=\'' . MakeAdminLink("banned?Action=Add") . '\'" value="Add Banned Emails"><br><br>';

		if($Total > 0)
		{
			$RTB .= '

				<script language="JavaScript">

					function selectOn(trObject)
					{
						for(i = 0; i <= 3; i++)
						{
							trObject.childNodes[i].className = "body bevel4 rowSelectOn";
						}
					}

					function selectOut(trObject, whichStyle)
					{
						for(i = 0; i <= 3; i++)
							trObject.childNodes[i].className = "body bevel4";
					}
				
				</script>

				<table width=100% border=0 cellspacing=2 cellpadding=2>
			';

			if($Pages > 1)
			{

				$RTB .= '

				  <tr>
					<td width=100% colspan=4 class="navtext">
				';

				if($Pages > 1)
				{
					$RTB .= '
							<a href="' . MakeAdminLink("banned?View=Banned&Page=&ListID=$ListID&Status=$Status&Search=$Search&OffSet=1&PerPage=$PerPage&OffSet=".($Page-1)) . '" class="navlink">««</a> |';
				}

				if($Page > 0){
					$RTB.='
					
							<a href="' . MakeAdminLink("banned?View=Banned&Page=" . ($Page-1) . "&ListID=$ListID&Status=$Status&Search=$Search&OffSet=$OffSet&PerPage=$PerPage&OffSet=".($Page-1)) . '" class="navlink">Prev</a> |';
				}

						  for($i = 0; $i < $Pages; $i++)
							{
								if($Page != $i)
									$RTB .= ' <a href="' . MakeAdminLink("banned?View=Banned&Page=$i&ListID=$ListID&Status=$Status&Search=$Search&PerPage=$PerPage&OffSet=".($i)) . '" class="navlink">' . ($i+1) . '</a> |';
								else
									$RTB .= ' ' . ($i+1) . ' |';
							}
					
				if($Page < $Pages-1){
					$RTB.='
					
								<a href="' . MakeAdminLink("banned?View=Banned&Page=" . ($Page+1) . "&ListID=$ListID&Status=$Status&Search=$Search&PerPage=$PerPage&OffSet=".($Page+1)) . '" class="navlink">Next</a> |';
				}

				if($Pages > 1)
				{
					$RTB .= '
							 <a href="' . MakeAdminLink("banned?View=Banned&Page=" . ($Pages-1) . "&ListID=$ListID&Status=$Status&Search=$Search&OffSet=1&PerPage=$PerPage&OffSet=".($Pages-1)) . '" class="navlink">»»</a>';
				}

				$RTB .= '
					  
					  
						</td>
					</tr>
				';
			
			}

			$RTB .= '

				  <tr>
					<td width=4% class="headbold bevel5">&nbsp;</td>
					<td class="headbold bevel5" width=40%>
						Email Address
					</td>
					<td class="headbold bevel5" width=36%>
						Date Added
					</td>
					<td class="headbold bevel5" width=20%>
						Action
					</td>
				</tr>
			';

			while($r=mysql_fetch_array($results)){

				$RTB .= '

					<tr onMouseover="selectOn(this)" onMouseout="selectOut(this)">
						<td height=20 class="body bevel4" width=4% class="body">
							<img src="' . $ROOTURL . 'admin/images/email.gif" width="13" height="12">
						</td>
						<td class="body bevel4" width=40%>' . $r["Email"] . '</td>
						<td class="body bevel4" width=36%>' . DisplayDate($r["DateAdded"]) . '</td>
						<td class="body bevel4" width=20%>';

						if($r["Status"]==1)
						{
							$RTB.=MakeLink("banned?View=Banned&Page=$Page&Action=StatusD&ListID=$ListID&Status=$Status&Search=$Search&OffSet=$OffSet&PerPage=$PerPage&Email=".$r["Email"],"Unban") . "&nbsp;&nbsp;&nbsp;";
						}else{
							$RTB.= MakeLink("banned?View=Banned&Page=$Page&Action=StatusA&ListID=$ListID&Status=$Status&Search=$Search&OffSet=$OffSet&PerPage=$PerPage&Email=".$r["Email"],"Re-ban") . "&nbsp;&nbsp;&nbsp;";
						}
						$RTB.= MakeLink("banned?View=Banned&Action=Delete&Page=$Page&ListID=$ListID&Status=$Status&Search=$Search&OffSet=$OffSet&PerPage=$PerPage&Email=".$r["Email"],"Delete",1);

				$RTB .= '		
						</td>
					</tr>
				';

			}

			$RTB .= '</table>';
		}

		$OUTPUT.=MakeBox("Search Banned Emails",$RTB);
		$DontDo=1;
	}

	if($Add=="Banned"){
		if($ListID=="GLOBAL"){
			$gl=1;
			$ListID=0;
		}else{
			$gl=0;
		}
		//check if its already there!
		$arrEmail = explode(",", $Email);

		for($i = 0; $i < sizeof($arrEmail); $i++)
		{
			if(trim($arrEmail[$i]) != "")
			{
				if(mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "banned_emails WHERE Email LIKE '" . trim($arrEmail[$i]) . "' && ListID='$ListID' && Global='$gl'"))==0)
				{
					mysql_query("INSERT INTO " . $TABLEPREFIX . "banned_emails SET Email='" . trim($arrEmail[$i]) . "', DateAdded='$SYSTEMTIME', ListID='$ListID', Global='$gl', Status='1'");
				}
			}
		}

		// Show the success message
		$OUTPUT .= MakeSuccessBox("Banned Emails Added Successfully", "The emails that you entered have been added to your banned list.", MakeAdminLink("banned"));

	}

		if(!$DontDo && $Add != "Banned"){
				$req = "<span class=req>*</span> ";
				$noreq = "&nbsp;&nbsp;&nbsp;";
			
				$FORM_ITEMS[$req."View"]="select|BannedType:1:all->All Banned;domains->Banned Domains;addy->Banned Addresses";
				$HELP_ITEMS["BannedType"]["Title"] = "View";
				$HELP_ITEMS["BannedType"]["Content"] = "Would you like to view a list of banned email address, banned domains, or both banned emails and domains?";

				$FORM_ITEMS[$req."Status"]="select|Status:1:ALL->View All;0->Inactive;1->Active:1";
				$HELP_ITEMS["Status"]["Title"] = "Status";
				$HELP_ITEMS["Status"]["Content"] = "Would you like to view a list of active banned emails, inactive banned emails, or both?";

				$FORM_ITEMS[$req."View Banned From"]="select|ListID:1:$alllists";
				$HELP_ITEMS["ListID"]["Title"] = "View Banned From";
				$HELP_ITEMS["ListID"]["Content"] = "Which mailing list would you like to view banned emails from?";

				$FORM_ITEMS[$req."Emails Per Page"]="select|PerPage:1:10->10;20->20;50->50;100->100:20";
				$HELP_ITEMS["PerPage"]["Title"] = "Banned Emails/Domains Per Page";
				$HELP_ITEMS["PerPage"]["Content"] = "How many banned emails/domains should be shown in the list on the next page?";

				$FORM_ITEMS[$noreq."Search Email"]="textfield|Search:30:44:";
				$HELP_ITEMS["Search"]["Title"] = "Search";
				$HELP_ITEMS["Search"]["Content"] = "If you only want to show banned emails that contain a certain word (such as \'hotmail\') then enter that word here.";
				
				$FORM_ITEMS["-1"]="submit|View Banned Emails";
				//make the form
				$FORM=new AdminForm;
				$FORM->title="View Banned Emails";
				$FORM->items=$FORM_ITEMS;
				$FORM->action=MakeAdminLink("banned?View=Banned");
				$FORM->MakeForm("Banned Search Details");

				// Add the description
				$FORM->output = "Use the form below to view or search for emails and domains on your banned subscriber list.<br>On the next page you will have the option to unban and remove emails from your banned list.<br><br><input type='button' class='button' onClick='document.location.href=\"" . MakeAdminLink("banned?Action=Add") . "\"' value='Add Banned Emails'>" . $FORM->output;

				$FORM->output .= '

					<script language="JavaScript">

						function CheckForm()
						{
							return true;
						}
					
					</script>
				';

				$OUTPUT .= MakeBox("View Banned Emails",$FORM->output);
		}
	}

?>
<?

	include("../includes/members.inc.php");

	global $TABLEPREFIX;

	$Action = @$_REQUEST["Action"];
	$SendID = @$_REQUEST["SendID"];
	$Email = @$_REQUEST["Email"];
	$Status = @$_REQUEST["Status"];
	$Confirmed = @$_REQUEST["Confirmed"];
	$Fields = @$_REQUEST["Fields"];
	$HaveClickedLink = @$_REQUEST["HaveClickedLink"];
	$Format = @$_REQUEST["Format"];
	$AlreadySet = @$_REQUEST["AlreadySet"];
	$ComposedID = @$_REQUEST["ComposedID"];
	$Multipart = @$_REQUEST["Multipart"];
	$SendName = @$_REQUEST["SendName"];
	$SendEmail = @$_REQUEST["SendEmail"];
	$ListID = @$_REQUEST["ListID"];
	$Resending = @$_REQUEST["Resending"];
	$Archive = @$_REQUEST["Archive"];
	$ReplyTo = @$_REQUEST["ReplyTo"];
	$ReturnPath = @$_REQUEST["ReturnPath"];

	$alllists = "";
	$alllinks = "";
	$allemails = "";
	$OUTPUT = "";
	$Send = array();

	// Workout the webmaster name and email address
	if(is_numeric($SendID))
	{
		// Workout the list this email is being sent to
		$ListID = @mysql_result(@mysql_query("SELECT ListID FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"), 0, 0);
		$wResult = @mysql_query("SELECT WebmasterName, WebmasterEmail FROM " . $TABLEPREFIX . "lists WHERE ListID='$ListID'");

		if($wRow = @mysql_fetch_array($wResult))
		{
			$WebmasterName = @$wRow["WebmasterName"];
			$WebmasterEmail = @$wRow["WebmasterEmail"];
		}
		else
		{
			$WebmasterName = $WebmasterEmail = "";
		}
	}
	else
	{
		$WebmasterName = $WebmasterEmail = "";
	}

	function ArchiveNewsletter($cID, $sID)
	{
		global $ROOTDIR;
		global $TABLEPREFIX;

		// Save a copy of the newsletter to /sendstudio/archive
		$cResult = mysql_query("select * from " . $TABLEPREFIX . "composed_emails where ComposedID = '$cID'");

		// Use the send ID to get the list name for where this is being sent
		$lID = (int)@mysql_result(@mysql_query("select ListID from " . $TABLEPREFIX . "sends where SendID = $sID"), 0, 0);
		$lName = str_replace(" ", "_", @mysql_result(@mysql_query("select ListName from " . $TABLEPREFIX . "lists where ListID = $lID"), 0, 0));

		@clearstatcache();
		@mkdir("../archive/" . $lName, 0777);

		// Put the archive index.php file in the directory
		@copy("../archive/index_list.php", "../archive/" . $lName . "/index.php");

		if(@is_writable("../archive/" . $lName))
		{
			if($cRow = mysql_fetch_array($cResult))
			{
				if($cRow["Format"] == 3)
				{
					// Generate a text and a HTML file name
					$fNameHTML = str_replace(" ", "_", $cRow["EmailName"] . "_" . DisplayDate(time()) . ".html");
					$fNameText = str_replace(" ", "_", $cRow["EmailName"] . "_" . DisplayDate(time()) . ".txt");

					// Try to save the HTML file
					$fp = @fopen("../archive/" . $lName . "/" . $fNameHTML, "wb");

					if($fp)
					{
						@fwrite($fp, $cRow["HTMLBody"]);
						@fclose($fp);
					}

					// Try to save the text file
					$fp = @fopen("../archive/" . $lName . "/" . $fNameText, "wb");

					if($fp)
					{
						@fwrite($fp, $cRow["TextBody"]);
						@fclose($fp);
					}
				}
				else
				{
					// Generate a single file name
					if($cRow["Format"] == 1)
						$fName = str_replace(" ", "_", $cRow["EmailName"] . "_" . DisplayDate(time()) . ".html");
					else
						$fName = str_replace(" ", "_", $cRow["EmailName"] . "_" . DisplayDate(time()) . ".txt");

					// Try to save the text file
					$fp = @fopen("../archive/" . $lName . "/" . $fName, "wb");

					if($fp)
					{
						if($cRow["Format"] == 1)
							@fwrite($fp, $cRow["HTMLBody"]);
						else
							@fwrite($fp, $cRow["TextBody"]);

						@fclose($fp);
					}
				}
			}
		}
	}

	if($Action == "Cancel")
	{
		$OUTPUT .= MakeSuccessBox("Newsletter Sending Cancelled", "To resume sending, click on the \"Resume\" link next to this newsletter in the newsletter manager.", MakeAdminLink("compose"));
	}

	if($Action == "Logo")
	{
		$POPOUTPUT=1;
		echo '
			<body bgcolor=red marginleft=0 margintop=0>
			<table cellspacing=0 cellpadding=0 width=100% align=center border=0>
			  <tr>
				<td valign=center align=center class=send><img height=57 src="';
		
		echo $ROOTURL;
		
		echo 'admin/images/logo.gif" width=294 border=0></td>
				<td valign=center class=send></td>
			  </tr>
			</table>
			</body>
		';
	}

	if($Action == "Done")
	{
		$OUTPUT .= MakeSuccessBox("Newsletter Sent Successfully!", "The selected newsletter has been sent successfully.", MakeAdminLink("index"));
	}

	if($Action == "Resend")
	{
		// Workout which newsletter can be resent
		$resend = mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends INNER JOIN " . $TABLEPREFIX . "composed_emails ON " . $TABLEPREFIX . "sends.ComposedID = " . $TABLEPREFIX . "composed_emails.ComposedID INNER JOIN " . $TABLEPREFIX . "lists ON " . $TABLEPREFIX . "sends.ListID = " . $TABLEPREFIX . "lists.ListID where " . $TABLEPREFIX . "sends.Completed = 0");

		$resendlists = "";
		$req = "<span class=req>*</span> ";

		while($r = mysql_fetch_array($resend))
		{
			// Are there still recipients waiting to receive this newsletter?
			if($r["EmailsSent"] < ($r["HTMLRecipients"] + $r["TextRecipients"]))
				$resendlists.=$r["SendID"]."->".$r["EmailName"].";";
		}

		$FORM_ITEMS2[$req . "Mailing List"]="select|SendID:5:$resendlists";
		$FORM_ITEMS2["-1"]="submit|Continue";

		$FORM2=new AdminForm;
		$FORM2->title="Restart a send";
		$FORM2->items=$FORM_ITEMS2;
		$FORM2->action=MakeAdminLink("send?Action=FinalOptions&AlreadySet=1&Resending=1");
		$FORM2->MakeForm("Newsletter Details");

		$FORM2->output = "If you stopped the sending process before it finished then<br>choose a newsletter from those below to resume sending." . $FORM2->output;
			
		$OUTPUT.=MakeBox("Resume Sending (Step 1 of 2)",$FORM2->output);
		$OUTPUT .= '

			<script language="JavaScript">

				function CheckForm()
				{
					var f = document.forms[0];

					if(f.SendID.selectedIndex == -1)
					{
						alert("Please select a newsletter to resend first.");
						f.SendID.focus();
						return false;
					}
				}
			
			</script>
		';

	}

	if($Action=="DoSending")
	{
		if($Archive == "1" && $AutoArchive == 1)
		{
			// Save a copy of this newsletter to the /sendstudio/archive folder
			$composedID = @(int)@mysql_result(@mysql_query("select ComposedID from " . $TABLEPREFIX . "sends where SendID = '$SendID'"), 0, 0);
			ArchiveNewsletter($composedID, $SendID);
		}

		$OUTPUT .= "<body bgcolor=red>";
		$POPOUTPUT=1;
		include("includes/send_emails.inc.php");
	}

	if($Action=="FinalOptions")
	{
		$Send=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"));
		
		if(!$AlreadySet)
		{
			$SendFrom=$SendName.' <'.$SendEmail.'>';
			mysql_query("UPDATE " . $TABLEPREFIX . "sends SET ComposedID='$ComposedID', SendFrom='$SendFrom', ReplyTo='$ReplyTo', ReturnPath='$ReturnPath' WHERE SendID='$SendID'");
		}

		//now break down the format for each user
		$Users=mysql_query("SELECT * FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID'");

		if(mysql_num_rows($Users) > 0)
		{	
			while($u=mysql_fetch_array($Users)){
				$user=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='".$u["MemberID"]."'"));
				$sf=0;
				if($Multipart=="none"){
					if($user["Format"]==1){
					$sf=2;
					}else{
					$sf=1;
					}
				}
				if($Multipart=="all"){
					$sf=3;
				}
				if($Multipart=="html"){
					if($user["Format"]==1){
					$sf=3;
					}else{
					$sf=1;
					}
				}
				mysql_query("UPDATE " . $TABLEPREFIX . "send_recipients SET Format='$sf' WHERE SendID='$SendID' && MemberID='".$u["MemberID"]."'");
				
			}
			}
			
			$list=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists WHERE ListID='".$Send["ListID"]."' ORDER BY ListName ASC"));

			if($Resending != 1)
			{
				$SR = "You have now completed the \"Send Newsletter\" wizard. The details of this sending are shown below.<br>Click on the \"Start Sending\" button below to start sending this newsletter.";
			}
			else
			{
				$SR = "The details of this resending are shown below.<br>Click on the \"Resume Sending\" button below to resume sending this newsletter.";
			}

			if($ComposedID == "")
			{
				$ComposedID = @mysql_result(mysql_query("SELECT ComposedID FROM " . $TABLEPREFIX . "sends WHERE SendID = $SendID"), 0, 0);
			}

			$total = @mysql_result(mysql_query("SELECT TotalRecipients FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"), 0, 0);
			$NewsletterName = @mysql_result(mysql_query("SELECT EmailName FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID = $ComposedID"), 0, 0);

			$SR .= "<ul style=\"line-height: 150%\">";
			$SR .= "<li><b>Newsletter Name:</b> " . $NewsletterName . "</li>";
			$SR .= "<li><b>Subscriber List:</b> ".$list["ListName"] . "</li>";
			$SR .= "<li><b>Total Recipients:</b> " . $total . "</li>";

			if($Resending == 1)
			{
				$SR .= "<li><b>Already Sent:</b> " . mysql_result(mysql_query("SELECT EmailsSent FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"), 0, 0) . "</li>";
				$SR .= "<li><b>Remaining:</b> " . ($total - mysql_result(mysql_query("SELECT EmailsSent FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"), 0, 0)) . "</li>";
			}
			
			$mins=round($total/24);
			$hours=round($mins/60);
			$mins=$mins-($hours*60);
			
			if($mins<0){
				$mins=0;
			}
			if($hours<1 && $mins>0){
				$time="$mins Minutes";
			}elseif($mins<1 && $hours<1){
				$time="Less Than a Minute";
			}else{
				$time="$hours hours, $mins minutes";
			}
			
			$SR .="<li><b>Send Time:</b> " . $time . " (Approximately)</li>";
			$SR .= "</ul>";

			if($Resending == 1)
			{
				// We're resuming a send
				$SR .= "<input type=button onClick='window.open(\"" . MakeAdminLink("send?Action=DoSending&SendID=$SendID") . "\", \"send$ComposedID\", \"width=300,height=300,left=400,top=300\")' value='Resume Sending' class=Button>";

				$OUTPUT.=MakeBox("Resume Sending (Step 2 of 2)",$SR);
			}
			else
			{
				// We're sending a newsletter
				$SR .= "<input type=button onClick='window.open(\"" . MakeAdminLink("send?Action=DoSending&Archive=1&SendID=$SendID") . "\", \"send$ComposedID\", \"width=300,height=300, left=400,top=300\")' value='Send Newsletter' class=Button>&nbsp;<input class=cancel onClick='if(confirm(\"Are you sure?\")) { document.location.href=\"" . MakeAdminLink("send") . "\" }' type=button value=Cancel>";

				$OUTPUT.=MakeBox("Send Newsletter (Step 4 of 4)",$SR);
			}
	}


	if($Action=="LogRecipients")
	{
		$Send=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"));
		$Members=ReturnMembers($Send["ListID"],$Email,$Status,$Confirmed,$Fields,$HaveClickedLink,$Format);

		// Update the TotalRecipients field
		@mysql_query("update " . $TABLEPREFIX . "sends set TotalRecipients = " . @sizeof($Members) . " where SendID='$SendID'");

		if($Members)
		{
			if($Members){foreach($Members as $MemberID){
				mysql_query("DELETE FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID' && MemberID='$MemberID'");
				mysql_query("INSERT INTO " . $TABLEPREFIX . "send_recipients SET SendID='$SendID', MemberID='$MemberID'");
			}}

				if($CURRENTADMIN["Manager"] == 1)
				{
					$emails=mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails ORDER BY EmailName ASC");
				}
				else
				{
					$emails=mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE AdminID = '" . $CURRENTADMIN["AdminID"] . "' ORDER BY EmailName ASC");
				}

				while($e=mysql_fetch_array($emails))
				{
					$allemails.=$e["ComposedID"].'->'.$e["EmailName"].';';
				}

				$req = "<span class=req>*</span> ";

				$FORM_ITEMS[$req . "Send Newsletter"]="select|ComposedID:1:$allemails:$ComposedID";
				$HELP_ITEMS["ComposedID"]["Title"] = "Send Newsletter";
				$HELP_ITEMS["ComposedID"]["Content"] = "Which newsletter would you like to send to your subscribers?";

				$FORM_ITEMS[$req . "Send Multipart To"]="select|Multipart:1:none->No One;html->HTML Recipients;all->All Recipients";
				$HELP_ITEMS["Multipart"]["Title"] = "Send Multipart To";
				$HELP_ITEMS["Multipart"]["Content"] = "A multipart email contains both text and HTML versions of the content. If you choose to send this email as multipart then the subscribers mail program will decide which version (text or HTML) shows up better and display it.";

				$FORM_ITEMS[$req . "Send From Name"]="textfield|SendName:100:44:$WebmasterName";
				$HELP_ITEMS["SendName"]["Title"] = "Send Name";
				$HELP_ITEMS["SendName"]["Content"] = "Which person or company name should show in the &quot;From Name&quot; field for this email?";
				
				$FORM_ITEMS[$req . "Send From Email"]="textfield|SendEmail:100:44:$WebmasterEmail";	
				$HELP_ITEMS["SendEmail"]["Title"] = "Send From Email";
				$HELP_ITEMS["SendEmail"]["Content"] = "Which email address should show in the &quot;From Email&quot; field for this email?";

				$FORM_ITEMS[$req . "Reply-To Email"]="textfield|ReplyTo:100:44:$WebmasterEmail";
				$HELP_ITEMS["ReplyTo"]["Title"] = "Reply-To Email";
				$HELP_ITEMS["ReplyTo"]["Content"] = "When a subscriber receives your email and clicks reply, which email address should that email be sent to? If you are unsure, use \'$WebmasterEmail\'.";

				$FORM_ITEMS[$req . "Return-Path Email"]="textfield|ReturnPath:100:44:$WebmasterEmail";
				$HELP_ITEMS["ReturnPath"]["Title"] = "Return-Path Email";
				$HELP_ITEMS["ReturnPath"]["Content"] = "When an email bounces, or is rejected by the mail server, which email address should the error be sent to? If you plan to use the bounce handler, then make sure no other emails will be sent to this address.";
				
				$FORM_ITEMS["-1"]="submit|Continue to Step 4:1-send";
				
				$FORM=new AdminForm;
				$FORM->title="FinalSendOptions";
				$FORM->items=$FORM_ITEMS;
				$FORM->action=MakeAdminLink("send?Action=FinalOptions&SendID=$SendID");
				$FORM->MakeForm("Newsletter Details");

				$FORM->output =  "The selected newsletter will be sent to " . @mysql_num_rows(mysql_query("SELECT * FROM " . $TABLEPREFIX . "send_recipients WHERE SendID='$SendID'")) . " member(s).<br>Click on the \"Continue to Step 4\" button below to continue." . $FORM->output;

				$OUTPUT.=MakeBox("Send Newsletter (Step 3 of 4)", $FORM->output);
				$OUTPUT .= '

					<script language="JavaScript">

						function CheckForm()
						{
							var f = document.forms[0];

							if(f.SendName.value == "")
							{
								alert("Please enter a \'From Name\' value for this newsletter.");
								f.SendName.focus();
								return false;
							}

							if(f.SendEmail.value.indexOf(".") == -1 || f.SendEmail.value.indexOf("@") == -1)
							{
								alert("Please enter a valid \'From Email\' for this newsletter.");
								f.SendEmail.select();
								return false;
							}

							if(f.ReplyTo.value.indexOf(".") == -1 || f.ReplyTo.value.indexOf("@") == -1)
							{
								alert("Please enter a valid \'Reply-To Email\' for this newsletter.");
								f.ReplyTo.select();
								return false;
							}

							if(f.ReturnPath.value.indexOf(".") == -1 || f.ReturnPath.value.indexOf("@") == -1)
							{
								alert("Please enter a valid \'Return Path\' for this newsletter.");
								f.ReturnPath.select();
								return false;
							}

							return true;
						}
					
					</script>
				';
		}
		else
		{
			// This list is empty
			$OUTPUT .= MakeErrorBox("No Subscribers Found", "<br>No subscribers were found for the criteria that you specified. Please click on the button below to go back and try again.");
		}
	}

	if($Action=="MakeSend")
	{		
		if(!$SendID){
			mysql_query("INSERT INTO " . $TABLEPREFIX . "sends set ListID='$ListID'");
			$SendID=mysql_insert_id();
		}

			$req = "<span class=req>*</span> ";
			$noreq = "&nbsp;&nbsp;&nbsp;";
			$size = $min = $max = $Width = $Height = 0;
		 
			//search for members form!
			$FORM_ITEMS[$req . "Status"]="select|Status:1:ALL->View All;0->Inactive;1->Active:1";
			$HELP_ITEMS["Status"]["Title"] = "Status";
			$HELP_ITEMS["Status"]["Content"] = "Should this newsletter be sent to only active, only inactive or all subscribers?";

			$FORM_ITEMS[$req . "Confirmed"]="select|Confirmed:1:ALL->Either;0->Not Confirmed;1->Confirmed:1";
			$HELP_ITEMS["Confirmed"]["Title"] = "Confirmed";
			$HELP_ITEMS["Confirmed"]["Content"] = "Should this newsletter be sent to only confirmed, only unconfirmed or all subscribers?";

			$FORM_ITEMS[$req . "Format"]="select|Format:1:ALL->Either;0->Text;1->HTML";
			$HELP_ITEMS["Format"]["Title"] = "Format";
			$HELP_ITEMS["Format"]["Content"] = "Should this newsletter be sent to subscribers who are flagged to receive text, HTML or both types of newsletters?";

			$FORM_ITEMS[$noreq . "Search Email"]="textfield|Email:100:44:";
			$HELP_ITEMS["Email"]["Title"] = "Search Emails";
			$HELP_ITEMS["Email"]["Content"] = "If you want to filter which subscribers receive this email, then enter the complete or partial email address to match here.";

				//extra fields
				$fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "' ORDER BY FieldName ASC");
				while($f=mysql_fetch_array($fields)){
					switch($f["FieldType"]){
						case "shorttext":
						{
							list($size,$min,$max)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:$max:44";
							break;
						}					
						case "longtext":
						{
							list($Width,$Height)=explode(",",$f["AllValues"]);
							$FORM_ITEMS[$noreq . "Search ".$f["FieldName"]]="textfield|Fields[".$f["FieldID"]."]:500:44";
							break;
						}					
						case "checkbox":
						{
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:y->Yes;n->No;all->All:all";
							break;
						}				
						case "dropdown":
						{
							$FORM_ITEMS[$noreq . $f["FieldName"]]="select|Fields[".$f["FieldID"]."]:1:->All Values;".$f["AllValues"].":";
							break;
						}
					}
				}
				$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE Status='1' ORDER BY LinkName ASC");
				while($l=mysql_fetch_array($links)){
					$alllinks.=$l["LinkID"].'->'.$l["LinkName"].';';
				}
			
			$FORM_ITEMS["-1"]="submit|Continue to Step 3:1-send";
			$FORM_ITEMS[-2]="hidden|ComposedID:$ComposedID";
			
			$FORM=new AdminForm;
			$FORM->title="SelectSendRecipients";
			$FORM->items=$FORM_ITEMS;
			$FORM->action=MakeAdminLink("send?Action=LogRecipients&SendID=$SendID");
			$FORM->MakeForm("Newsletter Recipient Details");

			$FORM->output = "Use the form below to choose the recipients to receive this newsletter.<br>Click on the \"Continue to Step 3\" button to continue." . $FORM->output;
			
			$OUTPUT.=MakeBox("Send Newsletter (Step 2 of 4)",$FORM->output); 
			$OUTPUT .= '

				<script language="JavaScript">

					function CheckForm()
					{
						return true;
					}
				
				</script>
			';

	}

	if(!$SendID && $Action == "")
	{			
			$lists = mysql_query("SELECT * FROM " . $TABLEPREFIX . "lists ORDER BY ListName ASC");
			$alllists =  $alllists1 = "";

			while($l=mysql_fetch_array($lists))
			{
				if(AllowList($l["ListID"]))
				{
					$alllists .= $l["ListID"].",";
					//$alllists1.=$l["ListID"]."->".$l["ListName"].";";

					$numSubs = (int)@mysql_result(@mysql_query("select count(MemberID) from " . $TABLEPREFIX . "members where ListID=" . $l["ListID"]), 0, 0);

					if($numSubs == 1)
						$subs = "1 subscriber";
					else
						$subs = $numSubs . " subscribers";

					$alllists1.=$l["ListID"]."->".$l["ListName"]." ($subs);";
				
				}
			}

			$alllists = eregi_replace(",$", "", $alllists);

			// How many newsletters are there to send?
			if($alllists == "")
			{
				$numNL = 0;
			}
			else
			{
				if($CURRENTADMIN["Manager"] == 1)
				{
					$numNL = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "composed_emails"), 0, 0);
				}
				else
				{
					$numNL = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "composed_emails where AdminID = " . $CURRENTADMIN["AdminID"]), 0, 0);
				}
			}

			if($numNL == 0)
			{
				if(AllowSection(11))
				{
					$TO .= 'No newsletters have been created. Click the "Create Newsletter" button to create one.
					<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("compose?Action=Add") . '"\' value="Create Newsletter">
					<br><br>';
				}
				else
				{
					$TO .= 'No newsletters have been created.<br><br>';
				}

				$OUTPUT.=MakeBox("Send Newsletter (Step 1 of 4)", $TO);
			}
			else
			{
				if($alllists == "")
				{
					if(AllowSection(2))
					{
						$TO .= 'No mailing lists have been created. Click the "Create Mailing List" button to create one.
						<br><br><input type=button class=button onClick=\'document.location.href="' . MakeAdminLink("lists?Action=Add") . '"\' value="Create Mailing List">
						<br><br>';
					}
					else
					{
						$TO .= 'No mailing lists have been created.<br><br>';
					}

					$OUTPUT.=MakeBox("Send Newsletter (Step 1 of 4)", $TO);
				}
				else
				{
					$req = "<span class=req>*</span> ";

					$FORM_ITEMS[$req . "Mailing List"]="select|ListID:5:$alllists1";
					$FORM_ITEMS["-1"]="submit|Continue to Step 2";
					$FORM_ITEMS[-2]="hidden|ComposedID:$ComposedID";

					$FORM=new AdminForm;
					$FORM->title="SelectList";
					$FORM->items=$FORM_ITEMS;
					$FORM->action=MakeAdminLink("send?Action=MakeSend&SendID=$SendID");
					$FORM->MakeForm("Mailing List Details");

					$FORM->output = "Complete the form below to send a newsletter. Click on the \"Continue to Step 2\" button to continue.<br><br>" . $FORM->output;
						
					$OUTPUT.=MakeBox("Send Newsletter (Step 1 of 4)",$FORM->output);

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
			}
	}

?>